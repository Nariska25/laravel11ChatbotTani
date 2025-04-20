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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // 'rajaongkir' => [
    //     'url' => env('RAJAONGKIR_BASE_URL', 'https://api.rajaongkir.com/starter'),
    //     'key' => env('RAJAONGKIR_API_KEY', 'Oh3ibrwQ857baf6b99d0b7a4sg9G9sUC'),
    //     'origin' => env('RAJAONGKIR_ORIGIN'), // Your store's city ID
    // ],

  'rajaongkir' => [
    'api_key' => env('RAJAONGKIR_API_KEY'),
    'base_url' => env('RAJAONGKIR_BASE_URL'),
    'origin' => env('RAJAONGKIR_ORIGIN', 501), // Default: Yogya
  ],

'xendit' => [
    'secret_key' => env('XENDIT_SECRET_KEY'),
],

'xendit' => [
    'callback_token' => env('XENDIT_CALLBACK_TOKEN'),
],
];