<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rate::class;

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
            'rate' => $this->faker->numberBetween($min = 1, $max = 5),
        ];
    }
}
