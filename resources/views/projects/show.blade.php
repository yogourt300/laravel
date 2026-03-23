@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold italic">Projet : {{ $project->name }}</h1>
        <a href="{{ route('projects.index') }}" class="text-blue-600 font-bold hover:underline">Retour a la liste</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded shadow text-center">
            <h3 class="text-gray-500 text-sm">Client</h3>
            <p class="font-bold">{{ $project->client_name }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow text-center">
            <h3 class="text-gray-500 text-sm">Enveloppe</h3>
            <p class="font-bold">{{ $project->total_hours }} h</p>
        </div>

        <div class="bg-white p-4 rounded shadow text-center">
            <h3 class="text-gray-500 text-sm">Consomme</h3>
            <p class="font-bold text-orange-600">{{ number_format($heuresConsommees, 2) }} h</p>
        </div>

        <div class="bg-white p-4 rounded shadow text-center border-2 border-green-500">
            <h3 class="text-gray-500 text-sm">Restant</h3>
            @php $restant = $project->total_hours - $heuresConsommees; @endphp
            <p class="font-bold {{ $restant < 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ number_format($restant, 2) }} h
            </p>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow-md mb-6">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Consultants rattaches</h3>
        <p class="text-gray-700 leading-relaxed">
            {{ $project->consultants->pluck('name')->join(', ') ?: 'Aucun consultant rattache.' }}
        </p>
    </div>

    <div class="bg-white p-6 rounded shadow-md">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Description du projet</h3>
        <p class="text-gray-700 leading-relaxed">{{ $project->description ?? 'Pas de description.' }}</p>
    </div>
</div>
@endsection
