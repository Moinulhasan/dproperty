<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    //
    public function appSettings()
    {
        return view('admin.settings.list');
    }
}
