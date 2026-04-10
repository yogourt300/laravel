@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="stack-lg">
    <section class="metric-grid">
        <article class="metric-card">
            <p class="metric-card__label">Projets</p>
            <p class="metric-card__value">{{ $totalProjects }}</p>
        </article>
        <article class="metric-card">
            <p class="metric-card__label">Tickets</p>
            <p class="metric-card__value">{{ $totalTickets }}</p>
        </article>
        @if(!auth()->user()->isClient())
            <article class="metric-card">
                <p class="metric-card__label">Heures incluses</p>
                <p class="metric-card__value metric-card__value--blue">{{ number_format($hoursInclus, 2) }} h</p>
            </article>
            <article class="metric-card">
                <p class="metric-card__label">Heures facturables</p>
                <p class="metric-card__value metric-card__value--orange">{{ number_format($hoursBillable, 2) }} h</p>
            </article>
        @endif
    </section>

    @if($pendingTickets->isNotEmpty())
        <section class="panel panel--padded">
            <h2 class="section-title">Tickets à valider</h2>
            <p class="section-text">Ces tickets facturables attendent votre validation.</p>
            <div class="list">
                @foreach($pendingTickets as $ticket)
                    <div class="list-item">
                        <div>
                            <p class="list-item__title">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="table-link">{{ $ticket->title }}</a>
                            </p>
                            <p class="list-item__meta">{{ $ticket->project->name }}</p>
                        </div>
                        <div style="display:flex;gap:.5rem;">
                            <form method="POST" action="{{ route('tickets.valider', $ticket->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="button button--primary">Valider</button>
                            </form>
                            <form method="POST" action="{{ route('tickets.refuser', $ticket->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="button button--danger">Refuser</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="content-grid">
        @if($recentEntries->isNotEmpty())
            <article class="panel panel--padded">
                <div class="split-header">
                    <h2 class="section-title">Activité récente</h2>
                    <a href="{{ route('tickets.index') }}" class="button button--ghost">Voir les tickets</a>
                </div>
                <div class="list">
                    @foreach($recentEntries as $entry)
                        <div class="list-item">
                            <div>
                                <p class="list-item__title">
                                    <a href="{{ route('tickets.show', $entry->ticket->id) }}" class="table-link">{{ $entry->ticket->title }}</a>
                                </p>
                                <p class="list-item__meta">{{ $entry->ticket->project->name }} • {{ $entry->user->name ?? '—' }} • {{ $entry->date->format('d/m/Y') }}</p>
                            </div>
                            <strong class="mono-text">{{ number_format($entry->hours, 2) }} h</strong>
                        </div>
                    @endforeach
                </div>
            </article>
        @endif

        <aside class="panel panel--padded">
            <h2 class="section-title">Actions rapides</h2>
            <div class="stack-md">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('projects.create') }}" class="button button--primary">Nouveau projet</a>
                    <a href="{{ route('users.create') }}" class="button button--secondary">Nouvel utilisateur</a>
                @endif
                @if(!auth()->user()->isClient())
                    <a href="{{ route('tickets.create') }}" class="button button--secondary">Nouveau ticket</a>
                @endif
            </div>
        </aside>
    </section>
</div>
@endsection
