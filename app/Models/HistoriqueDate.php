<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueDate extends Model
{
    use HasFactory;

    protected $table = 'historique_date';
    protected $fillable = [
        'project_optionttm_jalon_id',
        'date_initiale',
        'date_repouser',
    ];

    public function projectOptionttmJalon()
    {
        return $this->belongsTo(ProjectOptionttmJalon::class);
    }
}
