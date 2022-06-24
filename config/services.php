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
    
    'facebook' => [
        'facebook_client_id' => env('facebook_client_id'),
        'facebook_client_secret' => env('facebook_client_secret'),
        // 'facebook_redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],
    'google' => [
        'google_client_id' => env('google_client_id'),
        'google_client_secret' => env('google_client_secret'),
        // 'facebook_redirect' => 'http://localhost:8000/auth/facebook/callback',
    ],
    
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

];