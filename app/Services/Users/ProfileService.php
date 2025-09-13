<?php

namespace App\Services\Users;

use App\Services\Users\ProfileService; 
use App\Models\Users\Profile; 



class ProfileService
{
    public function getAll()
    {
        return Profile::all();
    }
}
