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
        'perfil' => 'required|integer',
        'rol' => 'required|array',
        'rol.*' => 'integer|exists:rol,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $validated = $validator->validated();

    return response()->json($this->userService->create($validated), 201);


}

}


