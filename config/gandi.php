<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gandi API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Gandi API client. You can obtain your Personal
    | Access Token from your Gandi account dashboard at:
    | https://admin.gandi.net/organizations/account/pat
    |
    */

    'personal_access_token' => env('GANDI_PERSONAL_ACCESS_TOKEN'),

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
