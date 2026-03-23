<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Inscription</h1>
        <p class="auth-text">Cree un compte pour acceder a l'application.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="form-grid">
        @csrf

        <div class="form-row">
            <label for="name" class="form-label">Nom</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-input">
            @error('name')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" class="form-input">
            @error('email')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" name="password" type="password" required autocomplete="new-password" class="form-input">
            @error('password')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="form-input">
            @error('password_confirmation')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('login') }}" class="button-link">J'ai deja un compte</a>
            <button type="submit" class="button button--primary">S'inscrire</button>
        </div>
    </form>
</x-guest-layout>
