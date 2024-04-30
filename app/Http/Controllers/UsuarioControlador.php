<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Http\Controllers\MailController;

class UsuarioControlador extends Controller{

    public function buscarById(Request $request){
        try{
            $id = $this->validar($request);
            $usuario = new Usuario;
            $data= $usuario->find($id);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un error al procesar la petición', 
                'error' => $e->getMessage()
            ], 500);
        }
    }  

    public function guardar(Request $request){
        try{        
            $usuario = new Usuario;
            $data = $request->all();
            $data['contra'] = md5($data['contra']);
            $usuario->fill($data);
            $usuario->save();

            return response()->json($usuario);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un error al procesar la petición', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function actualizar(Request $request) {
        try{
            $id = $this->validar($request);
            $usuario = Usuario::find(1);

            if($usuario){
                if($request->input('contra')){
                    $usuario->contra = md5($request->input('contra'));
                }
                $usuario->save();
                return response()->json($mensaje = 'Registro actualizado');
            }
            return response()->json($mensaje = 'Usuario no encontrado');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un error al procesar la petición', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function recuperarContra(Request $request) {
        try{       
            $usuario = Usuario::Where('correo',$request->correo)->first();
            // return $usuario;
            $contra = ($request->input('contra'));
            if ($usuario) {
                $usuario->contra = md5($contra);
                $usuario->save();
                $correo = $usuario->correo;
                $mailController = new MailController();
                $resultado = $mailController->enviarCorreo($correo, $contra);
                return $resultado;
            }
            return response()->json([
                'error' => 'dont_existing_email',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un error al procesar la petición', 
                'error' => $e->getMessage()
            ], 500);
        }
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
    
}