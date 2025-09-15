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
                'roles.modules:id,name',
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
            
        


     public function update(int $id, array $data): array
    {
                try {
                    DB::beginTransaction(); // Inicia una transacción para asegurar la atomicidad.

                    // Encuentra el usuario por su ID. Si no existe, lanza una excepción.
                    $user = User::findOrFail($id);

                    // Prepara los datos para la actualización, excluyendo la contraseña.
                    $updateData = [
                        
                        'name' => $data['nombres'],
                        'email' => $data['email'],
                        'profile_id' => $data['perfil'],
                        'status' => $data['status'], // Asume que 'status' puede ser parte de los datos a actualizar.
                        'updated_at' => Carbon::now(), // Registra la fecha de actualización.
                    ];

                    // Actualiza la información principal del usuario.
                    $user->update($updateData);

                    // Sincroniza los roles. `sync` maneja la adición, eliminación y mantenimiento de las relaciones.
                    $user->roles()->sync($data['rol']);

                    // Vuelve a cargar la relación de roles para asegurar que los datos estén al día.
                    $user->load('roles');

                    DB::commit(); // Confirma la transacción si todas las operaciones fueron exitosas.

                    return [
                        'status' => true,
                        'message' => 'Usuario actualizado exitosamente.',
                        'data' => $user, // Devuelve el usuario actualizado.
                    ];

                } catch (\Exception $e) {
                    DB::rollBack(); // Revierte la transacción si ocurre algún error.

                    // Devuelve un mensaje de error indicando el problema.
                    return [
                        'status' => false,
                        'message' => 'Error al actualizar el usuario.',
                        'error' => $e->getMessage(), // Incluye el mensaje de error técnico para depuración.
                    ];
                }
            }
        




            public function delete(int $id)
            {
                try {
                        DB::beginTransaction();

                        $user = User::findOrFail($id);

                        // Primero elimina la relación con roles
                        $user->roles()->detach();

                        // Luego elimina al usuario
                        $user->delete();

                        DB::commit();

                        return [
                            'status' => true,
                            'message' => 'Eliminacion exitoso.',
                        ];

                    } catch (\Exception $e) {
                        DB::rollBack();
                        return [
                            'status' => false,
                            'message' => 'Error al eliminar el usuario.',
                            'error' => $e->getMessage(),
                        ];
                    }


              }








        public function resetPassword(int $id, array $data)
       {
        
             try {
                        DB::beginTransaction();

                        $user = User::findOrFail($id);

                        $updateData = [
                            'password' => Hash::make($data['password']),
                            'updated_at' => Carbon::now(),
                        ];

                        $user->update($updateData);

                        DB::commit();

                        return [
                            'status' => true,
                            'message' => 'Contraseña restablecida exitosamente.',
                        ];  

                    
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return [
                            'status' => false,
                            'message' => 'Error al restablecer la contraseña del usuario el usuario.',
                            'error' => $e->getMessage(),
                        ];
                    }





    }












       }


        


