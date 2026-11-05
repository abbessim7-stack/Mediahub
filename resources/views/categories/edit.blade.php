@extends('layouts.app')

@section('titre', 'Modifier la catégorie')

@section('contenu')
    <h1>Modifier la catégorie</h1>

    <form method="POST" action="{{ route('categories.update', $categorie) }}">
        @csrf
        @method('PUT')

        <p>
            <label>Nom de la catégorie :</label><br>
            <input type="text" name="nom" value="{{ old('nom', $categorie->nom) }}" required>
        </p>
        <p>
            <label>Slug :</label><br>
            <input type="text" name="slug" value="{{ old('slug', $categorie->slug) }}" required>
        </p>
        <button type="submit">Enregistrer les modifications</button>
    </form>
@endsection
