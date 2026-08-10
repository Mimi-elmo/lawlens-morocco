@extends('layouts.admin')

@section('page-title', 'Règles juridiques')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-secondary-900">Règles juridiques</h1>
            <p class="text-secondary-500 mt-1">Gérez les règles applicables aux entreprises au Maroc.</p>
        </div>
        <x-button variant="primary" href="{{ route('admin.rules.create') }}">
            Nouvelle règle
        </x-button>
    </div>

    <x-card :padding="false">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs font-semibold text-secondary-400 uppercase tracking-wider border-b border-border">
                    <th class="px-6 py-3">Titre</th>
                    <th class="px-6 py-3">Catégorie</th>
                    <th class="px-6 py-3">Source</th>
                    <th class="px-6 py-3">Vigueur</th>
                    <th class="px-6 py-3">Statut</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rules as $rule)
                    <tr class="border-b border-border last:border-0 hover:bg-secondary-50/50">
                        <td class="px-6 py-4 font-medium text-secondary-900">{{ $rule->titre }}</td>
                        <td class="px-6 py-4 text-secondary-600">{{ $rule->categorie }}</td>
                        <td class="px-6 py-4 text-secondary-500">{{ $rule->source ?: '—' }}</td>
                        <td class="px-6 py-4 text-secondary-500">{{ $rule->date_entree_vigueur?->format('d/m/Y') ?: '—' }}</td>
                        <td class="px-6 py-4">
                            <x-badge :variant="$rule->statut === 'active' ? 'success' : 'pending'">
                                {{ $rule->statut }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <x-button variant="outline" size="sm" href="{{ route('admin.rules.edit', $rule) }}">
                                    Modifier
                                </x-button>
                                <form method="POST" action="{{ route('admin.rules.destroy', $rule) }}" onsubmit="return confirm('Supprimer cette règle juridique ?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">Supprimer</x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-secondary-500">
                            Aucune règle juridique pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-card>
@endsection