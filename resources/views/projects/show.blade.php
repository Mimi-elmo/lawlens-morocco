@extends('layouts.entrepreneur')

@section('page-title', $project->nom)

@section('content')
    <div class="mb-8">
        <a href="{{ route('projects.index') }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">&larr; Retour aux projets</a>
    </div>

    <div class="flex items-start justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-2xl font-bold text-secondary-900">{{ $project->nom }}</h1>
                <x-badge :variant="match($project->statut) { 'brouillon' => 'pending', 'en_cours' => 'info', 'termine' => 'success', default => 'pending' }">
                    {{ $project->statut }}
                </x-badge>
            </div>
            <p class="text-secondary-500">{{ $project->activite }} &middot; {{ $project->ville }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="outline" href="{{ route('projects.edit', $project) }}">Modifier</x-button>
            <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Supprimer ce projet ? Cette action est irréversible.')">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">Supprimer</x-button>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <p class="text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-1">Budget</p>
            <p class="text-lg font-bold text-secondary-900">{{ $project->budget ? number_format($project->budget, 0, ',', ' ') . ' MAD' : 'Non renseigné' }}</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <p class="text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-1">Associés</p>
            <p class="text-lg font-bold text-secondary-900">{{ $project->nombre_associes }}</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <p class="text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-1">Type d'activité</p>
            <p class="text-lg font-bold text-secondary-900 capitalize">{{ $project->type_activite }}</p>
        </div>
    </div>

    @if ($project->description)
        <x-card class="mb-8">
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="document" class="size-5 text-secondary-600" />
                    <span class="font-semibold">Description</span>
                </div>
            </x-slot:header>
            <p class="text-sm text-secondary-600 leading-relaxed">{{ $project->description }}</p>
        </x-card>
    @endif

    <x-card>
        <x-slot:header>
<div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <x-icon name="document" class="size-5 text-accent-600" />
                        <span class="font-semibold">Roadmaps</span>
                    </div>
                    <form method="POST" action="{{ route('roadmaps.generate', $project) }}">
                        @csrf
                        <x-button type="submit" variant="primary" size="sm">
                            <x-icon name="sparkles" class="size-4" />
                            Générer une roadmap
                        </x-button>
                    </form>
                </div>
            </x-slot:header>
        @if ($project->roadmaps_count === 0)
            <x-empty-state icon="document" title="Aucune roadmap" message="Générez votre première roadmap avec l'IA pour ce projet.">
                <form method="POST" action="{{ route('roadmaps.generate', $project) }}">
                    @csrf
                    <x-button type="submit" variant="primary">Générer avec l'IA</x-button>
                </form>
            </x-empty-state>
        @else
            <ul class="divide-y divide-border">
                @foreach ($roadmaps as $roadmap)
                    <li class="py-4 flex items-start justify-between gap-4">
                        <div>
                            <a href="{{ route('roadmaps.show', $roadmap) }}" class="text-sm font-medium text-secondary-900 hover:text-primary-600 transition-colors">
                                Roadmap #{{ $roadmap->id }}
                            </a>
                            <p class="text-xs text-secondary-500 mt-1">
                                {{ $roadmap->formeJuridiqueRecommendee?->nom ?? 'Structure recommandée indisponible' }}
                            </p>
                            <div class="flex items-center gap-3 mt-2">
                                <div class="w-32 bg-secondary-100 rounded-full h-1.5">
                                    <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ $roadmap->progression }}%"></div>
                                </div>
                                <span class="text-xs text-secondary-500">{{ $roadmap->progression }}%</span>
                            </div>
                        </div>
                        @php
                            $statusMap = ['pending' => 'pending', 'in_progress' => 'info', 'completed' => 'success', 'failed' => 'danger'];
                        @endphp
                        <x-badge :variant="$statusMap[$roadmap->statut] ?? 'pending'">
                            {{ match($roadmap->statut) { 'pending' => 'En attente', 'in_progress' => 'En cours', 'completed' => 'Terminé', 'failed' => 'Échec', default => $roadmap->statut } }}
                        </x-badge>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-card>
@endsection
