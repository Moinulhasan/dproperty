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

    public function privacy()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        return view('pages.privacy_policy',compact('settings'));
    }
    public function sitemap()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        return view('pages.sitemap',compact('settings'));
    }
    public function terms()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        return view('pages.tc',compact('settings'));
    }

    public function property_details($id)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        // For now, we return a mock property view since dynamic data integration is a future step
        return view('pages.property_details', compact('settings'));
    }

    public function buy()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $title = "Properties For Sale";
        return view('pages.listings', compact('settings', 'title'));
    }

    public function sell()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $title = "Sell Your Property";
        return view('pages.listings', compact('settings', 'title'));
    }

    public function rent()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $title = "Properties For Rent";
        return view('pages.listings', compact('settings', 'title'));
    }
}
