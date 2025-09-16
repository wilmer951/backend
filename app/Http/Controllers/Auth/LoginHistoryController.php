<?php

namespace App\Http\Controllers\Auth;

use Laravel\Lumen\Routing\Controller;
use App\Services\Auth\LoginHistoryService;



class LoginHistoryController extends Controller
{

    public function __construct(LoginHistoryService $loginHistoryService)
    {
        $this->loginHistoryService = $loginHistoryService;
    }




    public function index()
    {
        return $this->loginHistoryService->getAll();
    }
}
