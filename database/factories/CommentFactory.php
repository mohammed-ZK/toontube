<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'post_id' => Post::all()->random()->id,
            'user_id' => User::all()->random()->id,
            // User::all()->random()->id
            'body' => $this->faker->text(),
        ];
        // $factory->define(App\Reply::class, function (Faker\Generator $faker) {
        //     return [
        //       'thread_id' => 1,
        //       'user_id' => 1,
        //       'body' => $faker->paragraph
        //     ];
        //   });
    }
}
