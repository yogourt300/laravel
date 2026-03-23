<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Project; // ✅ L'import doit être ici !
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
            'status'      => 'ouvert',
        ]);

        // ✅ TRÈS IMPORTANT : Retourner du JSON pour le script JS
        return response()->json(['success' => true]);
    }
    public function show($id)
    {
        // On récupère le ticket avec son projet associé
        $ticket = Ticket::with('project')->findOrFail($id);

        return view('tickets.show', compact('ticket'));
    }
}