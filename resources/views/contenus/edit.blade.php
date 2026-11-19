@extends('layouts.app')

@section('titre', 'Modifier la publication')

@section('contenu')
    <h1>Modifier la publication</h1>

    <form method="POST" action="{{ route('contenus.update', $contenu) }}">
        @csrf
        @method('PUT')

        <p>
            <label>Titre :</label><br>
            <input type="text" name="titre" value="{{ old('titre', $contenu->titre) }}" style="width: 100%;">
            @error('titre')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>Catégorie :</label><br>
            <select name="categorie_id" style="padding: 5px;">
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ old('categorie_id', $contenu->categorie_id) == $categorie->id ? 'selected' : '' }}>
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
            <textarea name="contenu" rows="5" style="width: 100%;">{{ old('contenu', $contenu->contenu) }}</textarea>
            @error('contenu')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>
        <button type="submit">Enregistrer les modifications</button>
    </form>
@endsection
