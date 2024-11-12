@extends('layout')

@section('content')
<section class="py-16 bg-gray-100">
    <div class="container mx-auto text-center">
        <!-- Título de la página -->
        <h2 class="text-4xl font-bold mb-4">Convertir Texto en Tarjetas de Anki</h2>
        <p class="text-lg mb-8">
            Pega tu texto directamente aquí para convertirlo en tarjetas de Anki.
        </p>

        <!-- Área de texto para pegar las notas -->
        <div class="mb-8">
            <form action="{{ route('generate') }}" method="POST">
                @csrf
                <div class="border-2 border-dashed border-blue-600 p-12 rounded-lg bg-white hover:bg-gray-50 transition duration-300">
                    <div class="flex flex-col items-center">
                        <p class="text-xl text-gray-700">Pega tus notas aquí...</p>
                        <textarea id="notesText" name="notes" rows="10" class="mt-4 block w-full border-2 border-gray-300 rounded-lg p-4 text-lg" placeholder="Pega tu texto aquí..."></textarea>
                    </div>
                </div>

                <!-- Botón de acción -->
                <div class="mt-8">
                    <button type="submit" class="bg-blue-600 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-blue-500">
                        <!-- Emoji de IA -->
                        <span class="text-xl">🤖</span>
                        <span>Generar y Previsualizar</span> 
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Scripts adicionales para funcionalidad -->
<!-- Removed JavaScript for button click -->
@endsection