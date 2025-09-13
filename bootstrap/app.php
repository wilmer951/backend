<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

// Habilitar Facades y Eloquent (necesarios para JWT y modelos)
$app->withFacades();
$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
*/

$app->configure('app');
$app->configure('auth');   // Configuración para autenticación
$app->configure('jwt');    // Configuración para JWT

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
*/

// Middleware global (se ejecuta en todas las peticiones)
$app->middleware([
    App\Http\Middleware\CorsMiddleware::class,
]);

// Middleware de rutas (para proteger rutas con 'auth')
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'app:api' => Tymon\JWTAuth\Http\Middleware\Authenticate::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
*/

// Registrar el Service Provider de JWT
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);

// Puedes registrar otros providers personalizados aquí
// $app->register(App\Providers\AppServiceProvider::class);


$app->bind(App\Services\Users\RolService::class, function ($app) {
    return new App\Services\Users\RolService();
});

$app->bind(App\Services\Users\ProfileService::class, function ($app) {
    return new App\Services\Users\ProfileService();
});
$app->bind(App\Services\Users\UserService::class, function ($app) {
    return new App\Services\Users\UserService();
}); 


/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
