@extends('layouts.app')

@section('title', 'Modifier utilisateur')

@section('content')
<div class="panel panel--padded panel--narrow">
    <div class="split-header">
        <h1 class="page-title">Modifier l'utilisateur</h1>
        <a href="{{ route('users.index') }}" class="button button--secondary">Annuler</a>
    </div>

    <form method="POST" action="{{ route('users.update', $user->id) }}" class="form-grid">
        @csrf
        @method('PATCH')

        <div class="form-row">
            <label for="name" class="form-label">Nom</label>
            <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required>
            @error('name')<span class="error-box">{{ $message }}</span>@enderror
        </div>

        <div class="form-row">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required>
            @error('email')<span class="error-box">{{ $message }}</span>@enderror
        </div>

        <div class="form-row">
            <label for="role" class="form-label">Rôle</label>
            <select id="role" name="role" class="form-select">
                <option value="collaborateur" {{ $user->role === 'collaborateur' ? 'selected' : '' }}>Collaborateur</option>
                <option value="client"        {{ $user->role === 'client'        ? 'selected' : '' }}>Client</option>
                <option value="admin"         {{ $user->role === 'admin'         ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--primary">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
