<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\Users\UserService; 
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{
    protected $userService;


    public function __construct()
    {
        $this->userService = new UserService();
    }




        public function index()
    {

        return response()->json($this->userService->getAll ());
  
    }

     public function register(Request $request)
    {
    

            $validator = Validator::make($request->all(), [
                'usuario' => 'required|string|max:255|unique:users,username',
                'nombres' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6',
                'confirmar_password' => 'required|string|same:password',
                'perfil' => 'required|integer|exists:profile,id',
                'rol' => 'required|array',
                'rol.*' => 'integer|exists:rol,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $validated = $validator->validated();

            return response()->json($this->userService->create($validated), 201);


        }



        public function update(Request $request,$id)
                {
                    // 1. Validar los datos de entrada
                        $validator = Validator::make($request->all(), [
                            
                            'nombres' => 'required|string|max:255',
                            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
                            'perfil' => 'required|integer|exists:profile,id',
                            'rol' => 'required|array',
                            'rol.*' => 'integer|exists:rol,id',
                            'status' => 'required|integer|in:0,1',
                        ]);

                        // 2. Si la validación falla, devolver los errores  
                        if ($validator->fails()) {
                            return response()->json(['errors' => $validator->errors()], 422);
                        }

                        // 3. Obtener los datos validados
                        $validated = $validator->validated();
                        
                        // 4. Llamar al servicio de actualización y devolver la respuesta
                        return response()->json($this->userService->update($id, $validated), 200);
                    }   




            public function delete($id)
            {
                return response()->json($this->userService->delete($id));
            }



            public function resetPassword(Request $request,$id)
            {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|string|min:6',  
                     'confirmar_password' => 'required|string|same:password',
                ]);

            
                  if ($validator->fails()) {
                            return response()->json(['errors' => $validator->errors()], 422);
                        }

                        $validated = $validator->validated();

                    return response()->json($this->userService->resetPassword($id, $validated), 200);
            }
                        





}
