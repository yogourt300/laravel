@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">Gestion des tickets</h1>
            <p class="section-text">Suivi des tickets saisis sur les projets.</p>
        </div>
    </div>

    <div class="toolbar">
        <span class="form-label">Statuts :</span>
        <button type="button" onclick="filterBy('status', 'all')" class="button button--secondary">Tous</button>
        <button type="button" onclick="filterBy('status', 'nouveau')" class="button button--secondary">Nouveau</button>
        <button type="button" onclick="filterBy('status', 'en_cours')" class="button button--secondary">En cours</button>
        <button type="button" onclick="filterBy('status', 'en_attente')" class="button button--secondary">En attente</button>
        <button type="button" onclick="filterBy('status', 'a_valider')" class="button button--secondary">À valider</button>
        <button type="button" onclick="filterBy('status', 'valide')" class="button button--secondary">Validé</button>
        <button type="button" onclick="filterBy('status', 'refuse')" class="button button--secondary">Refusé</button>
    </div>

    <div class="toolbar">
        <span class="form-label">Type :</span>
        <button type="button" onclick="filterBy('type', 'all')" class="button button--secondary">Tous</button>
        <button type="button" onclick="filterBy('type', 'inclus')" class="button button--secondary">Inclus</button>
        <button type="button" onclick="filterBy('type', 'facturable')" class="button button--secondary">Facturable</button>
        <div class="toolbar__spacer"></div>
        <span id="api-count" class="section-text"></span>
        @if(!auth()->user()->isClient())
            <a href="{{ route('tickets.create') }}" class="button button--primary">Créer un ticket</a>
        @endif
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Projet</th>
                        <th>Type</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="ticket-row" data-status="{{ $ticket->status }}" data-type="{{ $ticket->type }}">
                            <td><a href="{{ route('tickets.show', $ticket->id) }}" class="table-link">{{ $ticket->title }}</a></td>
                            <td>{{ $ticket->project->name }}</td>
                            <td>{{ $ticket->type }}</td>
                            <td>
                                @php
                                    $badges = [
                                        'nouveau'    => ['badge--blue',   'Nouveau'],
                                        'en_cours'   => ['badge--yellow', 'En cours'],
                                        'en_attente' => ['badge--orange', 'En attente'],
                                        'a_valider'  => ['badge--purple', 'À valider'],
                                        'valide'     => ['badge--green',  'Validé'],
                                        'refuse'     => ['badge--red',    'Refusé'],
                                    ];
                                    $badge = $badges[$ticket->status] ?? ['badge--gray', $ticket->status];
                                @endphp
                                <span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="center-text">Aucun ticket.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var activeStatus = 'all';
    var activeType   = 'all';

    function filterBy(dimension, value) {
        if (dimension === 'status') {
            activeStatus = value;
        } else {
            activeType = value;
        }

        document.querySelectorAll('.ticket-row').forEach(function(row) {
            var matchStatus = activeStatus === 'all' || row.getAttribute('data-status') === activeStatus;
            var matchType   = activeType   === 'all' || row.getAttribute('data-type')   === activeType;
            row.style.display = matchStatus && matchType ? '' : 'none';
        });
    }

    fetch('/api/tickets')
        .then(function(response) { return response.json(); })
        .then(function(data) {
            document.getElementById('api-count').textContent = data.length + ' ticket(s) chargé(s) via API';
        });
</script>
@endsection
