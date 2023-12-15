<?php

namespace App\Models;

use App\Models\Jalon;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionTtm extends Model
{
    use HasFactory;
    protected $fillable=['nom','minComplexite','maxComplexite'];

    public function jalons()
       {
           return $this->belongsToMany(Jalon::class,'optionttm_jalon', 'option_ttm_id', 'jalon_id');    
       }
       
       public function milestones()
       {
           return $this->belongsToMany(Jalon::class, 'project_optionttm_jalon', 'option_ttm_id', 'jalon_id');
       }
}
