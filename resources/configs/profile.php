<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User model to be referenced.
    |--------------------------------------------------------------------------
    |
    | Define the user model class to be referenced.
    |
    */
    'user' => [
        'model' => env('PROFILE_USER'),
        'uuid' => env('PROFILE_UUID', 'uuid'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile model to be referenced.
    |--------------------------------------------------------------------------
    |
    | Define the profile model class to be referenced.
    |
    */
    'model' => [
        'default' => 'Joesama\Profile\Data\Model\Profile',
        'organization' => 'Joesama\Profile\Data\Model\ProfileWithOrganization'
    ],

    /*
    |--------------------------------------------------------------------------
    | Extension for profile data.
    |--------------------------------------------------------------------------
    |
    | Flag for data extension.
    |
    | 1. Department & unit.
    |
    */
    'has' => [
        'organization' => env('ORG_PROFILE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Switch profile extension usage.
    |--------------------------------------------------------------------------
    |
    | Flag if extension enable to used. By default TRUE.
    |
    */
    'allow' => [
        'import' => env('IMPORT_PROFILE', true),
        'registeration' => env('REGISTER_PROFILE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | If profile email & password required verification.
    |--------------------------------------------------------------------------
    |
    | Flag if profile registration required verification. By default TRUE.
    |
    */
    'verification' => env('VERIFY_PROFILE', true),

];
