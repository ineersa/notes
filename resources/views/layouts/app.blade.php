<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.googleapis.com"/>
        <link rel="dns-prefetch" href="//fonts.gstatic.com"/>
        <link rel="preconnect" href="//fonts.googleapis.com" crossorigin/>
        <link rel="preconnect" href="//fonts.gstatic.com" crossorigin/>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet"/>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles

        <!-- Scripts -->
        <wireui:scripts />
        @filamentScripts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
{{--                <header class="bg-white dark:bg-gray-800 shadow">--}}
{{--                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                        {{ $header }}--}}
{{--                    </div>--}}
{{--                </header>--}}
            @endif

            <!-- Page Content -->
            <main class="min-h-screen-3/4">
                {{ $slot }}
            </main>

            <footer>
                <livewire:layout.footer>
            </footer>
        </div>
    </body>
</html>
