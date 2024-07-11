<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Enums\QuestionCompetency;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalPreference>
 */
class QuestionFactory extends Factory
{

    protected $model = Question::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(10),
            'category' => QuestionCategory::cases()[array_rand(QuestionCategory::cases())],
            'competency' => QuestionCompetency::cases()[array_rand(QuestionCompetency::cases())],
        ];
    }
}
