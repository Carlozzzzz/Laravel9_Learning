<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = fake()->randomElement($array = array('Male','Female'));


        return [
            'user_image' => fake()->imageUrl(360, 360, 'people', true),
            'user_cover_image' => fake()->imageUrl(1000, 360, 'house', true),
            'name' => fake()->name($gender) ,
            'gender' => $gender,
            'email' => fake()->unique()->safeEmail(),
            'contact_number' => '09123456789',
            'age' => rand(15, 30),
            'industry' => fake()->randomElement($array = array('Technology', 'Healthcare', 'Finance', 'Automotive', 'Education', 'Real Estate', 'Entertainment', 'Retail', 'Hospitality', 'Manufacturing')),
            'occupation' => fake()->jobTitle(),
            // 'country' => fake()->country(),
            'country_id' => fake()->randomElement(Country::all())['id'],
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
