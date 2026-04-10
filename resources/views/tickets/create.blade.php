@extends('layouts.app')

@section('title', 'Nouveau ticket')

@section('content')
<div class="panel panel--padded panel--narrow">
    <div class="split-header">
        <div>
            <h1 class="page-title">Créer un ticket</h1>
            <p class="section-text">Renseigne les informations principales du ticket.</p>
        </div>
        <a href="{{ route('tickets.index') }}" class="button button--secondary">Annuler</a>
    </div>

    <form id="submitform" class="form-grid">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <div class="form-row">
            <label for="project_id" class="form-label">Projet associé</label>
            <select id="project_id" name="project_id" class="form-select">
                <option value="">Sélectionner le projet</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            <span id="project_error" class="error-box is-hidden">Veuillez choisir un projet.</span>
        </div>

        <div class="form-row">
            <label for="title" class="form-label">Titre du ticket</label>
            <input id="title" name="title" type="text" class="form-input" placeholder="Ex: Correction bug login">
            <span id="title_error" class="error-box is-hidden">Le titre est obligatoire.</span>
        </div>

        <div class="form-row">
            <label for="type" class="form-label">Type</label>
            <select id="type" name="type" class="form-select">
                <option value="inclus">Inclus</option>
                <option value="facturable">Facturable</option>
            </select>
        </div>

        <div class="form-row">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-textarea" placeholder="Détaille l'intervention..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" id="submit-btn" class="button button--primary">Enregistrer le ticket</button>
            <div id="success" class="status-message is-hidden">Ticket créé avec succès.</div>
            <div id="api-error" class="error-box is-hidden"></div>
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
                { id: 'title',      error: 'title_error' },
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

            if (hasErrors) return;

            fetch('/api/tickets', {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                }
            })
            .then(function(response) {
                if (!response.ok) {
                    return response.json().then(function(err) { throw err; });
                }
                return response.json();
            })
            .then(function(data) {
                document.getElementById('submit-btn').classList.add('is-hidden');
                document.getElementById('success').classList.remove('is-hidden');
                setTimeout(function() {
                    window.location.replace('/tickets');
                }, 1200);
            })
            .catch(function(err) {
                var msg = err.message || 'Erreur lors de la création.';
                document.getElementById('api-error').textContent = msg;
                document.getElementById('api-error').classList.remove('is-hidden');
            });
        });
    });
</script>
@endsection
