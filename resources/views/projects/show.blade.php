@extends('layouts.app')

@section('title', 'Detail projet')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">{{ $project->name }}</h1>
            <p class="section-text">Client : {{ $project->client->name ?? 'Non renseigné' }}</p>
        </div>
        <div style="display:flex; gap:.5rem;">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('projects.edit', $project->id) }}" class="button button--secondary">Modifier</a>
                <form method="POST" action="{{ route('projects.destroy', $project->id) }}" id="delete-form">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete()" class="button button--danger">Supprimer</button>
                </form>
            @endif
            <a href="{{ route('projects.index') }}" class="button button--secondary">Retour</a>
        </div>
    </div>

    @if(session('success'))
        <p class="status-message">{{ session('success') }}</p>
    @endif

    <section class="stats-grid">
        <article class="stat-box">
            <p class="stat-box__label">Statut</p>
            <p class="stat-box__value">{{ $project->status }}</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Tickets</p>
            <p class="stat-box__value">{{ $project->tickets->count() }}</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Heures contrat</p>
            <p class="stat-box__value">{{ $contractHours }} h</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Consommé (inclus)</p>
            <p class="stat-box__value">{{ number_format($includedHours, 2) }} h</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Restant</p>
            <p class="stat-box__value">{{ number_format($remainingHours, 2) }} h</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Facturable</p>
            <p class="stat-box__value">{{ number_format($billableHours, 2) }} h</p>
        </article>
    </section>

    @if($project->contract)
        <section class="panel panel--padded">
            <h2 class="section-title">Contrat</h2>
            <p class="section-text">
                <strong>{{ $contractHours }} heures incluses</strong> —
                Taux H.S. : <strong>{{ number_format($project->contract->extra_hourly_rate, 2, ',', ' ') }} EUR/h</strong>
            </p>
            @if($overflowHours > 0)
                <p class="section-text" style="margin-top:.5rem; color:#c0392b;">
                    Dépassement : <strong>{{ number_format($overflowHours, 2) }} h</strong> basculées en facturable.
                </p>
            @endif
            @if($billableHours > 0)
                <p class="section-text" style="margin-top:.5rem;">
                    Montant facturable estimé : <strong>{{ number_format($billableHours * $project->contract->extra_hourly_rate, 2, ',', ' ') }} EUR</strong>
                </p>
            @endif
        </section>
    @endif

    <section class="panel panel--padded">
        <h2 class="section-title">Collaborateurs assignés</h2>
        @if($project->collaborateurs->isEmpty())
            <p class="muted-text">Aucun collaborateur assigné.</p>
        @else
            <p class="section-text">{{ $project->collaborateurs->pluck('name')->join(', ') }}</p>
        @endif

        @if(auth()->user()->isAdmin())
            <div style="margin-top:1rem; display:flex; gap:.5rem; flex-wrap:wrap; align-items:center;">
                @foreach($project->collaborateurs as $collab)
                    <form method="POST" action="{{ route('projects.unassign', $project->id) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <input type="hidden" name="user_id" value="{{ $collab->id }}">
                        <button type="submit" class="button button--danger">Retirer {{ $collab->name }}</button>
                    </form>
                @endforeach
            </div>
            @if($collaborateurs->isNotEmpty())
                <form method="POST" action="{{ route('projects.assign', $project->id) }}" style="margin-top:1rem; display:flex; gap:.5rem;">
                    @csrf
                    <select name="user_id" class="form-select">
                        @foreach($collaborateurs as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="button button--primary">Assigner</button>
                </form>
            @endif
        @endif
    </section>

    <section class="panel panel--padded">
        <h2 class="section-title">Description</h2>
        <p class="section-text">{{ $project->description ?? 'Pas de description.' }}</p>
    </section>

    <div class="panel panel--padded">
        <h3 class="section-title">Tickets du projet</h3>
        @forelse($project->tickets as $ticket)
            @php $ticketHours = $ticket->timeEntries->sum('hours'); @endphp
            <div class="list-item">
                <div>
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="table-link">{{ $ticket->title }}</a>
                    <p class="list-item__meta">{{ $ticket->type }} • {{ $ticket->status }}</p>
                </div>
                <strong class="mono-text">{{ number_format($ticketHours, 2) }} h</strong>
            </div>
        @empty
            <p class="muted-text">Aucun ticket sur ce projet.</p>
        @endforelse
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('Êtes-vous sûr ? Vous allez supprimer tous les tickets liés à ce projet.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endsection
