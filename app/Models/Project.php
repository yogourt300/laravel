<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'name', 'description', 'status'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function collaborateurs()
    {
        return $this->belongsToMany(User::class, 'consultant_project')->withTimestamps();
    }
}
