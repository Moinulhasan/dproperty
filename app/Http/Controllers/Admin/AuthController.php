<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

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
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.user.list', compact('users'));
    }

    public function userAdd()
    {
        return view('admin.user.add');
    }

    public function userAddPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('admin.user.list')->with('success', 'User created successfully.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('errors', 'Something went wrong.');
        }
    }

    public function userEdit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function userEditPost(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return redirect()->route('admin.user.list')->with('success', 'User updated successfully.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('errors', 'Something went wrong.');
        }
    }

    public function userDelete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.list')->with('success', 'User deleted successfully.');
    }
}
