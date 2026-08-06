@extends('layouts.entrepreneur')

@section('page-title', 'Mes roadmaps')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-secondary-900">Mes roadmaps</h1>
            <p class="text-secondary-500 mt-1">Suivez l'avancement de vos roadmaps de création d'entreprise.</p>
        </div>
    </div>

    @if ($roadmaps->isEmpty())
        <x-empty-state icon="document" title="Aucune roadmap" message="Créez un projet et générez votre première roadmap pour commencer.">
            <x-button variant="primary" href="{{ route('projects.index') }}">Voir mes projets</x-button>
        </x-empty-state>
    @else
        <div class="bg-white rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border bg-secondary-50/50">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Projet</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Structure recommandée</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Statut</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Progression</th>
                            <th class="text-center px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Étapes</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Générée le</th>
                            <th class="text-right px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($roadmaps as $roadmap)
                            <tr class="hover:bg-secondary-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('roadmaps.show', $roadmap) }}" class="text-sm font-medium text-secondary-900 hover:text-primary-600 transition-colors">
                                        {{ $roadmap->project->nom }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary-500">
                                    {{ $roadmap->formeJuridiqueRecommendee?->nom ?? '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusMap = ['pending' => 'pending', 'in_progress' => 'info', 'completed' => 'success'];
                                    @endphp
                                    <x-badge :variant="$statusMap[$roadmap->statut] ?? 'pending'">
                                        {{ match($roadmap->statut) { 'pending' => 'En attente', 'in_progress' => 'En cours', 'completed' => 'Terminé', default => $roadmap->statut } }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 max-w-[120px] bg-secondary-100 rounded-full h-2">
                                            <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $roadmap->progression }}%"></div>
                                        </div>
                                        <span class="text-xs text-secondary-500">{{ $roadmap->progression }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-secondary-500">{{ $roadmap->steps_count }}</td>
                                <td class="px-6 py-4 text-sm text-secondary-500">{{ $roadmap->date_generation ? \Carbon\Carbon::parse($roadmap->date_generation)->format('d/m/Y') : '—' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('roadmaps.show', $roadmap) }}" class="p-1.5 rounded-lg text-secondary-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Voir">
                                            <x-icon name="document" class="size-4" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
