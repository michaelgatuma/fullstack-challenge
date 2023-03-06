<?php

namespace Tests\Feature;

use App\Models\User;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\RequestException;
use Illuminate\Testing\Fluent\AssertableJson;
use Response;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Database Working
     * @return void
     */
    public function test_application_database_works(): void
    {
        User::factory(20)->create();
        $this->assertEquals(20, User::all()->count());
    }

    /**
     * Test Application is online
     * @return void
     */
    public function test_the_application_api_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test Get Users Api works
     * @return void
     */
    public function test_get_all_users_endpoint_returns_expected_data(): void
    {
        $response = $this->getJson('/users')
            ->assertStatus(200)
            // assert json has all keys
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('data', 'links', 'meta'));
    }

    /**
     * Test Get Single User Api works
     * @return void
     */
    public function test_single_user_endpoint_returns_expected_data(): void
    {
        //dummy user
        $user = User::factory()->create();
        $response = $this->getJson("/user/{$user->id}")
            ->assertStatus(200)
            // assert json has all keys
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('id', 'name', 'email', 'email_verified_at', 'latitude', 'longitude', 'created_at', 'updated_at'));
    }
}
