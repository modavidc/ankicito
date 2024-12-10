@extends('layout')

@section('content')
<section class="py-16 bg-gray-100">
    <div class="container mx-auto text-center">
        <!-- Título de la página -->
        <h2 class="text-4xl font-bold mb-4">Vista Previa de las Tarjetas de Ankis</h2>
        <p class="text-lg mb-8">
            Edita las tarjetas antes de generarlas o importarlas a Anki.
        </p>

        <!-- Sección de tarjetas generadas -->
        <div class="mb-8">
            <div class="border-2 border-dashed border-blue-600 p-12 rounded-lg bg-white hover:bg-gray-50 transition duration-300">
                <div class="flex flex-col items-center space-y-6">
                    @foreach ($cards as $index => $card)
                    <div class="w-full bg-gray-50 p-4 rounded-lg shadow-md">
                        <div class="flex justify-between mb-4">
                            <input type="text" value="{{ $card['front'] }}" id="front_{{ $index }}" class="w-1/2 text-lg p-2 border-2 border-gray-300 rounded-lg" placeholder="Frente de la tarjeta">
                            <input type="text" value="{{ $card['back'] }}" id="back_{{ $index }}" class="w-1/2 text-lg p-2 border-2 border-gray-300 rounded-lg" placeholder="Reverso de la tarjeta">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="mt-8 flex justify-center space-x-4">
            <!-- <form action="{{ route('downloadAsJSON') }}" method="POST" id="downloadForm1">
                @csrf -->
            <input type="hidden" name="cards" id="cardsInput">
            <button id=downloadAsJSON type="submit" class="bg-blue-600 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-blue-500">
                <!-- Emoji de IA -->
                <span class="text-xl">📥</span>
                <span>Descargar como JSON</span>
            </button>
            <!-- </form> -->
            <!-- <form action="{{ route('syncWithAnki') }}" method="POST" id="downloadForm2">
                @csrf -->
            <button id="syncWithAnki" class="bg-green-600 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-green-500">
                <!-- Emoji de IA -->
                <span class="text-xl">🔄</span>
                <span>Sincronizar con Anki</span>
            </button>
            <!-- </form> -->
        </div>
    </div>
</section>

<script>
    const syncWithAnki = document.getElementById('syncWithAnki');

    // Botón para sincronizar las tarjetas con Anki
    syncWithAnki.addEventListener('click', () => {
        alert("Sincronizando...");

        const cards = [];

        // Recoger las tarjetas editadas
        @foreach($cards as $index => $card)
        var frontValue = document.getElementById('front_{{ $index }}').value;
        var backValue = document.getElementById('back_{{ $index }}').value;

        if (frontValue && backValue) { // Validar campos no vacíos
            cards.push({
                front: frontValue,
                back: backValue
            });
        } else {
            alert('Por favor, completa todos los campos de las tarjetas.');
            return; // Salir si falla la validación
        }
        @endforeach

        if (cards.length > 0) {
            console.log('Sincronizando con Anki...', cards);

            // Construir el payload con todas las tarjetas
            const notes = cards.map(card => ({
                deckName: "Ankicito", // Nombre del mazo
                modelName: "Basic", // Modelo de la carta
                fields: {
                    Front: card.front,
                    Back: card.back
                },
                options: {
                    allowDuplicate: false
                },
                tags: []
            }));

            const payload = {
                action: "addNotes",
                version: 6,
                params: {
                    notes: notes
                }
            };

            // Hacer una solicitud POST a AnkiConnect
            fetch('http://localhost:8765', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*', // CORS
                        'Access-Control-Allow-Headers': '*' // Permitir headers CORS
                    },
                    body: JSON.stringify(payload), // Convertir el payload a formato JSON
                    mode: 'cors' // Habilitar CORS en el cliente
                })
                .then(response => response.json()) // Esperar respuesta JSON
                .then(data => {
                    console.log('Respuesta de AnkiConnect:', data);

                    // Verificar la respuesta y dar feedback al usuario
                    if (data.error) {
                        alert('Error al sincronizar con Anki: ' + data.error);
                    } else {
                        alert('¡Las tarjetas han sido sincronizadas con Anki!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al sincronizar con Anki.');
                });
        } else {
            alert('Por favor, edita las tarjetas antes de importarlas.');
        }
    });
</script>