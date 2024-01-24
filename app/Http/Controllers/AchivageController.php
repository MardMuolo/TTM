<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class AchivageController extends Controller
{
    public function index(){
        $projects=Project::all();
        // dd($projects);
        $i = 1;

        $tab = ['yellow', 'orange', 'secondary'];
        return view('archivage.index',compact('projects', 'i', 'tab'));

    }
}
