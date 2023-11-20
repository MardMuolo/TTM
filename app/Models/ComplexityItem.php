<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplexityItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description'];

    public function complexityTargets()
    {
        return $this->hasMany(ComplexityTarget::class);
    }

    public function projectComplexityItems()
    {
        return $this->hasMany(ProjectComplexityItem::class);
    }
}
