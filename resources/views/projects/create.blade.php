@extends('layouts.app')

@section('title', 'Nouveau projet')

@section('content')
<div class="panel panel--padded panel--narrow">
    <div class="split-header">
        <div>
            <h1 class="page-title">Créer un projet</h1>
            <p class="section-text">Renseigne les informations principales du projet.</p>
        </div>
        <a href="{{ route('projects.index') }}" class="button button--secondary">Annuler</a>
    </div>

    <form id="submitform" class="form-grid">
        @csrf

        <div class="form-row">
            <label for="client_id" class="form-label">Client</label>
            <select id="client_id" name="client_id" class="form-select">
                <option value="">Sélectionner un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                @endforeach
            </select>
            <span id="client_error" class="error-box is-hidden">Veuillez choisir un client.</span>
        </div>

        <div class="form-row">
            <label for="name" class="form-label">Nom du projet</label>
            <input id="name" name="name" type="text" class="form-input" placeholder="Ex: Migration Cloud">
            <span id="name_error" class="error-box is-hidden">Le nom du projet est obligatoire.</span>
        </div>

        <div class="form-row form-row--two">
            <div class="form-row">
                <label for="included_hours" class="form-label">Heures incluses (contrat)</label>
                <input id="included_hours" name="included_hours" type="number" min="0" class="form-input" placeholder="Ex: 50">
                <span id="included_hours_error" class="error-box is-hidden">Indiquez un nombre d'heures valide.</span>
            </div>
            <div class="form-row">
                <label for="extra_hourly_rate" class="form-label">Taux H.S. (EUR/h)</label>
                <input id="extra_hourly_rate" name="extra_hourly_rate" type="number" min="0" step="0.01" class="form-input" placeholder="Ex: 500">
                <span id="extra_hourly_rate_error" class="error-box is-hidden">Indiquez un taux valide.</span>
            </div>
        </div>

        <div class="form-row">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-textarea" placeholder="Contexte, livrables, objectifs..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" id="submit-btn" class="button button--primary">Enregistrer le projet</button>
            <div id="success" class="status-message is-hidden">Projet créé avec succès.</div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('submitform');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let hasErrors = false;
            const fields = [
                { id: 'client_id', error: 'client_error' },
                { id: 'name', error: 'name_error' },
                { id: 'included_hours', error: 'included_hours_error' },
                { id: 'extra_hourly_rate', error: 'extra_hourly_rate_error' },
            ];

            fields.forEach(function(field) {
                const input = document.getElementById(field.id);
                const error = document.getElementById(field.error);
                if (input.value.trim() === '') {
                    error.classList.remove('is-hidden');
                    hasErrors = true;
                } else {
                    error.classList.add('is-hidden');
                }
            });

            if (hasErrors) {
                return;
            }

            fetch("{{ route('projects.store') }}", {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    document.getElementById('submit-btn').classList.add('is-hidden');
                    document.getElementById('success').classList.remove('is-hidden');
                    setTimeout(function() {
                        window.location.href = "{{ route('projects.index') }}";
                    }, 1200);
                }
            });
        });
    });
</script>
@endsection
