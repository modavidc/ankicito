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
    <nav class="bg-blue-600 p-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white text-xl font-semibold">
                <a class="navbar-brand fw-bold inline-flex items-center" href="{{ route('home') }}">
                    <img class="mr-2" height="25px" src="{{ asset('favicon.ico') }}">
                    <span>Ankicito</span>
                </a>
            </div>
            <div>
                <a href="#" class="border-2 border-yellow-500 text-white bg-transparent hover:bg-yellow-400 py-3 px-8 mr-2 rounded-full text-lg font-semibold">Login</a>
                <a href="#" class="bg-yellow-500 text-white hover:bg-yellow-400 py-3 px-8 rounded-full text-lg font-semibold">Sign Up</a>

                <!-- <a href="#pricing" class="text-white hover:text-gray-300 ml-4">Precios</a>
                <a href="#shared-decks" class="text-white hover:text-gray-300 ml-4">Mazos Compartidos</a> -->
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center py-4">
        <div class="container mx-auto">
            <p>&copy; 2024 Ankicito. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>