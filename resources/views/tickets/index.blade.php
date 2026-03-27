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
        <button type="button" onclick="filterTickets('all')" class="button button--secondary">Tous</button>
        <button type="button" onclick="filterTickets('ouvert')" class="button button--secondary">Ouvert</button>
        <button type="button" onclick="filterTickets('en cours')" class="button button--secondary">En cours</button>
        <button type="button" onclick="filterTickets('ferme')" class="button button--secondary">Ferme</button>
        <div class="toolbar__spacer"></div>
        <a href="{{ route('tickets.create') }}" class="button button--primary">Creer un ticket</a>
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Titre du ticket</th>
                        <th>Projet</th>
                        <th>Temps</th>
                        <th>Type</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="ticket-row" data-status="{{ $ticket->status }}">
                            <td><a href="{{ route('tickets.show', $ticket->id) }}" class="table-link">{{ $ticket->title }}</a></td>
                            <td>{{ $ticket->project->name }}</td>
                            <td class="center-text mono-text">{{ number_format($ticket->hours_spent, 2) }} h</td>
                            <td>{{ $ticket->type }}</td>
                            <td>
                                @php
                                        $badgeClass = match($ticket->status) {
                                            'ouvert'    => 'badge--blue',
                                            'en cours'  => 'badge--yellow',
                                            'ferme'     => 'badge--gray',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="center-text">Aucun ticket trouve.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterTickets(status) {
        document.querySelectorAll('.ticket-row').forEach(function(row) {
            row.style.display = status === 'all' || row.getAttribute('data-status') === status ? '' : 'none';
        });
    }
</script>
@endsection
