<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
       
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(([
            'role_name' => 'required|max:255',
            'role_slug' => 'required|max:255',
        ]));
        $role = new Role();
        $role->name = $request->role_name;
        $role->slug = $request->role_slug;
        $listOfpermissions = explode(',', $request->roles_permissions); //create array f
        foreach ($listOfpermissions as $permission) {
            $permissions = new Permission();
            $permissions->name = $permission;
            $permissions->slug = strtolower(str_replace("", "-", $permission));
            $permissions->save();
            $role->save();
            $role->permissions()->attach($permissions->id);
        }

        return redirect('Role');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $role = Role::where('id', $id)->first();

        return view('role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::where('id', $id)->first();
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->role_name,
            'slug' => $request->role_slug,


        ]);
        $role->permissions()->delete();
        $role->permissions()->detach();

        $listOfpermissions = explode(',', $request->roles_permissions); //create array f
        foreach ($listOfpermissions as $permission) {
            $permissions = new Permission();
            $permissions->name = $permission;
            $permissions->slug = strtolower(str_replace("", "-", $permission));
            $permissions->save();
            $role->save();
            $role->permissions()->attach($permissions->id);
        }



        return redirect('Role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        $role = Role::findOrFail($id);
        $role->permissions()->delete();
        $role->delete();
        $role->permissions()->detach();
        return redirect('Role');
    }
}
