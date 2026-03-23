<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Connexion</h1>
        <p class="auth-text">Connecte-toi pour acceder a ton espace de travail.</p>
    </div>

    @if (session('status'))
        <div class="status-message">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="form-grid">
        @csrf

        <div class="form-row">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input">
            @error('email')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="form-input">
            @error('password')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <label class="checkbox-row" for="remember_me">
            <input id="remember_me" name="remember" type="checkbox">
            <span>Se souvenir de moi</span>
        </label>

        <div class="form-actions">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="button-link">Mot de passe oublie ?</a>
            @endif

            <button type="submit" class="button button--primary">Se connecter</button>
        </div>
    </form>
</x-guest-layout>
