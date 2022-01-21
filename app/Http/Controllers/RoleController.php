<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.list', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validateForm($request);
        Role::create($request->only('name', 'persian_name'));
        return back()->with('successAdd', true);
    }

    public function validateForm($request)
    {
        $request->validate([
            'name' => 'required | min:3',
            'persian_name' => 'required | min:3'
        ]);
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load('permission' );
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->validateForm($request);
        $role->update($request->only('name', 'persian_name'));
        $role->refreshPermission($request->permissions);

        return back()->with('successUpdate', true);

    }
}
