<?php
/*
Author: emmenuel badibanga
 emmanuelbadidanga250@gmail.com
*/

namespace App\Http\Controllers;

use App\Models\ProjectFiles;
use App\Http\Requests\StoreProjectFilesRequest;
use App\Http\Requests\UpdateProjectFilesRequest;

class ProjectFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $file = ProjectFile::orderBy('id', 'desc')->paginate(5);
        return view('projects.single', compact('file'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectFilesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectFiles $projectFiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectFiles $projectFiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectFilesRequest $request, ProjectFiles $projectFiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectFiles $projectFiles)
    {
        //
    }
}
