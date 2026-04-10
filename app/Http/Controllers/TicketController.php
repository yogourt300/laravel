<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $tickets = Ticket::with('project')->orderBy('created_at', 'desc')->get();
        } elseif ($user->isClient()) {
            $tickets = Ticket::with('project')
                ->whereHas('project', fn($q) => $q->where('client_id', $user->id))
                ->orderBy('created_at', 'desc')->get();
        } else {
            $tickets = Ticket::with('project')
                ->whereHas('project.collaborateurs', fn($q) => $q->where('users.id', $user->id))
                ->orderBy('created_at', 'desc')->get();
        }

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        if (auth()->user()->isClient()) {
            abort(403);
        }

        $user = auth()->user();

        if ($user->isAdmin()) {
            $projects = Project::orderBy('name')->get();
        } else {
            $projects = $user->assignedProjects()->orderBy('name')->get();
        }

        return view('tickets.create', compact('projects'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->isClient()) {
            abort(403);
        }

        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:inclus,facturable',
        ]);

        Ticket::create([
            'project_id'  => $request->project_id,
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'status'      => 'nouveau',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket créé.');
    }

    public function show($id)
    {
        $user   = auth()->user();
        $ticket = Ticket::with(['project', 'timeEntries.user'])->findOrFail($id);

        if ($user->isClient() && $ticket->project->client_id !== $user->id) {
            abort(403);
        }

        if ($user->isCollaborateur() && !$ticket->project->collaborateurs()->where('users.id', $user->id)->exists()) {
            abort(403);
        }

        $totalHours = $ticket->timeEntries->sum('hours');

        return view('tickets.show', compact('ticket', 'totalHours'));
    }

    public function edit($id)
    {
        $user   = auth()->user();
        $ticket = Ticket::findOrFail($id);

        if ($user->isClient()) {
            abort(403);
        }

        if ($user->isAdmin()) {
            $projects = Project::orderBy('name')->get();
        } else {
            $projects = $user->assignedProjects()->orderBy('name')->get();
        }

        return view('tickets.edit', compact('ticket', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $user   = auth()->user();
        $ticket = Ticket::findOrFail($id);

        if ($user->isClient()) {
            abort(403);
        }

        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:nouveau,en_cours,en_attente,a_valider,valide,refuse',
            'type'        => 'required|in:inclus,facturable',
        ]);

        $ticket->update($request->only(['project_id', 'title', 'description', 'status', 'type']));

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket mis à jour.');
    }

    public function valider($id)
    {
        $ticket = Ticket::with('project')->findOrFail($id);

        if (!auth()->user()->isClient() || $ticket->project->client_id !== auth()->id()) {
            abort(403);
        }

        $ticket->update(['status' => 'valide']);

        return back()->with('success', 'Ticket validé.');
    }

    public function refuser($id)
    {
        $ticket = Ticket::with('project')->findOrFail($id);

        if (!auth()->user()->isClient() || $ticket->project->client_id !== auth()->id()) {
            abort(403);
        }

        $ticket->update(['status' => 'refuse']);

        return back()->with('success', 'Ticket refusé.');
    }

    public function indexApi()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $tickets = Ticket::with('project')->orderBy('created_at', 'desc')->take(20)->get();
        } elseif ($user->isClient()) {
            $tickets = Ticket::with('project')
                ->whereHas('project', fn($q) => $q->where('client_id', $user->id))
                ->orderBy('created_at', 'desc')->take(20)->get();
        } else {
            $tickets = Ticket::with('project')
                ->whereHas('project.collaborateurs', fn($q) => $q->where('users.id', $user->id))
                ->orderBy('created_at', 'desc')->take(20)->get();
        }

        return response()->json(
            $tickets->map(fn($t) => [
                'id'      => $t->id,
                'title'   => $t->title,
                'status'  => $t->status,
                'type'    => $t->type,
                'project' => $t->project->name,
            ])
        );
    }

    public function storeApi(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|integer|exists:users,id',
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:inclus,facturable',
        ]);

        $ticket = Ticket::create([
            'user_id'     => $validated['user_id'],
            'project_id'  => $validated['project_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type'        => $validated['type'],
            'status'      => 'nouveau',
        ]);

        return response()->json([
            'message' => 'Ticket ajouté avec succès.',
            'ticket'  => [
                'id'       => $ticket->id,
                'title'    => $ticket->title,
                'type'     => $ticket->type,
                'show_url' => route('tickets.show', $ticket->id),
            ],
        ], 201);
    }

    public function destroy($id)
    {
        $user   = auth()->user();
        $ticket = Ticket::findOrFail($id);

        if ($user->isClient()) {
            abort(403);
        }

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé.');
    }
}
