@extends('layouts.app')

@section('titre', 'Nouvelle publication')

@section('contenu')
    <h1>Créer une publication</h1>

    <!-- Notice the enctype attribute! -->
    <form method="POST" action="{{ route('contenus.store') }}" enctype="multipart/form-data">
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

        <!-- New file upload fields -->
        <p>
            <label>Image de couverture (max 2MB) :</label><br>
            <input type="file" name="image" accept="image/*">
            @error('image')
                <span style="color: red; font-size: 0.9em; display: block;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Fichier audio ou vidéo (max 100MB) :</label><br>
            <input type="file" name="fichier_media" accept="audio/*,video/*">
            @error('fichier_media')
                <span style="color: red; font-size: 0.9em; display: block;">{{ $message }}</span>
            @enderror
        </p>

        <button type="submit" style="margin-top: 10px; padding: 10px 20px;">Publier</button>
    </form>
@endsection
