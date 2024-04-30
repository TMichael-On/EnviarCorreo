<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->post('/acceso', 'AuthController@login');
$router->post('/guardar', 'UsuarioControlador@guardar');

//----------------USUARIO------------
$router->post('/recuperarContra', 'UsuarioControlador@recuperarContra');
$router->get('/leerCorreo', 'ProgramadoControlador@leerCorreo');
$router->get('/prueba', 'ProgramadoControlador@enviarCorreo');

$router->group(
    ['middleware'=>'jwt.auth'],
    function () use ($router) {
        // USUARIO
        $router->get('/buscarById', 'UsuarioControlador@buscarById');
        $router->post('/actualizar', 'UsuarioControlador@actualizar');

        // CUADRO
        // $router->get('/data', 'CuadroControlador@buscarById');
        $router->get('/data', 'CuadroControlador@listar');
    }
);

