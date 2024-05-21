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
$router->post('/actualizarEstado', 'CasoControlador@actEstado');
$router->get('/leerCorreo', 'ProgramadoControlador@leerCorreo');
$router->get('/enviarCorreo', 'ProgramadoControlador@enviarCorreo');

$router->get('/recuperar-pass', 'UsuarioControlador@vista_recuperar_pass');
$router->get('/', 'UsuarioControlador@vista_login');
$router->get('/login', 'UsuarioControlador@vista_login');
$router->get('/register', 'UsuarioControlador@vista_register');
$router->get('/home', 'UsuarioControlador@vista_home');
$router->get('/cambiar-pass', 'UsuarioControlador@vista_cambiar_pass');


$router->group(
    ['middleware'=>'jwt.auth'],
    function () use ($router) {
        // USUARIO
        $router->post('/actualizar', 'UsuarioControlador@actualizar');
        $router->get('/buscarById', 'UsuarioControlador@buscarById');
        $router->post('/filtrarAnio', 'UsuarioControlador@filtrarAnio');
        $router->post('/filtrarMes', 'UsuarioControlador@filtrarMes');
        $router->post('/reporteMes', 'UsuarioControlador@reporteMes');

        // CUADRO
        $router->get('/data-date', 'CuadroControlador@buscarById');
        $router->get('/data', 'CuadroControlador@listar');
    }
);

