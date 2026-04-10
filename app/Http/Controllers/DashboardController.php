<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\TimeEntry;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $totalProjects = Project::count();
            $totalTickets  = Ticket::count();
            $hoursInclus   = TimeEntry::whereHas('ticket', fn($q) => $q->where('type', 'inclus'))->sum('hours');
            $hoursBillable = TimeEntry::whereHas('ticket', fn($q) => $q->where('type', 'facturable'))->sum('hours');
            $recentEntries = TimeEntry::with(['ticket.project', 'user'])->orderBy('created_at', 'desc')->take(8)->get();
            $pendingTickets = collect();
        } elseif ($user->isClient()) {
            $totalProjects = Project::where('client_id', $user->id)->count();
            $totalTickets  = Ticket::whereHas('project', fn($q) => $q->where('client_id', $user->id))->count();
            $hoursInclus   = 0;
            $hoursBillable = 0;
            $recentEntries = collect();
            $pendingTickets = Ticket::with('project')
                ->where('status', 'a_valider')
                ->whereHas('project', fn($q) => $q->where('client_id', $user->id))
                ->get();
        } else {
            $totalProjects = $user->assignedProjects()->count();
            $totalTickets  = Ticket::where('user_id', $user->id)->count();
            $hoursInclus   = TimeEntry::where('user_id', $user->id)->whereHas('ticket', fn($q) => $q->where('type', 'inclus'))->sum('hours');
            $hoursBillable = TimeEntry::where('user_id', $user->id)->whereHas('ticket', fn($q) => $q->where('type', 'facturable'))->sum('hours');
            $recentEntries = TimeEntry::with(['ticket.project', 'user'])->where('user_id', $user->id)->orderBy('created_at', 'desc')->take(8)->get();
            $pendingTickets = collect();
        }

        return view('dashboard', compact(
            'totalProjects', 'totalTickets',
            'hoursInclus', 'hoursBillable',
            'recentEntries', 'pendingTickets'
        ));
    }
}
