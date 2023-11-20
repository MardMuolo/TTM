<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = ProjectType::orderBy('id', 'desc')->paginate(10);
        return view("projectTypes.index", ['types' => $types]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:project_types|max:200',
            'description' => 'required'
        ]);

        ProjectType::create([
            'name' => $request->name,
            'description' => $request->description, 
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectType $projectType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectType $projectType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectType $projectType)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:300',
        ]);


        $projectType->update([
            'name' => $request->name,
            'description' => $request->description, 
        ]);

        
        return redirect()->back()->with('success', 'Type de projet modifié avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectType $projectType)
    {
        //
        $projectType->delete();

        return redirect()->back()->with('success', 'Type de projet supprimé avec succes');
    }
}
