<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;

class CuadroControlador extends Controller{

    public function buscarById(Request $request){
        $id = $this->validar($request);
        date_default_timezone_set('America/Lima');
        $fechaActual = Carbon::now('America/Lima')->format('Y-m-d');

        $data = DB::select('CALL VerDatosEnviado(?,?)', [$id,$fechaActual]);
        return response()->json($data);
    }

    public function listar(Request $request){
        $id = $this->validar($request);
        $data = DB::select('CALL VerDatosUserCase(?)', [$id]);
        return response()->json($data);
    } 

    public function validar($request){
        if (!$request->header('Authorization')) {
            return response()->json([
                'error' =>'Usted no cuenta con los permisos necesarios'
            ],401);
        }

        $array_token = explode(' ', $request->header('Authorization'));
        $token = $array_token[1];

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            return $credentials->sub;
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'La sesión expiro'
            ], 400);        
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Algo salio mal']
            , 400);        
        }        
    }  
    
    public function prueba() {
        $MailController = new MailController();
        $data = $MailController->enviarCorreo('cdelacallecoz','121312');
        if($data['error']){
            return response()->json([
                'error' => 'Error'
            ],
             500);
        }
        // return $data;
    }
}