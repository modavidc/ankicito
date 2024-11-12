<?php

namespace App\Services;

class CardGeneratorService
{
    /**
     * Generate a prompt for the OpenAI API.
     *
     * @param array $keywords
     * @return string
     */
    public function generatePrompt(array $keywords): string
    {
        // Create the initial prompt with instructions
        $prompt =
            "Crea oraciones en inglés utilizando las siguientes palabras y proporciona su traducción en español. "
            . "Devuelve el resultado en formato JSON y el inicio y el fin delimítalo por ```.\n"
            . "Ejemplo de salida:\n"
            . "[{\"front\": \"This is an example sentence.\", \"back\": \"Esta es una oración de ejemplo.\"}, ...]\n";

        // Add keywords to the prompt
        $prompt .= implode("\n", array_map(function ($keyword) {
            return "- " . $keyword; // Format each keyword as a list item
        }, $keywords));

        return $prompt; // Return the complete prompt
    }

    /**
     * Process the responses generated by OpenAI and convert them into cards.
     *
     * @param string $generatedText
     * @return array
     */
    public function processGeneratedCards(string $generatedText): array
    {
        // Decode the JSON response directly
        $cardsData = json_decode($generatedText, true); // Decode to an associative array
        $cards = []; // Initialize an array to hold the card data

        // Check for JSON decode errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            dd("JSON decode error: " . json_last_error_msg()); // Handle the error as needed
        }

        foreach ($cardsData as $card) {
            if (isset($card['front']) && isset($card['back'])) { // Ensure both 'front' and 'back' exist
                $cards[] = [
                    'back' => trim($card['back']), // Set the back of the card
                    'front' => trim($card['front']), // Set the front of the card
                ];
            }
        }
        
        return $cards; // Return the array of processed cards
    }
}
