<?php

namespace Modules\Authentication\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Authentication\Models\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

    private array $credentials = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->credentials = [
            'email' => 'me@g.com',
            'name' => 'John Dou',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    public function test_happy_path()
    {
        $response = $this->postJson(route('register'), $this->credentials);
        $response->assertStatus(200);

        $response->assertJson(
            function (AssertableJson $assertableJson) {
                $assertableJson->has('data.authentication_token')
                    ->whereNot('data.authentication_token', null)
                    ->where('data.message', "welcome")
                    ->etc();
            }
        );

        $response = $this->withHeader('Authorization', "Bearer " . $response->json('data.authentication_token'))->get(route('test-auth'));
        $response->assertStatus(200);
    }

    public function test_can_not_register_with_invalid_email()
    {
        $this->credentials['email'] = 'invalid email';
        $response = $this->postJson(route('register'), $this->credentials);

        $response->assertStatus(422);

        $response->assertJson(
            function (AssertableJson $assertableJson) {
                $assertableJson->has('errors')
                    ->where('errors.email.0', 'The email field must be a valid email address.')
                    ->etc();
            }
        );

        $this->assertDatabaseMissing('users', Arr::except($this->credentials, ['password', 'password_confirmation']));
    }

    public function test_can_not_register_with_not_match_password()
    {
        $this->credentials['password_confirmation'] = 'not match with password';
        $response = $this->postJson(route('register'), $this->credentials);
        $response->assertStatus(422);

        $response->assertJson(
            function (AssertableJson $assertableJson) {
                $assertableJson->has('errors')
                    ->where('errors.password.0', 'The password field confirmation does not match.')
                    ->etc();
            }
        );

        $this->assertDatabaseMissing('users', Arr::except($this->credentials, ['password', 'password_confirmation']));
    }
}
