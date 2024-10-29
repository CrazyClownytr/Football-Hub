<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Football Lovers') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        /* Background setup */
        body {
            background: radial-gradient(circle, rgba(10, 50, 10, 0.95), rgba(5, 20, 5, 0.95));
            background-size: cover;
            font-family: 'figtree', sans-serif;
            color: #f0f0f0;
        }

        /* Header styling */
        header {
            background-color: #1a1a1a;
            border-bottom: 3px solid #3ba55d; /* Football green */
            color: #f0f0f0;
        }

        /* Navigation Bar */
        .navigation {
            background-color: #1a1a1a;
            color: #f0f0f0;
        }

        .navigation a {
            color: #3ba55d;
            font-weight: bold;
        }

        .navigation a:hover {
            color: #f0f0f0;
        }

        /* Main container */
        .min-h-screen {
            background: rgba(10, 50, 10, 0.95); /* A dark overlay on field */
        }

        /* Main content area */
        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: rgba(30, 30, 30, 0.8);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        /* Footer */
        footer {
            background-color: #1a1a1a;
            color: #3ba55d;
            padding: 15px;
            text-align: center;
            border-top: 3px solid #3ba55d;
        }

        /* Buttons */
        .btn {
            background-color: #3ba55d;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2e7d42;
        }
    </style>
</head>
<body>
<div class="min-h-screen">
    <!-- Navigation Bar -->
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

<!-- Footer -->
<footer class="bg-green-800 mt-12 py-4 text-center border-t border-green-600">
    <p class="text-gray-200">© 2024 Football Lovers. All rights reserved.</p>
</footer>
</body>
</html>
