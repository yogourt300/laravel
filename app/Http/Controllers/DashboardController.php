<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistiques simples
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'actif')->count();
        $totalTickets = Ticket::count();
        
        // 2. Somme de toutes les heures travaillées dans l'ESN
        $totalHours = Ticket::sum('hours_spent');

        // 3. Calcul du chiffre d'affaires théorique (heures * taux horaire)
        // On fait une petite boucle sur les tickets pour être précis
        $totalRevenue = Ticket::with('project')->get()->sum(function($ticket) {
            return $ticket->hours_spent * ($ticket->project->hourly_rate ?? 0);
        });

        // 4. Les 5 derniers tickets créés pour voir l'activité récente
        $recentTickets = Ticket::with('project')->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalProjects', 
            'activeProjects', 
            'totalTickets', 
            'totalHours', 
            'totalRevenue',
            'recentTickets'
        ));
    }
}