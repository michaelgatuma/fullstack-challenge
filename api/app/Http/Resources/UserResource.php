<?php

namespace App\Http\Resources;

use App\Services\WeatherService;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class UserResource extends JsonResource
{
    public static $wrap=null;

    /**
     * Transform the user resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        //if the request has a truthy 'weather' query param, then add weather to array
        if ($request->query('weather', false))
            $resource['weather'] = $this->getWeather();
        return $resource;
    }

    public function getWeather()
    {
        $cacheKey = WeatherService::getCacheKey($this->latitude,$this->longitude);
        return Cache::get($cacheKey);
    }
}
