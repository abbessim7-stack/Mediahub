@extends('layouts.app')

@section('titre', 'Connexion')

@section('contenu')
    <h1>Connexion</h1>

    <form method="POST" action="{{ route('connexion') }}">
        @csrf

        <p>
            <label>Email :</label><br>
            <input type="email" name="email" value="{{ old('email') }}" style="width: 100%;">
            @error('email')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Mot de passe :</label><br>
            <input type="password" name="password" style="width: 100%;">
            @error('password')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>

        <button type="submit">Se connecter</button>
    </form>
@endsection
