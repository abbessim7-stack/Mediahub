@extends('layouts.app')

@section('titre', 'Inscription')

@section('contenu')
    <h1>Inscription</h1>

    <form method="POST" action="{{ route('inscription') }}">
        @csrf

        <p>
            <label>Nom :</label><br>
            <input type="text" name="name" value="{{ old('name') }}" style="width: 100%;">
            @error('name')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Email :</label><br>
            <input type="email" name="email" value="{{ old('email') }}" style="width: 100%;">
            @error('email')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Mot de passe (min. 8 caractères) :</label><br>
            <input type="password" name="password" style="width: 100%;">
            @error('password')
                <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
            @enderror
        </p>

        <p>
            <label>Confirmer le mot de passe :</label><br>
            <input type="password" name="password_confirmation" style="width: 100%;">
        </p>

        <button type="submit">S'inscrire</button>
    </form>
@endsection
