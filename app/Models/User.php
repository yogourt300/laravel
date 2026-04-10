<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function ownedProjects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function assignedProjects()
    {
        return $this->belongsToMany(Project::class, 'consultant_project')->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isCollaborateur(): bool
    {
        return $this->role === 'collaborateur';
    }
}
