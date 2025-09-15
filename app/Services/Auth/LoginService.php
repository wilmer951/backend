<?php


namespace App\Services\Auth;

use App\Services\Auth\LoginService;
use App\Models\User;


class LoginService

{
    
    public function login(array $credentials)
    {

         $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
          return  response()->json(['status'=>false, 'message' => 'Credenciales inválidas o usuario no existe'], 401);
            
        }

        // Validar estado
        if ($user->status == 0) {
            
            
            return response()->json(['status'=>false,'message' => 'Usuario inactivo'], 403);
            
        }




        if (!$token = auth()->attempt($credentials)) {
             return response()->json([
                'status' => false,
                'message' => 'Credenciales inválidas' // O podrías mantener la del primer if si aplica
            ], 401); // Unauthorized
        }

        $user = auth()->user();

        // Carga los roles y los módulos de una vez
        $userWithRelations = $user->load('roles.modules');

        $roles = $userWithRelations->roles->pluck('id')->toArray();

        // Obtener los módulos de todos los roles del usuario
        $modules = $userWithRelations->roles->flatMap(function ($role) {
            return $role->modules->pluck('name');
        })->unique()->values()->toArray();


        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 1,
            'username'     => $user->username,
            'roles'        => $roles,
            'modules'      => $modules, // Agregas los módulos aquí
        ]);
    }
}
