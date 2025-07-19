<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use App\Models\Services;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    //
    public function index()
    {
        $sliders = HomeSlider::orderBy('created_at', 'desc')
            ->where('status', 1)
            ->get();
        $services = Services::orderBy('created_at', 'desc')
            ->where('status', 1)
            ->get();
        return view('homepage',compact('sliders','services'));
    }
}
