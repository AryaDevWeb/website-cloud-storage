<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        // Android Emulator → host machine localhost
        'http://10.0.2.2:8000',
        'http://10.0.2.2:*',
        // iOS Simulator → host machine localhost
        'http://localhost:8000',
        'http://localhost:*',
        // Production / Staging (update with your real domain)
        'https://yourdomain.com',
        'https://staging.yourdomain.com',
    ],

    'allowed_origins_patterns' => [
        // Matches any local emulator port
        '#^http://10\.0\.2\.2(:\d+)?$#',
        '#^http://localhost(:\d+)?$#',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
