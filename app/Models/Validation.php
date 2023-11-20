<?php

namespace App\Models;

use App\Models\Livrable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Validation extends Model
{
    use HasFactory;
    protected $table = 'validations';
    protected $fillable = ['nom_directeur','description', 'avis','livrable_id'];

    public function livrable()
    {
        return $this->belongsTo(Livrable::class);
    }
}
