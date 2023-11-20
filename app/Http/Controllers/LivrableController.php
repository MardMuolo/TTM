<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Livrable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LivrableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livrable = Livrable::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'required',
            'demande_id' => 'required|integer',
        ]);
        
        $paths = [];
        
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            
            foreach ($files as $file) {
                $namefile = date('ymdhis') . '.' . $file->extension();
                $path = $file->storeAs('livrable', $namefile);
                
                $publicPath = public_path('storage/livrable');
                File::ensureDirectoryExists($publicPath);
                File::delete($publicPath.'/'.$namefile);
                File::link(storage_path('app/'.$path), $publicPath.'/'.$namefile);
        
                $paths[] = $path;
            }
        }
        
        $livrable = Livrable::create([
            'demande_id' => $request->demande_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'date_livraison' => $request->date_livraison,
            'file' => implode(',', $paths),
        ]);
    
        $demande = Demande::findOrFail($request->demande_id);
        $demande->status = 'En attente de validation';
        $demande->date_reelle = $livrable->created_at;
        $demande->save();
    
        $logMessage = 'a uploadé un fichier';
        if ($paths) {
            $logMessage .= ' '.implode(',', $paths);
        }
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($demande)
            ->event('create')
            ->log($logMessage);
    
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $livrable = Livrable::findOrFail($id);

    if ($request->hasFile('file')) {
        
        if ($livrable->file) {
            Storage::delete($livrable->file);
        }

        
        $files = $request->file('file');
        $filePaths = [];
        foreach ($files as $file) {
            $path = $file->store('livrables');
            $filePaths[] = $path;
        }
        $livrable->file = implode(',', $filePaths);
    }

    $livrable->nom = $request->input('nom', $livrable->nom);
    $livrable->demande_id = $request->input('demande_id', $livrable->demande_id);
    $livrable->description = $request->input('description', $livrable->description);
    

    $livrable->save();

    $demande = Demande::findOrFail($request->demande_id);
    $demande->status = 'En attente de validation';
    $demande->save();

    return redirect()->back();
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}