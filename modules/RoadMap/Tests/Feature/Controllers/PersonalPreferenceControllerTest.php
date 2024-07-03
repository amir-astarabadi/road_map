<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLocation;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus;
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

    public function test_fill_budget_amount()
    {
        $response = $this->actingAs($this->authUser)->postJson(route('personal-preference.store'));
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('personal_preferences', ['user_id' => $this->authUser->getKey(), 'status' => PersonalPreferencesProcessStatus::START]);
        $response->assertJson(
            function (AssertableJson $assertableJson) {
                $assertableJson
                    ->has('data.id')
                    ->where('data.status', PersonalPreferencesProcessStatus::START)
                    ->where('data.budget', null)
                    ->where('data.course_length_type', null)
                    ->where('data.course_location_type', null)
                    ->where('data.industries', null)
                    ->where('data.jobs', null)
                    ->etc();
            }
        );
    }

    public function test_fill_course_lenght()
    {
        $inputs = ['course_length' => CourseLength::SHORT_TERM];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(PersonalPreferencesProcessStatus::COURSE_LENGTH)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => PersonalPreferencesProcessStatus::COURSE_LOCATION,
            'course_length_type' => $inputs['course_length']
        ]);

        $response->assertJson(
            function (AssertableJson $assertableJson) use($inputs){
                $assertableJson
                    ->has('data.id')
                    ->where('data.status', PersonalPreferencesProcessStatus::COURSE_LOCATION)
                    ->where('data.budget', null)
                    ->where('data.course_length_type', $inputs['course_length'])
                    ->where('data.course_location_type', null)
                    ->where('data.industries', null)
                    ->where('data.jobs', null)
                    ->etc();
            }
        );
    }


    public function test_fill_course_location()
    {
        $inputs = ['course_location' => CourseLocation::ONLINE];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(PersonalPreferencesProcessStatus::COURSE_LOCATION)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => PersonalPreferencesProcessStatus::INDUSTRIES,
            'course_location_type' => $inputs['course_location']
        ]);

        $response->assertJson(
            function (AssertableJson $assertableJson) use($inputs){
                $assertableJson
                    ->has('data.id')
                    ->where('data.status', PersonalPreferencesProcessStatus::INDUSTRIES)
                    ->where('data.budget', null)
                    ->where('data.course_length_type', null)
                    ->where('data.course_location_type', $inputs['course_location'])
                    ->where('data.industries', null)
                    ->where('data.jobs', null)
                    ->etc();
            }
        );
    }

    public function test_fill_industries()
    {
        $inputs = ['intrested_industries' => ['it', 'that']];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(PersonalPreferencesProcessStatus::INDUSTRIES)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => PersonalPreferencesProcessStatus::JOBS,
        ]);

        $this->assertSame($inputs['intrested_industries'], $personalPreference->refresh()->industries);

        $response->assertJson(
            function (AssertableJson $assertableJson) use($inputs){
                $assertableJson
                    ->has('data.id')
                    ->where('data.status', PersonalPreferencesProcessStatus::JOBS)
                    ->where('data.budget', null)
                    ->where('data.course_length_type', null)
                    ->where('data.course_location_type', null)
                    ->where('data.industries', $inputs['intrested_industries'])
                    ->where('data.jobs', null)
                    ->etc();
            }
        );
    }

    public function test_fill_jobs()
    {
        $inputs = ['intrested_jobs' => ['it', 'that']];
        $personalPreference = PersonalPreference::factory()->forUser($this->authUser)->inStatus(PersonalPreferencesProcessStatus::JOBS)->create();
        $response = $this->actingAs($this->authUser)->putJson(route('personal-preference.update', ['personal_preference' => $personalPreference->getKey()]), $inputs);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('personal_preferences', [
            'user_id' => $this->authUser->getKey(),
            'status' => PersonalPreferencesProcessStatus::FINISH,
        ]);

        $this->assertSame($inputs['intrested_jobs'], $personalPreference->refresh()->jobs);

        $response->assertJson(
            function (AssertableJson $assertableJson) use($inputs){
                $assertableJson
                    ->has('data.id')
                    ->where('data.status', PersonalPreferencesProcessStatus::FINISH)
                    ->where('data.budget', null)
                    ->where('data.course_length_type', null)
                    ->where('data.course_location_type', null)
                    ->where('data.industries', null)
                    ->where('data.jobs', $inputs['intrested_jobs'])
                    ->etc();
            }
        );
    }
}
