@extends('layouts.entrepreneur')

@section('page-title', 'Nouveau projet')

@section('content')
    <div class="mb-8">
        <a href="{{ route('projects.index') }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">&larr; Retour aux projets</a>
    </div>

    <x-card>
        <x-slot:header>
            <div class="flex items-center gap-3">
                <x-icon name="folder" class="size-5 text-primary-600" />
                <span class="font-semibold">Nouveau projet</span>
            </div>
        </x-slot:header>

        <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
            @csrf

            <div class="grid sm:grid-cols-2 gap-4">
                <x-input name="nom" label="Nom du projet" placeholder="Ex : Ma SARL" :value="old('nom')" required />
                <x-input name="activite" label="Activité" placeholder="Ex : Commerce en ligne" :value="old('activite')" required />
            </div>

            <x-textarea name="description" label="Description" placeholder="Décrivez votre projet..." :value="old('description')" rows="3" />

            <div class="grid sm:grid-cols-3 gap-4">
                <x-input name="ville" label="Ville" placeholder="Ex : Casablanca" :value="old('ville')" required />
                <x-input name="budget" label="Budget (MAD)" type="number" placeholder="Ex : 50000" :value="old('budget')" />
                <x-input name="nombre_associes" label="Nombre d'associés" type="number" placeholder="Ex : 1" :value="old('nombre_associes', 1)" required />
            </div>

            <x-select name="type_activite" label="Type d'activité" :value="old('type_activite')" required :options="['individuelle' => 'Individuelle', 'societe' => 'Société']" />

            <div class="flex items-center gap-3 pt-2">
                <x-button type="submit" variant="primary">Créer le projet</x-button>
                <x-button variant="ghost" href="{{ route('projects.index') }}">Annuler</x-button>
            </div>
        </form>
    </x-card>
@endsection
