@extends('layouts.app')

@section('title', 'Modifier le ticket')

@section('content')
<div class="panel panel--padded panel--narrow">
    <div class="split-header">
        <h1 class="page-title">Modifier le ticket</h1>
        <a href="{{ route('tickets.show', $ticket->id) }}" class="button button--secondary">Annuler</a>
    </div>

    <form method="POST" action="{{ route('tickets.update', $ticket->id) }}" class="form-grid">
        @csrf
        @method('PATCH')

        <div class="form-row">
            <label for="project_id" class="form-label">Projet associe</label>
            <select id="project_id" name="project_id" class="form-select">
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $ticket->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <label for="title" class="form-label">Titre</label>
            <input id="title" name="title" type="text" class="form-input" value="{{ $ticket->title }}">
        </div>

        <div class="form-row form-row--two">
            <div class="form-row">
                <label for="hours_spent" class="form-label">Temps passe (h)</label>
                <input id="hours_spent" name="hours_spent" type="number" step="0.25" class="form-input" value="{{ $ticket->hours_spent }}">
            </div>
            <div class="form-row">
                <label for="type" class="form-label">Type</label>
                <select id="type" name="type" class="form-select">
                    <option value="inclus" {{ $ticket->type === 'inclus' ? 'selected' : '' }}>Inclus</option>
                    <option value="facturable" {{ $ticket->type === 'facturable' ? 'selected' : '' }}>Facturable</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <label for="status" class="form-label">Statut</label>
            <select id="status" name="status" class="form-select">
                @foreach(['nouveau','en cours','en attente client','termine','a valider','valide','refuse'] as $s)
                    <option value="{{ $s }}" {{ $ticket->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-textarea">{{ $ticket->description }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="button button--primary">Enregistrer les modifications</button>
        </div>
    </form>
</div>
@endsection