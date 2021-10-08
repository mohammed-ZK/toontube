<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Serie;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title' => $this->faker->name(),
            'URL' => $this->faker->url(),
            'series_id' => Serie::all()->random()->id,
            'intro_start' => $this->faker->time(),
            'intro_end' => $this->faker->time(),
            'outro_start' => $this->faker->time(),
            'outro_end' => $this->faker->time(),
        ];
    }
}
