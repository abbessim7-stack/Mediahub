@extends('layouts.app')

@section('titre', 'Nouvelle catégorie')

@section('contenu')
    <h1>Créer une catégorie</h1>

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <p>
            <label>Nom de la catégorie :</label><br>
            <input type="text" name="nom" value="{{ old('nom') }}" required>
        </p>
        <p>
            <label>Slug (ex: video) :</label><br>
            <input type="text" name="slug" value="{{ old('slug') }}" required>
        </p>
        <button type="submit">Créer</button>
    </form>
@endsection
