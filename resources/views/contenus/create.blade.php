@extends('layouts.app')

@section('titre', 'Nouvelle publication')

@section('contenu')
    <h1>Créer une publication</h1>

    <form method="POST" action="{{ route('contenus.store') }}">
        @csrf
        <p>
            <label>Titre :</label><br>
            <input type="text" name="titre" value="{{ old('titre') }}" style="width: 100%;">
            @error('titre')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>Catégorie :</label><br>
            <select name="categorie_id" style="padding: 5px;">
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
            @error('categorie_id')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>Contenu :</label><br>
            <textarea name="contenu" rows="5" style="width: 100%;">{{ old('contenu') }}</textarea>
            @error('contenu')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>
        <button type="submit">Publier</button>
    </form>
@endsection
