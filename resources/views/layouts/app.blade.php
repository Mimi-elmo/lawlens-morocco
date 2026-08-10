<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'LawLens Morocco')) — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body class="antialiased bg-background">
    <div class="min-h-screen flex">
        <x-sidebar />
        <div class="flex-1 flex flex-col min-w-0">
            <x-navbar />
            <main class="flex-1 p-6">
                @if (session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif
                @if (session('error'))
                    <x-alert type="danger" :message="session('error')" />
                @endif
                @yield('content')
            </main>
            <x-footer />
        </div>
    </div>
</body>
</html>
