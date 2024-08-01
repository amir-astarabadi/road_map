<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Enums\QuestionCompetency;
use Modules\RoadMap\Models\Question;
use Modules\RoadMap\Models\Answer;
use Modules\RoadMap\Models\Exam;
use Tests\TestCase;

class ExamControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $authUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser = User::factory()->create();
    }

    // public function test_start_exam()
    // {
    //     Question::factory(2)->has(Answer::factory(2), 'answers')->create();
    //     $response = $this->actingAs($this->authUser)->postJson(route('exams.store'));
    //     $response->assertStatus(Response::HTTP_CREATED);

    //     $response->assertJson(
    //         fn (AssertableJson $response) =>
    //         $response->has('data.exam_id')
    //             ->has("data.questions.0.answers")
    //             ->count("data.questions", Question::count())
    //             ->etc()
    //     );
    //     $this->assertDatabaseCount('exams', 1);
    //     $this->assertDatabaseHas('exams', ['user_id' => $this->authUser->getKey()]);
    // }

    // public function test_start_exam_does_not_create_new_exam_if_an_ongoing_exists()
    // {
    //     Exam::startFor($this->authUser);
    //     $this->assertDatabaseCount('exams', 1);

    //     $this->actingAs($this->authUser)->postJson(route('exams.store'));

    //     $this->assertDatabaseCount('exams', 1);
    //     $this->assertDatabaseHas('exams', ['user_id' => $this->authUser->getKey()]);
    // }

    // public function test_user_can_store_answers()
    // {
    //     $questions = Question::factory(2)->has(Answer::factory(2), 'answers')->create();
    //     $exam = Exam::factory()->forUser($this->authUser)->create();
    //     $inputs = [];


    //     foreach ($questions as $q) {
    //         $inputs['answershit'][] = ['question_id' => $q->getKey(), 'answer_id' => $q->answers->first()->getKey()];
    //     }
    //     $response = $this->actingAs($this->authUser)->putJson(route('exams.update', ['exam' => $exam->getKey()]), $inputs);
        
    //     $response->assertJson(
    //         fn (AssertableJson $json) =>
    //         $json->has('data.category')
    //             ->has('data.category')
    //             ->has('data.competency')
    //             ->count('data.competency', count(QuestionCompetency::cases()))
    //             ->count('data.category', count(QuestionCategory::cases()))
    //             ->etc()
    //     );
    // }
}
