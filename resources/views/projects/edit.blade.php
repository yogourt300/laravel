@extends('layouts.app')

@section('title', 'Modifier le projet')

@section('content')
<div class="panel panel--padded panel--narrow">
    <div class="split-header">
        <div>
            <h1 class="page-title">Modifier le projet</h1>
        </div>
        <a href="{{ route('projects.show', $project->id) }}" class="button button--secondary">Annuler</a>
    </div>

    <form method="POST" action="{{ route('projects.update', $project->id) }}" class="form-grid">
        @csrf
        @method('PATCH')

        <div class="form-row">
            <label for="client_id" class="form-label">Client</label>
            <select id="client_id" name="client_id" class="form-select">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} ({{ $client->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <label for="name" class="form-label">Nom du projet</label>
            <input id="name" name="name" type="text" class="form-input" value="{{ $project->name }}">
        </div>

        <div class="form-row">
            <label for="status" class="form-label">Statut</label>
            <select id="status" name="status" class="form-select">
                <option value="actif"   {{ $project->status === 'actif'   ? 'selected' : '' }}>Actif</option>
                <option value="alerte"  {{ $project->status === 'alerte'  ? 'selected' : '' }}>Alerte</option>
                <option value="termine" {{ $project->status === 'termine' ? 'selected' : '' }}>Terminé</option>
            </select>
        </div>

        <div class="form-row form-row--two">
            <div class="form-row">
                <label for="included_hours" class="form-label">Heures incluses (contrat)</label>
                <input id="included_hours" name="included_hours" type="number" min="0" class="form-input"
                    value="{{ $project->contract->included_hours ?? 0 }}">
            </div>
            <div class="form-row">
                <label for="extra_hourly_rate" class="form-label">Taux H.S. (EUR/h)</label>
                <input id="extra_hourly_rate" name="extra_hourly_rate" type="number" min="0" step="0.01" class="form-input"
                    value="{{ $project->contract->extra_hourly_rate ?? 0 }}">
            </div>
        </div>

        <div class="form-row">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-textarea">{{ $project->description }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--primary">Enregistrer les modifications</button>
        </div>
    </form>
</div>
@endsection
