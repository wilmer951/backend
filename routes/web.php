<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// Ruta pública para login
$router->post('/login', 'Auth\LoginController@login');

// ✅ Rutas protegidas con JWT
$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->get('/profiles', 'Users\ProfileController@index');
    $router->get('/roles', 'Users\RolController@index');
    $router->get('/check-token', function () {
        return response()->json(['valid' => true]);
    });



});



$router->group(['middleware' => ['module:users', 'auth:api']], function () use ($router) {


    $router->get('/users', 'Users\UserController@index');
    $router->post('/register', 'Users\UserController@register');
    $router->put('/users/{id}', 'Users\UserController@update');
    $router->delete('/users/{id}', 'Users\UserController@delete');
    $router->put('/reset-password/{id}', 'Users\UserController@resetPassword'); 

    });



$router->group(['middleware' => ['module:auditoria', 'auth:api']], function () use ($router) {

        $router->get('/loginHistory', 'Auth\LoginHistoryController@index');
    

    });


    $router->get('/pruebaloginHistory', 'Auth\LoginHistoryController@index');