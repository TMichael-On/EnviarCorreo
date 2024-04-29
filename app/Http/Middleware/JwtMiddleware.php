<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->header('Authorization')) {
            return response()->json([
                'error' =>'Usted no cuenta con los permisos necesarios'
            ],401);
        }

        $array_token = explode(' ', $request->header('Authorization'));
        $token = $array_token[1];

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'La sesión expiro'
            ], 400);        
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Algo salio mal '.$e]
            , 400);        
        }

        $usuario = Usuario::find($credentials->sub);

        $request->auth = $usuario;

        return $next($request);
    }
}
