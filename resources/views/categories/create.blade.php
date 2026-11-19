@extends('layouts.app')

@section('titre', 'Nouvelle catégorie')

@section('contenu')
    <h1>Créer une catégorie</h1>

        <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <p>
            <label>Nom de la catégorie :</label><br>
            <!-- Keep the old value using old() -->
            <input type="text" name="nom" value="{{ old('nom') }}" style="width: 100%;">

            <!-- Show error for 'nom' -->
            @error('nom')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>Slug (ex: video) :</label><br>
            <input type="text" name="slug" value="{{ old('slug') }}" style="width: 100%;">

            <!-- Show error for 'slug' -->
            @error('slug')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>
        <button type="submit">Créer</button>
    </form>
@endsection
