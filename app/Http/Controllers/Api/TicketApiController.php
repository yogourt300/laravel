<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketApiController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('project')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($ticket) {
                return [
                    'id'          => $ticket->id,
                    'title'       => $ticket->title,
                    'description' => $ticket->description,
                    'status'      => $ticket->status,
                    'type'        => $ticket->type,
                    'hours_spent' => $ticket->hours_spent,
                    'project' => ['id' => $ticket->project->id, 'name' => $ticket->project->name],
                    'created_at'  => $ticket->created_at->format('d/m/Y H:i'),
                ];
            });

        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'hours_spent' => 'required|numeric|min:0.1',
            'type'        => 'nullable|in:inclus,facturable',
        ]);

        $ticket = Ticket::create([
            'project_id'  => $validated['project_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'hours_spent' => $validated['hours_spent'],
            'type'        => $validated['type'] ?? 'inclus',
            'status'      => 'ouvert',
        ]);

        return response()->json([
            'success' => true,
            'ticket'  => $ticket->load('project'),
        ], 201);
    }
}