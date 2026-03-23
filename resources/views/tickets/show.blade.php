@extends('layouts.app')

@section('title', 'Detail ticket')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">{{ $ticket->title }}</h1>
            <p class="section-text">Projet : <a href="{{ route('projects.show', $ticket->project->id) }}" class="table-link">{{ $ticket->project->name }}</a></p>
        </div>
        <a href="{{ route('tickets.index') }}" class="button button--secondary">Retour a la liste</a>
    </div>

    <section class="stats-grid stats-grid--three">
        <article class="stat-box">
            <p class="stat-box__label">Statut</p>
            <p class="stat-box__value">{{ $ticket->status }}</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Temps consomme</p>
            <p class="stat-box__value">{{ number_format($ticket->hours_spent, 2) }} h</p>
        </article>
        <article class="stat-box">
            <p class="stat-box__label">Type</p>
            <p class="stat-box__value">{{ $ticket->type }}</p>
        </article>
    </section>

    <section class="detail-card">
        <div class="detail-card__header">Details de l'intervention</div>
        <div class="detail-card__body">
            <p class="section-text">{{ $ticket->description ?: 'Aucune description fournie pour ce ticket.' }}</p>
        </div>
        <div class="detail-card__footer">
            <span>Cree le : {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            <span>ID Ticket : #{{ $ticket->id }}</span>
        </div>
    </section>
</div>
@endsection
