<section class="py-20 bg-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900">
                Votre roadmap en
                <span class="text-primary-600">un clic</span>
            </h2>
            <p class="mt-4 text-secondary-500 text-lg">
                Répondez à quelques questions et obtenez un plan d'action personnalisé avec délais, coûts et documents.
            </p>
        </div>
        <div class="relative max-w-4xl mx-auto">
            <div class="absolute left-8 top-0 bottom-0 w-px bg-gradient-to-b from-primary-500 via-secondary-500 to-accent-500 hidden md:block"></div>
            <div class="space-y-8 md:space-y-0 relative">
                @php
                    $steps = [
                        ['icon' => 'user', 'title' => 'Inscription', 'desc' => 'Créez votre compte en 30 secondes.', 'duration' => 'Jour 1', 'style' => 'primary'],
                        ['icon' => 'document', 'title' => 'Analyse IA', 'desc' => 'Notre IA analyse votre projet et vos besoins.', 'duration' => 'Jour 1', 'style' => 'primary'],
                        ['icon' => 'building', 'title' => 'Choix structure', 'desc' => 'Recommandation de la structure juridique optimale.', 'duration' => 'Jour 1-2', 'style' => 'secondary'],
                        ['icon' => 'currency', 'title' => 'Dépôt capital', 'desc' => 'Ouverture du compte bancaire et dépôt du capital.', 'duration' => 'Jour 3-7', 'style' => 'secondary'],
                        ['icon' => 'document', 'title' => 'Immatriculation', 'desc' => 'Dépôt du dossier au Tribunal de Commerce et OMPIC.', 'duration' => 'Jour 5-10', 'style' => 'accent'],
                        ['icon' => 'check', 'title' => 'Lancement', 'desc' => 'Vous êtes officiellement entrepreneur !', 'duration' => 'Jour 10-14', 'style' => 'accent'],
                    ];
                @endphp
                @foreach ($steps as $i => $step)
                    @php
                        $iconBg = match($step['style']) { 'primary' => 'bg-primary-100 text-primary-600', 'secondary' => 'bg-secondary-100 text-secondary-600', default => 'bg-accent-100 text-accent-600' };
                        $durationClass = match($step['style']) { 'primary' => 'text-primary-600', 'secondary' => 'text-secondary-600', default => 'text-accent-600' };
                    @endphp
                    <div class="md:flex items-start gap-8 group">
                        <div class="hidden md:flex flex-shrink-0 relative z-10">
                            <div class="size-16 rounded-2xl {{ $iconBg }} flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                <x-icon name="{{ $step['icon'] }}" class="size-7" />
                            </div>
                        </div>
                        <div class="md:hidden flex items-center gap-4 mb-3">
                            <div class="size-12 rounded-xl {{ $iconBg }} flex items-center justify-center flex-shrink-0">
                                <x-icon name="{{ $step['icon'] }}" class="size-5" />
                            </div>
                            <div class="text-xs font-semibold {{ $durationClass }} uppercase tracking-wider">{{ $step['duration'] }}</div>
                        </div>
                        <div class="flex-1 bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="hidden md:flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold {{ $durationClass }} uppercase tracking-wider">{{ $step['duration'] }}</span>
                                <span class="text-xs text-secondary-400">Étape {{ $i + 1 }}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-secondary-900 mb-1">{{ $step['title'] }}</h3>
                            <p class="text-secondary-500">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
