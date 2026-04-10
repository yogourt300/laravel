<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ESN Manager</title>
    @vite(['resources/css/app.css'])
</head>
<body class="welcome-page">
    <main class="welcome-layout">
        <section class="welcome-card">
            <p class="welcome-eyebrow">ESN Manager</p>
            <h1 class="welcome-title">Gestion de ticketing pour ESN.</h1>
            <div class="welcome-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="button button--primary">Accéder au dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="button button--primary">Se connecter</a>
                @endauth
            </div>
        </section>
    </main>
</body>
</html>
