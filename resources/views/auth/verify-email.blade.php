<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Verification email</h1>
        <p class="auth-text">Merci de verifier ton adresse email via le lien envoye dans ta boite de reception.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="status-message">Un nouveau lien de verification a ete envoye.</div>
    @endif

    <div class="form-actions">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="button button--primary">Renvoyer le lien</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="button button--secondary">Se deconnecter</button>
        </form>
    </div>
</x-guest-layout>
