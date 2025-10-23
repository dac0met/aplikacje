<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Application Form') }}</title>

         {{-- Fonts  --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- -- Scripts -- --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- -- Styles -- --}}
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-400 dark:bg-gray-900">
            {{-- @livewire('navigation-menu') --}}

            {{-- -- Page Heading -- --}}
            <header class="bg-white/70 dark:bg-gray-800/70 backdrop-blur border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('logo.svg') }}" alt="{{ trim(strip_tags($header ?? config('app.name', 'Application Form'))) }}" class="h-8 sm:h-10 object-contain" />
                    </div>
                    <button type="button"
                        onclick="window.__toggleTheme && window.__toggleTheme()"
                        class="inline-flex items-center gap-2 rounded-md border border-gray-300 dark:border-gray-600 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800"
                        aria-label="Toggle dark mode">
                        <span class="block dark:hidden">Dark</span>
                        <span class="hidden dark:block">Light</span>
                    </button>
                </div>
            </header>

            {{-- -- Page Content -- --}}
            <main>
                {{ $slot }}
            </main>
            
            {{-- Sekcje GDPR i RODO --}}
            <x-gdpr-rodo-sections />

            {{-- Footer --}}
            <x-footer />
        </div>


        {{-- @stack('modals') --}}

        @livewireScripts
    </body>
</html>
