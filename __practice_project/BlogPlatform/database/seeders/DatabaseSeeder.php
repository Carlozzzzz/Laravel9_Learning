<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		//disable foreign key check for this connection before running seeders
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		
        $this->call(CountrySeeder::class);
        
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CategorySeeder::class);
        
        $this->call(PostCategorySeeder::class);
        $this->call(CommentSeeder::class);

        $this->call(InterestSeeder::class);

        // supposed to only apply to a single connection and reset it's self
		// but I like to explicitly undo what I've done for clarity
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
