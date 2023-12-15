<?php

namespace App\Http\Controllers;

use App\Models\ComplexityItem;
use Illuminate\Http\Request;

class ComplexityItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = ComplexityItem::orderBy('id', 'desc')->paginate(5);
        return view("complexities.items.index", ['items' => $items]);
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
            'name' => 'required|unique:complexity_items|max:100'
        ]);

        ComplexityItem::create([
            'name' => $request->name,
            'description' => $request->description, 
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $complexityItem)
    {
        //
        $item = ComplexityItem::find($complexityItem);

        $targets = $item->complexityTargets()->orderBy('value')->paginate(5);

        return view("complexities.items.show", ["complexityItem" => $item, "targets" => $targets]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComplexityItem $complexityItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $complexityItem)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:300',
        ]);


        $complexityItem = ComplexityItem::findOrFail($complexityItem);

        $complexityItem->update([
            'name' => $request->name,
            'description' => $request->description, 
        ]);

        
        return redirect()->back()->with('success', 'Point de complexité modifié avec succes');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $complexityItem)
    {
        //
        $complexityItem = ComplexityItem::findOrFail($complexityItem);

        $complexityItem->delete();

        return redirect()->back()->with('success', 'Point de complexité supprimé avec succes');
    }
}
