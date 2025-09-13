<?php

namespace App\Http\Controllers\Users;

use App\services\Users\ProfileService;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProfileController extends BaseController
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return response()->json($this->profileService->getAll ());
    }

}
