<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Confirmation du mot de passe</h1>
        <p class="auth-text">Merci de confirmer ton mot de passe avant de continuer.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="form-grid">
        @csrf

        <div class="form-row">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="form-input">
            @error('password')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--primary">Confirmer</button>
        </div>
    </form>
</x-guest-layout>
