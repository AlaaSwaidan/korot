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
    'twelve' => [
        'base_url' => env('TWELVE_BASE_URL', 'https://api.twelve.sa/api/dev'),
//        'base_url' => env('TWELVE_BASE_URL', 'https://staging.twelvetecsa.com/api/online'),
        'key' => env('TWELVE_API_KEY','c49e4f27-3dcf-47a4-b521-86ab51af49f3'),
        'secret' => env('TWELVE_API_SECRET','df95aee4a0129ddc7167fbc0f37db29782be32c8c6f0ce0d1f86ee8861f9d977'),
    ],

];
