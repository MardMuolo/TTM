<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplexityTarget extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'complexity_item_id'];

    public function complexityItem()
    {
        return $this->belongsTo(ComplexityItem::class);
    }

    public function projectComplexityTargets()
    {
        return $this->hasMany(ProjectComplexityTarget::class);
    }
}
