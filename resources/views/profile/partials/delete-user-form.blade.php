<section>
    <h2 class="section-title">Supprimer le compte</h2>
    <p class="section-text">Cette action est definitive. Entre ton mot de passe pour confirmer la suppression.</p>

    <form method="POST" action="{{ route('profile.destroy') }}" class="form-grid">
        @csrf
        @method('DELETE')

        <div class="form-row">
            <label for="delete_password" class="form-label">Mot de passe</label>
            <input id="delete_password" name="password" type="password" class="form-input">
            @if ($errors->userDeletion->get('password'))
                <div class="error-box">{{ $errors->userDeletion->first('password') }}</div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--danger">Supprimer le compte</button>
        </div>
    </form>
</section>
