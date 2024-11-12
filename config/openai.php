<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the OpenAI API key and other related settings
    | such as the default model and other configuration options. You can
    | retrieve the key from your .env file to keep it secure.
    |
    */

    'api_key' => env('OPENAI_API_KEY'), // Store the API key in the .env file

    'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'), // Default model

    'base_uri' => env('OPENAI_BASE_URI', 'https://api.openai.com/v1/'), // OpenAI API Base URI

    // Timeout for API requests
    'timeout' => env('OPENAI_TIMEOUT', 30),

];
