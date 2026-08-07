@props(['user' => null])

<header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-border">
    <div class="flex items-center justify-between h-16 px-6">
        <div class="flex items-center gap-4 lg:hidden">
            <button x-data @click="$dispatch('toggle-sidebar')" class="text-secondary-500 hover:text-secondary-700">
                <x-icon name="menu" class="size-6" />
            </button>
            <x-logo />
        </div>

        <div class="flex-1 hidden lg:block"></div>

        <div class="flex items-center gap-3">
            <button class="relative text-secondary-500 hover:text-secondary-700 transition-colors">
                <x-icon name="bell" class="size-5" />
                <span class="absolute -top-1 -right-1 size-2 rounded-full bg-danger"></span>
            </button>

            @auth
                <x-dropdown align="right">
                    <x-slot:trigger>
                        <button class="flex items-center gap-2 text-sm text-secondary-700 hover:text-secondary-900 transition-colors">
                            <div class="size-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-sm font-medium">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                            <x-icon name="chevron-down" class="size-4" />
                        </button>
                    </x-slot:trigger>

                    <x-slot:content>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                            <x-icon name="user" class="size-4" />
                            Profile
                        </a>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                            <x-icon name="settings" class="size-4" />
                            Paramètres
                        </a>
                        <hr class="my-1 border-border">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-danger hover:bg-red-50">
                                <x-icon name="logout" class="size-4" />
                                Déconnexion
                            </button>
                        </form>
                    </x-slot:content>
                </x-dropdown>
            @else
                <x-button variant="secondary" size="sm" href="{{ route('login') }}">
                    Connexion
                </x-button>
                <x-button variant="primary" size="sm" href="{{ route('register') }}">
                    Inscription
                </x-button>
            @endauth
        </div>
    </div>
</header>
