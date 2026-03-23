@extends('layouts.app')

@section('title', 'Projets')

@section('content')
<div class="stack-lg">
    <div class="split-header">
        <div>
            <h1 class="page-title">Gestion des projets</h1>
            <p class="section-text">Consulte les projets visibles selon ton role.</p>
        </div>
    </div>

    <div class="toolbar">
        <span class="form-label">Statuts :</span>
        <button type="button" onclick="filterProjects('all')" class="button button--secondary">Tous</button>
        <button type="button" onclick="filterProjects('actif')" class="button button--secondary">Actif</button>
        <button type="button" onclick="filterProjects('alerte')" class="button button--secondary">Alerte</button>
        <button type="button" onclick="filterProjects('termine')" class="button button--secondary">Termine</button>
        <div class="toolbar__spacer"></div>
        @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create') }}" class="button button--primary">Creer un projet</a>
        @endcan
    </div>

    <div class="table-card">
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nom du projet</th>
                        <th>Client</th>
                        <th>Consultants</th>
                        <th>Enveloppe</th>
                        <th>Taux H.S.</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody id="project-list">
                    @forelse($projects as $project)
                        <tr class="project-row" data-status="{{ $project->status }}">
                            <td><a href="{{ route('projects.show', $project->id) }}" class="table-link">{{ $project->name }}</a></td>
                            <td>{{ $project->client_name }}</td>
                            <td>{{ $project->consultants->pluck('name')->join(', ') ?: 'Aucun consultant' }}</td>
                            <td class="center-text mono-text">{{ $project->total_hours }} h</td>
                            <td class="center-text mono-text">{{ number_format($project->hourly_rate, 2, ',', ' ') }} EUR</td>
                            <td>
                                <span class="badge {{ $project->status === 'actif' ? 'badge--green' : ($project->status === 'alerte' ? 'badge--yellow' : 'badge--red') }}">
                                    {{ $project->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="center-text">Aucun projet visible pour votre role.</td>
                        </tr>
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
