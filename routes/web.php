<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// Ruta pública para login
$router->post('/login', 'Auth\LoginController@login');

// ✅ Rutas protegidas con JWT
$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->get('/me', 'UserController@me');
    $router->get('/profiles', 'Users\ProfileController@index');
    $router->get('/roles', 'Users\RolController@index');
    $router->get('/check-token', function () {
        return response()->json(['valid' => true]);
    });



});



$router->group(['middleware' => ['module:usuarios', 'auth:api']], function () use ($router) {


    $router->get('/users', 'Users\UserController@index');
    $router->post('/register', 'Users\UserController@register');
    $router->put('/users/{id}', 'Users\UserController@update');
    $router->delete('/users/{id}', 'Users\UserController@delete');
    $router->put('/reset-password/{id}', 'Users\UserController@resetPassword'); 

    });



$router->get('/prueba/{id}/module', function ($id) {
    $rol = App\Models\Users\Rol::with('modules')->find($id);

    if (!$rol) {
        return response()->json(['error' => 'Rol no encontrado'], 404);
    }

    if ($rol->modules->isEmpty()) {
        return response()->json(['error' => 'Acceso denegado, este rol no tiene módulos'], 403);
    }

    return response()->json($rol->modules);
});
