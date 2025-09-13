<?php
namespace App\Services\Users;

use App\Models\Users\Rol;

class RolService
{
    public function getAll()
    {
        return Rol::all();
    }
}