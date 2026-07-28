@extends('layouts.app')

@section('title', 'UI Preview')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-secondary-900 mb-6">UI Component Preview</h1>
        <p class="text-secondary-500 mb-8">
            Cette page sert à vérifier les composants et layouts. 
            <strong class="text-warning">À supprimer avant la mise en production.</strong>
        </p>
    </div>

    <x-card header="<h2 class='font-semibold'>Buttons</h2>">
        <div class="flex flex-wrap gap-3">
            <x-button variant="primary">Primary</x-button>
            <x-button variant="secondary">Secondary</x-button>
            <x-button variant="outline">Outline</x-button>
            <x-button variant="danger">Danger</x-button>
            <x-button variant="ghost">Ghost</x-button>
            <x-button variant="primary" disabled>Disabled</x-button>
            <x-button variant="primary" size="sm">Small</x-button>
            <x-button variant="primary" size="lg">Large</x-button>
        </div>
    </x-card>

    <x-card header="<h2 class='font-semibold'>Badges</h2>">
        <div class="flex flex-wrap gap-2">
            <x-badge variant="success">Succès</x-badge>
            <x-badge variant="warning">Attention</x-badge>
            <x-badge variant="danger">Erreur</x-badge>
            <x-badge variant="pending">En attente</x-badge>
            <x-badge variant="info">Info</x-badge>
            <x-badge variant="primary">Nouveau</x-badge>
        </div>
    </x-card>

    <x-card header="<h2 class='font-semibold'>Form Inputs</h2>">
        <div class="space-y-4 max-w-md">
            <x-input name="text" label="Texte" placeholder="Entrez du texte" helper="Ceci est une aide" />
            <x-input name="email" label="Email" type="email" placeholder="email@exemple.com" required />
            <x-input name="error" label="Avec erreur" value="Mauvaise valeur" error="Ce champ est invalide." />
            <x-textarea name="description" label="Description" placeholder="Votre description..." rows="3" />
            <x-select name="pays" label="Pays" placeholder="Sélectionnez..." :options="['maroc' => 'Maroc', 'france' => 'France', 'autres' => 'Autres']" />
        </div>
    </x-card>

    <x-card header="<h2 class='font-semibold'>Alerts</h2>">
        <div class="space-y-3">
            <x-alert type="success" message="Opération réussie !" />
            <x-alert type="warning" message="Attention, vérifiez les informations." />
            <x-alert type="danger" message="Une erreur est survenue." />
            <x-alert type="info" message="Information importante." />
        </div>
    </x-card>

    <x-card header="<h2 class='font-semibold'>Empty State</h2>">
        <x-empty-state icon="folder" title="Aucun projet" message="Vous n'avez pas encore créé de projet. Commencez par en créer un !">
            <x-button variant="primary">
                <x-icon name="plus" class="size-4" />
                Créer un projet
            </x-button>
        </x-empty-state>
    </x-card>

    <x-card header="<h2 class='font-semibold'>Loading</h2>">
        <div class="flex gap-8 items-center">
            <x-loading size="sm" />
            <x-loading size="md" />
            <x-loading size="lg" text="Chargement en cours..." />
        </div>
    </x-card>
</div>
@endsection
