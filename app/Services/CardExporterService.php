<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class CardExporterService
{
    /**
     * Export the generated cards as a JSON file.
     *
     * @param array $cards
     * @return void
     */
    public function exportCards(array $cards): void
    {
        // Crear un archivo JSON con las tarjetas
        $jsonContent = json_encode($cards, JSON_PRETTY_PRINT);

        // Guardar el contenido JSON en un archivo
        $path = storage_path('app/public/anki_cards.json');
        file_put_contents($path, $jsonContent);

        // Opcionalmente, registrar la acción de exportación
        Log::info("Cards exported to: " . $path);
    }

    /**
     * Stream the JSON content for download.
     *
     * @param array $cards
     * @return \Illuminate\Http\Response
     */
    public function streamExport(array $cards)
    {
        $jsonContent = json_encode($cards, JSON_PRETTY_PRINT);

        return response()->stream(function () use ($jsonContent) {
            echo $jsonContent;
        }, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="anki_cards.json"',
        ]);
    }
}
