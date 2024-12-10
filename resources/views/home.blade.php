@extends('layout')

@section('title', 'Ankicito: El Generador de Tarjetas de Estudio AI #1 para Estudiantes')

@section('content')
<!-- Hero Section -->
<section class="bg-blue-600 text-white text-center py-16">
    <div class="container mx-auto pr-2 pl-2">
        <div class="mb-16 flex flex-col items-center" style="margin-top: -50px;">
            <span>⭐ ⭐ ⭐ ⭐ ⭐ </span>
            <span>Ayudando a los estudiantes a ahorrar horas en sus estudios.</span>
        </div>
        <img src="{{ asset('android-chrome-192x192.png') }}" alt="Texto" class="w-24 h-24 mb-4 mx-auto">

        <h1 class="text-4xl font-bold mb-4">
            El Generador de Tarjetas de Estudio AI #1 para Estudiantes
        </h1>
        <p class="text mb-12 pr-4 pl-4">
            Ahorra miles de horas de estudio convirtiendo tus notas de clase en tarjetas de Anki con un solo clic.</br>
            ¡<span style="font-weight: bold; color: #fbbf24">Apunta</span>, <span style="font-weight: bold; color: #fbbf24">genera</span> y <span style="font-weight: bold; color: #fbbf24">estudia</span> de manera más eficiente!
        </p>
        <a href="{{ route('convert') }}" class="bg-yellow-500 text-white hover:bg-yellow-400 py-3 px-8 rounded-full text-lg font-semibold">
            🤖 ¡Genera Tus Tarjetas Ahora!
        </a>
        <div class="flex flex-col items-center mt-10">
            <!-- <div class="flex space-x-4 mb-4">
                <img src="{{ asset('text-icon.png') }}" alt="Text" class="w-8 h-8">
                <img src="{{ asset('word-icon.png') }}" alt="Word" class="w-8 h-8">
                <img src="{{ asset('pdf-icon.png') }}" alt="PDF" class="w-8 h-8">
                <img src="{{ asset('ppt-icon.png') }}" alt="PowerPoint" class="w-8 h-8">
                <img src="{{ asset('excel-icon.png') }}" alt="Excel" class="w-8 h-8">
                <img src="{{ asset('png-icon.png') }}" alt="PNG" class="w-8 h-8">
                <img src="{{ asset('youtube-icon.png') }}" alt="YouTube" class="w-8 h-8">
            </div> -->
            <ul class="text-center mt-4">
                <li>🌟 <strong>El generador #1 de tarjetas de memorias que podrás encontrar.</strong></li>
                <li>🎉 <strong>A 2 estudiantes ya les encanta.</strong> </li>
                <li>⏳ <strong>Ahorra horas creando tarjetas de Anki.</strong> </li>
            </ul>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-12 px-12">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8">
            Convierte tus Notas en Tarjetas de Estudio de Anki en Segundos
        </h2>
        <p class="text-lg mb-8">
            Ya no necesitas crear las tarjetas manualmente. Simplemente sube tus notas y deja que Ankicito haga el resto.
            Concédele más tiempo a estudiar, no a crear tarjetas.
        </p>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-4">
                <img src="{{ asset('text-icon.png') }}" alt="Texto" class="mb-4 mx-auto w-24 h-24">
                <h3 class="text-xl font-semibold">Texto</h3>
                <p class="text-gray-600">¡Simplemente pega tu texto y genera las tarjetas al instante!</p>
            </div>
            <div class="p-4">
                <img src="{{ asset('word-icon.png') }}" alt="Word" class="mb-4 mx-auto w-24 h-24">
                <h3 class="text-xl font-semibold">Word</h3>
                <p class="text-gray-600">Convierte tus documentos de Word fácilmente en tarjetas de estudio con procesamiento AI.</p>
            </div>
            <div class="p-4">
                <img src="{{ asset('pdf-icon.png') }}" alt="PDF" class="mb-4 mx-auto w-24 h-24">
                <h3 class="text-xl font-semibold">PDF</h3>
                <p class="text-gray-600">Convierte tus notas de clase y archivos PDF directamente en tarjetas de Anki.</p>
            </div>
        </div>
    </div>
</section>

<!-- Additional sections can be added below as needed -->
@endsection

@push('scripts')
<script>
    const hamburgerButton = document.getElementById('hamburger-button');
    const mobileMenu = document.getElementById('mobile-menu');

    hamburgerButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
@endpush