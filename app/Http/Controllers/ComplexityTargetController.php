<?php

namespace App\Http\Controllers;

use App\Models\ComplexityItem;
use App\Models\ComplexityTarget;
use Illuminate\Http\Request;

class ComplexityTargetController extends Controller
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
        //
        //dd($request->route());
        $request->validate([
            'name' => 'required|max:255',
            'value' => 'required|min:0'
        ]);

        $complexityItem = ComplexityItem::findOrFail($request->item);

        if($complexityItem->complexityTargets()->get()->where('value', '=', $request->value)->isEmpty()) {
            $complexityItem->complexityTargets()->create([
                'name' => $request->name,
                'value' => $request->value, 
            ]);

            $message = 'Target crée avec succès';
            $status = 'success';
        }else{
            $message = 'Target avec ce score existe déjà';
            $status = 'danger';
        }
        

        return redirect()->back()->with(['message'=> $message, 'status'=>$status]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ComplexityTarget $complexityTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComplexityTarget $complexityTarget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $complexityTarget)
    {
        //
        
        $request->validate([
            'name' => 'required|max:255',
            'value' => 'required|min:0'
        ]);

        $complexityTarget = ComplexityTarget::findOrFail($complexityTarget);

        $complexityTarget->update([
            "name"=>$request->name,
            "value"=>$request->value
        ]);

        $message = 'Target crée avec succès';
        $status = 'success';

        return redirect()->back()->with(['message'=> $message, 'status'=>$status]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $complexityTarget)
    {
        //
        $complexityTarget = ComplexityTarget::findOrFail($complexityTarget);

        $complexityTarget->delete();

        return redirect()->back()->with('success', 'Target supprimé avec succes');
    }
}
