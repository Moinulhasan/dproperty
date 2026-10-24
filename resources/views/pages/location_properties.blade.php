@extends('master')

@section('title', $title . ' — DProperty')
@section('meta_description', 'Discover properties for sale and rent in ' . $location->name . '. Verified listings, photos, and full details on DProperty.')
@section('canonical_url', route('location.properties', $location->id))

@section('seo')
    @include('component._breadcrumb_jsonld', ['crumbs' => [
        ['name' => 'Home',           'url' => route('home')],
        ['name' => $location->name,  'url' => route('location.properties', $location->id)],
    ]])
@endsection

@section('styles')
    @vite('resources/css/listings.css')
@endsection

@section('content')
<div class="listings-hero">
    <div class="container px-md-5 px-3">
        <nav aria-label="breadcrumb" class="breadcrumb-listing mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
        <h1>{{ $title }}</h1>
        <p class="mb-0 text-white-50">Explore all properties available in {{ $location->name }}.</p>
    </div>
</div>

<div class="filter-wrapper">
    <div class="container px-md-5 px-3">
        <!-- Mobile Filter Toggle Button -->
        <button class="btn-filter-toggle d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileFilterForm" aria-expanded="false" aria-controls="mobileFilterForm">
            <span><i class="fas fa-sliders-h me-2"></i> Filter Properties</span>
            <i class="fas fa-chevron-down"></i>
        </button>

        <!-- Filter Form (Collapsible on Mobile, always visible on Desktop) -->
        <div class="collapse d-lg-block" id="mobileFilterForm">
            <form action="{{ url()->current() }}" method="GET">
                @php
                    $currentStatus = request('property_status');
                    $rawCat = request('property_category_id', []);
                    if (is_string($rawCat)) {
                        $currentCatIds = str_contains($rawCat, ',') ? explode(',', $rawCat) : [$rawCat];
                    } else {
                        $currentCatIds = (array) $rawCat;
                    }
                    $currentCatIds = array_filter(array_map('intval', $currentCatIds));
                    $currentCatId = $currentCatIds[0] ?? null;
                    $currentCatName = 'Select Type';
                    if ($currentCatId) {
                        foreach($categories as $p) {
                            if ($p->id == $currentCatId) { $currentCatName = $p->name; break; }
                            if (isset($p->children)) {
                                foreach($p->children as $c) {
                                    if ($c->id == $currentCatId) { $currentCatName = $c->name; break 2; }
                                }
                            }
                        }
                    }
                    $currentBed = request('bedrooms');
                    $bedToggleText = (!$currentBed || $currentBed === 'any') ? 'Bedrooms' : ($currentBed === '5' ? '5+ Bed' : $currentBed . ' Bed');
                    $minArea  = request('min_area');
                    $maxArea  = request('max_area');
                    $minPrice = request('min_price');
                    $maxPrice = request('max_price');
                    $areaToggleText  = ($minArea && $maxArea) ? ($minArea . ' - ' . $maxArea . ' SFT') : ($minArea ? $minArea . '+ SFT' : ($maxArea ? 'Up to ' . $maxArea . ' SFT' : 'Any Size'));
                    $priceToggleText = ($minPrice && $maxPrice) ? ($minPrice . ' - ' . $maxPrice . ' BDT') : ($minPrice ? $minPrice . '+ BDT' : ($maxPrice ? 'Up to ' . $maxPrice . ' BDT' : 'Max. Price'));
                @endphp

                {{-- ============ DESKTOP VIEW (carousel-style cards) ============ --}}
                <div class="d-none d-lg-block">
                    <div class="search-box card shadow listings-search-box">
                        <div class="compact-search-grid">
                            <!-- Status Card -->
                            <div class="search-card" id="listingsStatusCard">
                                <div class="card-label">STATUS</div>
                                <div class="search-field">
                                    <select class="form-select select2-listings-status" name="property_status" id="propertyStatusDesktop">
                                        <option value="">All</option>
                                        <option value="Buy" {{ $currentStatus == 'Buy' ? 'selected' : '' }}>Buy</option>
                                        <option value="Rent" {{ $currentStatus == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="Sell" {{ $currentStatus == 'Sell' ? 'selected' : '' }}>Sell</option>
                                    </select>
                                </div>
                                <div class="card-sub-label">Buy / Rent / Sell</div>
                            </div>

                            <!-- Property Type Card (multi-select, matches homepage) -->
                            <div class="search-card" id="listingsTypeCard">
                                <div class="card-label">PROPERTY TYPE</div>
                                <div class="search-field">
                                    <select class="form-select select2-listings-type" name="property_category_id[]" id="propertyTypeSelectDesktop" multiple="multiple">
                                        @foreach($categories as $parent)
                                            <option value="{{ $parent->id }}" data-level="0" data-parent-id="{{ $parent->id }}" {{ in_array($parent->id, $currentCatIds) ? 'selected' : '' }}>{{ $parent->name }} (All)</option>
                                            @if(isset($parent->children) && count($parent->children) > 0)
                                                @foreach($parent->children as $child)
                                                    <option value="{{ $child->id }}" data-level="1" data-parent="{{ $parent->id }}" {{ in_array($child->id, $currentCatIds) ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;- {{ $child->name }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="card-sub-label">Residential/Commercial</div>
                            </div>

                            <!-- Bed Card -->
                            <div class="search-card" id="listingsBedCard">
                                <div class="card-label">BED</div>
                                <div class="custom-dropdown" id="listingsBedDropdown">
                                    <div class="dropdown-toggle-custom" id="listingsBedToggle">{{ $bedToggleText }}</div>
                                    <div class="dropdown-content-custom">
                                        <div class="dropdown-header-custom">Bed</div>
                                        <div class="dropdown-body-custom">
                                            <div class="bed-options">
                                                <div class="bed-btn {{ (!$currentBed || $currentBed === 'any') ? 'active' : '' }}" data-value="any">Any</div>
                                                <div class="bed-btn {{ $currentBed === '1' ? 'active' : '' }}" data-value="1">1</div>
                                                <div class="bed-btn {{ $currentBed === '2' ? 'active' : '' }}" data-value="2">2</div>
                                                <div class="bed-btn {{ $currentBed === '3' ? 'active' : '' }}" data-value="3">3</div>
                                                <div class="bed-btn {{ $currentBed === '4' ? 'active' : '' }}" data-value="4">4</div>
                                                <div class="bed-btn {{ $currentBed === '5' ? 'active' : '' }}" data-value="5">5+</div>
                                            </div>
                                        </div>
                                        <div class="dropdown-footer-custom">
                                            <button type="button" class="btn-clear-dropdown">Clear</button>
                                            <button type="button" class="btn-apply-dropdown">Apply</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="bedrooms" id="bedValueDesktop" value="{{ $currentBed ?: '' }}">
                                </div>
                                <div class="card-sub-label">Number of Beds</div>
                            </div>

                            <!-- Property Size Card -->
                            <div class="search-card" id="listingsAreaCard">
                                <div class="card-label">PROPERTY SIZE</div>
                                <div class="custom-dropdown" id="listingsAreaDropdown">
                                    <div class="dropdown-toggle-custom" id="listingsAreaToggle">{{ $areaToggleText }}</div>
                                    <div class="dropdown-content-custom">
                                        <div class="dropdown-header-custom">Area (SFT)</div>
                                        <div class="dropdown-body-custom">
                                            <div class="range-container">
                                                <div class="range-field">
                                                    <label>Minimum</label>
                                                    <div class="input-with-prefix">
                                                        <span class="prefix">SFT</span>
                                                        <input type="number" name="min_area" id="minAreaDesktop" placeholder="MIN" value="{{ $minArea }}">
                                                    </div>
                                                </div>
                                                <div class="range-field">
                                                    <label>Maximum</label>
                                                    <div class="input-with-prefix">
                                                        <span class="prefix">SFT</span>
                                                        <input type="number" name="max_area" id="maxAreaDesktop" placeholder="MAX" value="{{ $maxArea }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-footer-custom">
                                            <button type="button" class="btn-clear-dropdown">Clear</button>
                                            <button type="button" class="btn-apply-dropdown">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-sub-label">Area in SFT</div>
                            </div>

                            <!-- Price Card -->
                            <div class="search-card" id="listingsPriceCard">
                                <div class="card-label">PRICE</div>
                                <div class="custom-dropdown" id="listingsPriceDropdown">
                                    <div class="dropdown-toggle-custom" id="listingsPriceToggle">{{ $priceToggleText }}</div>
                                    <div class="dropdown-content-custom">
                                        <div class="dropdown-header-custom">Price</div>
                                        <div class="dropdown-body-custom">
                                            <div class="range-container">
                                                <div class="range-field">
                                                    <label>Minimum</label>
                                                    <div class="input-with-prefix">
                                                        <span class="prefix">BDT</span>
                                                        <input type="number" name="min_price" id="minPriceDesktop" placeholder="MIN" value="{{ $minPrice }}">
                                                    </div>
                                                </div>
                                                <div class="range-field">
                                                    <label>Maximum</label>
                                                    <div class="input-with-prefix">
                                                        <span class="prefix">BDT</span>
                                                        <input type="number" name="max_price" id="maxPriceDesktop" placeholder="MAX" value="{{ $maxPrice }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-footer-custom">
                                            <button type="button" class="btn-clear-dropdown">Clear</button>
                                            <button type="button" class="btn-apply-dropdown">Apply</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-sub-label">Budget Range</div>
                            </div>

                            <!-- Search Button -->
                            <div class="search-action-box">
                                <button type="submit" class="btn-search-compact">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============ MOBILE VIEW (existing) ============ --}}
                <div class="d-lg-none filter-card border-0">
                    <div class="row g-3 align-items-end">
                        <div class="col-6">
                            <label class="filter-label">Status</label>
                            <select name="property_status" id="propertyStatusMobile" class="filter-control form-select">
                                <option value="">All</option>
                                <option value="Buy" {{ $currentStatus == 'Buy' ? 'selected' : '' }}>Buy</option>
                                <option value="Rent" {{ $currentStatus == 'Rent' ? 'selected' : '' }}>Rent</option>
                                <option value="Sell" {{ $currentStatus == 'Sell' ? 'selected' : '' }}>Sell</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="filter-label">Bedrooms</label>
                            <select name="bedrooms" id="bedroomsMobileSelect" class="filter-control form-select">
                                <option value="any">Any</option>
                                <option value="1" {{ $currentBed == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $currentBed == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $currentBed == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ $currentBed == '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ $currentBed == '5' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="filter-label">Property Category/Type</label>
                            <div class="custom-dropdown" id="propertyTypeDropdownMobile">
                                <div class="picker-toggle" id="propertyTypeToggleMobile">
                                    <span class="toggle-text">{{ $currentCatName === 'Select Type' ? 'All Categories' : $currentCatName }}</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="dropdown-content-custom picker-style">
                                    <div class="dropdown-body-custom scrollable-list">
                                        <div class="property-type-list">
                                            <div class="type-item {{ !$currentCatId ? 'selected' : '' }}" data-value="" data-text="All Categories">All Categories</div>
                                            @foreach($categories as $parent)
                                                <div class="type-item parent {{ $currentCatId == $parent->id ? 'selected' : '' }}" data-value="{{ $parent->id }}" data-text="{{ $parent->name }}">
                                                    {{ $parent->name }}
                                                </div>
                                                @if(isset($parent->children) && count($parent->children) > 0)
                                                    @foreach($parent->children as $child)
                                                        <div class="type-item child {{ $currentCatId == $child->id ? 'selected' : '' }}" data-value="{{ $child->id }}" data-text="{{ $child->name }}">
                                                            - {{ $child->name }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="property_category_id" id="propertyTypeMobileValue" class="mobile-input" value="{{ $currentCatId }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="filter-label">Property Size (SFT)</label>
                            <div class="d-flex gap-1">
                                <input type="number" name="min_area" id="minAreaMobile" class="form-control filter-control" placeholder="Min" value="{{ $minArea }}">
                                <input type="number" name="max_area" id="maxAreaMobile" class="form-control filter-control" placeholder="Max" value="{{ $maxArea }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="filter-label">Price Range</label>
                            <div class="d-flex gap-1">
                                <input type="number" name="min_price" id="minPriceMobile" class="form-control filter-control" placeholder="Min" value="{{ $minPrice }}">
                                <input type="number" name="max_price" id="maxPriceMobile" class="form-control filter-control" placeholder="Max" value="{{ $maxPrice }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-filter-apply py-3 w-100">
                                <i class="fas fa-search me-2"></i> Find
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-90 mb-5">
    <div class="row g-4">
        @forelse($properties as $property)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="property-card-global">
                <div class="card-image-box">
                    <div class="status-badge-container">
                        @php
                            $statusLower = strtolower($property->property_status);
                            $statusClass = 'status-sell'; // Default
                            if (str_contains($statusLower, 'rent')) $statusClass = 'status-rent';
                            elseif (str_contains($statusLower, 'buy')) $statusClass = 'status-buy';
                        @endphp
                        <div class="status-badge {{ $statusClass }}">
                            <span class="badge-dot left"></span>
                            <span class="badge-dot right"></span>
                            @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                                {{ $property->property_status }}
                            @else
                                For {{ $property->property_status }}
                            @endif
                        </div>
                        <span class="type-badge">{{ $property->category }}</span>
                    </div>
                    
                    @php
                        // Feature image first, then deduplicated gallery.
                        $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                        $cardImages = [];
                        if ($property->feature_image) {
                            $cardImages[] = $property->feature_image;
                        }
                        foreach ($gallery as $img) {
                            if (!in_array($img, $cardImages, true)) {
                                $cardImages[] = $img;
                            }
                        }
                        $allImages = array_map(fn ($p) => asset($p), $cardImages);
                        if (empty($allImages)) {
                            $allImages[] = 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80';
                        }
                    @endphp
                    <div class="card-image-hover-actions">
                        <button class="action-btn share-btn" title="Share" onclick="event.preventDefault(); navigator.clipboard.writeText('{{ route('property-details', $property->id) }}'); alert('Link copied to clipboard!');">
                            <i class="fas fa-bookmark"></i>
                        </button>
                        <button class="action-btn gallery-btn" title="View All Image" data-images="{{ json_encode($allImages) }}" onclick="event.preventDefault(); openGallery(this);">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <!-- Inner Card Slider — feature image guaranteed first. -->
                    <div class="swiper card-inner-slider">
                        <div class="swiper-wrapper">
                            @foreach($allImages as $sliderImg)
                                <div class="swiper-slide">@include('component._card_img', ['src' => $sliderImg, 'alt' => $property->title . ' - ' . $property->category . ' in ' . $property->displayLocation(), 'title' => $property->title, 'deferred' => !$loop->first])</div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <div class="card-body-global">
                    <h3 class="card-title-global">
                        <a href="{{ route('property-details', $property->id) }}" target="_blank">{{ $property->title }}</a>
                    </h3>

                    <div class="info-grid">
                        <h4 class="price-text">৳ {{ number_format($property->price, 0) }}{{ in_array($property->property_status, ['Rent', 'For Rent']) ? ' / mo' : '' }}</h4>
                        <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                        
                        <div class="location-text">
                            <i class="fas fa-map-marker-alt"></i> {{ $property->displayLocation() }}
                        </div>
                        <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                    </div>
                </div>
                @include('component._card_footer', ['p' => $property])
            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="empty-listings">
                    <i class="fas fa-home fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Properties Found</h4>
                    <p class="text-muted">No properties available in {{ $location->name }} at the moment.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Back to Home</a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper mt-5 d-flex justify-content-center">
        {{ $properties->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/select2.js', 'resources/js/pages/location_properties.js'])
@endpush
