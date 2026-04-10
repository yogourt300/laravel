@extends('layouts.app')

@section('title', 'Utilisateurs')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">Gestion des utilisateurs</h1>
            <p class="section-text">Créez et gérez les comptes utilisateurs.</p>
        </div>
        <a href="{{ route('users.create') }}" class="button button--primary">Nouvel utilisateur</a>
    </div>

    @if(session('success'))
        <p class="status-message">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="error-box">{{ session('error') }}</p>
    @endif

    <div class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roleClass = match($user->role) {
                                        'admin'         => 'badge--red',
                                        'collaborateur' => 'badge--blue',
                                        'client'        => 'badge--green',
                                        default         => 'badge--gray',
                                    };
                                @endphp
                                <span class="badge {{ $roleClass }}">{{ $user->role }}</span>
                            </td>
                            <td style="display:flex; gap:.5rem;">
                                <a href="{{ route('users.edit', $user->id) }}" class="button button--secondary">Modifier</a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="button button--danger">Supprimer</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="center-text">Aucun utilisateur.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
