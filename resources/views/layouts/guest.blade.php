<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'LawLens Morocco')) — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-background">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <x-logo class="mb-8" />
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
