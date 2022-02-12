<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'currency_converter_api'=>[
        'key' => 'f3c33dfc78290a4339eb',
    ],
    'OpenWeatherMap'=>[
       'key'=>'3a504595f7f10b652a4e0ade7cd3b9d5',
    ],
    'paypal'=>[
        'mode'=>'sandbox',
        'client_id'=>'ATSC3ooe2uK5fO4OJ3Vu28VHKYOq65H9sjmfupDUYxsWq0EVhJnHonxvQgGr9HLdzqYbXDX4zwKI1CjI',
        'secret'=>'EBrUKLIa2uOsC2tOPN2SU9xcnUNk607lUiP75bQoFK_H-VXQ2eq0MXnb9efyj3EJQjnGExldZ8eJkUOi',
    ],
    'nexmo' => [
        'sms_from' => 'App store',
    ],
    'moyasar'=>[
        'key'=>'pk_test_LGomrHwYfYMC3N8C7vJRMdsgre1um2rjon3a4mHq',
        'secret'=>'sk_test_EuCSVpb2Wj6KUJTHQWmMBFBY2cr1gnPGbn8EcLjH',
    ],

];
