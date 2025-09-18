<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CustomJWTMiddleware
{
   public function handle($request, Closure $next)
{
    try {
        if (! $request->bearerToken()) {
            return response()->json(['error' => 'Token no enviado'], 402);
        }

        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['error' => 'Usuario no encontrado'], 401);
        }

    } catch (TokenExpiredException $e) {
        return response()->json(['error' => 'Token expirado'], 401);
    } catch (TokenInvalidException $e) {
        return response()->json(['error' => 'Token inválido'], 401);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Token no enviado'], 401);
    }

    return $next($request);
}

}
