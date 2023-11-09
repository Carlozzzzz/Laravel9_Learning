<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'first_name' => 'Carlos',
            'last_name' => 'Maralit',
            'gender' => 'male',
            'email' => 'echibot1@gmail.com',
            'password' => bcrypt('password'),
            'user_type' => 'teacher',
        ]);
        
        \App\Models\User::factory(100)->create();
    }
}
