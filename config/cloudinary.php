<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | An HTTP URL to configure your Cloudinary account.
    |
    */
    'cloud_url' => env('CLOUDINARY_URL'),

    /*
    |--------------------------------------------------------------------------
    | Your Cloudinary Account Credentials
    |--------------------------------------------------------------------------
    |
    | You can find these credentials in your Cloudinary dashboard.
    |
    */
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key'    => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | URL Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the URL generation settings.
    |
    */
    'url' => [
        'secure' => env('CLOUDINARY_SECURE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the upload settings.
    |
    */
    'upload' => [
        'use_filename' => true,
        'unique_filename' => false,
        'overwrite' => true,
    ],
];
