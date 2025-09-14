<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ModuleMiddleware
{
    public function handle($request, Closure $next, $module)
    {

          \Log::info("Middleware ejecutado para el módulo: " . $module);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Verificar si el usuario tiene acceso al módulo
        if (!$user->hasModule($module)) {
            return response()->json(['error' => 'Acceso denegado al módulo ' . $module], 403);
        }

        return $next($request);
    }
}
