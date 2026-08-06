@extends('layouts.guest')

@section('title', 'Inscription')

@section('content')
    <x-card>
        <x-slot:header>
            <h1 class="text-xl font-bold text-secondary-900">Inscription</h1>
            <p class="text-sm text-secondary-500 mt-1">Créez votre compte en quelques secondes.</p>
        </x-slot:header>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <x-input name="name" label="Nom complet" placeholder="Votre nom" :value="old('name')" required autofocus autocomplete="name" />

            <x-input name="email" type="email" label="Adresse email" placeholder="votre@email.com" :value="old('email')" required autocomplete="email" />

            <x-input name="password" type="password" label="Mot de passe" placeholder="8 caractères minimum" required autocomplete="new-password" />

            <x-input name="password_confirmation" type="password" label="Confirmer le mot de passe" placeholder="Répétez le mot de passe" required autocomplete="new-password" />

            <label class="flex items-start gap-2 text-sm text-secondary-600 cursor-pointer">
                <input type="checkbox" name="cgu" value="1" class="mt-0.5 rounded border-border text-primary-600 focus:ring-primary-500">
                <span>J'accepte les <a href="#" class="text-primary-600 hover:text-primary-500 underline">conditions générales d'utilisation</a> et la <a href="#" class="text-primary-600 hover:text-primary-500 underline">politique de confidentialité</a>.</span>
            </label>

            <x-button type="submit" variant="primary" class="w-full">
                Créer mon compte
            </x-button>
        </form>

        <x-slot:footer>
            <p class="text-center text-sm text-secondary-500">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-500 font-medium">Se connecter</a>
            </p>
        </x-slot:footer>
    </x-card>
@endsection
