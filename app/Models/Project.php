<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_name',
        'client_id',
        'description',
        'total_hours',
        'hourly_rate',
        'status',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function consultants()
    {
        return $this->belongsToMany(User::class, 'consultant_project')
            ->withTimestamps();
    }
}
