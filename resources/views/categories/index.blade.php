@extends('layouts.app')

@section('titre', 'Catégories')

@section('contenu')
    <h1>Liste des catégories</h1>
    <p><a href="{{ route('categories.create') }}">+ Ajouter une catégorie</a></p>

    <ul>
        @foreach ($categories as $categorie)
            <li style="margin-bottom: 10px;">
                {{ $categorie->nom }} ({{ $categorie->publications_count }} publications)

                <!-- Edit Link -->
                <a href="{{ route('categories.edit', $categorie) }}" style="margin-left: 10px; color: blue;">Modifier</a>

                <!-- Delete Form -->
                <form method="POST" action="{{ route('categories.destroy', $categorie) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: red; background: none; border: none; cursor: pointer;" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- Add this to show pagination -->
    <div style="margin-top: 20px;">
        {{ $categories->links() }}
    </div>
@endsection
