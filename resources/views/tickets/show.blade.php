@extends('layouts.app')

@section('title', 'Detail ticket')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">{{ $ticket->title }}</h1>
            <p class="section-text">Projet : <a href="{{ route('projects.show', $ticket->project->id) }}" class="table-link">{{ $ticket->project->name }}</a></p>
        </div>
        <div style="display:flex; gap: 8px;">
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="button button--primary">Modifier</a>
            <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" onsubmit="return confirm('Supprimer ce ticket ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="button button--danger">Supprimer</button>
            </form>
            <a href="{{ route('tickets.index') }}" class="button button--secondary">Retour a la liste</a>
        </div>
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

    @if($ticket->type === 'facturable' && $ticket->status === 'a valider' && auth()->user()->role === 'client')
        <section class="panel panel--padded">
            <h2 class="section-title">Validation requise</h2>
            <p class="section-text">Ce ticket facturable est en attente de votre validation.</p>
            <div style="display:flex; gap: 10px; margin-top: 1rem;">
                <form method="POST" action="{{ route('tickets.valider', $ticket->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="button button--primary">✅ Valider</button>
                </form>
                <form method="POST" action="{{ route('tickets.refuser', $ticket->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="button button--danger">❌ Refuser</button>
                </form>
            </div>
        </section>
    @endif

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
