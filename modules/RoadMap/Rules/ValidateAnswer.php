<?php

namespace Modules\RoadMap\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Modules\RoadMap\Models\Question;

class ValidateAnswer implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $answers, Closure $fail): void
    {
        $validQuestionsAndAnswers = $this->getQuestionsWithAnswers();

        foreach ($answers as $answer) {
            $this->check($answer['answer_id'], $answer['question_id'], $validQuestionsAndAnswers);
        }
    }

    private function check(int $answerId, int $questionId, array $validQuestionsAndAnswers): bool
    {
        return $validQuestionsAndAnswers[$answerId] === $questionId;
    }
    
    private function getQuestionsWithAnswers(): array
    {
        return DB::table('questions')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->get(['answers.id as answer_id', 'questions.id as question_id'])
            ->pluck('question_id', 'answer_id')
            ->toArray();
    }
}
