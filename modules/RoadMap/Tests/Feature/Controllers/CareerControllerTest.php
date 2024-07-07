<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\CourseLength;
use Modules\RoadMap\Enums\CourseLocation;
use Modules\RoadMap\Enums\PersonalPreferencesProcessStatus;
use Modules\RoadMap\Models\PersonalPreference;
use Tests\TestCase;

class CareerControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $authUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser = User::factory()->create();
    }

    public function test_get_all_careers()
    {
        $response = $this->actingAs($this->authUser)->getJson(route('carrers.index'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            function (AssertableJson $assertableJson){
                $assertableJson
                    ->has('data')
                    ->has('data.0.id')
                    ->has('data.0.title')
                    ->has('data.0.category')
                    ->etc();
            }
        );
    }
}
