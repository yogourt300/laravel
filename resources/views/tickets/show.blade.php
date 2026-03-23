@extends('layouts.app')

@section('title', 'Détail du Ticket')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Fil d'ariane / Retour --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-gray-800">{{ $ticket->title }}</h1>
            <p class="text-blue-600 font-semibold uppercase text-sm">
                Projet : <a href="{{ route('projects.show', $ticket->project->id) }}" class="hover:underline">{{ $ticket->project->name }}</a>
            </p>
        </div>
        <a href="{{ route('tickets.index') }}" class="text-sm font-bold text-gray-500 hover:text-blue-600 transition">← Retour à la liste</a>
    </div>

    {{-- Stats du Ticket --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Statut --}}
        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 
            {{ $ticket->status === 'ouvert' ? 'border-blue-500' : '' }}
            {{ $ticket->status === 'en cours' ? 'border-yellow-500' : '' }}
            {{ $ticket->status === 'ferme' ? 'border-gray-500' : '' }}">
            <h3 class="text-gray-400 text-xs font-bold uppercase mb-1">Statut</h3>
            <span class="font-bold uppercase text-lg">
                {{ $ticket->status }}
            </span>
        </div>

        {{-- Temps passé --}}
        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-orange-500">
            <h3 class="text-gray-400 text-xs font-bold uppercase mb-1">Temps consommé</h3>
            <p class="text-2xl font-black text-orange-600">{{ number_format($ticket->hours_spent, 2) }} h</p>
        </div>

        {{-- Type --}}
        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-purple-500">
            <h3 class="text-gray-400 text-xs font-bold uppercase mb-1">Type de ticket</h3>
            <p class="text-lg font-bold text-gray-800 capitalize">{{ $ticket->type }}</p>
        </div>
    </div>

    {{-- Description --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-800 p-4">
            <h3 class="text-white font-bold">Détails de l'intervention</h3>
        </div>
        <div class="p-8">
            <p class="text-gray-700 leading-relaxed text-lg italic">
                {{ $ticket->description ?: "Aucune description fournie pour ce ticket." }}
            </p>
        </div>
        <div class="bg-gray-50 p-4 border-t flex justify-between text-xs text-gray-400 font-mono">
            <span>Créé le : {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            <span>ID Ticket : #{{ $ticket->id }}</span>
        </div>
    </div>
</div>
@endsection