<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use Illuminate\Support\Facades\DB;

class CasoControlador extends Controller{

    public function guardar($expediente, $correo,$proceso,$inboxID,$dateFormatted,$plazo,$estado, $IDUser){    
        $results = DB::select('CALL RegistrarCaso(?,?,?,?,?,?,?,?)', 
        [$expediente, $correo,$proceso,$inboxID,$dateFormatted,$plazo,$estado, $IDUser]);   
         
        return $results;
    }

}