<?php

namespace App\Http\Controllers;

use App\Models\Jalon;
use App\Models\OptionTtm;
use App\Models\OptionttmJalon;
use App\Http\Requests\StoreOptionTtmRequest;
use App\Http\Requests\UpdateOptionTtmRequest;

class OptionTtmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $optionTtms = OptionTtm::all();
        $jalons = Jalon::all();
        return view('optionsttm.index', compact('optionTtms','jalons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $optionTtms = OptionTtm::all();
        return view('optionsttm.create' , compact('optionTtms'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptionTtmRequest $request)
    {
        $optionTtm= OptionTtm::create([
            'nom' => $request->input('nom'),
            'minComplexite' => $request->input('minComplexite'),
            'maxComplexite' => $request->input('maxComplexite'),
        ]);
        $jalons = $request->input('jalons', []);
        $optionTtm->jalons()->attach($jalons);
        
        

        return redirect()->route('optionsttm.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OptionTtm $optionTtm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OptionTtm $optionTtm)
    {
        $jalons = Jalon::all();
        return view('optionsttm.edit', compact('optionTtm', 'jalons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptionTtmRequest $request, OptionTtm $optionTtm, $id)
    {
        
        $optionTtm->nom = $request->input('nom');
        $optionTtm->minComplexite = $request->input('minComplexite');
        $optionTtm->maxComplexite = $request->input('maxComplexite');
        $optionTtm->save();
        $jalons = $request->input('jalons', []);
        $optionTtm->jalons()->sync($jalons);
        return redirect()->route('optionsttm.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptionTtm $optionsttm)
    {
        $optionsttm->delete();
        return redirect()->route('optionsttm.index');
    }
}
