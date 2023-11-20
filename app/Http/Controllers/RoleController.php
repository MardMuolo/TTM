<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->paginate(4);

        return view('roles.index', compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * 4);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::where('name', $request->name)->withTrashed()->first();

        if ($role) {
            $role->restore();
        } else {
            $request->validate([
                'name' => 'required',
            ]);
            Role::create($request->all());
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::where('id', $id)->firstOrFail();
        $users = $role->users()->get();
        $policies = DB::select('select * from role_police where role_id = ?', [$id]);
        $actions = ['create', 'read', 'update', 'delete'];
        $modelFiles = File::files(app_path('Models'));
        $models = [];
        foreach ($modelFiles as $file) {
            $models[] = pathinfo($file)['filename'];
        }

        return view('roles.show', [
            'models' => $models,
            'actions' => $actions,
            'role' => $role,
            'users' => $users,
    ], )->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // exit();
        $actions = ['create', 'read', 'update', 'delete'];
        $modelFiles = File::files(app_path('Models'));
        $models = [];
        foreach ($modelFiles as $file) {
            $models[] = pathinfo($file)['filename'];
        }

        return view('roles.edit', [
            'models' => $models,
            'actions' => $actions,
    ], compact('role'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $role->update($request->all());

        return redirect()->route('roles.index')
                        ->with('success', 'Role mis à jour avec succès');
    }

    public function modify(Request $request, $roleId)
    {
        DB::table('role_police')->where('role_id', '=', $roleId)->delete();
        $form = $request->form;
        $newTable = [];

        if ($form != null) {
            foreach ($form as $key => $value) {
                $table = explode('_', $key);
                $newTable[0] = $table[0];
                $newTable[1] = $table[1];
                DB::insert('insert into role_police(role_id, model, action) values(?, ?, ?)', [
                    $request->role_id, $newTable[0], $newTable[1],
                ]);
            }
        } else {
            return redirect()->route('roles.show', $request->role_id)->with('error', 'Veillez cochet au moins une case ');
        }

        return redirect()->route('roles.show', $request->role_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
                        ->with('success', 'Role supprimé avec succès');
    }
}
