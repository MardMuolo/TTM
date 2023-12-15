<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectComplexityItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function complexityItem()
    {
        return $this->belongsTo(ComplexityItem::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
