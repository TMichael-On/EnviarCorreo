<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use Illuminate\Support\Facades\DB;

class CasoControlador extends Controller{

    public function guardar($expediente, $correo,$proceso,$inboxID,$dateFormatted,$plazo,$estado, $IDUser){    
        try{
            $results = DB::select('CALL RegistrarCaso(?,?,?,?,?,?,?,?)', 
            [$expediente, $correo,$proceso,$inboxID,$dateFormatted,$plazo,$estado, $IDUser]);   
            
            return $results;
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

}