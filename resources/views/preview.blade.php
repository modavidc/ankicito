@extends('layout')

@section('content')
<section class="py-16 bg-gray-100">
    <div class="container mx-auto text-center">
        <!-- Título de la página -->
        <h2 class="text-4xl font-bold mb-4">Vista Previa de las Tarjetas de Anki</h2>
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
            <form action="{{ route('downloadAsJSON') }}" method="POST" id="downloadForm1">
                @csrf
                <input type="hidden" name="cards" id="cardsInput">
                <button type="submit" class="bg-blue-600 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-blue-500">
                    <!-- Emoji de IA -->
                    <span class="text-xl">📥</span>
                    <span>Descargar como JSON</span>
                </button>
            </form>
            <form action="{{ route('syncWithAnki') }}" method="POST" id="downloadForm2">
                @csrf
                <button id="syncWithAnki" class="bg-green-600 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-green-500">
                    <!-- Emoji de IA -->
                    <span class="text-xl">🔄</span>
                    <span>Sincronizar con Anki</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Scripts adicionales para funcionalidad -->
<script>
    const downloadAsJSON = document.getElementById('downloadAsJSON');
    const syncWithAnki = document.getElementById('syncWithAnki');

    // Botón para descargar las tarjetas de Anki (redirige al backend)
    downloadAsJSON.addEventListener('click', () => {
        const cards = [];

        // Recoger las tarjetas editadas
        @foreach($cards as $index => $card)
        const frontValue = document.getElementById('front_{{ $index }}').value;
        const backValue = document.getElementById('back_{{ $index }}').value;
        if (frontValue && backValue) { // Validate non-empty fields
            cards.push({
                front: frontValue,
                back: backValue
            });
        } else {
            alert('Por favor, completa todos los campos de las tarjetas.');
            return; // Exit if validation fails
        }
        @endforeach

        if (cards.length > 0) {
            const json = JSON.stringify(cards);
            const blob = new Blob([json], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'cards.json'; // Name of the downloaded file
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            alert('Las tarjetas han sido generadas y descargadas como JSON!');
        } else {
            alert('Por favor, edita las tarjetas antes de generar.');
        }
    });

    // Botón para importar las tarjetas a Anki (sincroniza con Anki)
    syncWithAnki.addEventListener('click', () => {
        const cards = [];

        // Recoger las tarjetas editadas
        @foreach($cards as $index => $card)
        const frontValue = document.getElementById('front_{{ $index }}').value;
        const backValue = document.getElementById('back_{{ $index }}').value;
        if (frontValue && backValue) { // Validate non-empty fields
            cards.push({
                front: frontValue,
                back: backValue
            });
        } else {
            alert('Por favor, completa todos los campos de las tarjetas.');
            return; // Exit if validation fails
        }
        @endforeach

        if (cards.length > 0) {
            console.log('Importando tarjetas a Anki...', cards);
            
            // Nueva funcionalidad para enviar las tarjetas al backend
            fetch('{{ route("syncWithAnki") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
                },
                body: JSON.stringify(cards)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Las tarjetas han sido importadas a Anki!');
                } else {
                    alert('Error al importar las tarjetas: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al importar las tarjetas.');
            });
        } else {
            alert('Por favor, edita las tarjetas antes de importarlas.');
        }
    });

    document.getElementById('downloadForm1').addEventListener('submit', (event) => {
        const cards = [];

        // Recoger las tarjetas editadas
        @foreach($cards as $index => $card)
        const frontValue = document.getElementById('front_{{ $index }}').value;
        const backValue = document.getElementById('back_{{ $index }}').value;
        if (frontValue && backValue) { // Validate non-empty fields
            cards.push({
                front: frontValue,
                back: backValue
            });
        } else {
            alert('Por favor, completa todos los campos de las tarjetas.');
            event.preventDefault(); // Prevent form submission if validation fails
            return; // Exit if validation fails
        }
        @endforeach

        // Set the cards data to the hidden input
        document.getElementById('cardsInput').value = JSON.stringify(cards);
    });
</script>

@endsection