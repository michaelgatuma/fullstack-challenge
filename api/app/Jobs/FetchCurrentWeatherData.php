<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\WeatherService;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchCurrentWeatherData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
    }

    /**
     * Execute the job.
     * @throws RequestException
     */
    public function handle(): void
    {
        //cache's time to live
        $cache_ttl = now()->addHour();

        //only fetch and cache the current weather if the data is not already cached or is expired
        cache()->remember(WeatherService::getCacheKey($this->user->latitude, $this->user->longitude), $cache_ttl, function () use ($cache_ttl) {
            return [
                "data" => (new WeatherService())->latitude($this->user->latitude)->longitude($this->user->longitude)->fetchWeatherData(),
                "meta" => [
                    "created_at" => now(),
                    "ttl" => "3600",
                    "expires_at" => $cache_ttl,
                    "Provider" => "OpenWeather",
                    "provider_url" => config('open_weather_api.endpoint'),
                    "provide_logo" => config('open_weather_api.endpoint') . "/themes/openweathermap/assets/img/logo_white_cropped.png"
                ]
            ];
        });
    }
}
