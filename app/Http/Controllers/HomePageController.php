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

        // Neighborhoods (routes that have at least one location-featured property)
        $neighborhoods = Property::where('status', 1)
            ->where('is_location_featured', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('route')
            ->map(function ($property) {
                return (object) [
                    'id' => $property->id,
                    'name' => $property->route,
                    'image' => $property->feature_image,
                    'properties_count' => Property::where('status', 1)->where('route', $property->route)->count(),
                ];
            });
        $tags = Tags::where('status', 1)
            ->get();

        $locations = Property::where('status', 1)->distinct()->pluck('route')->filter()->values();
        $property_types = Property::where('status', 1)->distinct()->pluck('property_type')->filter()->values();
//        dd($rent_properties);
        return view('homepage', compact(
            'sliders', 'services', 'testimonials', 'settings',
            'rent_properties', 'sale_properties', 'featured_properties',
            'neighborhoods', 'tags', 'locations', 'property_types'
        ));
    }

    public function property_details($id)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        $property = Property::with(['amenities', 'user.company'])->findOrFail($id);

        return view('pages.property_details', compact('settings', 'property'));
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
            $query->where('route', $request->location);
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

        $locations = Property::where('status', 1)->distinct()->pluck('route')->filter()->values();
        $property_types = Property::where('status', 1)->distinct()->pluck('property_type')->filter()->values();

        $properties = $query->paginate(12)->withQueryString();

        return view('pages.listings', compact('settings', 'title', 'properties', 'locations', 'property_types'));
    }

    public function article_details($slug)
    {
        $settings = AppSettings::where('site_name', 'dproperty')->first();

        $articles = [
            'buying-tips' => [
                'title' => '10 Important Things to Know Before Buying a Home',
                'category' => 'Buying Tips',
                'date' => 'Oct 24, 2023',
                'author' => 'Admin',
                'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80',
                'content' => 'Buying a home is one of the most significant financial decisions you will ever make. It involves careful planning, research, and consideration of various factors. Here are 10 important things you should know before you start your home-buying journey:

                    1. **Understand Your Budget:** Before you even look at houses, know how much you can afford. This includes your down payment, monthly mortgage, property taxes, and insurance.
                    2. **Get Pre-Approved for a Mortgage:** This gives you a clear idea of your price range and makes you a more attractive buyer to sellers.
                    3. **Check Your Credit Score:** A better credit score often means lower interest rates on your mortgage.
                    4. **Location is Everything:** Research neighborhoods for safety, schools, proximity to work, and future development plans.
                    5. **Home Inspection is Crucial:** Never skip a professional home inspection. It can reveal hidden issues like structural problems or outdated wiring.
                    6. **Think About Long-Term Needs:** Will the house accommodate your family in 5 or 10 years?
                    7. **Calculate Closing Costs:** These can add up to 2-5% of the purchase price, so budget accordingly.
                    8. **Don\'t Let Emotions Drive Your Decisions:** Stay objective and remember it\'s a financial investment as much as a personal one.
                    9. **Work with a Reliable Real Estate Agent:** A professional agent can guide you through the complexities of the market and negotiation.
                    10. **Factor in Maintenance Costs:** Owning a home comes with ongoing maintenance and repair expenses that you didn\'t have as a renter.',
            ],
            'market-trends' => [
                'title' => 'The Future of Real Estate: Trends to Watch in 2024',
                'category' => 'Market Trends',
                'date' => 'Oct 20, 2023',
                'author' => 'Editor',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
                'content' => 'As we approach 2024, the real estate market continues to evolve, shaped by technological advancements, environmental concerns, and changing lifestyle preferences. Here are the key trends that will define the property market in the coming year:

                    **1. Sustainable and Green Living:** Eco-friendly homes are no longer a niche market. Buyers are increasingly looking for energy-efficient appliances, solar panels, and sustainable building materials.

                    **2. Technology Integration (PropTech):** The use of AI in property searches, virtual reality for home tours, and blockchain for secure transactions is becoming standard.

                    **3. The Rise of Flex Spaces:** With remote work here to stay, homes with dedicated office spaces or multi-functional rooms are in high demand.

                    **4. Urban Decentralization:** Many are moving away from crowded city centers to suburban or rural areas that offer more space and lower costs, facilitated by telecommuting.

                    **5. Focus on Wellness:** Smart homes equipped with air purification systems, biophilic design elements, and spaces for physical activity are gaining popularity.',
            ],
            'interior-design' => [
                'title' => 'How to Maximize Your Space in a Small Apartment',
                'category' => 'Interior Design',
                'date' => 'Oct 15, 2023',
                'author' => 'Admin',
                'image' => 'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80',
                'content' => 'Living in a compact apartment doesn\'t mean you have to sacrifice comfort or style. With a little creativity and smart planning, you can make even the smallest space feel open and inviting.

                    **Use Multi-Functional Furniture:** Look for beds with built-in storage, foldable desks, or coffee tables that can double as dining tables.

                    **Maximize Vertical Space:** Install shelves all the way to the ceiling to store items you don\'t use daily. Use wall-mounted organizers for kitchen tools and bathroom supplies.

                    **Mirror, Mirror on the Wall:** Mirrors reflect light and create the illusion of more space. Placing a large mirror opposite a window can brighten up a room instantly.

                    **Declutter Regularly:** In a small space, every item counts. Be ruthless about getting rid of things you no longer need or use.

                    **Choose Light Colors:** Light and neutral colors on walls and furniture can make a room feel more spacious and airy.',
            ],
            'investment-strategy' => [
                'title' => 'Why Real Estate is Still the Best Long-Term Investment',
                'category' => 'Investment',
                'date' => 'Oct 10, 2023',
                'author' => 'Editor',
                'image' => 'https://images.unsplash.com/photo-1554469384-e58fac16e23a?auto=format&fit=crop&w=1200&q=80',
                'content' => 'Despite market fluctuations, real estate remains one of the most reliable and rewarding asset classes for long-term wealth building. Unlike stocks, real estate is a tangible asset that often appreciates in value over time.

                    **Appreciation Potential:** Historically, real estate values tend to increase, providing significant capital gains over the long term.

                    **Passive Income through Rentals:** Owning property allows you to generate a steady stream of rental income, which can supplement your salary or fund your retirement.

                    **Tax Advantages:** Real estate investors can benefit from various tax deductions, including mortgage interest, property taxes, and depreciation.

                    **A Hedge Against Inflation:** As the cost of living rises, property values and rental rates typically increase as well, protecting your purchasing power.

                    **Control Over Your Investment:** Unlike other investments, you have direct control over your property and can make improvements to increase its value.',
            ],
        ];

        $article = isset($articles[$slug]) ? (object)$articles[$slug] : null;

        if (!$article) {
            abort(404);
        }

        return view('pages.article_details', compact('settings', 'article', 'articles'));
    }
}

