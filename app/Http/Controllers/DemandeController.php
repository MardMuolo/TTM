<?php

namespace App\Http\Controllers;

use App\Models\CategoryDemande;
use App\Models\Demande;
use App\Models\Jalon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandes = Demande::orderBy('id', 'desc')->paginate(10); // Remplacez 10 par le nombre de demandes que vous souhaitez afficher par page
        $categoriesDemandes = CategoryDemande::all();
        $jalons = Jalon::all();

        return view('demande.index', compact('demandes', 'categoriesDemandes', 'jalons'));
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_demande_id' => 'required|exists:category_demandes,id',
            'jalon_id' => 'required|exists:jalons,id',
        ]);

        $data = $request->all();
        $data['category_demande_id'] = intval($data['category_demande_id']);
        $data['jalon_id'] = intval($data['jalon_id']);
        DB::beginTransaction();
        try {
            Demande::create($data);
            DB::commit();

            return redirect()->route('demande.index')->with('success', 'La demande a été créée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Une erreur est survenue lors de la création de la demande. Veuillez réessayer.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Demande $demande)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Demande $demande)
    {
        $users = User::all();

        return view('projects.tasks.edit', compact('demande', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Demande $demande)
    {
        $request->validate([
            'title' => 'required',
            'category_demande_id' => 'required|exists:category_demandes,id',
            'jalon_id' => 'required|exists:jalons,id',
        ]);

        $data = $request->all();
        $data['category_demande_id'] = intval($data['category_demande_id']);
        $data['jalon_id'] = intval($data['jalon_id']);

        DB::beginTransaction();
        try {
            $demande->update($data);
            DB::commit();

            return redirect()->route('demande.index')->with('success', 'La demande a été mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la demande. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demande $demande)
    {
        DB::beginTransaction();
        try {
            $demande->delete();
            DB::commit();

            return redirect()->route('demande.index')->with('success', 'La demande a été supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Une erreur est survenue lors de la suppression de la demande. Veuillez réessayer.');
        }
    }
}
