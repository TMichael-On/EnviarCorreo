<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as HttpRequest;

class CasoControlador extends Controller{

    public function guardar($expediente, $correo, $proceso, $inboxID, $dateFormatted, $plazo, $estado, $IDUser) {    
        try {
            $results1 = DB::select('SELECT contar_expediente(?) AS count_result', [$inboxID]); 
            // return $results1[0]->count_result;
            if ($expediente != "No encontrado" && $results1[0]->count_result == 0) {
                $results = DB::select('CALL RegistrarCaso(?, ?, ?, ?, ?, ?, ?, ?)', 
                    [$expediente, $correo, $proceso, $inboxID, $dateFormatted, $plazo, $estado, $IDUser]);   
                // return $results;
                return "CORRECTO";
            } else {
                return "INCORRECTO";
            }
        } catch (Exception $e) {
            return 'Error en guardar caso';
        }
    }


    public function actualizarEstado($formData){
        try{
            $results = DB::select('CALL ActualizarEstado(?,?)', [$formData['ucID'], $formData['date']]);
            return 1;
        } catch (Exception $e) {            
            return 'Error en actualizar estado';
        }
    }
    
    
    public function actEstado(HttpRequest $request) {
    try {
        $ucID = $request->input('ucID');
        $date = $request->input('date');
        $results = DB::select('CALL ActualizarEstado(?,?)', [$ucID, $date]);
        return response()->json(['ucID' => $ucID]);
    } catch (Exception $e) {            
        return response()->json('Error en actualizar estado', 500);
    }
}

}