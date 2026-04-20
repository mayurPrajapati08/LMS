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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'cloudflare_r2' => [
        'avatar_folder' => env('R2_AVATAR_FOLDER', 'lms/avatars'),
        'thumbnail_folder' => env('R2_THUMBNAIL_FOLDER', 'lms/course-thumbnails'),
        'material_folder' => env('R2_MATERIAL_FOLDER', 'lms/course-materials'),
    ],

    'cloudflare_stream' => [
        'account_id' => env('CLOUDFLARE_STREAM_ACCOUNT_ID'),
        'api_token' => env('CLOUDFLARE_STREAM_API_TOKEN'),
        'customer_code' => env('CLOUDFLARE_STREAM_CUSTOMER_CODE'),
        'max_duration_seconds' => (int) env('CLOUDFLARE_STREAM_MAX_DURATION_SECONDS', 14400),
    ],

    'cloudinary' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key' => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
        'folder' => env('CLOUDINARY_FOLDER', 'lms/course-thumbnails'),
    ],

    'razorpay' => [
        'key_id' => env('RAZORPAY_KEY_ID'),
        'key_secret' => env('RAZORPAY_KEY_SECRET'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

];
