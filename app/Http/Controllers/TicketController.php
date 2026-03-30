<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Project; 
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        // Récupère les tickets avec leurs projets (Eager Loading)
        $tickets = Ticket::with('project')->orderBy('created_at', 'desc')->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        // Récupère tous les projets pour la liste déroulante
        $projects = Project::all();
        return view('tickets.create', compact('projects'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title'      => 'required|string|max:255',
            'hours_spent'=> 'required|numeric|min:0.1',
        ]);

        // Création
        Ticket::create([
            'project_id'  => $request->project_id,
            'title'       => $request->title,
            'description' => $request->description,
            'hours_spent' => $request->hours_spent,
            'type'        => $request->type,
            'status' => $request->status ?? 'nouveau',
        ]);


        return response()->json(['success' => true]);
    }
    public function show($id)
    {
        // On récupère le ticket avec son projet associé
        $ticket = Ticket::with('project')->findOrFail($id);

        return view('tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $projects = Project::all();
        return view('tickets.edit', compact('ticket', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'hours_spent' => 'required|numeric|min:0',
            'status'      => 'required|string',
            'type'        => 'required|in:inclus,facturable',
        ]);

        $ticket->update($request->only(['project_id', 'title', 'description', 'hours_spent', 'status', 'type']));

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket mis à jour.');
    }

    public function valider($id)
    {
        $ticket = Ticket::findOrFail($id);
        $user = auth()->user();
        if ($user->role !== 'client' || $ticket->project->client_id !== $user->id) {
            abort(403);
        }

        $ticket->update(['status' => 'valide']);
        return back()->with('success', 'Ticket validé.');
    }

    public function refuser($id)
    {
        $ticket = Ticket::findOrFail($id);

        $user = auth()->user();
        if ($user->role !== 'client' || $ticket->project->client_id !== $user->id) {
            abort(403);
        }

        $ticket->update(['status' => 'refuse']);
        return back()->with('success', 'Ticket refusé.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé.');
    }
}