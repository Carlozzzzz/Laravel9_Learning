<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = fake()->randomElement($array = array(
            'cat',
            'dog',
            'bird',
            'duck'
        ));
        
        return [
            'post_image' => fake()->imageUrl(360, 360, 'animals', true, $category),
            'title' => fake()->text(rand(30,50)),
            'content' => fake()->text(rand(100,450)),
            'user_id' => rand(1, 20),
        ];
    }
}
