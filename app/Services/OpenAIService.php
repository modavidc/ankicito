<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class OpenAIService
{
    protected $client; // Guzzle HTTP client instance
    protected $apiKey; // API key for authentication
    protected $baseUri; // Base URI for the OpenAI API
    protected $timeout; // Timeout for API requests

    public function __construct()
    {
        // Initialize Guzzle client
        $this->client = new Client();
        $this->apiKey = Config::get('openai.api_key'); // Retrieve API key from configuration
        $this->baseUri = Config::get('openai.base_uri'); // Retrieve base URI from configuration
        $this->timeout = Config::get('openai.timeout'); // Retrieve timeout setting from configuration
    }

    /**
     * Get a response from the OpenAI API based on the provided prompt.
     *
     * @param string $prompt
     * @return string|null
     */
    public function getResponse($prompt)
    {
        // Build the request payload for the OpenAI API
        $payload = [
            'json' => [
                'model' => Config::get('openai.model'), // Specify the model to use
                'messages' => [
                    ['role' => 'user', 'content' => $prompt], // Set the user message
                ],
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey, // Set the authorization header
            ],
            'timeout' => $this->timeout, // Set the request timeout
        ];

        // Make the POST request to OpenAI API
        try {
            $response = $this->client->post($this->baseUri . 'chat/completions', $payload); // Send the request
            $responseBody = json_decode($response->getBody(), true); // Decode the JSON response

            return $responseBody['choices'][0]['message']['content'] ?? null; // Return the content of the response
        } catch (\Exception $e) {
            // Handle the error and return an error message
            return 'Error: ' . $e->getMessage();
        }
    }
}
