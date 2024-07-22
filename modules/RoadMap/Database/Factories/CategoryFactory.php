<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\RoadMap\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalPreference>
 */
class CategoryFactory extends Factory
{

    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
