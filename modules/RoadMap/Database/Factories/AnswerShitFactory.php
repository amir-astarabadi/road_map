<?php

namespace Modules\RoadMap\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\RoadMap\Models\Answer;
use Modules\RoadMap\Models\Answershit;
use Modules\RoadMap\Models\Exam;
use Modules\RoadMap\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalPreference>
 */
class AnswerShitFactory extends Factory
{

    protected $model = Answershit::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $q = Question::factory()->create();
        return [
            'exam_id' => Exam::factory(),
            'question_id' => $q->getKey(),
            'answer_id' => Answer::factory()->forQuestion($q)->create()->getKey(),
            'score' => random_int(1, 3),
        ];
    }

    public function forExam(Exam $exam)
    {
        return $this->state([
            'exam_id' => $exam->getKey(),
        ]);
    }
}
