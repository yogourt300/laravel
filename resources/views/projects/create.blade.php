@extends('layouts.app')

@section('title', 'Nouveau projet')

@section('content')
<div class="panel panel--padded panel--narrow">
    <div class="split-header">
        <div>
            <h1 class="page-title">Creer un projet</h1>
            <p class="section-text">Renseigne les informations principales du projet.</p>
        </div>
        <a href="{{ route('projects.index') }}" class="button button--secondary">Annuler</a>
    </div>

    <form id="submitform" class="form-grid">
        @csrf

        <div class="form-row">
            <label for="client_id" class="form-label">Client</label>
            <select id="client_id" name="client_id" class="form-select">
                <option value="">Selectionner un client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                @endforeach
            </select>
            <span id="client_error" class="error-box is-hidden">Veuillez choisir un client.</span>
        </div>

        <div class="form-row">
            <label for="titre" class="form-label">Nom du projet</label>
            <input id="titre" name="titre" type="text" class="form-input" placeholder="Ex: Migration Cloud">
            <span id="titre_error" class="error-box is-hidden">Le nom du projet est obligatoire.</span>
        </div>

        <div class="form-row">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-textarea" placeholder="Contexte, livrables, objectifs..."></textarea>
        </div>

        <div class="form-row form-row--two">
            <div class="form-row">
                <label for="enveloppe" class="form-label">Heures incluses</label>
                <input id="enveloppe" name="enveloppe" type="number" class="form-input" placeholder="Ex: 50">
                <span id="enveloppe_error" class="error-box is-hidden">Indiquez un nombre d'heures valide.</span>
            </div>

            <div class="form-row">
                <label for="taux" class="form-label">Taux horaire H. Supp</label>
                <input id="taux" name="taux" type="number" class="form-input" placeholder="Ex: 500">
                <span id="taux_error" class="error-box is-hidden">Indiquez un taux valide.</span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" id="submit-btn" class="button button--primary">Enregistrer le projet</button>
            <div id="success" class="status-message is-hidden">Projet cree avec succes.</div>
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
                { id: 'titre', error: 'titre_error' },
                { id: 'enveloppe', error: 'enveloppe_error' },
                { id: 'taux', error: 'taux_error' }
            ];

            fields.forEach(function(field) {
                const input = document.getElementById(field.id);
                const error = document.getElementById(field.error);
                const empty = input.value.trim() === '';
                const invalidNumber = input.type === 'number' && Number(input.value) <= 0;

                if (empty || invalidNumber) {
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
                    'X-CSRF-TOKEN': document.querySelector('input[name=\"_token\"]').value,
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
