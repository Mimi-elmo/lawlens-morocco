<nav x-data="{ mobileOpen: false }" class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <div class="flex items-center gap-8">
                <x-logo />
                <div class="hidden lg:flex items-center gap-6">
                    <a href="#features" class="text-sm text-secondary-600 hover:text-primary-600 transition-colors">Fonctionnalités</a>
                    <a href="#structures" class="text-sm text-secondary-600 hover:text-primary-600 transition-colors">Structures</a>
                    <a href="#faq" class="text-sm text-secondary-600 hover:text-primary-600 transition-colors">FAQ</a>
                </div>
            </div>
            <div class="hidden lg:flex items-center gap-3">
                <x-button variant="ghost" size="sm" href="{{ route('login') }}">Connexion</x-button>
                <x-button variant="primary" size="sm" href="{{ route('register') }}">S'inscrire</x-button>
            </div>
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-secondary-600 hover:text-primary-600">
                <x-icon name="menu" class="size-6" />
            </button>
        </div>
    </div>
    <div x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false" class="lg:hidden border-t border-border bg-white px-4 py-4 space-y-3">
        <a href="#features" @click="mobileOpen = false" class="block text-sm text-secondary-600 hover:text-primary-600">Fonctionnalités</a>
        <a href="#structures" @click="mobileOpen = false" class="block text-sm text-secondary-600 hover:text-primary-600">Structures</a>
        <a href="#faq" @click="mobileOpen = false" class="block text-sm text-secondary-600 hover:text-primary-600">FAQ</a>
        <hr class="border-border">
        <x-button variant="ghost" size="sm" href="{{ route('login') }}" class="w-full">Connexion</x-button>
        <x-button variant="primary" size="sm" href="{{ route('register') }}" class="w-full">S'inscrire</x-button>
    </div>
</nav>
