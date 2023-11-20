<?php

namespace App\Http\Controllers;

use App\Models\Writelist;
use Illuminate\Http\Request;

class WritelistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $writelists = Writelist::all();

        return view('users.writelists.index', compact('writelists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.writelists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $writelist = Writelist::where('username', $request->username)->withTrashed()->first();
        if ($writelist) {
            $writelist->restore();
        } else {
            $request->validate([
                'username' => 'required',
            ]);

            Writelist::create($request->all());
        }

        return redirect('/writelist')->with('success', 'Writelist has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('users.writelists.show', compact('writelist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('users.writelists.edit', compact('writelist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Writelist $writelist)
    {
        $request->validate([
            'username' => 'required',
        ]);
        $writelist->update($request->all());

        return redirect('/writelist')->with('success', 'Writelist has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Writelist $writelist)
    {
        $writelist->delete();

        return redirect('/writelist')->with('success', 'Writelist has been deleted.');
    }
}
