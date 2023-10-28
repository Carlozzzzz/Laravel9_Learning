<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // My default account
        User::factory()->create([
            'user_image' => "https://api.dicebear.com/avatar.svg",
            'user_cover_image' => "",
            'name' => "Carlos Maralit",
            'gender' => "Male",
            'email' => "echibot1@gmail.com",
            'contact_number' => '09123456789',
            'age' => 23,
            'industry' => "IT | Software Engineer",
            'occupation' => "Freelancer",
            'country_id' => 175,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        
        User::factory(100)->create();

    }
}
