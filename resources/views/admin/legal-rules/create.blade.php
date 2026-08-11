@extends('layouts.admin')

@section('page-title', 'Nouvelle règle juridique')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.rules.index') }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">&larr; Retour aux règles</a>
    </div>

    <x-card>
        <x-slot:header>
            <div class="flex items-center gap-3">
                <x-icon name="shield" class="size-5 text-primary-600" />
                <span class="font-semibold">Nouvelle règle juridique</span>
            </div>
        </x-slot:header>

        <form method="POST" action="{{ route('admin.rules.store') }}" class="space-y-6">
            @csrf

            <x-input name="titre" label="Titre" placeholder="Ex : Déclaration de cessation d'activité" :value="old('titre')" required />

            <x-select name="categorie" label="Catégorie" :value="old('categorie')" required :options="['legal' => 'Légal', 'administrative' => 'Administrative', 'fiscal' => 'Fiscale', 'document' => 'Document']" />

            <x-input name="source" label="Source" placeholder="Ex : DGI, OMPIC..." :value="old('source')" />

            <x-input name="date_entree_vigueur" label="Date d'entrée en vigueur" type="date" :value="old('date_entree_vigueur')" />

            <x-textarea name="description" label="Description" placeholder="Décrivez la règle..." :value="old('description')" rows="3" />

            <x-select name="statut" label="Statut" :value="old('statut', 'active')" :options="['active' => 'Active', 'inactive' => 'Inactive']" />

            <div class="flex items-center gap-3 pt-2">
                <x-button type="submit" variant="primary">Créer</x-button>
                <x-button variant="ghost" href="{{ route('admin.rules.index') }}">Annuler</x-button>
            </div>
        </form>
    </x-card>
@endsection