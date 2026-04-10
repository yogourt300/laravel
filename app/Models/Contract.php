<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'included_hours', 'extra_hourly_rate'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
