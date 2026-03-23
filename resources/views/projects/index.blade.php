@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-center mb-8">Gestion des projets</h1>

    <div class="flex flex-wrap items-center gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm">
        <span class="font-bold">Contrats :</span>
        <button onclick="filterProjects('all')" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition text-sm font-bold">Tous</button>
        <button onclick="filterProjects('actif')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm font-bold">Actif</button>
        <button onclick="filterProjects('alerte')" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-sm font-bold">Alerte</button>
        <button onclick="filterProjects('termine')" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm font-bold">Termine</button>

        @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create') }}" class="ml-auto bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                + Creer un nouveau projet
            </a>
        @endcan
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-blue-600 text-white text-sm uppercase">
                    <th class="p-4">Nom du projet</th>
                    <th class="p-4">Client</th>
                    <th class="p-4">Consultants</th>
                    <th class="p-4 text-center">Enveloppe</th>
                    <th class="p-4 text-center">Taux H.S.</th>
                    <th class="p-4">Statut</th>
                </tr>
            </thead>
            <tbody id="project-list">
                @forelse($projects as $project)
                    <tr class="project-row border-b hover:bg-gray-50 transition" data-status="{{ $project->status }}">
                        <td class="p-4 font-bold text-blue-600">
                            <a href="{{ route('projects.show', $project->id) }}" class="hover:underline">{{ $project->name }}</a>
                        </td>
                        <td class="p-4 text-gray-700">{{ $project->client_name }}</td>
                        <td class="p-4 text-gray-700 text-sm">
                            {{ $project->consultants->pluck('name')->join(', ') ?: 'Aucun consultant' }}
                        </td>
                        <td class="p-4 text-center font-mono font-bold">{{ $project->total_hours }} h</td>
                        <td class="p-4 text-center font-mono text-gray-600">{{ number_format($project->hourly_rate, 2, ',', ' ') }} EUR</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                {{ $project->status === 'actif' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                {{ $project->status === 'alerte' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : '' }}
                                {{ $project->status === 'termine' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}">
                                {{ $project->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 italic">
                            Aucun projet visible pour votre role.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterProjects(status) {
        const rows = document.querySelectorAll('.project-row');
        rows.forEach(row => {
            row.style.display = (status === 'all' || row.getAttribute('data-status') === status) ? '' : 'none';
        });
    }
</script>
@endsection
