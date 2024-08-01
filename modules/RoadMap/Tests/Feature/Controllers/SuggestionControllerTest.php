<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Enums\QuestionCompetency;
use Modules\RoadMap\Models\Answer;
use Modules\RoadMap\Models\Answershit;
use Modules\RoadMap\Models\Exam;
use Modules\RoadMap\Models\Question;
use Tests\TestCase;

class SuggestionControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $authUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser = User::factory()->create();
        $questions = Question::factory(2)->has(Answer::factory(2), 'answers')->create();
        $exam = Exam::factory()->forUser($this->authUser)->create();
        $inputs = [];


        foreach ($questions as $q) {
            $inputs['answershit'][] = ['question_id' => $q->getKey(), 'answer_id' => $q->answers->first()->getKey()];
        }
        $this->actingAs($this->authUser)->putJson(route('exams.update', ['exam' => $exam->getKey()]), $inputs);
        
    }

    public function test_show_method()
    {
        
        $response = $this->actingAs($this->authUser)->getJson(route('suggestions.show'));
        $this->assertTrue(true);
    }
}
