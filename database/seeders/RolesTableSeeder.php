<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users\Rol;



class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create(['name' => 'admin', 'description' => 'Administrador del sistema']);
        Rol::create(['name' => 'calidad', 'description' => 'Editor de contenido']);
        Rol::create(['name' => 'auditor', 'description' => 'Usuario con acceso de solo lectura']);
    
    }
}
   