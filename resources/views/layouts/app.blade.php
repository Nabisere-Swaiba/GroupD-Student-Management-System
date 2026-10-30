<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Student Management System') }}</title>

    @include('partials.theme')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @include('partials.jet-skin')
</head>
<body class="antialiased">
    <x-banner />

    @include('partials.nav')

    @isset($header)
        <div class="page-header">
            <div class="page-header-inner">{{ $header }}</div>
        </div>
    @endisset

    <main style="flex:1">
        {{ $slot }}
    </main>

    <footer class="site-footer">&copy; {{ date('Y') }} Makerere University Business School &middot; BUC3131 Coursework Two</footer>

    @stack('modals')
    @livewireScripts
</body>
</html>
