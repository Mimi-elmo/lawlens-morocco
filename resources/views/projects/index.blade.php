@extends('layouts.entrepreneur')

@section('page-title', 'Mes projets')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-secondary-900">Mes projets</h1>
            <p class="text-secondary-500 mt-1">Gérez vos projets de création d'entreprise.</p>
        </div>
        <x-button variant="primary" href="{{ route('projects.create') }}">
            <x-icon name="plus" class="size-4" />
            Nouveau projet
        </x-button>
    </div>

    @if ($projects->isEmpty())
        <x-empty-state icon="folder" title="Aucun projet" message="Créez votre premier projet pour générer votre roadmap personnalisée.">
            <x-button variant="primary" href="{{ route('projects.create') }}">Créer un projet</x-button>
        </x-empty-state>
    @else
        <div class="bg-white rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border bg-secondary-50/50">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Nom</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Ville</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Type</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Statut</th>
                            <th class="text-center px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Roadmaps</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Créé le</th>
                            <th class="text-right px-6 py-3 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($projects as $project)
                            <tr class="hover:bg-secondary-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('projects.show', $project) }}" class="text-sm font-medium text-secondary-900 hover:text-primary-600 transition-colors">
                                        {{ $project->nom }}
                                    </a>
                                    <p class="text-xs text-secondary-500 mt-0.5">{{ $project->activite }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary-500">{{ $project->ville }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-secondary-600 capitalize">{{ $project->type_activite }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge :variant="match($project->statut) { 'brouillon' => 'pending', 'en_cours' => 'info', 'termine' => 'success', default => 'pending' }">
                                        {{ $project->statut }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-secondary-500">{{ $project->roadmaps_count }}</td>
                                <td class="px-6 py-4 text-sm text-secondary-500">{{ $project->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('projects.show', $project) }}" class="p-1.5 rounded-lg text-secondary-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Voir">
                                            <x-icon name="document" class="size-4" />
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" class="p-1.5 rounded-lg text-secondary-400 hover:text-accent-600 hover:bg-accent-50 transition-colors" title="Modifier">
                                            <x-icon name="settings" class="size-4" />
                                        </a>
                                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Supprimer ce projet ? Cette action est irréversible.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-secondary-400 hover:text-danger hover:bg-red-50 transition-colors" title="Supprimer">
                                                <x-icon name="xmark" class="size-4" />
                                            </button>
                                        </form>
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
