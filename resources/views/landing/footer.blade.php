<footer class="bg-secondary-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <x-logo class="text-white mb-4" />
                <p class="text-secondary-400 text-sm max-w-sm leading-relaxed">
                    LawLens Morocco utilise l'intelligence artificielle pour aider les entrepreneurs marocains à naviguer dans le paysage juridique et créer leur entreprise en toute sérénité.
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-4">Produit</h3>
                <ul class="space-y-3 text-sm text-secondary-400">
                    <li><a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                    <li><a href="#structures" class="hover:text-white transition-colors">Structures juridiques</a></li>
                    <li><a href="#faq" class="hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Tarifs</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-4">Légal</h3>
                <ul class="space-y-3 text-sm text-secondary-400">
                    <li><a href="#" class="hover:text-white transition-colors">Confidentialité</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Conditions d'utilisation</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Mentions légales</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary-700 my-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-secondary-500">
            <p>&copy; {{ date('Y') }} LawLens Morocco. Tous droits réservés.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-white transition-colors" aria-label="LinkedIn">
                    <x-icon name="external" class="size-5" />
                </a>
                <a href="#" class="hover:text-white transition-colors" aria-label="Twitter/X">
                    <x-icon name="external" class="size-5" />
                </a>
            </div>
        </div>
    </div>
</footer>
