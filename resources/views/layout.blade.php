<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ankicito: El Generador de Tarjetas de Estudio AI #1 para Estudiantes')</title>
    <!-- Aquí puedes incluir tu CSS o un archivo de estilo -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="text-white text-xl font-semibold">
                <a class="navbar-brand fw-bold inline-flex items-center" href="{{ route('home') }}">
                    <img class="mr-2" height="25px" src="{{ asset('favicon.ico') }}">
                    <span>Ankicito</span>
                </a>
            </div>

            <!-- Botón de menú hamburguesa en móvil -->
            <button class="block lg:hidden text-white" id="hamburger-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Menú de navegación -->
            <div class="hidden lg:flex space-x-6 items-center">
                <!-- <a href="#" class="hover:text-yellow-400">Inicio</a>
                <a href="#" class="hover:text-yellow-400">Características</a>
                <a href="#" class="hover:text-yellow-400">Sobre Nosotros</a> -->
                <a href="{{ route('convert') }}" class="bg-yellow-500 text-white hover:bg-yellow-400 py-3 px-8 rounded-full text-lg font-semibold">Genera tus Tarjetas</a>
            </div>
        </div>

        <!-- Menú desplegable (hamburguesa) -->
        <div class="lg:hidden hidden bg-blue-600 text-white w-full py-4 px-4 items-center" id="mobile-menu">
            <!-- <a href="#" class="block py-2">Inicio</a>
            <a href="#" class="block py-2">Características</a>
            <a href="#" class="block py-2">Sobre Nosotros</a> -->
            <a href="{{ route('convert') }}" class="block bg-yellow-500 text-white py-3 px-8 rounded-full text-lg font-semibold">Genera tus Tarjetas</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center py-6 px-6">
        <div class="container mx-auto">
            <p>&copy; 2024 Ankicito. Todos los derechos reservados.</p>
            <p>Desarrollado con pasión ❤️ y emoción 🤩, por <a style="font-weight: bold; color: #fbbf24" href="https://modavidc.com">Moi</a></p>
        </div>
    </footer>

</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('hamburger-button'); // ID del botón hamburguesa
        const menu = document.getElementById('mobile-menu'); // ID del menú móvil

        menuButton.addEventListener('click', function() {
            menu.classList.toggle('hidden'); // Alterna la clase 'hidden' para mostrar/ocultar el menú
        });
    });
</script>