<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Carlos Romulo',
            'email' => 'carlos@romulo.com',
            'job' => 'Junior Web Developer',
            'age' => 22,
            'password' => Hash::make('1234'),
        ]);

        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'job' => 'IT Specialist',
            'age' => 50,
            'password' => Hash::make('1234'),


        ]);
    }
}
