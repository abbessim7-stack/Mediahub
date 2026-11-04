<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre', 'MediaHub')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Ici, on inclura la barre de navigation -->
    @include('partials.navigation')

    <main>
        <!-- C'est ici que le contenu de chaque page viendra s'insérer -->
        @yield('contenu')
    </main>

    <!-- Ici, on inclura le pied de page -->
    @include('partials.pied-du-page')
</body>
</html>
