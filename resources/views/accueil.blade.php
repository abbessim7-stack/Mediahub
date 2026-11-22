@extends('layouts.app')

@section('titre', 'Accueil')

@section('contenu')
    <h1>Bienvenue sur MediaHub</h1>
    <p>La plateforme de gestion et de diffusion de contenus multimédias.</p>
        <h2>Dernières publications</h2>
    <ul>
        @foreach ($publications as $pub)
            <li>{{ $pub->titre }} (Catégorie : {{ $pub->categorie->nom }})</li>
        @endforeach
    </ul>
@endsection
