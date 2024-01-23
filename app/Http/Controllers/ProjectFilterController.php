<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectFilterController extends Controller
{
    public function index($status)
    {
        $tmp=$status;

        if($status==env('jalonEnRetard')){
            $tmp="En cours";
        }
        $currentDate = Carbon::now()->toDateString();


        $projects = Project::join('project_optionttm_jalon', 'projects.id', '=', 'project_optionttm_jalon.project_id')
            // ->join('optionttm_jalon', 'project_optionttm_jalon.option_ttm_id', '=', 'optionttm_jalon.id')
            ->join('jalons', 'project_optionttm_jalon.jalon_id', '=', 'jalons.id')
            ->where('project_optionttm_jalon.status', $tmp)
            ->whereDate('project_optionttm_jalon.echeance', '<', $currentDate)
            ->distinct()
            ->get();
        $i = 1;
        $tab = ['yellow', 'orange', 'secondary'];
        return view('reporting.projectByJalon', compact('projects', 'status', 'i', 'tab'));
    }


    public function get_projectBy(Request $request)
    {


        $optionValue = "valeur de l'option"; // Remplacez par la valeur de l'option_ttms souhaitée

        $projects = Project::join('project_optionttm_jalon', 'projects.id', '=', 'project_optionttm_jalon.project_id')
            ->join('optionttm_jalon', 'project_optionttm_jalon.option_ttm_id', '=', 'optionttm_jalon.id')
            ->join('jalons', 'project_optionttm_jalon.jalon_id', '=', 'jalons.id')
            ->join('option_ttms', 'optionttm_jalon.option_ttm_id', '=', 'option_ttms.id')
            ->where('option_ttms.column_name', $optionValue)
            ->where('jalons.designation', 'test')
            ->where('project_optionttm_jalon.status', 'en test')
            ->get();
        return response()->json(count($projects), Response::HTTP_OK);
    }
}
