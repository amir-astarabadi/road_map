<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Models\Answer;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalPreference>
 */
class AnswerFactory extends Factory
{

    protected $model = Answer::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'title' => fake()->realText(10),
            'score' => random_int(1,3),
        ];
    }
}
