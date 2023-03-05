<?php

namespace App\Interfaces;

use App\Models\User;

interface WeatherServiceInterface
{
    public function getWeather();

    public function fetchWeatherData();

    public function fetchWeatherDataForUser(User $user);

    public static function getCacheKey(float $lat, float $lon): string;
}
