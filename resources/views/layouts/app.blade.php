<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Swiper -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Header -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Navbar -->
        <nav class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center">
            <form action="{{ route('buscar') }}" method="GET" class="flex space-x-2">
                <input type="text" name="q" placeholder="Search" class="border p-2 rounded">
                <input type="hidden" name="view" value="{{ Route::currentRouteName() }}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
            </form>
            <ul class="flex space-x-6">
                <li><a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">Recommendations</a></li>
                <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-800">Products</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
