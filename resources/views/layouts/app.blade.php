<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CineMap') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-background text-text-primary">
    <div class="min-h-screen flex flex-col">
        
        {{-- Navbar --}}
        <nav class="bg-navbar text-text-primary border-b border-surface shadow-sm">
            @include('layouts.navigation')
        </nav>

        {{-- Page Header (optioneel) --}}
        @isset($header)
            <header class="bg-navbar/80 backdrop-blur-sm border-b border-surface">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Main content --}}
        <main class="flex-1">
            {{ $slot }}
        </main>

        {{-- Footer (optioneel) --}}
        <footer class="bg-navbar text-text-muted text-center py-4 text-sm border-t border-surface">
            © {{ date('Y') }} CineMap — All rights reserved.
        </footer>

    </div>
</body>
</html>
