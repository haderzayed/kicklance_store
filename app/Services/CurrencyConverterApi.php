<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverterApi
{
    protected $apiKey;
    protected $host = 'https://free.currconv.com';

    public function __construct($apiKey)
    {
        $this->apiKey=$apiKey;
    }

    public function get($from_currency ,$to_currency){
        $from_currency=strtoupper($from_currency);
        $to_currency=strtoupper($to_currency);

        $result=Http::baseUrl($this->host)
            ->get('api/v7/convert',[
                'q'=>"{$from_currency}_{$to_currency}",
                'compact'=>'ultra',
                'apiKey'=>$this->apiKey
            ])->json();
           return $result["{$from_currency}_{$to_currency}"];
    }

    public function currencies(){
      return  Http::baseUrl($this->host)
            ->get('api/v7/currencies',[
                'apiKey'=>$this->apiKey
            ])->json();
    }
}
