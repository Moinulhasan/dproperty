@extends('master')

@section('title', $title . ' — DProperty')
@section('meta_description', 'Browse ' . strtolower($title) . ' on DProperty. Verified apartments, houses, and commercial spaces across Bangladesh with photos, floor plans, and pricing.')
@php
    // Canonical without filter query string so filtered variants
    // don't fragment ranking signals.
    $canonicalListing = url()->current();
@endphp
@section('canonical_url', $canonicalListing)

@section('seo')
    @include('component._breadcrumb_jsonld', ['crumbs' => [
        ['name' => 'Home',  'url' => route('home')],
        ['name' => $title,  'url' => $canonicalListing],
    ]])
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/property_cards.css') }}">
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
        <p class="mb-0 text-white-50">Find the perfect property from our curated collection.</p>
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
            <div class="filter-card border-0">
                <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="filter-label">Location</label>
                        <!-- Desktop Version -->
                        <div class="d-none d-lg-block">
                            <select name="location" id="locationSelectDesktop" class="filter-control">
                                <option value="">All Locations</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc->id }}" {{ request('location') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mobile Version (Custom Picker) -->
                        <div class="custom-dropdown d-lg-none" id="locationDropdownMobile">
                            <div class="picker-toggle" id="locationToggleMobile">
                                <span class="toggle-text">
                                    @php
                                        $currentLocId = request('location');
                                        $currentLocName = 'All Locations';
                                        if ($currentLocId) {
                                            foreach($locations as $l) {
                                                if ($l->id == $currentLocId) { $currentLocName = $l->name; break; }
                                            }
                                        }
                                    @endphp
                                    {{ $currentLocName }}
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="dropdown-content-custom picker-style">
                                <div class="dropdown-body-custom scrollable-list">
                                    <div class="property-type-list">
                                        <div class="type-item {{ !$currentLocId ? 'selected' : '' }}" data-value="" data-text="All Locations">All Locations</div>
                                        @foreach($locations as $loc)
                                            <div class="type-item {{ $currentLocId == $loc->id ? 'selected' : '' }}" data-value="{{ $loc->id }}" data-text="{{ $loc->name }}">
                                                {{ $loc->name }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="location" id="locationMobileValue" class="mobile-input" value="{{ request('location') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="filter-label">Property Category/Type</label>
                        <!-- Desktop Version -->
                        <div class="d-none d-lg-block">
                            <select name="property_category_id" id="propertyTypeSelectDesktop" class="filter-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $parent)
                                    <option value="{{ $parent->id }}" {{ request('property_category_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }} (All)</option>
                                    @if(isset($parent->children) && count($parent->children) > 0)
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}" {{ request('property_category_id') == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Mobile Version (Custom Picker) -->
                        <div class="custom-dropdown d-lg-none" id="propertyTypeDropdownMobile">
                            <div class="picker-toggle" id="propertyTypeToggleMobile">
                                <span class="toggle-text">
                                    @php
                                        $currentCatId = request('property_category_id');
                                        $currentCatName = 'All Categories';
                                        if ($currentCatId) {
                                            foreach($categories as $p) {
                                                if ($p->id == $currentCatId) { $currentCatName = $p->name; break; }
                                                if (isset($p->children)) {
                                                    foreach($p->children as $c) {
                                                        if ($c->id == $currentCatId) { $currentCatName = $c->name; break; }
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    {{ $currentCatName }}
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="dropdown-content-custom picker-style">
                                <div class="picker-actions">
                                    <button type="button" class="btn-picker-action btn-select-all">Select All</button>
                                    <button type="button" class="btn-picker-action btn-deselect-all">Deselect All</button>
                                </div>
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
                            <input type="hidden" name="property_category_id" id="propertyTypeMobileValue" class="mobile-input" value="{{ request('property_category_id') }}">
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-6">
                        <label class="filter-label">Bedrooms</label>
                        <select name="bedrooms" class="filter-control">
                            <option value="any">Any</option>
                            <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3</option>
                            <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5+</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="filter-label">Property Size (SFT)</label>
                        <div class="d-flex gap-1">
                            <input type="number" name="min_area" class="form-control filter-control" placeholder="Min" value="{{ request('min_area') }}">
                            <input type="number" name="max_area" class="form-control filter-control" placeholder="Max" value="{{ request('max_area') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="filter-label">Price Range</label>
                        <div class="d-flex gap-1">
                            <input type="number" name="min_price" class="form-control filter-control" placeholder="Min" value="{{ request('min_price') }}">
                            <input type="number" name="max_price" class="form-control filter-control" placeholder="Max" value="{{ request('max_price') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn-filter-apply py-3 w-100">
                            <i class="fas fa-search me-2"></i> Find
                        </button>
                    </div>
                </form>
            </div>
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
                        $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                        $allImages = [];
                        if ($property->feature_image) $allImages[] = asset($property->feature_image);
                        foreach ($gallery as $img) $allImages[] = asset($img);
                        if (empty($allImages)) $allImages[] = 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80';
                    @endphp
                    <div class="card-image-hover-actions">
                        <button class="action-btn share-btn" title="Share" onclick="event.preventDefault(); navigator.clipboard.writeText('{{ route('property-details', $property->id) }}'); alert('Link copied to clipboard!');">
                            <i class="fas fa-bookmark"></i>
                        </button>
                        <button class="action-btn gallery-btn" title="View All Image" data-images="{{ json_encode($allImages) }}" onclick="event.preventDefault(); openGallery(this);">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <!-- Inner Card Slider -->
                    <div class="swiper card-inner-slider">
                        <div class="swiper-wrapper">
                            @if($property->feature_image)
                                <div class="swiper-slide"><img loading="lazy" src="{{ asset($property->feature_image) }}" alt="{{ $property->title }} - {{ $property->category }} in {{ $property->sub_route ?: $property->route }}" title="{{ $property->title }}"></div>
                            @endif
                            @php
                                $gallery = $property->images ?? [];
                            @endphp
                            @foreach($gallery as $img)
                                <div class="swiper-slide"><img loading="lazy" src="{{ asset($img) }}" alt="{{ $property->title }} - Gallery Image" title="{{ $property->title }}"></div>
                            @endforeach
                            @if(!$property->feature_image && count($gallery) == 0)
                                <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" alt="Default Image"></div>
                            @endif
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
                        <div class="detail-item"><span class="info-label">ID:</span> {{ $property->project_id }}</div>
                        
                        <div class="location-text">
                            <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: $property->route }}
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
                    <p class="text-muted">We couldn't find any properties matching this category at the moment.</p>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all inner card sliders
        const innerSliders = document.querySelectorAll('.card-inner-slider');
        innerSliders.forEach(slider => {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
            });
        });

        // No Select2 initialization needed for standard selects
        
        // Custom Dropdown Logic for mobile
        $(document).on('click', '#locationToggleMobile', function(e) {
            e.stopPropagation();
            $('#locationDropdownMobile').toggleClass('active');
            $('#propertyTypeDropdownMobile').removeClass('active');
        });

        $(document).on('click', '#propertyTypeToggleMobile', function(e) {
            e.stopPropagation();
            $('#propertyTypeDropdownMobile').toggleClass('active');
            $('#locationDropdownMobile').removeClass('active');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#propertyTypeDropdownMobile, #locationDropdownMobile').length) {
                $('#propertyTypeDropdownMobile, #locationDropdownMobile').removeClass('active');
            }
        });

        // Location Picker Logic
        const locationDropdown = document.getElementById('locationDropdownMobile');
        if (locationDropdown) {
            const locItems = locationDropdown.querySelectorAll('.type-item');
            const locToggleText = locationDropdown.querySelector('.toggle-text');
            const locHiddenInput = document.getElementById('locationMobileValue');
            const locSelectAllBtn = locationDropdown.querySelector('.btn-location-select-all');
            const locDeselectAllBtn = locationDropdown.querySelector('.btn-location-deselect-all');

            locItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    locItems.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    const val = this.getAttribute('data-value');
                    const text = this.getAttribute('data-text');
                    locHiddenInput.value = val;
                    locToggleText.innerText = text;
                    locationDropdown.classList.remove('active');
                });
            });

            locSelectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const firstItem = locItems[0];
                if (firstItem) firstItem.click();
            });

            locDeselectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                locItems.forEach(i => i.classList.remove('selected'));
                locHiddenInput.value = '';
                locToggleText.innerText = 'All Locations';
                locationDropdown.classList.remove('active');
            });
        }

        const propertyTypeDropdown = document.getElementById('propertyTypeDropdownMobile');
        if (propertyTypeDropdown) {
            const typeItems = propertyTypeDropdown.querySelectorAll('.type-item');
            const toggleText = propertyTypeDropdown.querySelector('.toggle-text');
            const hiddenInput = document.getElementById('propertyTypeMobileValue');
            const selectAllBtn = propertyTypeDropdown.querySelector('.btn-select-all');
            const deselectAllBtn = propertyTypeDropdown.querySelector('.btn-deselect-all');

            typeItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    typeItems.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    const val = this.getAttribute('data-value');
                    const text = this.getAttribute('data-text');
                    hiddenInput.value = val;
                    toggleText.innerText = text;
                    propertyTypeDropdown.classList.remove('active');
                });
            });

            selectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const firstItem = typeItems[0];
                if (firstItem) firstItem.click();
            });

            deselectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                typeItems.forEach(i => i.classList.remove('selected'));
                hiddenInput.value = '';
                toggleText.innerText = 'All Categories';
                propertyTypeDropdown.classList.remove('active');
            });
        }

        // On refresh or back, ensure mobile/desktop inputs are exclusive
        function syncInputs() {
            const propertyTypeDesktop = document.getElementById('propertyTypeSelectDesktop');
            const propertyTypeMobile = document.getElementById('propertyTypeMobileValue');
            const locationDesktop = document.getElementById('locationSelectDesktop');
            const locationMobile = document.getElementById('locationMobileValue');

            if (window.innerWidth <= 991) {
                if (propertyTypeDesktop) propertyTypeDesktop.name = '';
                if (propertyTypeMobile) propertyTypeMobile.name = 'property_category_id';
                if (locationDesktop) locationDesktop.name = '';
                if (locationMobile) locationMobile.name = 'location';
            } else {
                if (propertyTypeDesktop) propertyTypeDesktop.name = 'property_category_id';
                if (propertyTypeMobile) propertyTypeMobile.name = '';
                if (locationDesktop) locationDesktop.name = 'location';
                if (locationMobile) locationMobile.name = '';
            }
        }
        syncInputs();
        window.addEventListener('resize', syncInputs);
    });
</script>
@endpush
