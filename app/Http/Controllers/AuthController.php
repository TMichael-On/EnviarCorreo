<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Firebase\JWT\JWT;

class AuthController extends Controller{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function jwt(Usuario $usuario) 
    {
        $payload = [
            'iss' => "api-jwt",
            'sub' => $usuario->IDUser,
            'iat' => time(),
            'exp' => time() + 180 * 60
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function login(Usuario $usuario) 
    {
        $this->validate($this->request,[
            'correo' => 'required|email',
            'contra' =>'required'
        ]);

        $usuario = usuario::where('correo', $this->request->input('correo'))->first();
        if(!$usuario){
            return response()->json([
                'error' => 'El correo no existe'
            ], 400);            
        }
        // $hashMD5_clave = md5($this->request->input('contra'));
        $hashMD5_clave = ($this->request->input('contra'));
        if ($hashMD5_clave == $usuario->contra){
            return response()->json([
                'token' => $this->jwt($usuario)
            ], 200);   
        }
        
        return response()->json([
            'error' => 'La contraseña es incorrecta'
        ], 400);
    }
}