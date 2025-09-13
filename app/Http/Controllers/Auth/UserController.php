<?php

namespace App\Http\Controllers\Auth;

use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{

    public function me()
    {
        return response()->json(auth()->user());
    }
}
