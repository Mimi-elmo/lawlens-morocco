@extends('layouts.admin')

@section('page-title', 'Administration')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-secondary-900">Administration</h1>
            <p class="text-secondary-500 mt-1">Vue d'ensemble de la plateforme LawLens Morocco.</p>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="size-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                    <x-icon name="users" class="size-5" />
                </div>
                <span class="text-2xl font-bold text-secondary-900">{{ $totalUsers }}</span>
            </div>
            <h3 class="text-sm font-medium text-secondary-500">Utilisateurs</h3>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="size-10 rounded-lg bg-accent-100 text-accent-600 flex items-center justify-center">
                    <x-icon name="folder" class="size-5" />
                </div>
                <span class="text-2xl font-bold text-secondary-900">{{ $totalProjects }}</span>
            </div>
            <h3 class="text-sm font-medium text-secondary-500">Projets</h3>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="size-10 rounded-lg bg-secondary-100 text-secondary-600 flex items-center justify-center">
                    <x-icon name="document" class="size-5" />
                </div>
                <span class="text-2xl font-bold text-secondary-900">{{ $totalRoadmaps }}</span>
            </div>
            <h3 class="text-sm font-medium text-secondary-500">Roadmaps</h3>
        </div>
        <div class="bg-white rounded-xl border border-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="size-10 rounded-lg bg-success/10 text-success flex items-center justify-center">
                    <x-icon name="chart" class="size-5" />
                </div>
                <span class="text-2xl font-bold text-secondary-900">{{ $globalProgression }}%</span>
            </div>
            <div class="w-full bg-secondary-100 rounded-full h-2 mt-2">
                <div class="bg-success h-2 rounded-full" style="width: {{ $globalProgression }}%"></div>
            </div>
            <h3 class="text-sm font-medium text-secondary-500 mt-2">Progression moyenne</h3>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mb-8">
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="users" class="size-5 text-primary-600" />
                    <span class="font-semibold">Utilisateurs par rôle</span>
                </div>
            </x-slot:header>
            @if ($usersByRole->isEmpty())
                <p class="text-sm text-secondary-500">Aucun utilisateur.</p>
            @else
                <div class="space-y-4">
                    @php
                        $roleColors = ['admin' => 'bg-danger', 'entrepreneur' => 'bg-primary-500', 'default' => 'bg-secondary-500'];
                        $maxCount = max($usersByRole->values()->toArray());
                    @endphp
                    @foreach ($usersByRole as $role => $count)
                        @php
                            $pct = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                            $barColor = $roleColors[$role] ?? $roleColors['default'];
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="font-medium text-secondary-700 capitalize">{{ $role }}</span>
                                <span class="text-secondary-500">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-secondary-100 rounded-full h-2.5">
                                <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-card>

        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-3">
                    <x-icon name="folder" class="size-5 text-accent-600" />
                    <span class="font-semibold">Projets par statut</span>
                </div>
            </x-slot:header>
            @if ($projectsByStatus->isEmpty())
                <p class="text-sm text-secondary-500">Aucun projet.</p>
            @else
                <div class="space-y-4">
                    @php
                        $statusColors = ['brouillon' => 'bg-pending', 'en_cours' => 'bg-info', 'termine' => 'bg-success', 'default' => 'bg-secondary-500'];
                        $maxCount = max($projectsByStatus->values()->toArray());
                    @endphp
                    @foreach ($projectsByStatus as $status => $count)
                        @php
                            $pct = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                            $barColor = $statusColors[$status] ?? $statusColors['default'];
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="font-medium text-secondary-700 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                                <span class="text-secondary-500">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-secondary-100 rounded-full h-2.5">
                                <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-card>
    </div>

    <x-card>
        <x-slot:header>
            <div class="flex items-center gap-3">
                <x-icon name="users" class="size-5 text-secondary-600" />
                <span class="font-semibold">Derniers utilisateurs inscrits</span>
            </div>
        </x-slot:header>
        @if ($recentUsers->isEmpty())
            <x-empty-state icon="users" title="Aucun utilisateur" message="Aucun utilisateur inscrit pour le moment." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border text-left">
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Nom</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Email</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Rôle</th>
                            <th class="pb-2 text-xs font-semibold text-secondary-500 uppercase tracking-wider">Inscrit le</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($recentUsers as $user)
                            <tr>
                                <td class="py-3 text-sm font-medium text-secondary-900">{{ $user->name }}</td>
                                <td class="py-3 text-sm text-secondary-500">{{ $user->email }}</td>
                                <td class="py-3">
                                    <x-badge :variant="$user->role === 'admin' ? 'danger' : 'primary'">
                                        {{ $user->role }}
                                    </x-badge>
                                </td>
                                <td class="py-3 text-sm text-secondary-500">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
@endsection
