@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-center mb-8">Gestion des Tickets</h1>

    {{-- Filtres de Statuts --}}
    <div class="flex flex-wrap items-center gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm">
        <span class="font-bold text-gray-700">Statuts :</span>
        
        <button onclick="filterTickets('all')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition text-sm font-bold whitespace-nowrap">
            Tous
        </button>
        
        <button onclick="filterTickets('ouvert')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm font-bold whitespace-nowrap">
            Ouvert
        </button>
        
        <button onclick="filterTickets('en cours')" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-sm font-bold whitespace-nowrap">
            En cours
        </button>
        
        <button onclick="filterTickets('ferme')" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition text-sm font-bold whitespace-nowrap">
            Fermé
        </button>

        <a href="{{ route('tickets.create') }}" class="ml-auto bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition whitespace-nowrap shadow-md">
            + Créer un ticket
        </a>
    </div>

    {{-- Tableau des Tickets --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                {{-- En-tête bleu synchronisé avec les boutons --}}
                <tr class="bg-blue-600 text-white text-sm uppercase tracking-wider">
                    <th class="p-4">Titre du Ticket</th>
                    <th class="p-4">Projet</th>
                    <th class="p-4 text-center">Temps (h)</th>
                    <th class="p-4">Type</th>
                    <th class="p-4">Statut</th>
                </tr>
            </thead>
            <tbody id="ticket-list">
                @forelse($tickets as $ticket)
                <tr class="ticket-row border-b hover:bg-gray-50 transition" data-status="{{ $ticket->status }}">
                    
                    {{-- Titre : Lien bleu --}}
                    <td class="p-4 font-bold">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline">
                            {{ $ticket->title }}
                        </a>
                    </td>

                    {{-- Projet : Texte NOIR, gras, sans boîte (Épuré) --}}
                    <td class="p-4 text-sm font-bold text-black whitespace-nowrap">
                        {{ $ticket->project->name }}
                    </td>

                    {{-- Temps : Orange --}}
                    <td class="p-4 text-center font-mono font-bold text-orange-600">
                        {{ number_format($ticket->hours_spent, 2) }} h
                    </td>

                    {{-- Type : Noir profond --}}
                    <td class="p-4 text-sm font-medium text-gray-900">
                        {{ $ticket->type }}
                    </td>

                    {{-- Statut : Badge avec couleurs --}}
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase whitespace-nowrap
                            {{ $ticket->status === 'ouvert' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                            {{ $ticket->status === 'en cours' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : '' }}
                            {{ $ticket->status === 'ferme' ? 'bg-gray-200 text-gray-700 border border-gray-300' : '' }}">
                            {{ $ticket->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500 italic">
                        Aucun ticket trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script de filtrage instantané --}}
<script>
    function filterTickets(status) {
        const rows = document.querySelectorAll('.ticket-row');
        rows.forEach(row => {
            if (status === 'all' || row.getAttribute('data-status') === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection