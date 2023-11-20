<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectComplexityTarget extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    public function complexityTarget()
    {
        return $this->belongsTo(ComplexityTarget::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
