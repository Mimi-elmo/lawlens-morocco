@extends('layouts.admin')

@section('page-title', 'Modifier : ' . $structure->nom)

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.structures.index') }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">&larr; Retour aux structures</a>
    </div>

    <x-card>
        <x-slot:header>
            <div class="flex items-center gap-3">
                <x-icon name="scale" class="size-5 text-primary-600" />
                <span class="font-semibold">Modifier la structure</span>
            </div>
        </x-slot:header>

        <form method="POST" action="{{ route('admin.structures.update', $structure) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <x-input name="nom" label="Nom" placeholder="Ex : SARL" :value="old('nom', $structure->nom)" required />

            <x-textarea name="description" label="Description" placeholder="Décrivez la structure..." :value="old('description', $structure->description)" rows="3" />

            <x-textarea name="capital_information" label="Capital" placeholder="Informations sur le capital..." :value="old('capital_information', $structure->capital_information)" rows="2" />

            <x-textarea name="tax_information" label="Informations fiscales" placeholder="Régime fiscal applicable..." :value="old('tax_information', $structure->tax_information)" rows="2" />

            <x-select name="statut" label="Statut" :value="old('statut', $structure->statut)" :options="['active' => 'Active', 'inactive' => 'Inactive']" />

            <div class="flex items-center gap-3 pt-2">
                <x-button type="submit" variant="primary">Enregistrer</x-button>
                <x-button variant="ghost" href="{{ route('admin.structures.index') }}">Annuler</x-button>
            </div>
        </form>
    </x-card>
@endsection