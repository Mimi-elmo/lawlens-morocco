<section id="structures" class="py-20 bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900">
                Structures juridiques
                <span class="text-primary-600">marocaines</span>
            </h2>
            <p class="mt-4 text-secondary-500 text-lg">
                Découvrez les principales formes juridiques disponibles au Maroc. LawLens vous aide à choisir la meilleure option.
            </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <x-legal-card
                name="SARL"
                full-name="Société à Responsabilité Limitée"
                description="Idéale pour les petites et moyennes entreprises. Responsabilité limitée aux apports, capital minimum de 10 000 MAD."
                type="privée"
                icon="briefcase"
                features='["1 à 50 associés", "Capital à partir de 10 000 MAD", "Gérant libre ou associé", "Responsabilité limitée"]'
            />
            <x-legal-card
                name="SASU"
                full-name="Société par Actions Simplifiée Unipersonnelle"
                description="Parfaite pour l'entrepreneur individuel souhaitant une structure flexible avec une responsabilité limitée."
                type="unipersonnelle"
                icon="user"
                features='["Associé unique", "Capital libre", "Flexibilité statutaire", "Protection du patrimoine"]'
            />
            <x-legal-card
                name="SA"
                full-name="Société Anonyme"
                description="Conçue pour les grands projets nécessitant des capitaux importants. Minimum 5 actionnaires, capital à partir de 3 000 000 MAD."
                type="publique"
                icon="building"
                features='["5+ actionnaires", "Capital à partir de 3M MAD", "Conseil d'administration", "Levée de fonds possible"]'
            />
        </div>
        <div class="text-center mt-12">
            <p class="text-secondary-500 mb-4">Et plus encore : GIE, SNC, SCS, Société en Participation...</p>
            <x-button variant="primary" size="lg" href="{{ route('register') }}">
                Analyser ma situation
                <x-icon name="arrow-right" class="size-5 ml-1" />
            </x-button>
        </div>
    </div>
</section>
