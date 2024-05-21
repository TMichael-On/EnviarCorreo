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
        $cargar = true;
        $valor_prede = 'No encontrado';
        $valor_prede2 = '1970-01-01';
        $rowNum = 1;
        $row_aux = 0;
        $tamaño = 20; // Tamaño máximo del script 1-20
        $inicio = 0;
        $response = array();
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
                $offset = $i * $tamaño + $inicio; // Comenzar desde
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

                    if (isset($result['data'])) {
                        $body = $result['data']['body'];
                        $plainBody = $result['data']['plainBody'];
                        $dateLlegada = "1970-01-01";
                                       $plainBodyUpper = strtoupper($plainBody);
                                       $meses = [
                                          'JAN' => '01', 'FEB' => '02', 'MAR' => '03', 'APR' => '04', 'MAY' => '05', 'JUN' => '06',
                                          'JUL' => '07', 'AUG' => '08', 'SEP' => '09', 'OCT' => '10', 'NOV' => '11', 'DEC' => '12',
                                          'ENE' => '01', 'FEB' => '02', 'MAR' => '03', 'ABR' => '04', 'MAY' => '05', 'JUN' => '06',
                                          'JUL' => '07', 'AGO' => '08', 'SET' => '09', 'OCT' => '10', 'NOV' => '11', 'DIC' => '12',
                                          'JANUARY' => '01', 'FEBRUARY' => '02', 'MARCH' => '03', 'APRIL' => '04', 'MAY' => '05', 'JUNE' => '06',
                                          'JULY' => '07', 'AGOST' => '08', 'SEPTEMBER' => '09', 'OCTOBER' => '10', 'NOVEMBER' => '11', 'DECEMBER' => '12',
                                          'ENERO' => '01', 'FEBRERO' => '02', 'MARZO' => '03', 'ABRIL' => '04', 'MAYO' => '05', 'JUNIO' => '06',
                                          'JULIO' => '07', 'AGOSTO' => '08', 'SETIEMBRE' => '09', 'OCTUBRE' => '10', 'NOVIEMBRE' => '11', 'DICIEMBRE' => '12'
                                       ];
                        
                                       if (preg_match('/DATE: (\d{4})-(\d{2})-(\d{2})/', $plainBodyUpper, $matches)) {
                                          $anio = $matches[1];
                                          $mes = $matches[2];
                                          $dia = $matches[3];
                        
                                          $dateLlegada = "$anio-$mes-$dia";
                                       } else if (preg_match('/DATE: (LUN|MAR|MIE|JUE|VIE|SAB|DOM), (\d{1,2}) DE ([A-Z]{3,})\. DE (\d{4})/', $plainBodyUpper, $matches)) {
                                          $dia = str_pad($matches[2], 2, '0', STR_PAD_LEFT); // Asegurar que el día tenga 2 dígitos
                                          $mesNombre = strtoupper(substr($matches[3], 0, 3)); // Tomar las primeras tres letras del nombre del mes
                                          $anio = $matches[4];
                                          $mes = isset($meses[$mesNombre]) ? $meses[$mesNombre] : '00';
                                          $dateLlegada = "$anio-$mes-$dia";
                                       } else if (preg_match('/DATE: .*? (\d{1,2}) DE ([A-Z]{3,})\. DE (\d{4})/', $plainBodyUpper, $matches)) {
                                          $dia = str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Asegurar que el día tenga 2 dígitos
                                          $mesNombre = strtoupper(substr($matches[2], 0, 3)); // Tomar las primeras tres letras del nombre del mes
                                          $anio = $matches[3];
                                          $mes = isset($meses[$mesNombre]) ? $meses[$mesNombre] : '00';
                                          $dateLlegada = "$anio-$mes-$dia";
                                       } else if (preg_match('/DATE: .*?, (\d{1,2}) DE ([A-Z]{3})\. DE (\d{4}) (\d{1,2}):(\d{2}) (A|P)\.M\./', $plainBodyUpper, $matches)) {
                                          $dia = str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Asegurar que el día tenga 2 dígitos
                                          $mesNombre = strtoupper($matches[2]); // Convertir el nombre del mes a mayúsculas
                                          $anio = $matches[3];
                                          $hora = $matches[4];
                                          $minuto = $matches[5];
                                          $ampm = $matches[6];
                                          $mes = isset($meses[$mesNombre]) ? $meses[$mesNombre] : '00';
                                          $dateLlegada = "$anio-$mes-$dia $hora:$minuto:00";
                                       } else if (preg_match('/DATE: .*?, (\d{1,2}) DE ([A-Z]{3})\. DE (\d{4})/', $plainBodyUpper, $matches)) {
                                          $dia = str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Asegurar que el día tenga 2 dígitos
                                          $mesNombre = strtoupper($matches[2]); // Convertir el nombre del mes a mayúsculas
                                          $anio = $matches[3];
                        
                                          $mes = isset($meses[$mesNombre]) ? $meses[$mesNombre] : '00';
                                          $dateLlegada = "$anio-$mes-$dia";
                                       } else if (preg_match('/DATE: .*?, (\d{1,2}) ([A-Z]{3}) (\d{4})/', $plainBodyUpper, $matches)) {
                                          $dia = str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Asegurar que el día tenga 2 dígitos
                                          $mesNombre = strtoupper($matches[2]); // Convertir el nombre del mes a mayúsculas
                                          $anio = $matches[3];
                        
                                          $mes = isset($meses[$mesNombre]) ? $meses[$mesNombre] : '00';
                                          $dateLlegada = "$anio-$mes-$dia";
                                       }  else if (preg_match('/DATE: .*?, (\d{1,2}) ([A-Z]{3}) (\d{4})/', $plainBodyUpper, $matches)) {
                                          $dia = str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Asegurar que el día tenga 2 dígitos
                                          $mesNombre = strtoupper($matches[2]); // Convertir el nombre del mes a mayúsculas
                                          $anio = $matches[3];
                                      
                                          $mes = isset($meses[$mesNombre]) ? $meses[$mesNombre] : '00';
                                          $dateLlegada = "$anio-$mes-$dia";
                                      }
                                      
                        $expediente = $valor_prede;
                        
                        if (preg_match('/perteneciente al expediente[^\d]*(\d+)/', $plainBody, $matches)) {
                          $expediente = $matches[1];
                        } else if (preg_match('/\*Número \*\s*:\s*(\d+)/', $plainBody, $matches)) {
                          $expediente = $matches[1];
                        } else if (preg_match('/EXPEDIENTE Número\s*:\s*(\d+)/',  $plainBody, $matches)) {
                          $expediente = $matches[1];
                        } else if (preg_match('/DATOS DEL EXPEDIENTE\s*Número\s*:\s*(\d+)/', $plainBody, $matches)) {
                          $expediente = $matches[1];
                        }

                        $correo = $valor_prede;

                       $plainText = strip_tags($body);
                       $plainText = preg_replace('/\s+/', ' ', $plainText);
                       $plainText = trim($plainText);
                       if (preg_match_all('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $plainText, $matches)) {
                          $correos = $matches[0];
                       }
                       $correoEncontrado = "No encontrado";
                       foreach ($correos as $email) {
                          if (stripos($email, 'supervisor') === 0) {
                             $correoEncontrado = $email;
                             break;
                          }
                       }  

                        $proceso = $valor_prede;
                        $proceso = $inbox['subject'];

                        $tarea = $valor_prede;
                        if (preg_match('/Subject: RV: (\w+)/', $plainBody, $matches)) {
                            $tarea = $matches[1];
                        }

                        $plazo = $valor_prede2;
                        if (preg_match('/Plazo.*?(\d{2})\.(\d{2})\.(\d{4})/', $plainBody, $matches)) {
                  // Formato: 26.04.2024
                  $day = $matches[1];
                  $month = $matches[2];
                  $year = $matches[3];
                  $plazo = date('Y-m-d', strtotime("$year-$month-$day"));
               } else if (preg_match('/Plazo.*?(\d{2})\/(\d{2})\/(\d{4})/', $plainBody, $matches)) {
                  // Formato: 06/05/2023
                  $day = $matches[1];
                  $month = $matches[2];
                  $year = $matches[3];
                  $plazo = date('Y-m-d', strtotime("$year-$month-$day"));
               } else if (preg_match('/Plazo.*?Hasta el día de hoy,\s*(\d{4})-(\d{2})-(\d{2})/', $plainBody, $matches)) {
                  // Formato: Hasta el día de hoy, 2024-04-29
                  $year = $matches[1];
                  $month = $matches[2];
                  $day = $matches[3];
                  $plazo = date('Y-m-d', strtotime("$year-$month-$day"));
               } else if (preg_match('/Plazo.*?(\d{1,2})\s*de\s*(\w+)\./i', $plainBody, $matches)) {
                  // Formato: 12 de abril
                  $day = $matches[1];
                  $monthName = $matches[2];
                  $currentYear = date('Y');
                  $months = array(
                     'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                     'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                     'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                  );
                  $month = isset($months[strtolower($monthName)]) ? $months[strtolower($monthName)] : '01';
                  $plazo = date('Y-m-d', strtotime("$currentYear-$month-$day"));
               } else if (preg_match('/Plazo[^:]*:\s*Hasta el día de hoy,\s*(\d{4})-(\d{2})-(\d{2})/', $plainBody, $matches)) {
                  // Formato: Hasta el día de hoy, 2024-04-29
                  $year = $matches[1];
                  $month = $matches[2];
                  $day = $matches[3];
                  $plazo = date('Y-m-d', strtotime("$year-$month-$day"));
               } else if (preg_match('/Plazo[^:]*:\s*(\d{1,2})\s*de\s*(\w+)\./i', $plainBody, $matches)) {
                  // Formato: "Plazo: 16 de abril."
                  $day = $matches[1];
                  $monthName = $matches[2];
                  $currentYear = date('Y');
                  $months = array(
                     'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                     'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                     'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                  );
                  $month = isset($months[strtolower($monthName)]) ? $months[strtolower($monthName)] : '01';
                  $plazo = date('Y-m-d', strtotime("$currentYear-$month-$day"));
               } else if (preg_match('/Plazo[^:]*:\s*(\d{1,2})\/(\d{1,2})\/(\d{4})/', $plainBody, $matches)) {
                  // Formato: "Plazo: 9/04/2024"
                  $day = $matches[1];
                  $month = $matches[2];
                  $year = $matches[3];
                  $plazo = date('Y-m-d', strtotime("$year-$month-$day"));
               } else if (preg_match('/Plazo para modificar el informe \(con el sustento correspondiente\): (\d{1,2}) de (\w+)\./', $plainBody, $matches)) {
                  // Formato específico: "Plazo para modificar el informe (con el sustento correspondiente): 12 de abril."
                  $day = $matches[1];
                  $monthName = $matches[2];
                  $currentYear = date('Y');
                  $months = array(
                     'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                     'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                     'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
                  );
                  $month = isset($months[strtolower($monthName)]) ? $months[strtolower($monthName)] : '01';
                  $plazo = date('Y-m-d', strtotime("$currentYear-$month-$day"));
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
                        // if($cargar==true and $expediente!=$valor_prede){    
                        $estado='0'; 
                        if($plazo==$valor_prede2){
                            $estado='2';
                        }             
                        $casoControlador = new CasoControlador();
                        $result1 = $casoControlador->guardar($expediente, $correoEncontrado,$proceso,$inbox['id'],$dateLlegada,$plazo,$estado, $IDUser);
                        // }
                        $results = array();
                        $response['data'][] = array(
                            "rowNum" => $rowNum,
                            "id" => $inbox['id'],
                            "from" => $inbox['from'],
                            "subject" => $inbox['subject'],
                            "date" => $dateLlegada,
                            "expediente" => $expediente,
                            "correo" => $correoEncontrado,
                            "proceso" => $proceso,
                            "tarea" => $tarea,
                            "plazo" => $plazo,
                            "cargar" => $cargar,
                            "resultado" => $result1,
                            "estado" => $estado,
                            "valor" => $valor_prede2
                        );
                        $rowNum++;
                    }
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
                    $aux=0;
                    if ($row['estado'] == 0) {
                        $aux=$aux+1;
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
                        $response = $MailController->formatoCorreo($Data);
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
                            return 'Correos enviados correctamente';
                        }
                        error_log($response, 3, base_path()."/enviarCorreo.log");
                        return 'Error en enviarCorreo';
                    }
                    if($aux==0)
                        return 'No hay correos pendientes para: '.$fechaActual;
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