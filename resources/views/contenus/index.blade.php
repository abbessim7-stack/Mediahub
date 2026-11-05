@extends('layouts.app')

@section('titre', 'Contenus')

@section('contenu')
    <h1>Contenus multimédias</h1>

    <p><a href="{{ route('contenus.create') }}">+ Ajouter une publication</a></p>

    @forelse ($publications as $publication)
        <x-carte titre="{{ $publication->titre }}">
            <p><strong>Auteur :</strong> {{ $publication->auteur->name }}</p>
            <p><strong>Catégorie :</strong> {{ $publication->categorie->nom }}</p>
            <p><strong>Commentaires :</strong> {{ $publication->commentaires_count }}</p>
            <p>{{ Str::limit($publication->contenu, 150) }}</p>

            <!-- Action Links -->
            <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                <a href="{{ route('contenus.show', $publication) }}">Voir le détail</a> |
                <a href="{{ route('contenus.edit', $publication) }}" style="color: blue;">Modifier</a> |

                <form method="POST" action="{{ route('contenus.destroy', $publication) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: red; background: none; border: none; cursor: pointer;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">Supprimer</button>
                </form>
            </div>
        </x-carte>
    @empty
        <p>Aucun contenu disponible pour le moment.</p>
    @endforelse

    <div style="margin-top: 20px;">
        {{ $publications->links() }}
    </div>
@endsection
