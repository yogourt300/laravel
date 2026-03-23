<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ESN Manager') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <main class="flex min-h-screen items-center justify-center px-6">
        <div class="w-full max-w-md rounded-2xl bg-white p-10 text-center shadow-sm ring-1 ring-gray-100">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-600">ESN Manager</p>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Bienvenue</h1>
            <p class="mt-3 text-sm text-gray-600">Connecte-toi ou cree ton compte pour acceder a l'application.</p>

            <div class="mt-8 flex flex-col gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700">
                        Acceder au dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="rounded-xl border border-gray-300 px-5 py-3 font-semibold text-gray-700 transition hover:bg-gray-50">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </main>
</body>
</html>
