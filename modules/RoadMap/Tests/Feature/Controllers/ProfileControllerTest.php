<?php

namespace Modules\RoadMap\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Enums\QuestionCategory;
use Modules\RoadMap\Enums\QuestionCompetency;
use Modules\RoadMap\Models\Answer;
use Modules\RoadMap\Models\Answershit;
use Modules\RoadMap\Models\Course;
use Modules\RoadMap\Models\Exam;
use Modules\RoadMap\Models\Question;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    private User $authUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser = User::factory()->create();
        Course::factory(2)->create();
        Course::first()->attachToUser($this->authUser);
        
    }

    public function test_show_method()
    {        
        $response = $this->actingAs($this->authUser)->getJson(route('profile.show'));

        $this->assertTrue(true);
    }
}
