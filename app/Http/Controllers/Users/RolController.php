<?php

namespace App\Http\Controllers\Users;
use App\Services\Users\RolService;



use Laravel\Lumen\Routing\Controller as BaseController;

class RolController extends BaseController
{


    public function __construct(RolService $rolService)
    {
        $this->rolService = $rolService;
    }

    public function index()
    {
        
        return response()->json($this->rolService->getAll ());
    }

   






}
