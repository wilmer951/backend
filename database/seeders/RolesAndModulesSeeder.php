<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndModulesSeeder extends Seeder
{
    public function run()
    {
        // Insertar roles
        DB::table('rol')->insert([
            ['name' => 'admin'],
            ['name' => 'calidad'],
            ['name' => 'auditor'],
        ]);

        // Insertar módulos
        DB::table('module')->insert([
            ['name' => 'users'],
            ['name' => 'calidad'],
            ['name' => 'auditoria'],
        ]);

        // Relación role ↔ módulos
        DB::table('rol_module')->insert([
            // admin tiene acceso a todo
            ['rol_id' => 1, 'module_id' => 1],
            ['rol_id' => 1, 'module_id' => 2],
            ['rol_id' => 1, 'module_id' => 3],

            // cliente solo módulo calidad
            ['rol_id' => 2, 'module_id' => 2],

            // vendedor solo módulo auditoria
            ['rol_id' => 3, 'module_id' => 3],
        ]);
    }
}
