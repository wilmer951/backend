<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- ¡Añade esta línea!
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // <-- Add this line


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $user = User::create([
            'username' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345'),
            'profile_id' => 1,
            'last_login' => Carbon::now(),
            'status' => 1,
        ]);

        

        $user->roles()->attach([1, 2]);  // admin y editor
    }
}
