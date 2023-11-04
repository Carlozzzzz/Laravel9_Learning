<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
        ]);
        
        \App\Models\User::factory(10)->create();

    }
}
