@extends('layouts.app')

@section('titre', 'Modifier la publication')

@section('contenu')
    <h1>Modifier la publication</h1>

    <!-- Notice the enctype attribute! -->
    <form method="POST" action="{{ route('contenus.update', $contenu) }}" enctype="multipart/form-data">
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

        <!-- New file upload fields -->
        <p>
            <label>Remplacer l'image (max 2MB) :</label><br>
            <input type="file" name="image" accept="image/*">
            @error('image')
                <span style="color: red; font-size: 0.9em; display: block;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Remplacer le fichier audio/vidéo (max 100MB) :</label><br>
            <input type="file" name="fichier_media" accept="audio/*,video/*">
            @error('fichier_media')
                <span style="color: red; font-size: 0.9em; display: block;">{{ $message }}</span>
            @enderror
        </p>

        <button type="submit" style="margin-top: 10px; padding: 10px 20px;">Enregistrer les modifications</button>
    </form>
@endsection
