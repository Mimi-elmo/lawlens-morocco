@extends('layouts.entrepreneur')

@section('page-title', $roadmap->project->nom . ' — Roadmap')

@section('content')
    <div class="mb-8">
        <a href="{{ route('roadmaps.index') }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">&larr; Retour aux roadmaps</a>
    </div>

    <div class="flex items-start justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-2xl font-bold text-secondary-900">{{ $roadmap->project->nom }}</h1>
                @php
                    $statusMap = ['pending' => 'pending', 'in_progress' => 'info', 'completed' => 'success'];
                @endphp
                <x-badge :variant="$statusMap[$roadmap->statut] ?? 'pending'">
                    {{ match($roadmap->statut) { 'pending' => 'En attente', 'in_progress' => 'En cours', 'completed' => 'Terminé', default => $roadmap->statut } }}
                </x-badge>
            </div>
            <p class="text-secondary-500">Roadmap générée le {{ $roadmap->date_generation ? \Carbon\Carbon::parse($roadmap->date_generation)->format('d/m/Y') : '—' }}</p>
        </div>
    </div>

    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-secondary-700">Progression globale</span>
            <span class="text-sm font-bold text-primary-600">{{ $roadmap->progression }}%</span>
        </div>
        <div class="w-full bg-secondary-100 rounded-full h-3">
            <div class="bg-primary-500 h-3 rounded-full transition-all" style="width: {{ $roadmap->progression }}%"></div>
        </div>
    </div>

    <div class="grid sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <p class="text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-1">Structure recommandée</p>
            <p class="text-lg font-bold text-secondary-900">{{ $roadmap->formeJuridiqueRecommendee?->nom ?? 'Non définie' }}</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <p class="text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-1">Étapes</p>
            <p class="text-lg font-bold text-secondary-900">{{ $roadmap->steps->count() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <p class="text-xs font-semibold text-secondary-400 uppercase tracking-wider mb-1">Documents</p>
            <p class="text-lg font-bold text-secondary-900">{{ $roadmap->documents->count() }}</p>
        </div>
    </div>

    @if ($roadmap->resume)
        <x-card class="mb-8">
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="document" class="size-5 text-primary-600" />
                    <span class="font-semibold">Résumé</span>
                </div>
            </x-slot:header>
            <p class="text-sm text-secondary-600 leading-relaxed">{{ $roadmap->resume }}</p>
        </x-card>
    @endif

    <x-card class="mb-8">
        <x-slot:header>
            <div class="flex items-center gap-3">
                <x-icon name="map" class="size-5 text-primary-600" />
                <span class="font-semibold">Étapes</span>
            </div>
        </x-slot:header>
        @if ($roadmap->steps->isEmpty())
            <x-empty-state icon="map" title="Aucune étape" message="Les étapes seront générées par l'IA." />
        @else
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-px bg-secondary-200"></div>
                <div class="space-y-6">
                    @foreach ($roadmap->steps as $step)
                        <div class="relative pl-12">
                            <div class="absolute left-2.5 top-1.5 size-3 rounded-full border-2 {{ $step->statut === 'completed' ? 'bg-success border-success' : ($step->statut === 'in_progress' ? 'bg-info border-info' : 'bg-white border-secondary-300') }}"></div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="text-sm font-semibold text-secondary-900">Étape {{ $step->ordre }} : {{ $step->titre }}</h3>
                                    <x-badge :variant="match($step->statut) { 'pending' => 'pending', 'in_progress' => 'info', 'completed' => 'success', default => 'pending' }" size="sm">
                                        {{ match($step->statut) { 'pending' => 'À faire', 'in_progress' => 'En cours', 'completed' => 'Fait', default => $step->statut } }}
                                    </x-badge>
                                </div>
                                @if ($step->description)
                                    <p class="text-sm text-secondary-500">{{ $step->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </x-card>

    @if ($roadmap->documents->isNotEmpty())
        <x-card class="mb-8">
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="folder" class="size-5 text-accent-600" />
                    <span class="font-semibold">Documents nécessaires</span>
                </div>
            </x-slot:header>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border text-left">
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Document</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Description</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Obligatoire</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($roadmap->documents as $doc)
                            <tr>
                                <td class="py-3 text-sm font-medium text-secondary-900">{{ $doc->nom }}</td>
                                <td class="py-3 text-sm text-secondary-500">{{ $doc->description ?? '—' }}</td>
                                <td class="py-3">
                                    @if ($doc->obligatoire)
                                        <x-icon name="check" class="size-4 text-success" />
                                    @else
                                        <span class="text-sm text-secondary-400">—</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <x-badge :variant="match($doc->statut) { 'pending' => 'pending', 'completed' => 'success', default => 'pending' }" size="sm">
                                        {{ match($doc->statut) { 'pending' => 'En attente', 'completed' => 'Fourni', default => $doc->statut } }}
                                    </x-badge>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    @endif

    @if ($roadmap->taxObligations->isNotEmpty())
        <x-card class="mb-8">
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="currency" class="size-5 text-warning" />
                    <span class="font-semibold">Obligations fiscales</span>
                </div>
            </x-slot:header>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border text-left">
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Obligation</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Description</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Fréquence</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Obligatoire</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($roadmap->taxObligations as $tax)
                            <tr>
                                <td class="py-3 text-sm font-medium text-secondary-900">{{ $tax->nom }}</td>
                                <td class="py-3 text-sm text-secondary-500">{{ $tax->description ?? '—' }}</td>
                                <td class="py-3 text-sm text-secondary-600 capitalize">{{ $tax->frequence ?? '—' }}</td>
                                <td class="py-3">
                                    @if ($tax->obligatoire)
                                        <x-icon name="check" class="size-4 text-success" />
                                    @else
                                        <span class="text-sm text-secondary-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    @endif
@endsection
