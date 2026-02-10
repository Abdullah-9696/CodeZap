<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    // Add all routes that may be accessed from React frontend
    'paths' => ['api/*', 'profile', 'profile/update', 'sanctum/csrf-cookie', 'logout', 'courses', 'skills'],

    'allowed_methods' => ['*'],

    // React frontend origins
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Required to send cookies / sessions cross-origin
    'supports_credentials' => true,
];
