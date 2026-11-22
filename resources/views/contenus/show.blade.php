@extends('layouts.app')

@section('titre', $publication->titre)

@section('contenu')
    <h1>{{ $publication->titre }}</h1>
    <p><strong>Auteur :</strong> {{ $publication->auteur->name }}</p>
    <p><strong>Catégorie :</strong> {{ $publication->categorie->nom }}</p>

    <p><strong>Tags :</strong>
        @forelse ($publication->tags as $tag)
            <span style="background: #eee; padding: 3px 8px; border-radius: 4px; font-size: 0.9em; margin-right: 5px;">
                {{ $tag->nom }}
            </span>
        @empty
            <em>Aucun tag</em>
        @endforelse
    </p>

    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-left: 4px solid #333;">
        {!! nl2br(e($publication->contenu)) !!}
    </div>

    <h3 style="margin-top: 40px;">Commentaires ({{ $publication->commentaires->count() }})</h3>

    @forelse ($publication->commentaires as $commentaire)
        <div class="carte" style="margin-bottom: 10px;">
            <p><strong>{{ $commentaire->auteur->name }}</strong> a dit :</p>
            <p>{{ $commentaire->contenu }}</p>
        </div>
    @empty
        <p>Aucun commentaire pour le moment.</p>
    @endforelse
        <!-- Display full image if it exists -->
    @if ($publication->image)
        <div style="margin-bottom: 20px;">
            <img src="{{ Storage::url($publication->image) }}" alt="{{ $publication->titre }}" style="max-width: 100%; height: auto; border-radius: 8px;">
        </div>
    @endif

    <!-- Display media player if a file exists -->
    @if ($publication->fichier_media)
        <div style="margin-bottom: 20px;">
            @if ($publication->type_media === 'audio')
                <audio controls style="width: 100%;">
                    <source src="{{ Storage::url($publication->fichier_media) }}">
                    Votre navigateur ne supporte pas l'audio.
                </audio>
            @elseif ($publication->type_media === 'video')
                <video controls style="max-width: 100%; height: auto; border-radius: 8px;">
                    <source src="{{ Storage::url($publication->fichier_media) }}">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            @endif
        </div>
    @endif

    <!-- The text content -->
    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-left: 4px solid #333;">
        {!! nl2br(e($publication->contenu)) !!}
    </div>

    <!-- Action Links -->
    <div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee;">

        @can('update', $publication)
            <a href="{{ route('contenus.edit', $publication) }}" style="color: blue; margin-right: 15px; font-weight: bold;">Modifier cette publication</a>
        @endcan

        <a href="{{ route('contenus.index') }}">&larr; Retour à la liste</a>
    </div>
@endsection
