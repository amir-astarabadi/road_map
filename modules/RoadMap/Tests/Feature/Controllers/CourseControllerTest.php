<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Models\Course;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $authUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser = User::factory()->create();
        Course::factory(2)->create();
    }

    public function test_user_can_add_a_course_to_his_profile()
    {
        $input = [
            'course_id' => Course::first()->getKey()
        ];
        
        $response = $this->actingAs($this->authUser)->postJson(route('courses.store'), $input);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('course_user', ['user_id' => $this->authUser->getKey(), 'course_id' => $input['course_id']]);
    }

    public function test_when_user_adding_new_course_do_not_delete_last_ones()
    {
        Course::first()->users()->attach([$this->authUser->getKey()]);
        $input = [
            'course_id' => Course::latest()->first()->getKey()
        ];
        
        $response = $this->actingAs($this->authUser)->postJson(route('courses.store'), $input);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('course_user', ['user_id' => $this->authUser->getKey(), 'course_id' => $input['course_id']]);
        $this->assertDatabaseHas('course_user', ['user_id' => $this->authUser->getKey(), 'course_id' => Course::first()->getKey()]);
    }
}














