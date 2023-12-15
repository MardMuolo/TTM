<?php

namespace App\Http\Controllers;

use App\Models\Livrable;
use App\Models\Validation;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;

class ValidationController extends Controller
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
    public function store(StoreValidationRequest $request)
    {
        $avis = $request->input('avis');
        $description = $request->input('description');
        $livrable_id = $request->input('livrable_id');
        // Vérifier si un avis existe déjà pour le livrable
        $avisExistant = Validation::where('livrable_id', $livrable_id)->first();
        if ($avisExistant) {
            // Mettre à jour l'avis existant
            $avisExistant->avis = $avis;
            $avisExistant->description = $description;
            $avisExistant->save();
        } else {
            // Créer un nouvel avis
            Validation::create([
                'avis' => $avis,
                'description' => $description,
                'livrable_id' => $livrable_id,
            ]);
        }
        $livrable = Livrable::find($livrable_id);
        $demande = $livrable->demande;
        if ($avis == 'Valider') {
            $demande->status = 'Soumis';
        } else {
            $demande->status = 'Attendu';
        }
        $demande->save();
        return redirect()->back()->with('success', 'L\'avis a été mis à jour avec succès.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Validation $validation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Validation $validation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateValidationRequest $request, Validation $validation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Validation $validation)
    {
        //
    }
}
