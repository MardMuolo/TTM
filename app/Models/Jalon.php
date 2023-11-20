<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalon extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function optionttms()
    {
        return $this->belongsToMany(OptionTtm::class, 'optionttm_jalon', 'option_ttm_id', 'jalon_id');
    }

    public function options()
    {
        return $this->belongsToMany(OptionTtm::class, 'project_optionttm_jalon', 'jalon_id', 'option_ttm_id');
    }

    public function projectOptionttmJalons()
    {
        return $this->belongsToMany(ProjectOptionttmJalon::class, 'project_optionttm_jalon', 'jalon_id', 'option_ttm_id')
            ->withPivot('debutDate', 'echeance', 'status');
    }

    public function demandes()
    {
        return $this->belongsToMany(Demande::class);
    }
}
