<?php

namespace Modules\Authentication\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    private array $credentials = [];

    public function setUp():void
    {
        parent::setUp();
        $this->credentials = ['email' => 'me@g.com', 'password' => 'password'];
        User::factory()->create($this->credentials);

    }

    public function test_happy_path()
    {
        $response = $this->post(route('login'), $this->credentials);

        $response->assertStatus(200);
        $response->assertJson(
            function (AssertableJson $assertableJson) {
                $assertableJson->has('data.authentication_token')
                    ->whereNot('data.authentication_token', null)
                    ->etc();
            }
        );

        $response = $this->withHeader('Authorization', "Bearer " . $response->json('data.authentication_token'))->get(route('test-auth'));
        $response->assertStatus(200);
    }

    public function test_can_not_login_with_invalid_credentials()
    {
        $this->credentials['password'] = 'invalid password';
        $response = $this->post(route('login'), $this->credentials);

        $response->assertStatus(401);
        $response->assertJson(
            function (AssertableJson $assertableJson) {
                $assertableJson->has('errors')
                    ->where('errors.0', 'invalid credentials')
                    ->etc();
            }
        );
    }

    public function test_can_not_use_routes_with_invalid_token()
    {
        $response = $this->withHeader('Authorization', "Bearer jebrish")->get(route('test-auth'));
        $response->assertStatus(302);

        $response = $this->get(route('test-auth'));
        $response->assertStatus(302);
    }
}
