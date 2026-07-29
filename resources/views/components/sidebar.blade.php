@props(['user' => null])

<aside
    x-data="{ open: false }"
    x-on:toggle-sidebar.window="open = !open"
    x-on:keydown.escape.window="open = false"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-surface border-r border-border transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:z-auto"
    :class="open ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="flex items-center justify-between h-16 px-6 border-b border-border">
        <x-logo />
        <button @click="open = false" class="lg:hidden text-secondary-400 hover:text-secondary-600">
            <x-icon name="xmark" class="size-5" />
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        @php
            $isDashboard = request()->routeIs('dashboard');
            $isProjects = request()->routeIs('projects.*');
            $isRoadmaps = request()->routeIs('roadmaps.*');
            $isAdmin = request()->routeIs('admin.*');
        @endphp
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $isDashboard ? 'bg-primary-50 text-primary-700' : 'text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900' }}">
            <x-icon name="chart" class="size-5" />
            Tableau de bord
        </a>
        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $isProjects ? 'bg-primary-50 text-primary-700' : 'text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900' }}">
            <x-icon name="folder" class="size-5" />
            Projets
        </a>
        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $isRoadmaps ? 'bg-primary-50 text-primary-700' : 'text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900' }}">
            <x-icon name="document" class="size-5" />
            Roadmaps
        </a>

        <hr class="my-3 border-border">

        <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Juridique</p>
        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
            <x-icon name="scale" class="size-5" />
            Structures juridiques
        </a>
        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition-colors">
            <x-icon name="shield" class="size-5" />
            Règles juridiques
        </a>

        @auth
            @if(auth()->user()->isAdmin())
                <hr class="my-3 border-border">
                <p class="px-3 text-xs font-semibold text-secondary-400 uppercase tracking-wider">Administration</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $isAdmin ? 'bg-primary-50 text-primary-700' : 'text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900' }}">
                    <x-icon name="users" class="size-5" />
                    Administration
                </a>
            @endif
        @endauth
    </nav>
</aside>

<div
    x-data="{ open: false }"
    x-on:toggle-sidebar.window="open = !open"
    x-show="open"
    class="fixed inset-0 z-30 bg-secondary-900/50 backdrop-blur-sm lg:hidden"
    @click="open = false"
    style="display: none;"
></div>
