<?php

namespace App\Http\Controllers\Auth;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\LoginService;





class LoginController extends Controller
{


    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }       
    


    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        
        $credentials = $request->only(['username', 'password']);
        $data = $this->loginService->login($credentials,$request);
  
        return response()->json($data);
    }

    






}
