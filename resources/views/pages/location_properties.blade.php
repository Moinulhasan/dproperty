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
                                <div class="swiper-slide"><img loading="lazy" src="{{ $sliderImg }}" alt="{{ $property->title }} - {{ $property->category }} in {{ $property->displayLocation() }}" title="{{ $property->title }}"></div>
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
<script>
    // Same dual-defence approach as listings.blade.php (see comments there).
    (function attachFilterFormDefences() {
        const FILTER_PAIRS = [
            { desktopId: 'propertyStatusDesktop',     mobileId: 'propertyStatusMobile' },
            { desktopId: 'propertyTypeSelectDesktop', mobileId: 'propertyTypeMobileValue' },
            { desktopId: 'bedValueDesktop',           mobileId: 'bedroomsMobileSelect' },
            { desktopId: 'minAreaDesktop',            mobileId: 'minAreaMobile' },
            { desktopId: 'maxAreaDesktop',            mobileId: 'maxAreaMobile' },
            { desktopId: 'minPriceDesktop',           mobileId: 'minPriceMobile' },
            { desktopId: 'maxPriceDesktop',           mobileId: 'maxPriceMobile' },
        ];

        function syncDisabledState() {
            const isMobile = window.innerWidth <= 991;
            FILTER_PAIRS.forEach(p => {
                const d = document.getElementById(p.desktopId);
                const m = document.getElementById(p.mobileId);
                if (d) d.disabled = isMobile;
                if (m) m.disabled = !isMobile;
            });
        }

        function attachOnce() {
            syncDisabledState();
            window.addEventListener('resize', syncDisabledState);

            const filterForm = document.querySelector('#mobileFilterForm form');
            if (!filterForm) return;

            filterForm.addEventListener('submit', function (e) {
                e.preventDefault();
                syncDisabledState();

                const collected = {};
                const formData  = new FormData(this);
                for (const [key, raw] of formData.entries()) {
                    if (key === '_token' || key === '_method') continue;
                    const value = (raw ?? '').toString().trim();
                    if (value === '' || value === 'any') continue;
                    collected[key] = value;
                }

                const params  = new URLSearchParams(collected).toString();
                const baseUrl = window.location.origin + window.location.pathname;
                window.location.assign(baseUrl + (params ? '?' + params : ''));
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', attachOnce);
        } else {
            attachOnce();
        }
    })();

    document.addEventListener('DOMContentLoaded', function() {

        // Initialize all inner card sliders. loop disabled so slide 0
        // (the feature image) is always the visible starting slide.
        const innerSliders = document.querySelectorAll('.card-inner-slider');
        innerSliders.forEach(slider => {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: false,
                watchOverflow: true,
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
            });
        });

        // Custom Dropdown Logic for mobile
        $(document).on('click', '#propertyTypeToggleMobile', function(e) {
            e.stopPropagation();
            $('#propertyTypeDropdownMobile').toggleClass('active');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#propertyTypeDropdownMobile').length) {
                $('#propertyTypeDropdownMobile').removeClass('active');
            }
        });

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

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const firstItem = typeItems[0];
                    if (firstItem) firstItem.click();
                });
            }

            if (deselectAllBtn) {
                deselectAllBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    typeItems.forEach(i => i.classList.remove('selected'));
                    hiddenInput.value = '';
                    toggleText.innerText = 'All Categories';
                    propertyTypeDropdown.classList.remove('active');
                });
            }
        }

        // ===== DESKTOP carousel-style search cards =====
        if (window.innerWidth >= 992 && typeof $ !== 'undefined' && typeof $.fn.select2 === 'function') {

            function formatTypeOption(state) {
                if (!state.id) return state.text;
                const level = $(state.element).data('level') || 0;
                const padding = level === 1 ? '20px' : '0';
                const cleanText = state.text.replace(/&nbsp;|\s\s\s/g, '');
                return $(
                    '<div style="display:flex;align-items:center;padding-left:' + padding + ';">' +
                        '<span>' + cleanText + '</span>' +
                    '</div>'
                );
            }

            if (!$('style#listings-type-fixes').length) {
                $('head').append(
                    '<style id="listings-type-fixes">' +
                    '.listings-type-select2 .select2-selection__choice { display: none !important; }' +
                    '</style>'
                );
            }

            // ---- STATUS (single-select) ----
            $('.select2-listings-status').select2({
                placeholder: 'All',
                width: '100%',
                allowClear: true,
                minimumResultsForSearch: Infinity,
                dropdownCssClass: 'premium-search-dropdown',
                dropdownParent: $('.select2-listings-status').closest('.search-card'),
            });

            // ---- PROPERTY TYPE (multi-select, carousel design) ----
            const $typeSelect = $('.select2-listings-type');
            if ($typeSelect.length) {
                $typeSelect.select2({
                    placeholder: 'Select Type',
                    width: '100%',
                    allowClear: true,
                    templateResult: formatTypeOption,
                    minimumResultsForSearch: Infinity,
                    closeOnSelect: false,
                    dropdownCssClass: 'premium-search-dropdown',
                    dropdownParent: $typeSelect.closest('.search-card'),
                });
                $typeSelect.next('.select2-container').addClass('listings-type-select2');

                $typeSelect.on('change', function () {
                    setTimeout(function () {
                        const selected = $typeSelect.val() || [];
                        const $rendered = $typeSelect.next('.select2-container').find('.select2-selection__rendered');
                        $rendered.find('.custom-summary-text').remove();
                        if (selected.length > 0) {
                            $rendered.find('.select2-search__field').attr('placeholder', '').css('width', '0');
                            const total = $typeSelect.find('option').length;
                            let summaryText;
                            if (selected.length === 1) {
                                summaryText = $typeSelect.find('option:selected').text().replace(/&nbsp;|-/g, '').trim();
                            } else if (selected.length === total) {
                                summaryText = 'All types selected';
                            } else {
                                summaryText = selected.length + ' types selected';
                            }
                            $rendered.prepend(
                                '<li class="custom-summary-text" style="list-style:none;display:flex;align-items:center;padding-left:8px;margin-top:6px;color:#6c757d;font-size:14px;">' +
                                summaryText +
                                '</li>'
                            );
                        } else {
                            $rendered.find('.select2-search__field').attr('placeholder', 'Select Type').css('width', '');
                        }
                    }, 0);
                });

                let __ptPrev = new Set(($typeSelect.val() || []).map(String));
                let __ptCascading = false;
                $typeSelect.on('change.cascade', function () {
                    if (__ptCascading) return;
                    __ptCascading = true;
                    const curr  = new Set(($typeSelect.val() || []).map(String));
                    const added = [...curr].filter(v => !__ptPrev.has(v));
                    const removed = [...__ptPrev].filter(v => !curr.has(v));
                    let mutated = false;
                    const setOpt = (opt, on) => {
                        if (opt.selected !== on) { opt.selected = on; if (on) curr.add(String(opt.value)); else curr.delete(String(opt.value)); mutated = true; }
                    };
                    added.forEach(id => {
                        const $opt = $typeSelect.find('option[value="' + id + '"]');
                        const level = $opt.attr('data-level');
                        if (level === '0') {
                            const pid = $opt.attr('data-parent-id') || id;
                            $typeSelect.find('option[data-parent="' + pid + '"]').each(function () { setOpt(this, true); });
                        } else if (level === '1') {
                            const pid = $opt.attr('data-parent');
                            const $parent = $typeSelect.find('option[data-parent-id="' + pid + '"]');
                            const $siblings = $typeSelect.find('option[data-parent="' + pid + '"]');
                            if ($parent.length && $siblings.toArray().every(o => o.selected)) setOpt($parent[0], true);
                        }
                    });
                    removed.forEach(id => {
                        const $opt = $typeSelect.find('option[value="' + id + '"]');
                        const level = $opt.attr('data-level');
                        if (level === '0') {
                            const pid = $opt.attr('data-parent-id') || id;
                            $typeSelect.find('option[data-parent="' + pid + '"]').each(function () { setOpt(this, false); });
                        } else if (level === '1') {
                            const pid = $opt.attr('data-parent');
                            const $parent = $typeSelect.find('option[data-parent-id="' + pid + '"]');
                            if ($parent.length && $parent[0].selected) setOpt($parent[0], false);
                        }
                    });
                    __ptPrev = new Set([...curr].map(String));
                    __ptCascading = false;
                    if (mutated) $typeSelect.trigger('change');
                });

                $typeSelect.on('select2:open', function () {
                    const $dropdown = $('.select2-dropdown--below, .select2-dropdown--above').last();
                    if (!$dropdown.find('.select2-all-actions').length) {
                        $dropdown.prepend(
                            '<div class="select2-all-actions d-flex align-items-center border-bottom bg-white">' +
                                '<button type="button" class="btn-selection-action flex-grow-1 btn-select-all-s2">Select All</button>' +
                                '<div class="action-divider"></div>' +
                                '<button type="button" class="btn-selection-action flex-grow-1 btn-deselect-all-s2">Deselect All</button>' +
                            '</div>'
                        );
                        $dropdown.find('.btn-select-all-s2').on('click', function () {
                            $typeSelect.find('option').prop('selected', 'selected');
                            $typeSelect.trigger('change');
                        });
                        $dropdown.find('.btn-deselect-all-s2').on('click', function () {
                            $typeSelect.val(null).trigger('change');
                        });
                    }
                });

                $typeSelect.trigger('change');
            }

            $(document).on('click', '#listingsStatusCard, #listingsTypeCard', function (e) {
                const $sel = $(this).find('select');
                if ($sel.length && $sel.hasClass('select2-hidden-accessible')) {
                    e.stopPropagation();
                    $sel.select2('open');
                }
            });

            const desktopDropdowns = ['listingsBedDropdown', 'listingsAreaDropdown', 'listingsPriceDropdown'];
            desktopDropdowns.forEach(id => {
                const dd = document.getElementById(id);
                if (!dd) return;
                const toggle = dd.querySelector('.dropdown-toggle-custom');
                if (toggle) {
                    toggle.addEventListener('click', function (e) {
                        e.stopPropagation();
                        desktopDropdowns.forEach(otherId => {
                            if (otherId !== id) {
                                const other = document.getElementById(otherId);
                                if (other) other.classList.remove('active');
                            }
                        });
                        dd.classList.toggle('active');
                    });
                }
                const content = dd.querySelector('.dropdown-content-custom');
                if (content) content.addEventListener('click', e => e.stopPropagation());
            });

            document.addEventListener('click', function (e) {
                if (!e.target.closest('#listingsBedDropdown, #listingsAreaDropdown, #listingsPriceDropdown, .search-card')) {
                    desktopDropdowns.forEach(id => {
                        const dd = document.getElementById(id);
                        if (dd) dd.classList.remove('active');
                    });
                }
            });

            const bedDropdown = document.getElementById('listingsBedDropdown');
            if (bedDropdown) {
                const bedBtns  = bedDropdown.querySelectorAll('.bed-btn');
                const bedInput = document.getElementById('bedValueDesktop');
                const bedToggle = document.getElementById('listingsBedToggle');
                bedBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        bedBtns.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
                const clearBtn = bedDropdown.querySelector('.btn-clear-dropdown');
                const applyBtn = bedDropdown.querySelector('.btn-apply-dropdown');
                if (clearBtn) clearBtn.addEventListener('click', function () {
                    bedBtns.forEach(b => b.classList.remove('active'));
                    const any = bedDropdown.querySelector('.bed-btn[data-value="any"]');
                    if (any) any.classList.add('active');
                    bedInput.value = '';
                    bedToggle.innerText = 'Bedrooms';
                    bedDropdown.classList.remove('active');
                });
                if (applyBtn) applyBtn.addEventListener('click', function () {
                    const active = bedDropdown.querySelector('.bed-btn.active');
                    const val = active ? active.getAttribute('data-value') : 'any';
                    bedInput.value = (val === 'any') ? '' : val;
                    bedToggle.innerText = (val === 'any') ? 'Bedrooms' : (val === '5' ? '5+ Bed' : val + ' Bed');
                    bedDropdown.classList.remove('active');
                });
            }

            function wireRangeDropdown(dropdownId, minId, maxId, toggleId, defaultText, suffix) {
                const dd = document.getElementById(dropdownId);
                if (!dd) return;
                const minEl = document.getElementById(minId);
                const maxEl = document.getElementById(maxId);
                const toggle = document.getElementById(toggleId);
                const clearBtn = dd.querySelector('.btn-clear-dropdown');
                const applyBtn = dd.querySelector('.btn-apply-dropdown');
                function renderToggle() {
                    const mn = minEl.value, mx = maxEl.value;
                    if (mn && mx)       toggle.innerText = mn + ' - ' + mx + ' ' + suffix;
                    else if (mn)        toggle.innerText = mn + '+ ' + suffix;
                    else if (mx)        toggle.innerText = 'Up to ' + mx + ' ' + suffix;
                    else                toggle.innerText = defaultText;
                }
                if (clearBtn) clearBtn.addEventListener('click', function () {
                    minEl.value = '';
                    maxEl.value = '';
                    renderToggle();
                    dd.classList.remove('active');
                });
                if (applyBtn) applyBtn.addEventListener('click', function () {
                    renderToggle();
                    dd.classList.remove('active');
                });
            }
            wireRangeDropdown('listingsAreaDropdown',  'minAreaDesktop',  'maxAreaDesktop',  'listingsAreaToggle',  'Any Size',  'SFT');
            wireRangeDropdown('listingsPriceDropdown', 'minPriceDesktop', 'maxPriceDesktop', 'listingsPriceToggle', 'Max. Price', 'BDT');
        }
    });
</script>
@endpush
