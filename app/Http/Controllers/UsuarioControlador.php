<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Http\Controllers\MailController;

class UsuarioControlador extends Controller
{

    public function buscarById(Request $request)
    {
        try {
            $id = $this->validar($request);
            $usuario = new Usuario;
            $data = $usuario->find($id);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un error al procesar la petición',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function guardar(Request $request)
    {
        try {
            // Validar la solicitud utilizando las reglas de validación de Laravel
            $rules =[
                'correo' => 'required|unique:tbl_user,correo',
                'nombres' => 'required',
                'apellidos' => 'required',
                'contra' => 'required',
                'urlGmail' => 'required',
            ];
            $this->validate($request, $rules);

            // Obtener los datos de la solicitud
            $data = $request->all();

            // Crear un nuevo usuario
            $usuario = new Usuario;
            $usuario->fill([
                'correo' => $data['correo'],
                'nombres' => $data['nombres'],
                'apellidos' => $data['apellidos'],
                'contra' => md5($data['contra']), // No se recomienda utilizar md5 para almacenar contraseñas
                'url_gmail' => $data['urlGmail'], // Asegúrate de que el nombre del campo sea correcto
            ]);
            $usuario->save();

            // Retornar una respuesta de éxito
            return response()->json([
                'success' => "Registro exitoso."
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo de errores de validación
            return response()->json([
                'error_validation' => $e->validator->errors()->first()
            ]);
        } catch (\Exception $e) {
            // Capturar y manejar cualquier excepción
            return response()->json([
                'error' => 'Hubo un error al procesar la petición'
            ], 500);
        }
    }

    public function actualizar(Request $request)
    {
        try {
            $id = $this->validar($request);
            $usuario = Usuario::find($id);

            if ($usuario) {
                if ($request->input('contra')) {
                    $usuario->contra = md5($request->input('contra'));
                }
                $usuario->save();
                return response()->json([
                    'message' => 'Registro actualizado'
                ]);
            }
            return response()->json($mensaje = 'Usuario no encontrado');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Hubo un error al procesar la petición'
            ], 500);
        }
    }

    public function recuperarContra(Request $request)
    {
        try {
            $usuario = Usuario::Where('correo', $request->correo)->first();
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
                'dont_existing_email' => 'Correo no encontrado',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Hubo un error al procesar la petición',
            ], 500);
        }
    }

    public function validar($request)
    {
        if (!$request->header('Authorization')) {
            return response()->json([
                'error' => 'Usted no cuenta con los permisos necesarios'
            ], 401);
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
            return response()->json(
                [
                    'error' => 'Algo salio mal'
                ],
                400
            );
        }
    }

    public function vista_login()
    {
        return view('login');
    }

    public function vista_recuperar_pass()
    {
        return view('recuperar_pass');
    }

    public function vista_register()
    {
        return view('register');
    }

    public function vista_home()
    {
        return view('home');
    }

    public function vista_cambiar_pass()
    {
        return view('cambiar_pass');
    }
}
