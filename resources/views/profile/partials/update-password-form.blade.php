<section>
    <h2 class="section-title">Mot de passe</h2>
    <p class="section-text">Choisis un mot de passe long et securise.</p>

    <form method="POST" action="{{ route('password.update') }}" class="form-grid">
        @csrf
        @method('PUT')

        <div class="form-row">
            <label for="current_password" class="form-label">Mot de passe actuel</label>
            <input id="current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
            @if ($errors->updatePassword->get('current_password'))
                <div class="error-box">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="form-row">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" class="form-input" autocomplete="new-password">
            @if ($errors->updatePassword->get('password'))
                <div class="error-box">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="form-row">
            <label for="password_confirmation" class="form-label">Confirmation</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
            @if ($errors->updatePassword->get('password_confirmation'))
                <div class="error-box">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--primary">Enregistrer</button>
            @if (session('status') === 'password-updated')
                <span class="inline-note">Mot de passe mis a jour.</span>
            @endif
        </div>
    </form>
</section>
