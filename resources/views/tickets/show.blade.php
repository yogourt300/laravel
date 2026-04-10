@extends('layouts.app')

@section('title', 'Detail ticket')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">{{ $ticket->title }}</h1>
            <p class="section-text">Projet : <a href="{{ route('projects.show', $ticket->project->id) }}" class="table-link">{{ $ticket->project->name }}</a></p>
        </div>
        <div style="display:flex; gap:8px;">
            @if(!auth()->user()->isClient())
                <a href="{{ route('tickets.edit', $ticket->id) }}" class="button button--secondary">Modifier</a>
                <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" onsubmit="return confirm('Supprimer ce ticket ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="button button--danger">Supprimer</button>
                </form>
            @endif
            <a href="{{ route('tickets.index') }}" class="button button--secondary">Retour</a>
        </div>
    </div>

    @if(session('success'))
        <p class="status-message">{{ session('success') }}</p>
    @endif

    <section class="stats-grid">
        <article class="stat-box">
            <p class="stat-box__label">Statut</p>
            <p class="stat-box__value">{{ $ticket->status }}</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Type</p>
            <p class="stat-box__value">{{ $ticket->type }}</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Total heures</p>
            <p class="stat-box__value">{{ number_format($totalHours, 2) }} h</p>
        </article>
    </section>

    @if(auth()->user()->isClient() && $ticket->status === 'a_valider' && $ticket->project->client_id === auth()->id())
        <section class="panel panel--padded">
            <h2 class="section-title">Validation requise</h2>
            <p class="section-text">Ce ticket facturable est en attente de votre validation.</p>
            <div style="display:flex; gap:10px; margin-top:1rem;">
                <form method="POST" action="{{ route('tickets.valider', $ticket->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="button button--primary">Valider</button>
                </form>
                <form method="POST" action="{{ route('tickets.refuser', $ticket->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="button button--danger">Refuser</button>
                </form>
            </div>
        </section>
    @endif

    <section class="detail-card">
        <div class="detail-card__header">Description</div>
        <div class="detail-card__body">
            <p class="section-text">{{ $ticket->description ?: 'Aucune description.' }}</p>
        </div>
        <div class="detail-card__footer">
            <span>Créé le : {{ $ticket->created_at->format('d/m/Y') }}</span>
            <span>ID : #{{ $ticket->id }}</span>
        </div>
    </section>

    @if(!auth()->user()->isClient())
        <section class="panel panel--padded">
            <h2 class="section-title">Saisir des heures</h2>
            <form method="POST" action="{{ route('time-entries.store', $ticket->id) }}" class="form-grid">
                @csrf
                <div class="form-row form-row--two">
                    <div class="form-row">
                        <label for="date" class="form-label">Date</label>
                        <input id="date" name="date" type="date" class="form-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-row">
                        <label for="hours" class="form-label">Heures</label>
                        <input id="hours" name="hours" type="number" step="0.25" min="0.25" class="form-input" placeholder="Ex: 1.5" required>
                    </div>
                </div>
                <div class="form-row">
                    <label for="comment" class="form-label">Commentaire (optionnel)</label>
                    <input id="comment" name="comment" type="text" class="form-input">
                </div>
                <div class="form-actions">
                    <button type="submit" class="button button--primary">Ajouter les heures</button>
                </div>
            </form>
        </section>
    @endif

    <section class="panel panel--padded">
        <h2 class="section-title">Historique des saisies</h2>
        @if($ticket->timeEntries->isEmpty())
            <p class="muted-text">Aucune heure saisie.</p>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Collaborateur</th>
                            <th>Heures</th>
                            <th>Commentaire</th>
                            @if(!auth()->user()->isClient())<th></th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ticket->timeEntries->sortByDesc('date') as $entry)
                            <tr>
                                <td>{{ $entry->date->format('d/m/Y') }}</td>
                                <td>{{ $entry->user->name ?? '—' }}</td>
                                <td class="mono-text">{{ number_format($entry->hours, 2) }} h</td>
                                <td>{{ $entry->comment ?? '—' }}</td>
                                @if(!auth()->user()->isClient())
                                    <td>
                                        <form method="POST" action="{{ route('time-entries.destroy', $entry->id) }}" onsubmit="return confirm('Supprimer cette saisie ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="button button--danger">Supprimer</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
@endsection
