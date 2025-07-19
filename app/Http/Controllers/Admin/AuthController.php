<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {

    }

    public function userList()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.user.list',compact('users'));
    }
}
