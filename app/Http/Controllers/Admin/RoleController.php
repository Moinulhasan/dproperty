<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    public function add()
    {
        $permissions = Permission::all();
        return view('admin.role.add', compact('permissions'));
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (strtolower($request->name) === 'super admin') {
            return redirect()->back()->withErrors(['name' => 'Cannot create another Super Admin role.'])->withInput();
        }

        try {
            $role = Role::create(['name' => $request->name]);
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
            return redirect()->route('admin.role.list')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Role $role, Request $request)
    {
        $roleCheck = $request->user()->roles()->where('name', 'Super Admin')->first();
        if (!$roleCheck) {
            return redirect()->route('admin.role.list')->withErrors(['error' => 'You Dont have access to edit this']);
        }
        $permissions = Permission::all();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    public function editPost(Request $request, Role $role)
    {
        $roleCheck = $request->user()->roles()->where('name', 'Super Admin')->first();
        if (!$roleCheck) {
            return redirect()->route('admin.role.list')->withErrors(['error' => 'The Super Admin role cannot be edited.']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (strtolower($request->name) === 'super admin' && $role->name !== 'Super Admin') {
            return redirect()->back()->withErrors(['name' => 'Cannot rename a role to Super Admin.'])->withInput();
        }

        try {
            $role->name = $request->name;
            $role->save();
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            } else {
                $role->syncPermissions([]);
            }
            return redirect()->route('admin.role.list')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function delete(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->route('admin.role.list')->withErrors(['error' => 'The Super Admin role cannot be deleted.']);
        }
        $role->delete();
        return redirect()->route('admin.role.list')->with('success', 'Role deleted successfully.');
    }
}
