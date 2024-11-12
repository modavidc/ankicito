<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

// Core
use App\Services\OpenAIService;
use App\Services\CardGeneratorService;
use App\Services\CardExporterService;

/**
 * Class AnkiController
 *
 * This controller handles the interaction between the application and the Anki flashcard system.
 * It provides methods for converting notes, generating flashcards, previewing, downloading,
 * and syncing with Anki.
 *
 * Properties:
 * @property OpenAIService $openAIService - Service for interacting with OpenAI API.
 * @property CardGeneratorService $cardGeneratorService - Service for generating flashcards.
 * @property CardExporterService $cardExporterService - Service for exporting flashcards.
 */
class AnkiController extends Controller
{
    protected $openAIService;
    protected $cardGeneratorService;
    protected $cardExporterService;

    /**
     * AnkiController constructor.
     *
     * @param OpenAIService $openAIService - Service for OpenAI API interactions.
     * @param CardGeneratorService $cardGeneratorService - Service for generating flashcards.
     * @param CardExporterService $cardExporterService - Service for exporting flashcards.
     */
    public function __construct(
        OpenAIService $openAIService,
        CardGeneratorService $cardGeneratorService,
        CardExporterService $cardExporterService
    ) {
        $this->openAIService = $openAIService;
        $this->cardGeneratorService = $cardGeneratorService;
        $this->cardExporterService = $cardExporterService;
    }

    /**
     * Clears the session cards and returns the convert view.
     *
     * @return \Illuminate\View\View
     */
    public function convert()
    {
        session()->forget('cards');

        return view('convert');
    }

    /**
     * Generates flashcards based on the provided notes.
     *
     * @param Request $request - The incoming request containing notes.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate(Request $request)
    {
        $notes = $request->input('notes');
        $notesTransformed = $this->transformNotes($notes);

        $prompt = $this->cardGeneratorService->generatePrompt($notesTransformed);
        $response = $this->openAIService->getResponse($prompt);
        $jsonResponse = $this->cleanResponse($response);

        $cards = $this->cardGeneratorService->processGeneratedCards($jsonResponse);

        session(['cards' => $cards]);

        return redirect()->route('preview');
    }

    /**
     * Transforms the input notes into an array.
     *
     * @param string $notes - The notes to transform.
     * @return array
     */
    private function transformNotes(string $notes): array
    {
        return explode("\n", $notes);
    }

    /**
     * Cleans the response from OpenAI by trimming and formatting it.
     *
     * @param string $response - The raw response from OpenAI.
     * @return string
     */
    private function cleanResponse(string $response): string
    {
        $jsonResponse = trim($response);
        $jsonResponse = str_replace("```", "", $jsonResponse);
        $jsonResponse = str_replace("json", "", $jsonResponse);

        Log::info("Cleaned OpenAI response:\n" . $jsonResponse);

        return $jsonResponse;
    }

    /**
     * Previews the generated flashcards.
     *
     * @param Request $request - The incoming request.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function preview(Request $request)
    {
        $cards = session('cards', []);

        if (empty($cards)) {
            return redirect()->route('convert');
        }

        return view('preview', ['cards' => $cards]);
    }

    /**
     * Downloads the flashcards as a JSON file.
     *
     * @param Request $request - The incoming request.
     * @return \Illuminate\Http\Response
     */
    public function downloadAsJSON(Request $request)
    {
        $cards = session('cards', []);

        if (empty($cards)) {
            return response()->json([
                'status' => false,
                'code'  => 404,
                'message' => 'No se han encontrado tarjetas en la sesión.'
            ], 404);
        }

        $jsonContent = json_encode($cards, JSON_PRETTY_PRINT);

        session()->forget('cards');

        return response()->stream(function () use ($jsonContent) {
            echo $jsonContent;
        }, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="anki_cards.json"',
        ]);
    }

    /**
     * Syncs the generated flashcards with Anki.
     *
     * @param Request $request - The incoming request.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncWithAnki(Request $request)
    {
        $cards = session('cards', []);

        if (empty($cards)) {
            return redirect()->route('convert')->withErrors('No se encontraron tarjetas en la sesión.');
        }

        $response = $this->sendToAnki($cards);

        session()->forget('cards');

        if ($response['status'] === 'success') {
            return redirect()->route('success')->with('message', 'Tarjetas importadas a Anki con éxito.');
        } else {
            return redirect()->route('convert')->withErrors('Ocurrió un error al importar las tarjetas a Anki.');
        }
    }

    /**
     * Sends the flashcards to Anki.
     *
     * @param array $cards - The flashcards to send.
     * @return array
     */
    private function sendToAnki($cards)
    {
        $deckName = 'Ankicito';
        $results = [];

        if (!$this->deckExists($deckName)) {
            $this->createDeck($deckName);
        }

        foreach ($cards as $card) {
            $response = $this->createAnkiCard($deckName, $card['front'], $card['back']);
            $results[] = $response;
        }

        return [
            'status' => 'success',
            'message' => 'Cards sent to Anki successfully.',
            'results' => $results,
        ];
    }

    /**
     * Checks if a specific deck exists in Anki.
     *
     * @param string $deckName - The name of the deck to check.
     * @return bool
     */
    private function deckExists($deckName)
    {
        $payload = [
            "action" => "deckNames",
            "version" => 6,
        ];

        $response = Http::post("http://localhost:8765", $payload);
        $decks = $response->json()['result'] ?? [];

        return in_array($deckName, $decks);
    }

    /**
     * Creates a new deck in Anki.
     *
     * @param string $deckName - The name of the deck to create.
     * @return void
     */
    private function createDeck($deckName)
    {
        $payload = [
            "action" => "createDeck",
            "version" => 6,
            "params" => [
                "deck" => $deckName,
            ],
        ];

        Http::post("http://localhost:8765", $payload);
    }

    /**
     * Creates a new card in Anki.
     *
     * @param string $deckName - The name of the deck.
     * @param string $front - The front content of the card.
     * @param string $back - The back content of the card.
     * @return array|\Illuminate\Http\JsonResponse
     */
    private function createAnkiCard($deckName, $front, $back)
    {
        $payload = [
            "action" => "addNote",
            "version" => 6,
            "params" => [
                "note" => [
                    "deckName" => $deckName,
                    "modelName" => "Basic",
                    "fields" => [
                        "Front" => $front,
                        "Back" => $back,
                    ],
                    "options" => [
                        "allowDuplicate" => false,
                    ],
                    "tags" => [],
                ],
            ],
        ];

        $response = Http::post("http://localhost:8765", $payload);

        if ($response->successful()) {
            $result = $response->json();
            if (isset($result['error']) && $result['error'] !== null) {
                return response()->json([
                    'status' => false,
                    'code'  => 500,
                    'message' => $result['error']
                ], 500);
            } else {
                // return ['success' => true, 'id' => $result['result']];
            }
        } else {
            return response()->json([
                'status' => false,
                'code'  => 500,
                'message' => 'HTTP request failed with status ' . $response->status()
            ], 500);
        }
    }
}
