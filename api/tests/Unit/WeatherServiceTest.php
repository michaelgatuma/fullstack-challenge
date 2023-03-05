<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    public $user;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->user = User::factory()->create([
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ]);
    }

    /**
     * @throws RequestException
     */
    public function test_weather_data_is_fetched_correctly_for_a_single_user()
    {
        // Create a user with a specific latitude and longitude
        $user = User::factory()->create([
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ]);

        // Mock the response from openweathermap.org
        $response = file_get_contents(base_path('tests/Mocks/openWeatherMap/currentWeather.json'));

        Http::fake([
            'api.openweathermap.org/data/2.5/weather*' => Http::response($response, 200),
        ]);

        // Call the method that fetches weather data for a single user
        $weatherData = (new WeatherService())->fetchWeatherDataForUser($user);

        $this->assertIsArray($weatherData);
        $this->assertEquals(json_decode($response, true), $weatherData["data"]);
    }

    /**
     * @throws RequestException
     */
    public function test_weather_data_is_cached_correctly_for_a_single_user()
    {
        // Create a user with a specific latitude and longitude
        $user = User::factory()->create([
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ]);

        // Mock the response from openweathermap.org
        $response = file_get_contents(base_path('tests/Mocks/openWeatherMap/currentWeather.json'));

        Http::fake([
            'api.openweathermap.org/data/2.5/weather*' => Http::response($response, 200),
        ]);

        // Call the method that fetches weather data for a single user
        $weatherData = (new WeatherService())->fetchWeatherDataForUser($user);

        // Assert that the data are correctly fetched and returned
        $this->assertIsArray($weatherData);
        $this->assertEquals(json_decode($response, true), $weatherData["data"]);

        // Call the method again to retrieve the cached weather data
        $cachedWeatherData = (new WeatherService())->fetchWeatherDataForUser($user);

        // Assert that the cached weather data is the same as the original weather data
        $this->assertEquals($weatherData, $cachedWeatherData);
    }

    /**
     * @throws RequestException
     */
    public function test_weather_data_cache_ttl_is_one_hour()
    {
        // Create a user with a specific latitude and longitude
        $user = User::factory()->create([
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ]);

        // Mock the response from openweathermap.org
        $response = file_get_contents(base_path('tests/Mocks/openWeatherMap/currentWeather.json'));

        Http::fake([
            'api.openweathermap.org/data/2.5/weather*' => Http::response($response, 200),
        ]);

        // Call the method that fetches weather data for a single user
        $weatherData = (new WeatherService())->fetchWeatherDataForUser($user);

        // Assert that the data are correctly fetched and returned
        $this->assertIsArray($weatherData);
        $this->assertEquals(json_decode($response, true), $weatherData["data"]);

        // Call the method again to retrieve the cached weather data after one hour
        $this->travel(2)->hour(); // Teleport one hour ahead to simulate cache TTL expiration
        $cachedWeatherData = (new WeatherService())->getWeatherForUser($user);

        // Assert that the cached weather data is empty after one hour
        $this->assertEmpty($cachedWeatherData);
    }

    /**
     * @throws RequestException
     */
    public function test_fetching_weather_data_for_a_single_user_fails_gracefully_when_external_api_is_unavailable()
    {
        // Create a user with a random latitude and longitude
        $user = User::factory()->create();

        // Mock the response from openweathermap.org to return a 500 status code
        Http::fake([
            'api.openweathermap.org/data/2.5/weather*' => Http::response([], 500),
        ]);

        // Call the method that fetches and caches weather data for a single user
        $weatherData = (new WeatherService())->fetchWeatherDataForUser($user);

        // Assert that the weather data was not cached
        $weatherData = Cache::get(WeatherService::getCacheKey($user->latitude, $user->longitude));
        $this->assertNull($weatherData);
    }
}
