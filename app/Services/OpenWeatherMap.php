<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenWeatherMap
{
   protected $base_url='https://api.openweathermap.org/data/2.5';
   protected $apikey;

   public function __construct($apikey){

       $this->apikey=$apikey;
   }

   public function currentWeather($city){
       return  Http::baseUrl($this->base_url)
             ->get('weather',[
                 'q'=>$city,
                 'appid'=>$this->apikey,
                 'units'=>'metric',
                 'lang'=>'ar'
             ])->json();
   }
}
