<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ESN Manager') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="welcome-page">
    <main class="welcome-layout">
        <section class="welcome-card">
            <p class="welcome-eyebrow">ESN Manager</p>
            <h1 class="welcome-title">Pilote tes projets et tickets dans une interface claire.</h1>
            <p class="welcome-text">Connexion, gestion des projets, tickets et profils utilisateurs sont centralises dans une seule application Laravel.</p>

            <div class="welcome-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="button button--primary">Acceder au dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="button button--primary">Se connecter</a>
                    <a href="{{ route('register') }}" class="button button--secondary">Creer un compte</a>
                @endauth
            </div>
        </section>

        <aside class="welcome-side">
            <div class="feature-list">
                <article class="feature-item">
                    <h2 class="feature-item__title">Gestion centralisee</h2>
                    <p class="muted-text">Retrouve les projets, les tickets et les droits d'acces depuis la meme interface.</p>
                </article>
                <article class="feature-item">
                    <h2 class="feature-item__title">Roles metier</h2>
                    <p class="muted-text">Admins, consultants et clients peuvent voir uniquement ce qui leur correspond.</p>
                </article>
                <article class="feature-item">
                    <h2 class="feature-item__title">Base propre</h2>
                    <p class="muted-text">Toute la presentation repose maintenant sur un seul fichier CSS commun au projet.</p>
                </article>
            </div>
        </aside>
    </main>
</body>
</html>
