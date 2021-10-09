<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        
        $this->call(CategorySeeder::class);
        $this->call(typeSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(RateSeeder::class);
        $this->call(SerieSeeder::class);
        $this->call(VideoSeeder::class);
    }
}
