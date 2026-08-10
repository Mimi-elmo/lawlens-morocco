@extends('layouts.admin')

@section('page-title', 'Structures juridiques')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-secondary-900">Structures juridiques</h1>
            <p class="text-secondary-500 mt-1">Gérez les formes juridiques disponibles pour les entrepreneurs.</p>
        </div>
        <x-button variant="primary" href="{{ route('admin.structures.create') }}">
            Nouvelle structure
        </x-button>
    </div>

    <x-card :padding="false">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-secondary-400 uppercase tracking-wider border-b border-border">
                    <th class="px-6 py-3">Nom</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">Règles liées</th>
                    <th class="px-6 py-3">Statut</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($structures as $structure)
                    <tr class="border-b border-border last:border-0 hover:bg-secondary-50/50">
                        <td class="px-6 py-4 font-medium text-secondary-900">{{ $structure->nom }}</td>
                        <td class="px-6 py-4 text-secondary-500 max-w-md truncate">{{ $structure->description }}</td>
                        <td class="px-6 py-4 text-secondary-600">{{ $structure->legal_rules_count }}</td>
                        <td class="px-6 py-4">
                            <x-badge :variant="$structure->statut === 'active' ? 'success' : 'pending'">
                                {{ $structure->statut }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <x-button variant="outline" size="sm" href="{{ route('admin.structures.edit', $structure) }}">
                                    Modifier
                                </x-button>
                                <form method="POST" action="{{ route('admin.structures.destroy', $structure) }}" onsubmit="return confirm('Supprimer cette structure juridique ?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">Supprimer</x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-secondary-500">
                            Aucune structure juridique pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
@endsection