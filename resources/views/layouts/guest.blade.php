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

    <style>
        .auth-wrap{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:32px 16px}
        .auth-card{width:100%;max-width:440px;margin-top:22px;background:var(--surface);border:1px solid var(--line);border-radius:18px;padding:28px;box-shadow:0 1px 2px rgba(17,24,39,.04),0 18px 44px rgba(17,24,39,.08)}
        .auth-head{text-align:center;margin-bottom:18px}
        .auth-head h1{font-size:30px;font-weight:800;letter-spacing:-.02em;line-height:1.15;margin:0 0 6px;color:var(--ink)}
        .auth-head p{margin:0;font-size:14px;color:var(--muted)}
        .auth-card label.f{display:block;margin:16px 0 6px;font-weight:600;font-size:13px;color:#374151}
        .auth-card input.f{width:100%;padding:11px 12px;border:1px solid #d9d3c6;border-radius:10px;background:#fff;font:400 14px 'Inter',sans-serif;color:var(--ink)}
        .auth-card input.f:focus{outline:0;border-color:var(--teal);box-shadow:0 0 0 3px rgba(15,118,110,.15)}
        .auth-row{display:flex;align-items:center;justify-content:space-between;margin:16px 0 20px;font-size:13px}
        .auth-row label{display:flex;align-items:center;gap:8px;color:#4b5563}
        .auth-row a{color:var(--teal);text-decoration:none;font-weight:500}
        .auth-row a:hover{text-decoration:underline}
        .auth-note{text-align:center;margin-top:18px;font-family:var(--mono);font-size:11px;letter-spacing:.06em;color:var(--muted);text-transform:uppercase}
    </style>
</head>
<body class="antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
