@extends('layouts.landing')

@section('title', 'LawLens Morocco — Votre roadmap IA pour créer votre entreprise au Maroc')

@section('content')
    @include('landing.navbar')
    @include('landing.hero')
    @include('landing.features')
    @include('landing.legal-structures')
    @include('landing.roadmap-preview')
    @include('landing.faq')
    @include('landing.cta')
    @include('landing.footer')
@endsection
