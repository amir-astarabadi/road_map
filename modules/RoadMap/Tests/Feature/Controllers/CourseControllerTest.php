<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Models\Course;
use Modules\RoadMap\Models\Exam;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $authUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser = User::factory()->create();
        Exam::factory()->forUser($this->authUser)->create();
        Course::factory()->create();
        Course::factory()->create();
    }

    public function test_user_can_add_a_course_to_his_profile()
    {
        Course::latest()->first()->attachToUser($this->authUser);
        $input = [
            'course_id' => Course::where('id', '!=', Course::latest()->first()->id)->first()->getKey()
        ];

        $response = $this->actingAs($this->authUser)->postJson(route('courses.store'), $input);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('course_user', ['user_id' => $this->authUser->getKey(), 'course_id' => $input['course_id']]);
    }

    public function test_when_user_adding_duplicate_course_get_401()
    {
        Course::first()->users()->attach([$this->authUser->getKey()]);
        $input = [
            'course_id' => Course::latest()->first()->getKey()
        ];

        $response = $this->actingAs($this->authUser)->postJson(route('courses.store'), $input);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
