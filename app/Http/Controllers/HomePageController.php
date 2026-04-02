<?php

namespace App\Http\Controllers;

use App\Models\AppSettings;
use App\Models\HomeSlider;
use App\Models\Location;
use App\Models\Property;
use App\Models\Services;
use App\Models\Tags;
use App\Models\Article;
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

        // Dynamic Properties for sections
        $rent_properties = Property::where('status', 1)
            ->where('property_status', 'Rent')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $sale_properties = Property::where('status', 1)
            ->where('property_status', 'Sell')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $featured_properties = Property::where('status', 1)
            ->where('is_home_featured', 1)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Neighborhoods from Location table
        $neighborhoods = Location::where('status', 1)
            ->orderBy('name')
            ->get()
            ->map(function ($location) {
                return (object) [
                    'id' => $location->id,
                    'name' => $location->name,
                    'image' => $location->image,
                    'properties_count' => Property::where('status', 1)->where('location_id', $location->id)->count(),
                ];
            });
        $tags = Tags::where('status', 1)
            ->get();

        $locations = Location::where('status', 1)->orderBy('name')->get();
        $property_types = Property::where('status', 1)->distinct()->pluck('property_type')->filter()->values();
        
        $articles = Article::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('homepage', compact(
            'sliders', 'services', 'testimonials', 'settings',
            'rent_properties', 'sale_properties', 'featured_properties',
            'neighborhoods', 'tags', 'locations', 'property_types', 'articles'
        ));
    }

    public function property_details($id)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $property = Property::with(['amenities', 'user.company', 'detailValues.detail'])->findOrFail($id);

        $recommended_properties = Property::where('status', 1)
            ->where('location_id', $property->location_id)
            ->where('id', '!=', $id)
            ->with(['detailValues.detail'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('pages.property_details', compact('settings', 'property', 'recommended_properties'));
    }

    public function buy(Request $request)
    {
        return $this->handle_property_listing($request, 'Buy', 'Properties For Buy');
    }

    public function sell(Request $request)
    {
        return $this->handle_property_listing($request, 'Sell', 'Properties For Sell');
    }

    public function rent(Request $request)
    {
        return $this->handle_property_listing($request, 'Rent', 'Properties For Rent');
    }

    private function handle_property_listing(Request $request, $property_status, $title)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();

        $query = Property::where('status', 1)
            ->where('property_status', $property_status)
            ->orderBy('created_at', 'desc');

        if ($request->filled('location')) {
            $query->where('location_id', $request->location);
        }
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        if ($request->filled('bedrooms') && $request->bedrooms != 'any') {
            if ($request->bedrooms == '5') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', $request->bedrooms);
            }
        }
        if ($request->filled('min_area')) {
            $query->where('area', '>=', $request->min_area);
        }
        if ($request->filled('max_area')) {
            $query->where('area', '<=', $request->max_area);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $locations = Location::where('status', 1)->orderBy('name')->get();
        $property_types = Property::where('status', 1)->distinct()->pluck('property_type')->filter()->values();

        $properties = $query->paginate(12)->withQueryString();

        return view('pages.listings', compact('settings', 'title', 'properties', 'locations', 'property_types'));
    }

    public function locationProperties($id, Request $request)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $location = Location::findOrFail($id);

        $query = Property::where('status', 1)
            ->where('location_id', $id)
            ->orderBy('created_at', 'desc');

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        if ($request->filled('property_status')) {
            $query->where('property_status', $request->property_status);
        }
        if ($request->filled('bedrooms') && $request->bedrooms != 'any') {
            if ($request->bedrooms == '5') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', $request->bedrooms);
            }
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $locations = Location::where('status', 1)->orderBy('name')->get();
        $property_types = Property::where('status', 1)->distinct()->pluck('property_type')->filter()->values();

        $properties = $query->paginate(12)->withQueryString();
        $title = 'Properties in ' . $location->name;

        return view('pages.location_properties', compact('settings', 'title', 'properties', 'locations', 'property_types', 'location'));
    }

    public function article_details($slug)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $article = Article::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        // Increment views
        $article->increment('views');

        $recent_articles = Article::where('status', 1)
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.article_details', compact('settings', 'article', 'recent_articles'));
    }

    public function contact()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $tags = Tags::where('status', 1)->get();
        return view('pages.contact', compact('settings', 'tags'));
    }
}

