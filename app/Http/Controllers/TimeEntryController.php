<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    public function store($ticketId, Request $request)
    {
        $ticket = Ticket::findOrFail($ticketId);

        $request->validate([
            'hours'   => 'required|numeric|min:0.25',
            'date'    => 'required|date',
            'comment' => 'nullable|string|max:500',
        ]);

        TimeEntry::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'hours'     => $request->hours,
            'date'      => $request->date,
            'comment'   => $request->comment,
        ]);

        return back()->with('success', 'Heures ajoutées.');
    }

    public function destroy($id)
    {
        $entry = TimeEntry::findOrFail($id);
        $entry->delete();

        return back()->with('success', 'Entrée supprimée.');
    }
}
