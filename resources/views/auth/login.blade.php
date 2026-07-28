@extends('layouts.guest')

@section('title', 'Connexion')

@section('content')
    <x-card>
        <x-slot:header>
            <h1 class="text-xl font-bold text-secondary-900">Connexion</h1>
            <p class="text-sm text-secondary-500 mt-1">Connectez-vous pour accéder à votre espace.</p>
        </x-slot:header>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <x-input name="email" type="email" label="Adresse email" placeholder="votre@email.com" :value="old('email')" required autofocus autocomplete="email" />

            <x-input name="password" type="password" label="Mot de passe" placeholder="Votre mot de passe" required autocomplete="current-password" />

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-secondary-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-border text-primary-600 focus:ring-primary-500">
                    Se souvenir de moi
                </label>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-500">Mot de passe oublié ?</a>
            </div>

            <x-button type="submit" variant="primary" class="w-full">
                Se connecter
            </x-button>
        </form>

        <x-slot:footer>
            <p class="text-center text-sm text-secondary-500">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-500 font-medium">S'inscrire</a>
            </p>
        </x-slot:footer>
    </x-card>
@endsection
