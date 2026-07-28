@extends('layouts.entrepreneur')

@section('page-title', 'Modifier : ' . $project->nom)

@section('content')
    <div class="mb-8">
        <a href="{{ route('projects.show', $project) }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">&larr; Retour au projet</a>
    </div>

    <x-card>
        <x-slot:header>
            <div class="flex items-center gap-3">
                <x-icon name="folder" class="size-5 text-accent-600" />
                <span class="font-semibold">Modifier le projet</span>
            </div>
        </x-slot:header>

        <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <x-input name="nom" label="Nom du projet" placeholder="Ex : Ma SARL" :value="old('nom', $project->nom)" required />
                <x-input name="activite" label="Activité" placeholder="Ex : Commerce en ligne" :value="old('activite', $project->activite)" required />
            </div>

            <x-textarea name="description" label="Description" placeholder="Décrivez votre projet..." :value="old('description', $project->description)" rows="3" />

            <div class="grid sm:grid-cols-3 gap-4">
                <x-input name="ville" label="Ville" placeholder="Ex : Casablanca" :value="old('ville', $project->ville)" required />
                <x-input name="budget" label="Budget (MAD)" type="number" placeholder="Ex : 50000" :value="old('budget', $project->budget)" />
                <x-input name="nombre_associes" label="Nombre d'associés" type="number" placeholder="Ex : 1" :value="old('nombre_associes', $project->nombre_associes)" required />
            </div>

            <x-select name="type_activite" label="Type d'activité" :value="old('type_activite', $project->type_activite)" required :options="['individuelle' => 'Individuelle', 'societe' => 'Société']" />

            <x-select name="statut" label="Statut" :value="old('statut', $project->statut)" :options="['brouillon' => 'Brouillon', 'en_cours' => 'En cours', 'termine' => 'Terminé']" />

            <div class="flex items-center gap-3 pt-2">
                <x-button type="submit" variant="primary">Enregistrer</x-button>
                <x-button variant="ghost" href="{{ route('projects.show', $project) }}">Annuler</x-button>
            </div>
        </form>
    </x-card>
@endsection
