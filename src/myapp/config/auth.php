<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        // keep web (admin) as default
        'guard'     => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // NEW: candidate guard
        'candidate' => [
            'driver'   => 'session',        // still session based, just uses a different provider
            'provider' => 'candidates',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => env('AUTH_MODEL', App\Models\User::class),
        ],

        // NEW: candidate provider
        'candidates' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Candidate::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire'   => 60,
            'throttle' => 60,
        ],

        // Candidate password reset is usually not needed for OTP-only login,
        // but you can add if you ever decide to allow password-based candidate login:
        // 'candidates' => [
        //     'provider' => 'candidates',
        //     'table'    => 'password_reset_tokens',
        //     'expire'   => 60,
        //     'throttle' => 60,
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
