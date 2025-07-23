<?php

namespace App\Http\Controllers;

use App\Models\AppSettings;
use App\Models\HomeSlider;
use App\Models\Property;
use App\Models\Services;
use App\Models\Tags;
use App\Models\Testimonial;
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
        $testimonials = Testimonial::orderBy('created_at', 'desc')
            ->where('status', 1)
            ->get();
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $properties = Property::orderBy('created_at', 'desc')
            ->where('status', 1)
            ->get();
        $tags = Tags::where('status', 1)
            ->get();
        return view('homepage', compact('sliders', 'services', 'testimonials', 'settings','properties','tags'));
    }
}
