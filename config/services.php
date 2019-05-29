<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'github' => [
      'client_id' => 'a876539dc4a8b3451fb4',
      'client_secret' => 'a54051d101f77ce01fd1c661a95827f855456696',
      'redirect' => 'https://momentreeglobal.herokuapp.com/login/github/callback',
    ],

    'facebook' => [
        'client_id' => '495583944312453',
        'client_secret' => '4ca6e91628d27c72e70adbede3e570c2',
        'redirect' => 'https://momentreeglobal.herokuapp.com/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '58638391374-63upad2oej1eonug4gt732onu9p314em.apps.googleusercontent.com',
        'client_secret' => 'kijRwIz6pmq9sO01k5W_SBcG',
        'redirect' => 'https://momentreeglobal.herokuapp.com/login/google/callback',
    ],
    
    //'github' => [
    //'client_id' => env('GITHUB_ID'),
    //'client_secret' => env('GITHUB_SECRET'),
    //'redirect' => env('GITHUB_CALLBACK'),
//],
];
