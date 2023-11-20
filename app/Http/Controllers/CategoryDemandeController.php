<?php

namespace App\Http\Controllers;

use App\Models\CategoryDemande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryDemandeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryDemandes = CategoryDemande::all();

        return view('demande.categories.index', compact('categoryDemandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    // ...

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        DB::beginTransaction();
        try {
            CategoryDemande::create($request->all());
            DB::commit();

            return redirect()->route('categoryDemande.index')->with('success', 'La demande de catégorie a été créée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Une erreur est survenue lors de la création de la demande de catégorie. Veuillez réessayer.');
        }
    }

    // ...
    /**
     * Display the specified resource.
     */
    public function show(CategoryDemande $categoryDemande)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryDemande $categoryDemande)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryDemande $categoryDemande)
    {
        $request->validate([
            'title' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $categoryDemande->update($request->all());
            DB::commit();

            return redirect()->route('categoryDemande.index')->with('success', 'La demande de catégorie a été mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la demande de catégorie. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryDemande $categoryDemande)
    {
        // Vérifier si la catégorie a des demandes associées
        if ($categoryDemande->demandes()->exists()) {
            return back()->withErrors(['title' => 'Impossible de supprimer la catégorie car elle possède des demandes associées.']);
        }

        // Supprimer la catégorie
        DB::beginTransaction();
        try {
            $categoryDemande->delete();
            DB::commit();

            return redirect()->route('categoryDemande.index')->with('success', 'La catégorie a été supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();

            return back();
        }
    }
}
