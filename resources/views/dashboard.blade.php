@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-secondary-900">Tableau de bord</h1>
            <p class="text-secondary-500 mt-1">Bienvenue, {{ auth()->user()->name }}.</p>
        </div>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="folder" class="size-5 text-primary-600" />
                    <span class="font-semibold">Projets</span>
                </div>
            </x-slot:header>
            <p class="text-secondary-500 text-sm">Vous n'avez pas encore de projet.</p>
            <x-slot:footer>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-500 font-medium">Créer un projet →</a>
            </x-slot:footer>
        </x-card>
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="document" class="size-5 text-primary-600" />
                    <span class="font-semibold">Roadmaps</span>
                </div>
            </x-slot:header>
            <p class="text-secondary-500 text-sm">Générez votre première roadmap.</p>
            <x-slot:footer>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-500 font-medium">Générer →</a>
            </x-slot:footer>
        </x-card>
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="book" class="size-5 text-primary-600" />
                    <span class="font-semibold">Ressources</span>
                </div>
            </x-slot:header>
            <p class="text-secondary-500 text-sm">Consultez les structures juridiques.</p>
            <x-slot:footer>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-500 font-medium">Explorer →</a>
            </x-slot:footer>
        </x-card>
    </div>
@endsection
