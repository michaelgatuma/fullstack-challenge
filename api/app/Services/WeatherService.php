<?php

namespace App\Services;

use App\Interfaces\WeatherServiceInterface;
use App\Models\User;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService implements WeatherServiceInterface
{
    protected float $lat, $lon;

    /**
     * Set Latitude
     * @param float $lat
     * @return $this
     */
    public function latitude(float $lat): static
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * Set Longitude
     * @param float $lon
     * @return $this
     */
    public function longitude(float $lon): static
    {
        $this->lon = $lon;
        return $this;
    }

    /**
     * Fetch the weather from external weather api
     */
    public function fetchWeatherData($throws = false)
    {
        try {
            $response = Http::retry(3, 3000)
                ->withUrlParameters([
                    'endpoint' => config('open_weather_api.endpoint'),
                    'page' => config('open_weather_api.page'),
                    'version' => config('open_weather_api.version'),
                    'topic' => config('open_weather_api.topic'),
                ])->get('{+endpoint}/{page}/{version}/{topic}', [
                    'lat' => $this->lat,
                    'lon' => $this->lon,
                    'appid' => config('open_weather_api.api_key'),
                    'units' => config('open_weather_api.units','metric'),
                ])->throwIf($throws);

            //cache time to live : 1hr
            $ttl = now()->addHour();

            if ($response->successful())
                //return weather data
                return cache()->remember(self::getCacheKey($this->lat, $this->lon), $ttl, function () use ($response, $ttl) {
                    return  $response->json();
                    //below code returns nested data which is undesired
//                    return [
//                        "data" => $response->json(),
//                        "meta" => [
//                            "created_at" => now(),
//                            "ttl" => "3600",
//                            "expires_at" => $ttl,
//                            "Provider" => "OpenWeather",
//                            "provider_url" => config('open_weather_api.endpoint'),
//                            "provide_logo" => config('open_weather_api.endpoint') . "/themes/openweathermap/assets/img/logo_white_cropped.png"
//                        ]
//                    ];
                });
            return null;
        }catch (RequestException $e){
            return null;
        }
    }

    /**
     * Fetch the weather for the defined user from external weather api
     */
    public function fetchWeatherDataForUser(User $user)
    {
        $this->lat = $user->latitude;
        $this->lon = $user->longitude;
        return $this->fetchWeatherData();
    }

    /**
     * Get cached weather or fetch data
     * @return mixed
     */
    public function getWeather(): mixed
    {
        $cacheKey = $this->getCacheKey($this->lat, $this->lon);

        //return cached weather or fetch weather
        return Cache::get($cacheKey, fn() => null);
//        return Cache::get($cacheKey, function () use ($cacheKey) {
//            return $this->fetchWeatherData();
//        });

    }

    /**
     * Get cached weather or fetch data for the defined user from external weather api
     * @param User $user
     * @return mixed
     */
    public function getWeatherForUser(User $user): mixed
    {
        $this->lat = $user->latitude;
        $this->lon = $user->longitude;
        $cacheKey = $this->getCacheKey($this->lat, $this->lon);

        //return cached weather or fetch weather
        return Cache::get($cacheKey, fn() => null);
//        return Cache::get($cacheKey, function () use ($cacheKey) {
//            return $this->fetchWeatherData();
//        });

    }

    /**
     * Get cache key for stored data
     * @param float $lat
     * @param float $lon
     * @return string
     */
    public static function getCacheKey(float $lat, float $lon): string
    {
        return "users.weather.{$lat}_{$lon}";
    }
}
