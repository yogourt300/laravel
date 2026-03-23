<section>
    <h2 class="section-title">Informations du profil</h2>
    <p class="section-text">Mets a jour ton nom et ton adresse email.</p>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" class="form-grid">
        @csrf
        @method('PATCH')

        <div class="form-row">
            <label for="name" class="form-label">Nom</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus class="form-input">
            @error('name')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="form-input">
            @error('email')
                <div class="error-box">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="inline-note">
                    Votre email n'est pas verifie.
                    <button form="send-verification" class="button-link" type="submit">Renvoyer le mail de verification</button>
                </p>
            @endif

            @if (session('status') === 'verification-link-sent')
                <div class="status-message">Un nouveau lien de verification a ete envoye.</div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--primary">Enregistrer</button>
            @if (session('status') === 'profile-updated')
                <span class="inline-note">Profil enregistre.</span>
            @endif
        </div>
    </form>
</section>
