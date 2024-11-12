<!-- success.blade.php -->
@extends('layout')

@section('content')
<section class="py-16 bg-gray-100">
    <div class="container mx-auto text-center">
        <!-- Mensaje de éxito -->
        <div class="bg-white border-2 border-green-500 p-12 rounded-lg shadow-md hover:bg-gray-50 transition duration-300">
            <div class="flex flex-col items-center">
                <!-- Icono de éxito y mensaje -->
                <span class="text-6xl text-green-500 mb-4">✅</span>
                <h2 class="text-3xl font-bold text-gray-700 mb-4">¡Acción completada con éxito!</h2>
                <p class="text-lg text-gray-600 mb-8">
                    Tus notas han sido {{ session('action') == 'download' ? 'descargado como JSON' : 'importadas a Anki' }}.
                </p>

                <!-- Botón para regresar al inicio -->
                <a href="{{ route('home') }}" class="bg-blue-600 text-white py-3 px-8 rounded-full text-lg font-semibold hover:bg-blue-500 transition duration-300">
                    Regresar al inicio
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
