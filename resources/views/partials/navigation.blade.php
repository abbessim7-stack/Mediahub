<nav>
    <a href="{{ route('accueil') }}">MediaHub</a>
    <a href="{{ route('contenus.index') }}">Contenus</a>
    <a href="{{ route('categories.index') }}">Catégories</a>
    <a href="{{ route('a-propos') }}">À propos</a>

    @guest
        <!-- Links shown only to visitors (not logged in) -->
        <a href="{{ route('connexion') }}">Connexion</a>
        <a href="{{ route('inscription') }}">Inscription</a>
    @endguest

    @auth
        <!-- Links shown only to logged-in users -->
        <form method="POST" action="{{ route('deconnexion') }}" style="display: inline; margin-left: auto;">
            @csrf
            <button type="submit" style="background: none; border: none; color: red; font-weight: bold; cursor: pointer; font-size: 16px; font-family: inherit;">
                Déconnexion ({{ auth()->user()->name }})
            </button>
        </form>
    @endauth
</nav>
