<?php

return [

    /*
    |--------------------------------------------------------------------------
    |   Your auth0 domain
    |--------------------------------------------------------------------------
    |   As set in the auth0 administration page
    |
    */
    'domain' => env('AUTH0_DOMAIN'),
	/*
     |--------------------------------------------------------------------------
    |   Your auth0 domain
    |--------------------------------------------------------------------------
    |   As set in the auth0 administration page
    |
    */
    'audience' => env('AUTH0_AUDIENCE'),
    /*
    |--------------------------------------------------------------------------
    |   Auth0 management API domain
    |--------------------------------------------------------------------------
    |
    */
    'api_domain' => env('AUTH0_API_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    |   Auth0 current client
    |--------------------------------------------------------------------------
    |   As set in the auth0 administration page
    |
    */
    'current_client' => 'default',

    /*
    |--------------------------------------------------------------------------
    |   Auth0 client keys
    |--------------------------------------------------------------------------
    |   As set in the auth0 administration page
    |
    */
    'client' => [
        'default' => [
            'client_id' => env('AUTH0_CLIENT_ID'),
            'client_api_id' => env('AUTH0_API_CLIENT_ID'),
            'client_api_secret' => env('AUTH0_API_CLIENT_SECRET'),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    |   Your APP secret
    |--------------------------------------------------------------------------
    |   As set in the auth0 administration page
    |
    */
    'api_audience' => env('AUTH0_API_AUDIENCE'),

    /*
     |--------------------------------------------------------------------------s
     |   The redirect URI
     |--------------------------------------------------------------------------
     |   Should be the same that the one configure in the route to handle the
     |   'Auth0\Login\Auth0Controller@callback'
     |
     */
    'redirect_uri' => env('APP_URL').'/auth0/callback',

    /*
    |--------------------------------------------------------------------------
    |   Persistence Configuration
    |--------------------------------------------------------------------------
    |   persist_user            (Boolean) Optional. Indicates if you want to persist the user info, default true
    |   persist_access_token    (Boolean) Optional. Indicates if you want to persist the access token, default false
    |   persist_refresh_token   (Boolean) Optional. Indicates if you want to persist the refresh token, default false
    |   persist_id_token        (Boolean) Optional. Indicates if you want to persist the id token, default false
    |
    */
    'persist_user' => true,
    'persist_access_token' => false,
    'persist_refresh_token' => false,
    'persist_id_token' => false,

    /*
    |--------------------------------------------------------------------------
    |   The authorized token issuers
    |--------------------------------------------------------------------------
    |   This is used to verify the decoded tokens when using RS256
    |
    */
    'authorized_issuers' => [env('AUTH0_DOMAIN')],

    /*
    |--------------------------------------------------------------------------
    |   The authorized token audiences
    |--------------------------------------------------------------------------
    |
    */
    // 'api_identifier'  => '',

    /*
    |--------------------------------------------------------------------------
    |   The secret format
    |--------------------------------------------------------------------------
    |   Used to know if it should decode the secret when using HS256
    |
    */
    'secret_base64_encoded' => false,

    /*
    |--------------------------------------------------------------------------
    |   Supported algorithms
    |--------------------------------------------------------------------------
    |   Token decoding algorithms supported by your API
    |
    */
    'supported_algs' => ['RS256'],

    /*
    |--------------------------------------------------------------------------
    |   jwks.json uri
    |--------------------------------------------------------------------------
    |   jwks for check ID token key
    |
    */
    'jwks_uri' => env('AUTH0_JWKS_URI'),

    /*
    |--------------------------------------------------------------------------
    |   Guzzle Options
    |--------------------------------------------------------------------------
    |   guzzle_options    (array) optional. Used to specify additional connection options e.g. proxy settings
    |
    */
    // 'guzzle_options' => []
];
