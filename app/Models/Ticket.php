<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // ✅ VÉRIFIE BIEN QUE 'project_id' EST ÉCRIT ICI !
    protected $fillable = [
        'project_id', 
        'title', 
        'description', 
        'hours_spent', 
        'type', 
        'status'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}