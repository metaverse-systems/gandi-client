<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gandi API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Gandi API client. You can obtain your API key
    | from your Gandi account dashboard.
    |
    */

    'api_key' => env('GANDI_API_KEY'),

    'base_url' => env('GANDI_BASE_URL', 'https://api.gandi.net/v5'),

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Default options for API requests
    |
    */

    'timeout' => env('GANDI_TIMEOUT', 30),

    'verify_ssl' => env('GANDI_VERIFY_SSL', true),
];
