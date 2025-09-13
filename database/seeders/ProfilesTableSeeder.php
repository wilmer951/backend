<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile; // Asegúrate de importar el modelo profile

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create(['name' => 'Manager', 'description' => 'Manages team operations']);
        Profile::create(['name' => 'Developer', 'description' => 'Develops software applications']);
        Profile::create(['name' => 'Designer', 'description' => 'Designs user interfaces and experiences']);
        Profile::create(['name' => 'QA Tester', 'description' => 'Tests software for bugs and issues']);
    }
}
