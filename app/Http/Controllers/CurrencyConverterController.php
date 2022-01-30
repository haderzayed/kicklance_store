<?php

namespace App\Http\Controllers;

use App\Services\CurrencyConverterApi;
use App\Services\OpenWeatherMap;
use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    public function convert($from_currency ,$to_currency){
           $key=config('services.currency_converter_api.key');
           $converter=new CurrencyConverterApi($key);
           $value=$converter->get($from_currency ,$to_currency);
           return $value;
    }

    public function currencies(){

        $key=config('services.currency_converter_api.key');
        $converter=new CurrencyConverterApi($key);
        $result=$converter->currencies();
        $currencies=$result['results'];

        $weatherKey=config('services.OpenWeatherMap.key');
        $services=new OpenWeatherMap($weatherKey);
        $weather=$services->currentWeather('mansoura,eg');
        // dd($currencies['currencyName']);
         return view('currencies', compact('currencies','weather'));
    }

}
