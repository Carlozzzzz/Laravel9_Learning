<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement($array = array(
                'Technology',
                'Healthcare',
                'Finance',
                'Automotive',
                'Education',
                'Real Estate',
                'Entertainment',
                'Retail',
                'Hospitality',
                'Manufacturing')),
        ];
    }
}
