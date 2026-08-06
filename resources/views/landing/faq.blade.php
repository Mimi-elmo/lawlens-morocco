<section id="faq" class="py-20 bg-background">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-secondary-900">
                Questions
                <span class="text-primary-600">fréquentes</span>
            </h2>
            <p class="mt-4 text-secondary-500 text-lg">
                Tout ce que vous devez savoir sur la création d'entreprise au Maroc.
            </p>
        </div>
        <div x-data="{ open: null }" class="space-y-3">
            <x-faq-item key="1" question="Quelle est la meilleure structure juridique pour une startup au Maroc ?" x-data-key="open">
                Le choix dépend de plusieurs facteurs : nombre d'associés, capital disponible, activité, et objectifs de croissance.
                La <strong>SARL</strong> est recommandée pour la plupart des PME. La <strong>SASU</strong> est idéale pour les entrepreneurs individuels.
                LawLens analyse votre situation et vous recommande la structure optimale.
            </x-faq-item>
            <x-faq-item key="2" question="Combien coûte la création d'une entreprise au Maroc ?" x-data-key="open">
                Les coûts varient selon la structure :<br>
                - SARL : environ 3 000 - 5 000 MAD (hors capital)<br>
                - SASU : environ 2 500 - 4 000 MAD<br>
                - SA : 10 000 - 20 000 MAD<br>
                Ces frais incluent l'immatriculation à l'OMPIC, la publication légale, et les frais de greffe.
            </x-faq-item>
            <x-faq-item key="3" question="Combien de temps faut-il pour créer une entreprise au Maroc ?" x-data-key="open">
                Le délai moyen est de <strong>7 à 14 jours</strong> pour une SARL ou SASU. Avec LawLens, vous gagnez du temps
                en ayant toutes les étapes et documents préparés à l'avance. Le délai peut être réduit à 5-7 jours
                si tous les documents sont prêts.
            </x-faq-item>
            <x-faq-item key="4" question="Puis-je créer une entreprise seul au Maroc ?" x-data-key="open">
                Oui, absolument. La <strong>SASU</strong> (Société par Actions Simplifiée Unipersonnelle) est spécialement
                conçue pour l'entrepreneur individuel. Vous pouvez aussi opter pour le statut d'<strong>auto-entrepreneur</strong>
                si votre chiffre d'affaires est inférieur aux seuils réglementaires.
            </x-faq-item>
            <x-faq-item key="5" question="LawLens est-il gratuit ?" x-data-key="open">
                LawLens propose un <strong>niveau gratuit</strong> pour découvrir les structures juridiques et consulter
                la base légale. Les fonctionnalités avancées (roadmap personnalisée IA, suivi de projet) sont disponibles
                via un abonnement abordable. Pas de carte bancaire requise pour commencer.
            </x-faq-item>
        </div>
    </div>
</section>
