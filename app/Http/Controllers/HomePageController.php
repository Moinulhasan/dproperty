<?php

namespace App\Http\Controllers;

use App\Models\AppSettings;
use App\Models\ContactInquiry;
use App\Models\HomeSlider;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyRequest;
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
        $tags = Tags::where('status', 1)->get();
        $locations = Location::where('status', 1)->orderBy('name')->get();
        $categories = \App\Models\PropertyCategory::with('children')->whereNull('parent_id')->get();
        
        $articles = Article::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('homepage', compact(
            'sliders', 'services', 'testimonials', 'settings',
            'rent_properties', 'sale_properties', 'featured_properties',
            'neighborhoods', 'tags', 'locations', 'categories', 'articles'
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
        if ($request->filled('property_category_id')) {
            $input = $request->property_category_id;
            if (is_string($input) && str_contains($input, ',')) {
                $categoryIds = explode(',', $input);
            } else {
                $categoryIds = is_array($input) ? $input : [$input];
            }
            
            $allIds = [];
            foreach ($categoryIds as $id) {
                $allIds[] = $id;
                $category = \App\Models\PropertyCategory::find($id);
                if ($category && $category->parent_id === null) {
                    // Parent category selected, include all children
                    $childIds = $category->children->pluck('id')->toArray();
                    $allIds = array_merge($allIds, $childIds);
                }
            }
            $query->whereIn('property_category_id', array_unique($allIds));
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
        $categories = \App\Models\PropertyCategory::with('children')->whereNull('parent_id')->get();

        $properties = $query->paginate(12)->withQueryString();

        return view('pages.listings', compact('settings', 'title', 'properties', 'locations', 'categories'));
    }

    public function locationProperties($id, Request $request)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $location = Location::findOrFail($id);

        $query = Property::where('status', 1)
            ->where('location_id', $id)
            ->orderBy('created_at', 'desc');

        if ($request->filled('property_category_id')) {
            $categoryId = $request->property_category_id;
            $category = \App\Models\PropertyCategory::find($categoryId);
            if ($category && $category->parent_id === null) {
                $childIds = $category->children->pluck('id')->toArray();
                $query->where(function($q) use ($categoryId, $childIds) {
                    $q->where('property_category_id', $categoryId)
                      ->orWhereIn('property_category_id', $childIds);
                });
            } else {
                $query->where('property_category_id', $categoryId);
            }
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
        $categories = \App\Models\PropertyCategory::with('children')->whereNull('parent_id')->get();

        $properties = $query->paginate(12)->withQueryString();
        $title = 'Properties in ' . $location->name;

        return view('pages.location_properties', compact('settings', 'title', 'properties', 'locations', 'categories', 'location'));
    }

    public function blog()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $articles = Article::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('pages.blog', compact('settings', 'articles'));
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

    public function service()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $services = Services::orderBy('created_at', 'desc')
            ->where('status', 1)
            ->get();
        $tags = Tags::where('status', 1)->get();
        return view('pages.service', compact('settings', 'services', 'tags'));
    }

    public function postProperty()
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $tags = Tags::where('status', 1)->get();
        return view('pages.post_property', compact('settings', 'tags'));
    }

    public function postPropertySubmit(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'want_to' => 'required|in:Sale,Rent',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        PropertyRequest::create([
            'want_to' => $request->want_to,
            'property_type' => $request->property_type,
            'property_category' => $request->property_category,
            'furnished_type' => $request->furnished_type,
            'facing' => $request->facing,
            'sft' => $request->sft,
            'price' => $request->price,
            'address' => $request->address,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Your property has been submitted successfully! Our team will review it shortly.');
    }

    public function contactInquirySubmit(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactInquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}

