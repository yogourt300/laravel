@extends('layouts.app')

@section('title', 'Projets')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">Gestion des projets</h1>
            <p class="section-text">Liste des projets accessibles.</p>
        </div>
    </div>

    <div class="toolbar">
        <span class="form-label">Statuts :</span>
        <button type="button" onclick="filterProjects('all')" class="button button--secondary">Tous</button>
        <button type="button" onclick="filterProjects('actif')" class="button button--secondary">Actif</button>
        <button type="button" onclick="filterProjects('alerte')" class="button button--secondary">Alerte</button>
        <button type="button" onclick="filterProjects('termine')" class="button button--secondary">Terminé</button>
        <div class="toolbar__spacer"></div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('projects.create') }}" class="button button--primary">Créer un projet</a>
        @endif
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom du projet</th>
                        <th>Client</th>
                        <th>Statut</th>
                        @if(auth()->user()->isAdmin())<th>Actions</th>@endif
                    </tr>
                </thead>
                <tbody id="project-list">
                    @forelse($projects as $project)
                        <tr class="project-row" data-status="{{ $project->status }}">
                            <td><a href="{{ route('projects.show', $project->id) }}" class="table-link">{{ $project->name }}</a></td>
                            <td>{{ $project->client->name ?? 'Non renseigné' }}</td>
                            <td>
                                <span class="badge {{ $project->status === 'actif' ? 'badge--green' : ($project->status === 'alerte' ? 'badge--yellow' : 'badge--red') }}">
                                    {{ $project->status }}
                                </span>
                            </td>
                            @if(auth()->user()->isAdmin())
                                <td><a href="{{ route('projects.edit', $project->id) }}" class="button button--secondary">Modifier</a></td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="4" class="center-text">Aucun projet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filterProjects(status) {
        document.querySelectorAll('.project-row').forEach(function(row) {
            row.style.display = status === 'all' || row.getAttribute('data-status') === status ? '' : 'none';
        });
    }
</script>
@endsection
