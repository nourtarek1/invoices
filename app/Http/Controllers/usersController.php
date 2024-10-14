<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Permission;


class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::where('id', $request->role_id)->first();
            $permissions = $roles->permissions;
            return $permissions;
        }
        $roles = Role::all();
        return view('users.add_users', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //validate the fields
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|between:8,255|confirmed',
            'password_confirmation' => 'required'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        if ($request->role != null) {

            $user->roles()->attach($request->role);
            $user->save();
        }
        if ($request->permissions != null) {
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }   
        }
        return redirect('users');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $userRole = $user->roles->first();
        if ($userRole != null) {
            $rolePermissions = $userRole->allRolePermission;
        } else {
            $rolePermissions = null;
        }
        $userPermissions = $user->permissions;
        //  dd($rolePermission);

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $userRole,
            'rolePermissions' => $rolePermissions,
            'userPermissions' => $userPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != Null) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->roles()->detach();
        $user->permissions()->detach();
        if ($request->role != null) {
            $user->roles()->attach($request->role);
            $user->save();
        }
        if ($request->permissions != null) {
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }
        }
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/users');
    }
}
