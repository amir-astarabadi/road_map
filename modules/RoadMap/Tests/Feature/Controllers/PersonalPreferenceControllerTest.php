<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseFormat;
use Modules\RoadMap\Enums\Duration;
use Modules\RoadMap\Enums\NeedDegree;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus as Status;
use Modules\RoadMap\Enums\WorkExperience;
use Modules\RoadMap\Models\Career;
use Modules\RoadMap\Models\PersonalPreference;
use Tests\TestCase;

class PersonalPreferenceControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $authUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser = User::factory()->create();
    }

    public function test_index_method()
    {
        PersonalPreference::factory(2)->forUser($this->authUser)->create();

        $response = $this->actingAs($this->authUser)->getJson(route('personal-preference.index'));

        $this->assertCount(2, $response->json('data'));
    }


    public function test_show_method()
    {
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(Status::FINISH->value)->create();

        $response = $this->actingAs($this->authUser)->getJson(route('personal-preference.show', ['personal_preference' => $personalPreference->getKey()]));

        $response->assertJson(
            fn (AssertableJson $response) =>
            $response->where('data.id', $personalPreference->getKey())
                ->where('data.career', $personalPreference->career_id)
                ->where('data.status', $personalPreference->status)
                ->where('data.budget', $personalPreference->budget)
                ->where('data.work_experience', $personalPreference->work_experience->value)
                ->where('data.course_format', $personalPreference->course_format)
                ->where('data.need_degree', $personalPreference->need_degree)
                ->where('data.duration', $personalPreference->duration)
                ->etc()
        );
    }


    public function test_fill_career()
    {
        $inputs = ['intrested_career' => Career::factory()->create()->getKey()];
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update'), $inputs);
        $this->assertDatabaseHas('personal_preferences', ['user_id' => $this->authUser->getKey(), 'status' => Status::BUDGET->value]);

        $response->assertJson(
            fn (AssertableJson $assertableJson) =>
            $assertableJson
                ->has('data.id')
                ->where('data.status', Status::BUDGET->value)
                ->where('data.career', $inputs['intrested_career'])
                ->etc()
        );
    }

    public function test_fill_budget_amount()
    {
        $inputs = ['budget_amout' => ['min' => 10, 'max' => 1000]];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(Status::BUDGET->value)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', ['user_id' => $this->authUser->getKey(), 'status' => Status::WORK_EXPERIENCE->value]);
        $response->assertJson(
            fn (AssertableJson $assertableJson) =>
            $assertableJson
                ->has('data.id')
                ->where('data.status', Status::WORK_EXPERIENCE->value)
                ->where('data.career', $personalPreference->career_id)
                ->where('data.budget', $inputs['budget_amout'])
                ->etc()
        );
    }

    public function test_fill_work_experience()
    {
        $inputs = ['work_experience' => WorkExperience::TWO_TO_FIVE->value];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(Status::WORK_EXPERIENCE->value)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => Status::COURSE_FORMAT->value,
            'work_experience' => $inputs['work_experience']
        ]);

        $response->assertJson(
            fn (AssertableJson $assertableJson) =>
            $assertableJson
                ->has('data.id')
                ->where('data.status', Status::COURSE_FORMAT->value)
                ->where('data.career', $personalPreference->career_id)
                ->where('data.budget', $personalPreference->budget)
                ->where('data.work_experience', $inputs['work_experience'])
                ->etc()
        );
    }

    public function test_fill_course_format()
    {
        $inputs = ['course_format' => CourseFormat::HYBRIDE->value];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(Status::COURSE_FORMAT->value)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => Status::DEGREE->value,
            'course_format' => $inputs['course_format']
        ]);

        $response->assertJson(
            fn (AssertableJson $assertableJson) =>
            $assertableJson
                ->has('data.id')
                ->where('data.status', Status::DEGREE->value)
                ->where('data.career', $personalPreference->career_id)
                ->where('data.budget', $personalPreference->budget)
                ->where('data.work_experience', $personalPreference->work_experience->value)
                ->where('data.course_format', $inputs['course_format'])
                ->etc()
        );
    }

    public function test_fill_need_degree()
    {
        $inputs = ['need_degree' => NeedDegree::NOT_SURE->value];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(Status::DEGREE->value)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => Status::DURATION->value,
            'need_degree' => $inputs['need_degree'],
        ]);

        $response->assertJson(
            fn (AssertableJson $assertableJson) =>
            $assertableJson
                ->has('data.id')
                ->where('data.status', Status::DURATION->value)
                ->where('data.career', $personalPreference->career_id)
                ->where('data.budget', $personalPreference->budget)
                ->where('data.work_experience', $personalPreference->work_experience->value)
                ->where('data.course_format', $personalPreference->course_format)
                ->where('data.need_degree', $inputs['need_degree'])
                ->etc()
        );
    }

    public function test_fill_duration()
    {
        $inputs = ['duration' => Duration::LESS_THAN_3_MOUNTH->value];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(Status::DURATION->value)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => Status::FINISH->value,
            'duration' => $inputs['duration'],
        ]);

        $response->assertJson(
            fn (AssertableJson $assertableJson) =>
            $assertableJson
                ->has('data.id')
                ->where('data.status', Status::FINISH->value)
                ->where('data.career', $personalPreference->career_id)
                ->where('data.budget', $personalPreference->budget)
                ->where('data.work_experience', $personalPreference->work_experience->value)
                ->where('data.course_format', $personalPreference->course_format)
                ->where('data.need_degree', $personalPreference->need_degree)
                ->where('data.duration', $inputs['duration'])
                ->etc()
        );
    }
}
