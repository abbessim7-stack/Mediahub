@extends('layouts.app')

@section('titre', 'Contenus')

@section('contenu')
    <h1>Contenus multimédias</h1>

    @forelse ($publications as $publication)
        <x-carte titre="{{ $publication->titre }}">
            <p><strong>Auteur :</strong> {{ $publication->auteur->name }}</p>
            <p><strong>Catégorie :</strong> {{ $publication->categorie->nom }}</p>
            <p>{{ Str::limit($publication->contenu, 150) }}</p>
            <p><strong>Commentaires :</strong> {{ $publication->commentaires_count }}</p>
        </x-carte>
    @empty
        <p>Aucun contenu disponible pour le moment.</p>
    @endforelse

    <!-- Affichage des liens de pagination -->
    <div style="margin-top: 20px;">
        {{ $publications->links() }}
    </div>
@endsection
