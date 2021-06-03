<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register()
    {
        $response = $this->postJson(config('app.api_url') . '/auth/register', [
            'name'                  => 'John Doe',
            'email'                 => 'johndoe@test.com',
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('success', true)
                ->where('message', 'Customer created.')
                ->has('data.token'));
    }

    public function test_customer_can_login()
    {
        $customer = Customer::factory()->create([
            'password' => bcrypt('secret')
        ]);

        $response = $this->postJson(config('app.api_url') . '/auth/login', [
            'email'    => $customer->email,
            'password' => 'secret',
        ]);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('success', true)
                ->where('message', null)
                ->has('data.token'));
    }

    public function test_logged_customer_can_obtain_its_personal_data()
    {
        /** @var Customer $customer */
        $customer = Customer::factory()->create([
            'password' => bcrypt('secret')
        ]);

        $loginResponse = $this->post(config('app.api_url') . '/auth/login', [
            'email'    => $customer->email,
            'password' => 'secret',
        ]);

        $loginResponse->assertStatus(Response::HTTP_CREATED);

        $dataResponse = $this->getJson(config('app.api_url') . '/me', [
            'Authorization' => 'Bearer ' . $loginResponse->json('data.token')
        ]);

        $dataResponse->assertJson(fn(AssertableJson $json) => $json->has('id')
            ->where('name', $customer->name)
            ->where('email', $customer->email)
            ->where('email_verified_at', $customer->email_verified_at->toJSON())
            ->missing('password')
            ->etc());
    }

    public function test_unlogged_user_cannot_obtain_any_personal_data()
    {
        $dataResponse = $this->getJson(config('app.api_url') . '/me', [
            'Authorization' => 'Bearer ' . \Str::random()
        ]);

        $dataResponse->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
