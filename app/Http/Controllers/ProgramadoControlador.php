<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CasoControlador;
use App\Http\Controllers\MailController;
use Carbon\Carbon;
use DateTime;
class ProgramadoControlador extends Controller{
    
    public function leerCorreo(Request $request){

        $results = DB::select('CALL leerCorreo()');
        $results = json_decode(json_encode($results), true);
        $cargar = false;
        $valor_prede = 'No encontrado';
        $valor_prede2 = '1970-01-01';
        $rowNum = 1;
        $row_aux = 0;
        $tamaño = 20; // Tamaño máximo del script 1-20
        $response = array();
        $estado = '0';
        $response['data'] = array();
        foreach ($results as $row) {
            $IDUser = $row['IDUser'];
            $scriptUrl = $row['urlGmail'];
            $exp_aux = $row['expediente'];
            // $IDUser = 1;
            // $scriptUrl = 'https://script.google.com/macros/s/AKfycbzQT1L3POuFN3s76UZsPO34ROw83S4rFlBmnfyTdH3nUlARoTHgv-K8kstqiYIdhhGy/exec';
            // $exp_aux = 0;
        
            for ($i = 0; $i < 5; $i ++) {
                $limit = $tamaño; // Cantidad de datos a mostrar por página
                $offset = $i * $tamaño + 15; // Comenzar desde
                // $limit = 2; // Cantidad de datos a mostrar por página
                // $offset = 0; // Comenzar desde
                $data = array(
                    "action" => "inboxList",
                    "limit" => $limit,
                    "offset" => $offset
                );

                $ch = curl_init($scriptUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $result = curl_exec($ch);
                $result = json_decode($result, true);

                // $response['status'] = $result['status'];

                if ($result['status'] == 'success') {
                    foreach ($result['data'] as $inbox) {
                        $data = array(
                            "action" => "inboxRead",
                            "id"  => $inbox['id'],
                        );

                        $ch = curl_init($scriptUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        $result = curl_exec($ch);
                        $result = json_decode($result, true);

                        $body = $result['data']['body'];
                        $plainBody = $result['data']['plainBody'];

                        $expediente = $valor_prede;
                        if (preg_match('/perteneciente al expediente[^\d]*(\d+)/', $plainBody, $matches)) {
                            $expediente = $matches[1];
                        }
                        else if (preg_match('/\*Número \*\s*:\s*(\d+)/', $plainBody, $matches)) {
                            $expediente = $matches[1];
                            // echo "Número capturado: " . $expediente;
                        }

                        $correo = $valor_prede;
                        if (preg_match('/To: <([\w.-]+@[\w.-]+)>/', $plainBody, $matches)) {
                            $correo = $matches[1];
                        }

                        $proceso = $valor_prede;
                        $proceso = $inbox['subject'];

                        $tarea = $valor_prede;
                        if (preg_match('/Subject: RV: (\w+)/', $plainBody, $matches)) {
                            $tarea = $matches[1];
                        }

                        $plazo = $valor_prede2;
                        if (preg_match('/Hasta el (\d{2})\.(\d{2})\.(\d{4})/', $plainBody, $matches)) {
                            $plazo = date('Y-m-d', strtotime($matches[3] . '-' . $matches[2] . '-' . $matches[1]));
                        } else {
                            // Intenta encontrar el formato "*PLAZO: 11/04/2024*"
                            if (preg_match('/PLAZO: (\d{2})\/(\d{2})\/(\d{4})\*/', $plainBody, $matches)) {
                                $plazo = date('Y-m-d', strtotime($matches[3] . '-' . $matches[2] . '-' . $matches[1]));
                            } else {
                                // Intenta encontrar el formato "Plazo: 11/04/2024"
                                if (preg_match('/Plazo: (\d{2})\.(\d{2})\.(\d{4})/', $plainBody, $matches)) {
                                    $plazo = date('Y-m-d', strtotime($matches[3] . '-' . $matches[2] . '-' . $matches[1]));
                                } else {
                                    // Intenta encontrar el formato "Plazo: 16 de abril."
                                    if (preg_match('/Plazo: (\d{1,2}) de (\w+)\./', $plainBody, $matches)) {
                                        // Obtén el mes y conviértelo al formato de fecha
                                        $meses = [
                                            'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                                            'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                                            'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                                        ];
                                        $plazo = date('Y-m-d', strtotime($matches[1] . '-' . $meses[strtolower($matches[2])] . '-' . date('Y')));
                                    } else{
                                        if (preg_match('/Plazo para modificar el informe \(con el sustento correspondiente\): (\d{1,2}) de (\w+)\./', $plainBody, $matches)) {
                                            // Obtén el mes y conviértelo al formato de fecha
                                            $meses = [
                                                'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                                                'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                                                'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                                            ];
                                            $plazo = date('Y-m-d', strtotime($matches[1] . '-' . $meses[strtolower($matches[2])] . '-' . date('Y')));
                                        } else{
                                        if (preg_match('/Plazo para modificar el informe \(con el sustento correspondiente\): (\d{1,2}) de (\w+)\./', $plainBody, $matches)) {
                                            // Obtén el mes y conviértelo al formato de fecha
                                            $meses = [
                                                'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                                                'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                                                'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                                            ];
                                            $plazo = date('Y-m-d', strtotime($matches[1] . '-' . $meses[strtolower($matches[2])] . '-' . date('Y')));
                                        } else{
                                        if (preg_match('/Plazo: (.*)(\w+\s+\w+\s+\w+)\./', $plainBody, $matches)) {
                                            $ultimas_tres_palabras = trim($matches[2]);
                                            // echo "Últimas tres palabras: " . $ultimas_tres_palabras;
                                        } 
                                        }
                                    }
                                    }
                                }
                            }
                        }

                        $newDate = DateTime::createFromFormat('d/m/Y', $inbox['date']);
                        if ($newDate !== false) {
                            $dateFormatted = $newDate->format('Y-m-d');
                        } else {
                            $dateFormatted = "Fecha no válida";
                        }
                        if($expediente == $exp_aux){
                            $row_aux = $row;
                        }
                        if($expediente != $valor_prede){
                            $cargar=true;
                        }
                        if($row_aux!=0){
                            $cargar=false;
                        }
                        if($cargar==true and $expediente!=$valor_prede){     
                            if($plazo==$valor_prede2)
                                $estado='2';                   
                            $casoControlador = new CasoControlador();
                            $casoControlador->guardar($expediente, $correo,$proceso,$inbox['id'],$dateFormatted,$plazo,$estado, $IDUser);
                            }
                            $results = array();
                            $response['data'][] = array(
                                "rowNum" => $rowNum,
                                "id" => $inbox['id'],
                                "from" => $inbox['from'],
                                "subject" => $inbox['subject'],
                                "date" => $dateFormatted,
                                "expediente" => $expediente,
                                "correo" => $correo,
                                "proceso" => $proceso,
                                "tarea" => $tarea,
                                "plazo" => $plazo,
                                "cargar" => $cargar
                            );
                        $rowNum++;
                    }
                }
            }
        }
        // echo json_encode($response);
        return $response;
    }

    public function enviarCorreo(){
        try{
            date_default_timezone_set('America/Lima');
            $fechaActual = Carbon::now('America/Lima')->format('Y-m-d');
            $results = DB::select('CALL VerCorreoProgramado(?)', [$fechaActual]);
            // return $results;
            if (!empty($results)) {
                // Convertir stdClass a array
                $results = json_decode(json_encode($results), true);
                foreach ($results as $row) {
                    if ($row['estado'] == 0) {
                        $Data = [
                            'apellidos' => $row['apellidos'],
                            'nombres' => $row['nombres'],
                            'email' => $row['correo'],
                            'dest_email' => $row['dest_correo'],
                            'expediente' => $row['expediente'],
                            'proceso' => $row['proceso'],                        
                            'asignado' => $row['asignado'],
                            'limite' => $row['limite'],
                            'ucID' => $row['IDUC'],
                            'documento' => $row['documento']
                        ];
        
                        $MailController = new MailController();
                        $response = 0; // $MailController->actualizarEstado($Data)
                        // return $response;
                        if($response){
                            $formData = [
                                'ucID' => $row['IDUC'],
                                'date' => $fechaActual
                            ];
                            $CasoControlador = new CasoControlador();
                            $result = $CasoControlador->actualizarEstado($formData);
                            
                            if(!$result){
                                error_log($result, 3, base_path()."/enviarCorreo.log");
                                return 'Error en actualizarEstado';
                            }
                            return 'Correcto';
                        }
                        error_log($response, 3, base_path()."/enviarCorreo.log");
                        return 'Error en enviarCorreo';
                    }
                }
            }
        } catch (\Exception $e) {
            error_log('Error exception en enviarCorreo', 3, base_path()."/enviarCorreo.log");
            return response()->json([
                'error' => 'Algo salio mal'
                ], 400);
        } 
    }
}