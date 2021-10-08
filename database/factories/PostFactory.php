<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'body' => $this->faker->text(),
            'category_id' => Category::all()->random()->id,
            'image' => "uploads/folder_1/folder_2/2cd9390ec06bb5c8061532ae9aeb7c84.jpg",
            // 'statues' => true, // password
        ];
    }
}
