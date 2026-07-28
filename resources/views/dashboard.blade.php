@extends('layouts.entrepreneur')

@section('page-title', 'Tableau de bord')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-secondary-900">Tableau de bord</h1>
            <p class="text-secondary-500 mt-1">Bienvenue, {{ auth()->user()->name }}.</p>
        </div>
        <x-button variant="primary" href="#">
            <x-icon name="plus" class="size-4" />
            Nouveau projet
        </x-button>
    </div>

    <div class="grid sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="size-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                    <x-icon name="folder" class="size-5" />
                </div>
                <span class="text-2xl font-bold text-secondary-900">{{ $projectsCount }}</span>
            </div>
            <h3 class="text-sm font-medium text-secondary-500">Projets</h3>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="size-10 rounded-lg bg-accent-100 text-accent-600 flex items-center justify-center">
                    <x-icon name="document" class="size-5" />
                </div>
                <span class="text-2xl font-bold text-secondary-900">{{ $roadmapsCount }}</span>
            </div>
            <h3 class="text-sm font-medium text-secondary-500">Roadmaps</h3>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="size-10 rounded-lg bg-secondary-100 text-secondary-600 flex items-center justify-center">
                    <x-icon name="chart" class="size-5" />
                </div>
                <span class="text-2xl font-bold text-secondary-900">{{ $globalProgression }}%</span>
            </div>
            <div class="w-full bg-secondary-100 rounded-full h-2 mt-2">
                <div class="bg-primary-500 h-2 rounded-full transition-all" style="width: {{ $globalProgression }}%"></div>
            </div>
            <h3 class="text-sm font-medium text-secondary-500 mt-2">Progression globale</h3>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mb-8">
        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <x-icon name="folder" class="size-5 text-primary-600" />
                        <span class="font-semibold">Projets récents</span>
                    </div>
                </div>
            </x-slot:header>
            @if ($recentProjects->isEmpty())
                <x-empty-state icon="folder" title="Aucun projet" message="Créez votre premier projet pour commencer.">
                    <x-button variant="primary" href="#">Créer un projet</x-button>
                </x-empty-state>
            @else
                <div class="divide-y divide-border">
                    @foreach ($recentProjects as $project)
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-medium text-secondary-900">{{ $project->nom }}</p>
                                <p class="text-xs text-secondary-500">{{ $project->created_at->format('d/m/Y') }}</p>
                            </div>
                            <x-badge :variant="match($project->statut) { 'draft' => 'pending', 'in_progress' => 'info', 'completed' => 'success', default => 'pending' }">
                                {{ $project->statut }}
                            </x-badge>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-card>

        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <x-icon name="document" class="size-5 text-accent-600" />
                        <span class="font-semibold">Roadmaps récentes</span>
                    </div>
                </div>
            </x-slot:header>
            @if ($recentRoadmaps->isEmpty())
                <x-empty-state icon="document" title="Aucune roadmap" message="Générez votre première roadmap depuis un projet.">
                    <x-button variant="primary" href="#">Créer un projet</x-button>
                </x-empty-state>
            @else
                <div class="divide-y divide-border">
                    @foreach ($recentRoadmaps as $roadmap)
                        <div class="py-3">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-secondary-900">{{ $roadmap->project->nom }}</p>
                                <x-badge :variant="match($roadmap->statut) { 'pending' => 'pending', 'in_progress' => 'info', 'completed' => 'success', default => 'pending' }">
                                    {{ $roadmap->statut }}
                                </x-badge>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex-1 bg-secondary-100 rounded-full h-1.5">
                                    <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ $roadmap->progression ?? 0 }}%"></div>
                                </div>
                                <span class="text-xs text-secondary-500">{{ $roadmap->progression ?? 0 }}%</span>
                            </div>
                            <p class="text-xs text-secondary-400 mt-1">{{ $roadmap->date_generation ? \Carbon\Carbon::parse($roadmap->date_generation)->format('d/m/Y') : '' }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-card>
    </div>

    <div class="grid sm:grid-cols-3 gap-6">
        <a href="#" class="group bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="size-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <x-icon name="plus" class="size-5" />
            </div>
            <h3 class="font-semibold text-secondary-900 mb-1">Nouveau projet</h3>
            <p class="text-sm text-secondary-500">Créez un projet pour générer votre roadmap.</p>
        </a>
        <a href="#" class="group bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="size-10 rounded-lg bg-accent-100 text-accent-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <x-icon name="scale" class="size-5" />
            </div>
            <h3 class="font-semibold text-secondary-900 mb-1">Structures juridiques</h3>
            <p class="text-sm text-secondary-500">Explorez les formes juridiques marocaines.</p>
        </a>
        <a href="#" class="group bg-white rounded-xl border border-border p-6 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
            <div class="size-10 rounded-lg bg-secondary-100 text-secondary-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <x-icon name="shield" class="size-5" />
            </div>
            <h3 class="font-semibold text-secondary-900 mb-1">Règles juridiques</h3>
            <p class="text-sm text-secondary-500">Consultez la base de données légale.</p>
        </a>
    </div>
@endsection
