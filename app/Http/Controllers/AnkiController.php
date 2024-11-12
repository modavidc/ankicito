<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

// Core
use App\Services\OpenAIService;
use App\Services\CardGeneratorService;
use App\Services\CardExporterService;

class AnkiController extends Controller
{
    protected $openAIService;
    protected $cardGeneratorService;
    protected $cardExporterService;

    public function __construct(
        OpenAIService $openAIService,
        CardGeneratorService $cardGeneratorService,
        CardExporterService $cardExporterService
    ) {
        $this->openAIService = $openAIService;
        $this->cardGeneratorService = $cardGeneratorService;
        $this->cardExporterService = $cardExporterService;
    }

    public function convert()
    {
        session()->forget('cards');

        return view('convert');
    }

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

    private function transformNotes(string $notes): array
    {
        return explode("\n", $notes);
    }


    private function cleanResponse(string $response): string
    {
        $jsonResponse = trim($response);
        $jsonResponse = str_replace("```", "", $jsonResponse);
        $jsonResponse = str_replace("json", "", $jsonResponse);

        Log::info("Cleaned OpenAI response:\n" . $jsonResponse);

        return $jsonResponse;
    }

    public function preview(Request $request)
    {
        $cards = session('cards', []);

        if (empty($cards)) {
            return redirect()->route('convert');
        }

        return view('preview', ['cards' => $cards]);
    }

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
