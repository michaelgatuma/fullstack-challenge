<?php

return [
    'endpoint' => 'https://api.openweathermap.org',
    'page' => 'data',
    'version' => '2.5',
    'topic' => 'weather',
    'units' => env('OPEN_WEATHER_UNITS','metric'),//standard,metric,imperial
    'lang' => env('OPEN_WEATHER_LANGUAGE','en'),//standard,metric,imperial
    'api_key' => env('OPEN_WEATHER_API_KEY')
];
