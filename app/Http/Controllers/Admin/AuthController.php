<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful.');
        } else {
            return redirect()->back()->withErrors('Invalid credentials.')
                ->withInput();
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login')->with('success', 'Logout successful.');
    }

    public function userList()
    {
        $user = auth()->user();
        $query = User::with('company', 'roles')->orderBy('created_at', 'desc');

        if ($user->hasRole('Super Admin')) {
            // Super Admin sees everyone
        } elseif ($user->hasRole('Property Admin')) {
            // Company Owner sees only their company's users
            $query->where('company_id', $user->company_id);
        } else {
            // Others see only themselves (or could be restricted further depending on requirement)
            $query->where('id', $user->id);
        }

        $users = $query->paginate(10);
        return view('admin.user.list', compact('users'));
    }

    public function userAdd()
    {
        $roles = Role::all();
        $companies = Company::where('status', 'active')->get();
        return view('admin.user.add', compact('roles', 'companies'));
    }

    public function userAddPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'is_verified' => 'boolean',
            'role' => 'required|exists:roles,name',
            'company_id' => 'nullable|exists:companies,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        try {
            $admin = auth()->user();

            // Role assignment validation
            if ($admin->hasRole('Super Admin')) {
                if ($request->role !== 'Super Admin') {
                    return redirect()->back()->with('error', 'Super Admins can only create other Super Admins.')->withInput();
                }
            } else {
                if ($request->role === 'Super Admin') {
                    return redirect()->back()->with('error', 'You are not authorized to assign the Super Admin role.')->withInput();
                }
            }

            $data = $request->except(['password', 'role', 'avatar', 'is_verified']);
            $data['password'] = Hash::make($request->password);
            $data['is_verified'] = $request->has('is_verified') ? 1 : 0;

            if ($request->hasFile('avatar')) {
                $imageName = time() . '.' . $request->avatar->extension();
                $request->avatar->move(public_path('uploads/avatar'), $imageName);
                $data['avatar'] = 'uploads/avatar/' . $imageName;
            }

            // Auto Generate Agent ID
            $agentId = 'AGT-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            while (User::where('agent_id', $agentId)->exists()) {
                $agentId = 'AGT-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            }
            $data['agent_id'] = $agentId;

            // Role-based Company ID
            $admin = auth()->user();
            if (!$admin->hasRole('Super Admin')) {
                $data['company_id'] = $admin->company_id;
            }

            $user = User::create($data);
            $user->assignRole($request->role);

            return redirect()->route('admin.user.list')->with('success', 'User created successfully.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $exception->getMessage());
        }
    }

    public function userEdit(User $user)
    {
        $roles = Role::all();
        $companies = Company::where('status', 'active')->get();
        $userRole = $user->roles->first()?->name;
        return view('admin.user.edit', compact('user', 'roles', 'companies', 'userRole'));
    }

    public function userEditPost(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'role' => 'required|exists:roles,name',
            'company_id' => 'nullable|exists:companies,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        try {
            $admin = auth()->user();

            // Role assignment validation
            if ($admin->hasRole('Super Admin')) {
                if ($request->role !== 'Super Admin') {
                    return redirect()->back()->with('error', 'Super Admins can only assign the Super Admin role.')->withInput();
                }
            } else {
                if ($request->role === 'Super Admin') {
                    return redirect()->back()->with('error', 'You are not authorized to assign the Super Admin role.')->withInput();
                }
            }

            $data = $request->except(['password', 'role', 'avatar', 'is_verified']);
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            $data['is_verified'] = $request->has('is_verified') ? 1 : 0;

            if ($request->hasFile('avatar')) {
                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }
                $imageName = time() . '.' . $request->avatar->extension();
                $request->avatar->move(public_path('uploads/avatar'), $imageName);
                $data['avatar'] = 'uploads/avatar/' . $imageName;
            }

            // Keep company restricted for non-super-admins during edit
            $admin = auth()->user();
            if (!$admin->hasRole('Super Admin')) {
                $data['company_id'] = $admin->company_id;
            }

            $user->update($data);
            $user->syncRoles([$request->role]);

            return redirect()->route('admin.user.list')->with('success', 'User updated successfully.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $exception->getMessage());
        }
    }

    public function userDelete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.list')->with('success', 'User deleted successfully.');
    }
}
