<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre', 'MediaHub')</title>
    <!-- Link to our CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navigation Bar -->
    @include('partials.navigation')

    <main style="padding: 20px;">

        <!-- Flash Message: Success (Green) -->
        @if (session('succes'))
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #c3e6cb;">
                {{ session('succes') }}
            </div>
        @endif

        <!-- Flash Message: Error (Red) -->
        @if (session('erreur'))
            <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #f5c6cb;">
                {{ session('erreur') }}
            </div>
        @endif

        <!-- Main Content of the page -->
        @yield('contenu')

    </main>

    <!-- Footer -->
    @include('partials.pied-du-page')
</body>
</html>
