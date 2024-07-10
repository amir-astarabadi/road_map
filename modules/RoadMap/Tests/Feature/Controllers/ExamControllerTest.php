<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
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

    public function test_start_exam()
    {
        Question::factory(2)->has(Answer::factory(2), 'answers')->create();
        $response = $this->actingAs($this->authUser)->postJson(route('exams.store'));
        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJson(
            fn (AssertableJson $response) =>
            $response->has('data.exam_id')
                ->has("data.questions.0.answers")
                ->count("data.questions", Question::count())
                ->etc()
        );
        $this->assertDatabaseCount('answershits', Question::count());
        $this->assertDatabaseCount('exams', 1);
        $this->assertDatabaseHas('exams', ['user_id' => $this->authUser->getKey()]);
        $this->assertDatabaseHas('answershits', ['question_id' => $response->json('data.questions.0.id'), 'exam_id' => $response->json('data.exam_id')]);
    }

    public function test_start_exam_does_not_create_new_exam_if_an_ongoing_exists()
    {
        Exam::startFor($this->authUser);
        $this->assertDatabaseCount('exams', 1);

        $this->actingAs($this->authUser)->postJson(route('exams.store'));

        $this->assertDatabaseCount('exams', 1);
        $this->assertDatabaseHas('exams', ['user_id' => $this->authUser->getKey()]);
    }

}
