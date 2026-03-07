<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.permission.index', compact('permissions'));
    }

    public function add()
    {
        return view('admin.permission.add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Permission::create(['name' => $request->name]);
            return redirect()->route('admin.permission.list')->with('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Permission $permission)
    {
        return view('admin.permission.edit', compact('permission'));
    }

    public function editPost(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('admin.permission.list')->with('success', 'Permission updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permission.list')->with('success', 'Permission deleted successfully.');
    }
}
