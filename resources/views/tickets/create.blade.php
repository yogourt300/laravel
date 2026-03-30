@extends('layouts.app')

@section('title', 'Nouveau ticket')

@section('content')
<div class="panel panel--padded panel--narrow">
    <div class="split-header">
        <div>
            <h1 class="page-title">Creer un ticket</h1>
            <p class="section-text">Associe le ticket a un projet et precise le temps passe.</p>
        </div>
        <a href="{{ route('tickets.index') }}" class="button button--secondary">Annuler</a>
    </div>

    <form id="submitform" class="form-grid">
        @csrf

        <div class="form-row">
            <label for="project_id" class="form-label">Projet associe</label>
            <select id="project_id" name="project_id" class="form-select">
                <option value="">Selectionner le projet</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            <span id="project_error" class="error-box is-hidden">Veuillez choisir un projet.</span>
        </div>

        <div class="form-row">
            <label for="title" class="form-label">Titre du ticket</label>
            <input id="title" name="title" type="text" class="form-input" placeholder="Ex: Debug menu responsive">
            <span id="title_error" class="error-box is-hidden">Le titre du ticket est obligatoire.</span>
        </div>

        <div class="form-row form-row--two">
            <div class="form-row">
                <label for="hours_spent" class="form-label">Temps passe (h)</label>
                <input id="hours_spent" name="hours_spent" type="number" step="0.25" class="form-input" placeholder="Ex: 2.5">
                <span id="hours_error" class="error-box is-hidden">Indiquez un temps valide.</span>
            </div>

            <div class="form-row">
                <label for="type" class="form-label">Type</label>
                <select id="type" name="type" class="form-select">
                    <option value="inclus">Inclus</option>
                    <option value="facturable">Facturable</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <label for="description" class="form-label">Description du travail</label>
            <textarea id="description" name="description" class="form-textarea" placeholder="Detaille l'intervention..."></textarea>
        </div>

        <div class="form-row">
            <label for="status" class="form-label">Statut</label>
            <select id="status" name="status" class="form-select">
                <option value="nouveau">Nouveau</option>
                <option value="en cours">En cours</option>
                <option value="en attente client">En attente client</option>
                <option value="termine">Terminé</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" id="submit-btn" class="button button--primary">Enregistrer le ticket</button>
            <div id="success" class="status-message is-hidden">Ticket cree avec succes.</div>
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
                { id: 'project_id', error: 'project_error' },
                { id: 'title', error: 'title_error' },
                { id: 'hours_spent', error: 'hours_error' }
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

            fetch("/api/tickets", {
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
                        window.location.href = "{{ route('tickets.index') }}";
                    }, 1200);
                }
            });
        });
    });
</script>
@endsection
