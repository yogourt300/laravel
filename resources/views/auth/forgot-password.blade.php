<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Mot de passe oublie</h1>
        <p class="auth-text">Entre ton email pour recevoir un lien de reinitialisation.</p>
    </div>

    @if (session('status'))
        <div class="status-message">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="form-grid">
        @csrf

        <div class="form-row">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="form-input">
            @error('email')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('login') }}" class="button-link">Retour connexion</a>
            <button type="submit" class="button button--primary">Envoyer le lien</button>
        </div>
    </form>
</x-guest-layout>
