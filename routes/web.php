<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// Ruta pública para login
$router->post('/login', 'Auth\LoginController@login');
$router->get('/roles', 'Users\RolController@index');
$router->get('/users', 'Users\UserController@index');
$router->get('/profiles', 'Users\ProfileController@index');
$router->post('/register', 'Users\UserController@register');

// ✅ Rutas protegidas con JWT
$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->get('/me', 'UserController@me');
    $router->get('/check-token', function () {
        return response()->json(['valid' => true]);
    });






});



