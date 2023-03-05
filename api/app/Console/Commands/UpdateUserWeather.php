<?php

namespace App\Console\Commands;

use App\Jobs\FetchCurrentWeatherData;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the weather data of all users';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::all()->each(function (User $user) {
            FetchCurrentWeatherData::dispatch($user);
        });
        $this->info("Weather info updating in the background...");
    }
}
