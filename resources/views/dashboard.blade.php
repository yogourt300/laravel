@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h1 class="page-title">Tableau de bord</h1>
@endsection

@section('content')
<div class="stack-lg">
    <section class="metric-grid">
        <article class="metric-card">
            <p class="metric-card__label">Projets totaux</p>
            <p class="metric-card__value">{{ $totalProjects }}</p>
        </article>
        <article class="metric-card">
            <p class="metric-card__label">Projets actifs</p>
            <p class="metric-card__value metric-card__value--blue">{{ $activeProjects }}</p>
        </article>
        <article class="metric-card">
            <p class="metric-card__label">Tickets</p>
            <p class="metric-card__value">{{ $totalTickets }}</p>
        </article>
        <article class="metric-card">
            <p class="metric-card__label">Heures saisies</p>
            <p class="metric-card__value metric-card__value--orange">{{ number_format($totalHours, 2) }} h</p>
        </article>
    </section>

    <section class="content-grid">
        <article class="panel panel--padded">
            <div class="split-header">
                <div>
                    <h2 class="section-title">Activite recente</h2>
                    <p class="section-text">Les derniers tickets saisis dans l'application.</p>
                </div>
                <a href="{{ route('tickets.index') }}" class="button button--ghost">Voir les tickets</a>
            </div>

            <div class="list">
                @forelse ($recentTickets as $ticket)
                    <div class="list-item">
                        <div>
                            <p class="list-item__title">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="table-link">{{ $ticket->title }}</a>
                            </p>
                            <p class="list-item__meta">{{ $ticket->project->name }} • {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <strong>{{ number_format($ticket->hours_spent, 2) }} h</strong>
                    </div>
                @empty
                    <p class="muted-text">Aucun ticket enregistre pour le moment.</p>
                @endforelse
            </div>
        </article>

        <aside class="panel panel--padded">
            <h2 class="section-title">Resume business</h2>
            <p class="section-text">Chiffre d'affaires theorique base sur les tickets et le taux des projets.</p>
            <p class="metric-card__value metric-card__value--green">{{ number_format($totalRevenue, 2, ',', ' ') }} EUR</p>

            <div class="stack-md">
                <a href="{{ route('projects.create') }}" class="button button--primary">Nouveau projet</a>
                <a href="{{ route('tickets.create') }}" class="button button--secondary">Nouveau ticket</a>
            </div>
        </aside>
    </section>
</div>
@endsection
