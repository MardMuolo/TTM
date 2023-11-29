<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jalon;
use App\Models\Project;
use App\Models\Direction;
use App\Models\OptionTtm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportingController extends Controller
{
  
    public function index()
    {
        //
          
        $projetSoumis =  Project::where('status',env('projetSoumis'))->get()->count();  
        $projetEncours =  Project::where('status',env('projetenCours'))->get()->count();  
        $projetFinis =  Project::where('status',env('projetTerminer'))->get()->count(); 
       
       
        // $projets = DB::table('projects')
        //     ->join('project_users', 'projects.id','=','project_users.project_id')
        //     ->join('users', 'users.id','=','project_users.user_id')
        //     ->join('direction_users', 'users.id', '=','direction_users.user_id')
        //     ->join('directions', 'directions.id', '=','direction_users.user_id')
        //     ->groupBy('directions.name')
        //     ->select(DB::raw('count(*) as nb_projet, directions.name'))
        
            
        //     ->get() ;

       // die($projets);


        $directions = DB::table('directions')
                    ->select('id','name', DB::raw("(SELECT COUNT(pu.project_id) FROM direction_users du, users u,
                     project_users pu WHERE directions.id = du.direction_id AND du.user_id = u.id AND u.id = pu.user_id AND pu.role = 'projectOwner' GROUP BY du.direction_id) AS nb_projet"),
                     DB::raw("(SELECT COUNT(pu.project_id) FROM direction_users du, users u, project_users pu, projects p WHERE directions.id = du.direction_id 
                     AND du.user_id = u.id AND u.id = pu.user_id AND pu.project_id = p.id AND pu.role = 'projectOwner' AND p.status = 'finish' GROUP BY du.direction_id) AS nb_projetFinis")
                     )->get()
                    ;

       // die($directions);
       
        $users = User::all();
        $annee = date('Y');
        $annePrec = $annee-1;

        $janv =  Project::whereBetween('endDate',[$annee.'-01-01',$annee.'-01-30'])->get()->count();
        $fev =  Project::whereBetween('enDdate',[$annee.'-02-01',$annee.'-02-30'])->get()->count(); 
        $mars =  Project::whereBetween('endDate',[$annee.'-03-01',$annee.'-03-30'])->get()->count();
        $avril =  Project::whereBetween('endDate',[$annee.'-04-01',$annee.'-04-30'])->get()->count();  
        $mai =  Project::whereBetween('endDate',[$annee.'-05-01',$annee.'-05-30'])->get()->count(); 
        $juin =  Project::whereBetween('endDate',[$annee.'-06-01',$annee.'-06-30'])->get()->count();   
        $juillet =  Project::whereBetween('endDate',[$annee.'-07-01',$annee.'-07-30'])->get()->count(); 
        $aout =  Project::whereBetween('endDate',[$annee.'-08-01',$annee.'-08-30'])->get()->count();
        $sep =  Project::whereBetween('endDate',[$annee.'-09-01',$annee.'-09-30'])->get()->count();
        $oct =  Project::whereBetween('endDate',[$annee.'-10-01',$annee.'-10-30'])->get()->count();
        $nov =  Project::whereBetween('endDate',[$annee.'-11-01',$annee.'-11-30'])->get()->count();
        $dec =  Project::whereBetween('endDate',[$annee.'-12-01',$annee.'-12-30'])->get()->count();   
        
        $janv2 =  Project::whereBetween('endDate',[$annePrec.'-01-01',$annePrec.'-01-30'])->get()->count();
        $fev2 =  Project::whereBetween('enDdate',[$annePrec.'-02-01',$annePrec.'-02-30'])->get()->count(); 
        $mars2 =  Project::whereBetween('endDate',[$annePrec.'-03-01',$annePrec.'-03-30'])->get()->count();
        $avril2 =  Project::whereBetween('endDate',[$annee.'-04-01',$annePrec.'-04-30'])->get()->count();  
        $mai2 =  Project::whereBetween('endDate',[$annePrec.'-05-01',$annePrec.'-05-30'])->get()->count(); 
        $juin2 =  Project::whereBetween('endDate',[$annePrec.'-06-01',$annePrec.'-06-30'])->get()->count();   
        $juillet2 =  Project::whereBetween('endDate',[$annePrec.'-07-01',$annePrec.'-07-30'])->get()->count(); 
        $aout2 =  Project::whereBetween('endDate',[$annePrec.'-08-01',$annePrec.'-08-30'])->get()->count();
        $sep2 =  Project::whereBetween('endDate',[$annePrec.'-09-01',$annePrec.'-09-30'])->get()->count();
        $oct2 =  Project::whereBetween('endDate',[$annePrec.'-10-01',$annePrec.'-10-30'])->get()->count();
        $nov2 =  Project::whereBetween('endDate',[$annePrec.'-11-01',$annePrec.'-11-30'])->get()->count();
        $dec2 =  Project::whereBetween('endDate',[$annePrec.'-12-01',$annePrec.'-12-30'])->get()->count();      
        
        
        
        $datadonut = json_encode( [$projetSoumis,$projetEncours,$projetFinis] );

        $data = json_encode( [$janv,6,$mars,10,$mai,$juin,5,$aout,$sep,$oct,$nov,10] );

        $data2 = json_encode( [15,$fev2,8,10,$mai2,$juin2,20,$aout2,$sep2,$oct2,15,$dec2] );
        
        $projetsEncours = Project::whereBetween('endDate',[$annee.'-01-01',$annee.'-12-31'])->get()->count(); 
        $projetsPrec = Project::whereBetween('endDate',[$annePrec.'-01-01',$annePrec.'-12-31'])->get()->count(); 
        
        
        return view('reporting.index', compact('projetSoumis','projetEncours','projetFinis','data','data2','datadonut','directions','users','projetsEncours','projetsPrec','annee','annePrec')); 
    }

    public function rapport(Request $request){


        $statut = $request->statut??null;
        $direction = $request->direction??null;
        $user = $request->user??null;
        $optionttm = $request->optionttm??null;
        $jalon = $request->jalon??null;
        $debut = $request->debut??null;
        $fin = $request->fin??null;

        $jalons=Jalon::all();
        $projets = Project::orderBy('id');       
       

       if ($direction){
            $projets= DB::table('projects')
                ->select('id','name', DB::raw("(SELECT (direction.name) FROM direction_users du, users u,
                project_users pu, projects p WHERE p.id = pu.project_id 
                AND pu.user_id = u.id AND u.id = du.user_id AND  du.direction_id = directions.id
                GROUP BY du.direction_id) AS dn"),
                );
                    
            $projets->where('direction.name', $direction);
              
                 }

        if ($statut){
            $projets->where('status', $statut);
        }
        if ($user){
            $projets->where('projectOwner', $user);
        }
        if ($optionttm){
            $projets = Project::select('projet.*', 'optionttm.nom')
            ->join('project_optionttm_jalon', 'project.id', '=', 'project_optionttm_jalon.project_id')
            ->join('optionttm', 'project_optionttm_jalon.optionttm_id', '=', 'optionttm.id')
            ->orderBy('optionttm.nom')
            ->get();
          // $projets->has('optionttm');//
          $projets->where('optionttm.nom', $optionttm);
            }

        if ($jalon){
            $projets = Project::select('projet.*', 'jalon.designation')
            ->join('project_optionttm_jalon', 'project.id', '=', 'project_optionttm_jalon.project_id')
            ->join('jalon', 'project_optionttm_jalon.jalon_id', '=', 'jalon.id_')
            ->orderBy('jalon.designation')
            ->get();
            
            $projets->where('jalon.designation', $jalon);
        
         }

        if ($debut and $fin){
            $projets->whereBetween('endDate',[$debut,$fin]);
        }
        // if (){
        //     $projets->where('', $direction);
        // }
        $projets = $projets->get();
        $directions = Direction::all();
        $optionttms =  OptionTtm ::all();
        $projectOwners = Project::all();
        // die($projectOwners);
        $i = 1;
        $tab=['yellow','orange','secondary'];
        return view('reporting.rapport', compact('projets', 'i','directions','projectOwners','optionttms','statut','direction','user','optionttm','jalons','tab'));
  }

        

    


}

