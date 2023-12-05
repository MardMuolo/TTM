<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Livrable;
use App\Models\DemandeJalon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'required',
            'demande_jalon_id' => 'required|integer',
        ]);


        if ($request->hasFile('fichier')) {

            $namefile = date('ymdhis') . '.' . $request->fichier->extension();
            $path = $request->fichier->storeAs('livrable', $namefile);
            $publicPath = public_path('storage/livrable');
            File::ensureDirectoryExists($publicPath);
            File::delete($publicPath . '/' . $namefile);
            File::link(storage_path('app/' . $path), $publicPath . '/' . $namefile);
        }

        $livrable = Livrable::create([
            'demande_jalon_id' => $request->demande_jalon_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'fichier' => $path,
        ]);

        $demande = DemandeJalon::findOrFail($request->demande_jalon_id);
        $demande->status = env('demandeEnAttenteValidation');
        $demande->date_reelle = $livrable->created_at;
        $demande->save();

        $logMessage = 'a uploadé un fichier';
        if ($path) {
            $logMessage .= $path;
        }
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($demande)
            ->event('create')
            ->log($logMessage);

        return redirect()->back()->with(['message' => 'livrable déposé avec succes']);
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

    public function valider_livrable(Request $request, $livrable)
    {
        $livrable_id=Crypt::decrypt($livrable);
        $livrable = Livrable::findOrFail($livrable_id);
        
        $livrable->status = $request->Avis;
        $livrable->pv = Null;
        if ($request->Avis == env('livrableRevoquer')) {
            $livrable->pv = $request->description;
        }
        $statusDemande=[
            env('livrableValider')=>env('demandeSoumise'),
            env('livrableRevoquer')=>env('demandeRenvoyer'),
            env('livrableRejeter')=>env('demandeNonSoumise'),
            env('livrableEnAttente')=>env('demandeNonSoumise'),
        ];
        // dd($statusDemande[ $request->Avis]);


        $demandeJalon = DemandeJalon::findOrFail($livrable->demande_jalon_id);
        $demandeJalon->status =$statusDemande[ $request->Avis];
        $demandeJalon->save();
        $livrable->save();
        return redirect()->back()->with(['message' => 'validation du livrable avec success']);
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
        $livrable->status = $request->input('status', $request->Avis);


        $livrable->save();

        $demande = Demande::findOrFail($request->demande_id);
        $demande->status = env('demandeEnAttenteValidation');
        $demande->save();

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $livrable = Livrable::findOrFail($id);
        $livrable->delete();
        return redirect()->back();
    }
}