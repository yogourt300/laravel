<x-guest-layout>
    <div class="auth-header">
        <h1 class="auth-title">Reinitialiser le mot de passe</h1>
        <p class="auth-text">Definis un nouveau mot de passe pour ton compte.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="form-grid">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-row">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus class="form-input">
            @error('email')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" required class="form-input">
            @error('password')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password_confirmation" class="form-label">Confirmation</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="form-input">
            @error('password_confirmation')
                <div class="error-box">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--primary">Reinitialiser</button>
        </div>
    </form>
</x-guest-layout>
