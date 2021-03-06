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

    'telegram' => [
        'id' => env('TELEGRAM_CHAT_ID'),
        'secret' => env('TELEGRAM_TOKEN'),
    ],

    'facebook' => [
        'id' => env('FACEBOOK_APP_ID', 'yolo'),
        'secret' => env('FACEBOOK_APP_SECRET', 'yolo'),
    ],

    'mailgun' => [
        'domain' => 'mg.lasceneparisienne.com',
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => 'api.eu.mailgun.net',
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
