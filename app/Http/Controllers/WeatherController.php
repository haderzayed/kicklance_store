<?php

namespace App\Http\Controllers;

use App\Services\OpenWeatherMap;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function current(){
        $key=config('services.OpenWeatherMap.key');
        $services=new OpenWeatherMap($key);
        $weather=$services->currentWeather('mansoura,eg');
        dd($weather);
    }
}
