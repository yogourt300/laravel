<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $projects = Project::with('client')->get();
        } elseif ($user->isClient()) {
            $projects = Project::with('client')->where('client_id', $user->id)->get();
        } else {
            $projects = Project::with('client')
                ->whereHas('collaborateurs', fn($q) => $q->where('users.id', $user->id))
                ->get();
        }

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $clients = User::where('role', 'client')->orderBy('name')->get();

        return view('projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'client_id'         => ['required', 'exists:users,id'],
            'description'       => ['nullable', 'string'],
            'included_hours'    => ['required', 'integer', 'min:0'],
            'extra_hourly_rate' => ['required', 'numeric', 'min:0'],
        ]);

        $project = Project::create([
            'name'        => $validated['name'],
            'client_id'   => $validated['client_id'],
            'description' => $validated['description'],
            'status'      => 'actif',
        ]);

        Contract::create([
            'project_id'        => $project->id,
            'included_hours'    => $validated['included_hours'],
            'extra_hourly_rate' => $validated['extra_hourly_rate'],
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $user    = auth()->user();
        $project = Project::with(['tickets.timeEntries', 'client', 'contract', 'collaborateurs'])->findOrFail($id);

        if ($user->isClient() && $project->client_id !== $user->id) {
            abort(403);
        }

        if ($user->isCollaborateur() && !$project->collaborateurs->contains($user->id)) {
            abort(403);
        }

        $contractHours    = $project->contract->included_hours ?? 0;
        $rawIncludedHours = $project->tickets->where('type', 'inclus')->sum(fn($t) => $t->timeEntries->sum('hours'));
        $overflowHours    = max(0, $rawIncludedHours - $contractHours);
        $includedHours    = min($rawIncludedHours, $contractHours);
        $remainingHours   = $contractHours - $includedHours;
        $billableHours    = $project->tickets->where('type', 'facturable')->sum(fn($t) => $t->timeEntries->sum('hours')) + $overflowHours;

        $assignedIds    = $project->collaborateurs->pluck('id');
        $collaborateurs = $user->isAdmin() ? User::where('role', 'collaborateur')->whereNotIn('id', $assignedIds)->orderBy('name')->get() : collect();

        return view('projects.show', compact(
            'project', 'includedHours', 'billableHours',
            'contractHours', 'remainingHours', 'overflowHours', 'collaborateurs'
        ));
    }

    public function assign(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $project = Project::findOrFail($id);
        $project->collaborateurs()->syncWithoutDetaching([$request->user_id]);

        return back()->with('success', 'Collaborateur assigné.');
    }

    public function unassign(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $project = Project::findOrFail($id);
        $project->collaborateurs()->detach($request->user_id);

        return back()->with('success', 'Collaborateur retiré.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projet supprimé.');
    }

    public function edit($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $project = Project::with('contract')->findOrFail($id);
        $clients = User::where('role', 'client')->orderBy('name')->get();

        return view('projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'client_id'         => ['required', 'exists:users,id'],
            'description'       => ['nullable', 'string'],
            'status'            => ['required', 'in:actif,alerte,termine'],
            'included_hours'    => ['required', 'integer', 'min:0'],
            'extra_hourly_rate' => ['required', 'numeric', 'min:0'],
        ]);

        $project->update([
            'name'        => $validated['name'],
            'client_id'   => $validated['client_id'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
        ]);

        $project->contract()->updateOrCreate(
            ['project_id' => $project->id],
            [
                'included_hours'    => $validated['included_hours'],
                'extra_hourly_rate' => $validated['extra_hourly_rate'],
            ]
        );

        return redirect()->route('projects.show', $project->id)->with('success', 'Projet mis à jour.');
    }
}
