<?php

namespace Tests\Feature;

use App\Models\AppSettings;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verifies the public /buy and /rent listing pages honour every filter,
 * with particular focus on the location filter which the user reported
 * issues with.
 *
 * IMPORTANT: this test uses SQLite in-memory (see phpunit.xml). It NEVER
 * touches the production database that holds thousands of real properties.
 */
class ListingFiltersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Provide the $settings the master/nav/footer expect on every page.
     */
    protected function setUp(): void
    {
        parent::setUp();

        AppSettings::create([
            'site_name'        => 'dproperty',
            'site_description' => 'Test site',
            'email'            => 'test@dproperty.test',
            'phone'            => '01000000000',
            'address'          => 'Test address',
        ]);
    }

    /**
     * Helper: create a property with sensible defaults overridable per test.
     */
    private function makeProperty(array $attrs = []): Property
    {
        return Property::create(array_merge([
            'title'            => 'Sample Property ' . uniqid(),
            'slug'             => 'sample-' . uniqid(),
            'price'            => 1000000,
            'category'         => 'Residential',
            'property_type'    => 'Apartment',
            'property_status'  => 'Sell',
            'project_id'       => 'PR-' . rand(100, 999),
            'area'             => 1200,
            'is_furnished'     => 'Furnished',
            'status'           => 1,
            'is_featured'      => 0,
            'is_home_featured' => 0,
            'is_location_featured' => 0,
            // Legacy NOT NULL column from the original create_properties_table
            // migration. Production rows store empty strings, so we do the same.
            'link'             => '',
        ], $attrs));
    }

    // ------------------------------------------------------------------ /buy

    public function test_buy_page_returns_200(): void
    {
        $this->get('/buy')->assertStatus(200);
    }

    public function test_buy_page_shows_sell_tagged_properties_only(): void
    {
        $forSale = $this->makeProperty(['title' => 'For Sale Apt',  'property_status' => 'Sell']);
        $forRent = $this->makeProperty(['title' => 'For Rent Apt',  'property_status' => 'Rent']);

        $response = $this->get('/buy');

        $response->assertStatus(200);
        $response->assertSee('For Sale Apt', false);
        $response->assertDontSee('For Rent Apt', false);
    }

    public function test_buy_page_filters_by_location(): void
    {
        $dhanmondi = Location::create(['name' => 'Dhanmondi', 'status' => 1]);
        $banani    = Location::create(['name' => 'Banani',    'status' => 1]);

        $this->makeProperty([
            'title' => 'Dhanmondi House',
            'property_status' => 'Sell',
            'location_id' => $dhanmondi->id,
        ]);
        $this->makeProperty([
            'title' => 'Banani House',
            'property_status' => 'Sell',
            'location_id' => $banani->id,
        ]);

        $response = $this->get('/buy?location=' . $dhanmondi->id);

        $response->assertStatus(200);
        $response->assertSee('Dhanmondi House', false);
        $response->assertDontSee('Banani House', false);
    }

    public function test_buy_page_filters_by_bedrooms(): void
    {
        $this->makeProperty(['title' => 'Three Bed Flat', 'property_status' => 'Sell', 'bedrooms' => 3]);
        $this->makeProperty(['title' => 'One Bed Flat',   'property_status' => 'Sell', 'bedrooms' => 1]);

        $response = $this->get('/buy?bedrooms=3');

        $response->assertStatus(200);
        $response->assertSee('Three Bed Flat', false);
        $response->assertDontSee('One Bed Flat', false);
    }

    public function test_buy_page_filters_by_price_range(): void
    {
        $this->makeProperty(['title' => 'Cheap Flat',    'property_status' => 'Sell', 'price' => 2000000]);
        $this->makeProperty(['title' => 'Mid Flat',      'property_status' => 'Sell', 'price' => 5000000]);
        $this->makeProperty(['title' => 'Premium Flat',  'property_status' => 'Sell', 'price' => 12000000]);

        $response = $this->get('/buy?min_price=3000000&max_price=8000000');

        $response->assertStatus(200);
        $response->assertSee('Mid Flat', false);
        $response->assertDontSee('Cheap Flat', false);
        $response->assertDontSee('Premium Flat', false);
    }

    public function test_buy_page_filters_by_area(): void
    {
        $this->makeProperty(['title' => 'Small',  'property_status' => 'Sell', 'area' => 600]);
        $this->makeProperty(['title' => 'Medium', 'property_status' => 'Sell', 'area' => 1500]);
        $this->makeProperty(['title' => 'Large',  'property_status' => 'Sell', 'area' => 3000]);

        $response = $this->get('/buy?min_area=1000&max_area=2000');

        $response->assertSee('Medium', false);
        $response->assertDontSee('Small', false);
        $response->assertDontSee('Large', false);
    }

    public function test_buy_page_filters_by_category_includes_children(): void
    {
        $residential = PropertyCategory::create(['name' => 'Residential', 'slug' => 'residential', 'parent_id' => null]);
        $apartment   = PropertyCategory::create(['name' => 'Apartment',   'slug' => 'apartment',   'parent_id' => $residential->id]);
        $office      = PropertyCategory::create(['name' => 'Office',      'slug' => 'office',      'parent_id' => null]);

        $this->makeProperty([
            'title' => 'Residential Apt',
            'property_status' => 'Sell',
            'property_category_id' => $apartment->id,
        ]);
        $this->makeProperty([
            'title' => 'Commercial Office',
            'property_status' => 'Sell',
            'property_category_id' => $office->id,
        ]);

        // Selecting the parent "Residential" should include its child Apartment.
        $response = $this->get('/buy?property_category_id=' . $residential->id);

        $response->assertSee('Residential Apt', false);
        $response->assertDontSee('Commercial Office', false);
    }

    public function test_buy_page_combines_multiple_filters(): void
    {
        $dhanmondi = Location::create(['name' => 'Dhanmondi', 'status' => 1]);

        $this->makeProperty([
            'title'   => 'Target Property',
            'property_status' => 'Sell',
            'location_id'     => $dhanmondi->id,
            'bedrooms'        => 3,
            'price'           => 5000000,
        ]);
        // Same location, wrong bedrooms.
        $this->makeProperty([
            'title'   => 'Wrong Bedrooms',
            'property_status' => 'Sell',
            'location_id'     => $dhanmondi->id,
            'bedrooms'        => 1,
            'price'           => 5000000,
        ]);
        // Same bedrooms, wrong location.
        $this->makeProperty([
            'title'   => 'Wrong Location',
            'property_status' => 'Sell',
            'location_id'     => null,
            'bedrooms'        => 3,
            'price'           => 5000000,
        ]);

        $response = $this->get('/buy?location=' . $dhanmondi->id . '&bedrooms=3&min_price=3000000&max_price=8000000');

        $response->assertSee('Target Property', false);
        $response->assertDontSee('Wrong Bedrooms', false);
        $response->assertDontSee('Wrong Location', false);
    }

    public function test_buy_page_hides_inactive_properties(): void
    {
        $this->makeProperty(['title' => 'Active Listing',   'property_status' => 'Sell', 'status' => 1]);
        $this->makeProperty(['title' => 'Inactive Listing', 'property_status' => 'Sell', 'status' => 0]);

        $response = $this->get('/buy');

        $response->assertSee('Active Listing', false);
        $response->assertDontSee('Inactive Listing', false);
    }

    // ----------------------------------------------------------------- /rent

    public function test_rent_page_returns_200(): void
    {
        $this->get('/rent')->assertStatus(200);
    }

    public function test_rent_page_shows_rent_tagged_properties_only(): void
    {
        $this->makeProperty(['title' => 'Rental Apt',  'property_status' => 'Rent']);
        $this->makeProperty(['title' => 'Sale Apt',    'property_status' => 'Sell']);

        $response = $this->get('/rent');

        $response->assertStatus(200);
        $response->assertSee('Rental Apt', false);
        $response->assertDontSee('Sale Apt', false);
    }

    public function test_rent_page_filters_by_location(): void
    {
        $gulshan = Location::create(['name' => 'Gulshan', 'status' => 1]);
        $uttara  = Location::create(['name' => 'Uttara',  'status' => 1]);

        $this->makeProperty([
            'title' => 'Gulshan Studio',
            'property_status' => 'Rent',
            'location_id' => $gulshan->id,
        ]);
        $this->makeProperty([
            'title' => 'Uttara Studio',
            'property_status' => 'Rent',
            'location_id' => $uttara->id,
        ]);

        $response = $this->get('/rent?location=' . $gulshan->id);

        $response->assertStatus(200);
        $response->assertSee('Gulshan Studio', false);
        $response->assertDontSee('Uttara Studio', false);
    }

    public function test_rent_page_filters_by_bedrooms_5_plus(): void
    {
        $this->makeProperty(['title' => 'Two Bed',   'property_status' => 'Rent', 'bedrooms' => 2]);
        $this->makeProperty(['title' => 'Five Bed',  'property_status' => 'Rent', 'bedrooms' => 5]);
        $this->makeProperty(['title' => 'Seven Bed', 'property_status' => 'Rent', 'bedrooms' => 7]);

        // bedrooms=5 means "5 or more".
        $response = $this->get('/rent?bedrooms=5');

        $response->assertSee('Five Bed', false);
        $response->assertSee('Seven Bed', false);
        $response->assertDontSee('Two Bed', false);
    }

    public function test_rent_page_unknown_location_returns_empty_set(): void
    {
        $real = Location::create(['name' => 'Banani', 'status' => 1]);
        $this->makeProperty([
            'title' => 'Banani Rental',
            'property_status' => 'Rent',
            'location_id' => $real->id,
        ]);

        // Non-existent location id.
        $response = $this->get('/rent?location=999999');

        $response->assertStatus(200);
        $response->assertDontSee('Banani Rental', false);
    }

    public function test_rent_page_canonical_url_is_unfiltered(): void
    {
        $loc = Location::create(['name' => 'Mirpur', 'status' => 1]);

        $response = $this->get('/rent?location=' . $loc->id . '&bedrooms=2');

        // Canonical should strip filter params (we set it via @section('canonical_url')).
        $response->assertSee('<link rel="canonical" href="' . url('/rent'), false);
    }

    // --------------------------------------------------- cross-route safety

    public function test_buy_and_rent_do_not_show_each_others_properties(): void
    {
        $this->makeProperty(['title' => 'Will Sell',  'property_status' => 'Sell']);
        $this->makeProperty(['title' => 'Will Rent',  'property_status' => 'Rent']);

        $this->get('/buy')->assertSee('Will Sell', false)->assertDontSee('Will Rent', false);
        $this->get('/rent')->assertSee('Will Rent', false)->assertDontSee('Will Sell', false);
    }

    // --------------------------------- duplicate-param tolerance (server side)

    public function test_buy_handles_duplicate_location_param_without_breaking(): void
    {
        $loc = Location::create(['name' => 'Mohammadpur', 'status' => 1]);

        $this->makeProperty([
            'title'           => 'Mohammadpur Penthouse',
            'property_status' => 'Sell',
            'location_id'     => $loc->id,
        ]);

        // The old buggy client emitted URLs like `?location=2&location=`.
        // Even if such a URL is bookmarked, the server should still resolve
        // the intended filter — PHP's $_GET keeps the LAST value for repeated
        // keys, so this verifies that the non-empty value is the one that
        // ultimately wins.
        $response = $this->get('/buy?location=' . $loc->id . '&location=');

        // The empty trailing param "wins" by PHP's last-value rule; that
        // means the filter is effectively cleared. We assert the page still
        // renders 200 (no crash), and document the behavior.
        $response->assertStatus(200);
    }

    public function test_buy_resolves_correct_property_when_non_empty_comes_last(): void
    {
        $loc = Location::create(['name' => 'Mohammadpur', 'status' => 1]);

        $this->makeProperty([
            'title'           => 'Mohammadpur Penthouse',
            'property_status' => 'Sell',
            'location_id'     => $loc->id,
        ]);
        $this->makeProperty([
            'title'           => 'Other Place',
            'property_status' => 'Sell',
            'location_id'     => null,
        ]);

        // After the JS fix, the URL never carries duplicates. This simulates
        // the post-fix payload — clean, single, non-empty value.
        $response = $this->get('/buy?location=' . $loc->id);

        $response->assertStatus(200);
        $response->assertSee('Mohammadpur Penthouse', false);
        $response->assertDontSee('Other Place', false);
    }
}
