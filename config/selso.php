<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SSO Client Credentials
    |--------------------------------------------------------------------------
    |
    | These values are used for authenticating your application with the
    | Single Sign-On (SSO) provider. Ensure these environment variables
    | are properly set in your .env file.
    |
    */

    'client_id' => env('SSO_CLIENT_ID'),
    'client_secret' => env('SSO_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Redirect URI
    |--------------------------------------------------------------------------
    |
    | The callback URL where the SSO provider will redirect the user after
    | authentication. This must match the value registered with the SSO
    | provider.
    |
    */

    'redirect_uri' => env('SSO_REDIRECT_URI'),

    /*
    |--------------------------------------------------------------------------
    | Authorization Server URL
    |--------------------------------------------------------------------------
    |
    | Base URL of the SSO authorization server. Used to build endpoints
    | for token retrieval and user authentication.
    |
    */

    'auth_server_url' => env('SSO_SERVER_URL'),

    /*
    |--------------------------------------------------------------------------
    | Public Key
    |--------------------------------------------------------------------------
    |
    | The public key used to verify the JWT issued by the SSO server.
    | Make sure the path to the key file is valid and secure.
    |
    */

    'public_key' => file_get_contents(storage_path('oauth-public.key')),

    /*
    |--------------------------------------------------------------------------
    | Redirect After Login
    |--------------------------------------------------------------------------
    |
    | Define the named route to which the user will be redirected
    | after a successful login through the SSO process.
    |
    */

    'redirect_after_login' => 'dashboard',
];
