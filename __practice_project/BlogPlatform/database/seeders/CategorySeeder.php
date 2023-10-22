<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create([
            'name' => 'Technology',
        ]);
        Category::factory()->create([
            'name' => 'Healthcare',
        ]);
        Category::factory()->create([
            'name' => 'Finance',
        ]);
        Category::factory()->create([
            'name' => 'Automotive',
        ]);
        Category::factory()->create([
            'name' => 'Education',
        ]);
        Category::factory()->create([
            'name' => 'Real Estate',
        ]);
        Category::factory()->create([
            'name' => 'Entertainment',
        ]);
        Category::factory()->create([
            'name' => 'Retail',
        ]);
        Category::factory()->create([
            'name' => 'Hospitality',
        ]);
        Category::factory()->create([
            'name' => 'Manufacturing',
        ]);
        Category::factory()->create([
            'name' => 'Sample Category',
        ]);
        Category::factory()->create([
            'name' => 'Sample Category2',
        ]);
    }
}
