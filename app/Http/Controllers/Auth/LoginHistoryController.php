<?php

namespace App\Http\Controllers\Auth;

use Laravel\Lumen\Routing\Controller;
use App\Services\Auth\LoginHistoryService;
use Illuminate\Http\Request;




class LoginHistoryController extends Controller
{

    public function __construct(LoginHistoryService $loginHistoryService)
    {
        $this->loginHistoryService = $loginHistoryService;
    }




    public function index(Request $request)
    {
         $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
       

        // Validar que los valores sean mayores a cero
        if ($perPage <= 0) {
            $perPage = 10;
        }
        if ($page <= 0) {
            $page = 1;
        }



        return $this->loginHistoryService->getAll($page, $perPage);



        // El controlador da formato a la respuesta
        return response()->json($history);
    }
}
