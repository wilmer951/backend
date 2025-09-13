<?php   
namespace App\Services\Users;

use App\Models\User;

use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;  

class UserService
{
    public function getAll()
    {
            $users = User::select('id', 'username', 'name', 'profile_id', 'email', 'status', 'last_login')
            ->with([
                // Carga la relación 'roles' y selecciona solo 'id' y 'name'
                'roles:id,name',

                // Carga la relación 'profile' y selecciona solo 'id' y 'name'
                // Esto asume que tienes un método `profile()` en tu modelo `User`
                'profile:id,name',
            ])
            ->get();

        return $users;
    }


    public function create(array $data)
    {
           try {
        DB::beginTransaction();

        $user = User::create([
            'username' => $data['usuario'],
            'name' => $data['nombres'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_id' => $data['perfil'],
            'status' => 1,
            'last_login' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->roles()->attach($data['rol']);
        $user->load('roles');

        DB::commit();

        return [
            'status' => true,
            'message' => 'Usuario creado exitosamente.',
            'data' => $user,
        ];

    } catch (\Exception $e) {
        DB::rollBack();

        // Manejo de errores (puedes lanzar una excepción si prefieres)
        return [
            'status' => false,
            'message' => 'Error al crear el usuario.',
            'error' => $e->getMessage(),
        ];
    }
}                   

    }









