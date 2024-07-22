<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalPreference>
 */
class CourseFactory extends Factory
{

    protected $model = Course::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(random_int(10, 20)),
            'description' => fake()->realText(random_int(200, 300)),
            'level' => 3,
            'level_up_from' => 1,
            'level_up_to' => 2,
            'url' => 'https://www.youtube.com/watch?v=oTugjssqOT0',
            'price' => random_int(0, 100),
            'courseable_type' => 'Modules\\RoadMap\\Models\\Career',
            'courseable_id' => 1,
        ];
    }
}
