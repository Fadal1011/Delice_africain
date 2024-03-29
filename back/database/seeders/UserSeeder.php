<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'bertha',
            'email' => 'bertha@gmail.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'khady',
            'email' => 'khady@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // Ajoutez autant d'utilisateurs que nécessaire
    }
}
