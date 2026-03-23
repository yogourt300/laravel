<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Project::class);

        $user = auth()->user();

        $projects = Project::query()
            ->with(['client', 'consultants'])
            ->when($user->role === User::ROLE_CLIENT, fn ($query) => $query->where('client_id', $user->id))
            ->when($user->role === User::ROLE_CONSULTANT, fn ($query) => $query->whereHas('consultants', fn ($subQuery) => $subQuery->where('users.id', $user->id)))
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);

        $clients = User::query()
            ->where('role', User::ROLE_CLIENT)
            ->orderBy('name')
            ->get();

        return view('projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'exists:users,id'],
            'description' => ['nullable', 'string'],
            'enveloppe' => ['required', 'integer', 'min:1'],
            'taux' => ['required', 'numeric', 'min:0'],
        ]);

        $client = User::query()
            ->where('role', User::ROLE_CLIENT)
            ->findOrFail($validated['client_id']);

        Project::create([
            'name' => $validated['titre'],
            'client_name' => $client->name,
            'client_id' => $client->id,
            'description' => $validated['description'],
            'total_hours' => $validated['enveloppe'],
            'hourly_rate' => $validated['taux'],
            'status' => 'actif',
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $project = Project::with(['tickets', 'client', 'consultants'])->findOrFail($id);

        $this->authorize('view', $project);

        $heuresConsommees = $project->tickets->sum('hours_spent');

        return view('projects.show', compact('project', 'heuresConsommees'));
    }
}
