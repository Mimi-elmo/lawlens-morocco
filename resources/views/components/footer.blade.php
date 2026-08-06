<footer {{ $attributes->merge(['class' => 'border-t border-border bg-white px-6 py-4']) }}>
    <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-secondary-500">
        <p>&copy; {{ date('Y') }} LawLens Morocco. Tous droits réservés.</p>
        <div class="flex items-center gap-4">
            <a href="#" class="hover:text-secondary-700 transition-colors">Confidentialité</a>
            <a href="#" class="hover:text-secondary-700 transition-colors">CGU</a>
            <a href="#" class="hover:text-secondary-700 transition-colors">Contact</a>
        </div>
    </div>
</footer>
