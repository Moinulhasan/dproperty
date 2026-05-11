@extends('master')

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
            <div class="filter-card border-0">
                <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-lg-2 col-md-6">
                        <label class="filter-label">Property Status</label>
                        <select name="property_status" class="filter-control">
                            <option value="">All Types</option>
                            <option value="Buy" {{ request('property_status') == 'Buy' ? 'selected' : '' }}>Buy</option>
                            <option value="Rent" {{ request('property_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                            <option value="Sell" {{ request('property_status') == 'Sell' ? 'selected' : '' }}>Sell</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="filter-label">Property Category/Type</label>
                        <!-- Desktop Version -->
                        <div class="d-none d-lg-block">
                            <select name="property_category_id" id="propertyTypeSelectDesktop" class="filter-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $parent)
                                    <optgroup label="{{ $parent->name }}">
                                        <option value="{{ $parent->id }}" {{ request('property_category_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }} (All)</option>
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}" {{ request('property_category_id') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                        @endforeach
                                    </optgroup>
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
                    <div class="col-lg-2 col-md-6">
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
                    <div class="col-lg-3 col-md-6">
                        <label class="filter-label">Price Range</label>
                        <div class="d-flex gap-1">
                            <input type="number" name="min_price" class="form-control filter-control" placeholder="Min" value="{{ request('min_price') }}">
                            <input type="number" name="max_price" class="form-control filter-control" placeholder="Max" value="{{ request('max_price') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <button type="submit" class="btn-filter-apply py-3 w-100">
                            <i class="fas fa-search me-2"></i> Find properties
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
                                <div class="swiper-slide"><img src="{{ asset($property->feature_image) }}" alt="{{ $property->title }} - {{ $property->category }} in {{ $property->sub_route ?: ($property->location ? $property->location->name : '') }}" title="{{ $property->title }}"></div>
                            @endif
                            @foreach($gallery as $img)
                                <div class="swiper-slide"><img src="{{ asset($img) }}" alt="{{ $property->title }} - Gallery Image" title="{{ $property->title }}"></div>
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
                        <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                        
                        <div class="location-text">
                            <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: ($property->location ? $property->location->name : '') }}
                        </div>
                        <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                    </div>
                </div>
                <div class="card-footer-global">
                    <div class="feature-item-global"><i class="fas fa-bed"></i> {{ $property->bedrooms }} Bed</div>
                    <div class="feature-item-global"><i class="fas fa-bath"></i> {{ $property->bathrooms }} Bath</div>
                    <div class="feature-item-global"><i class="fas fa-ruler-combined"></i> {{ $property->area }} SFT</div>
                </div>
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
            if (window.innerWidth <= 991) {
                const desk = document.getElementById('propertyTypeSelectDesktop');
                if (desk) desk.name = '';
                const mob = document.getElementById('propertyTypeMobileValue');
                if (mob) mob.name = 'property_category_id';
            } else {
                const desk = document.getElementById('propertyTypeSelectDesktop');
                if (desk) desk.name = 'property_category_id';
                const mob = document.getElementById('propertyTypeMobileValue');
                if (mob) mob.name = '';
            }
        }
        syncInputs();
        window.addEventListener('resize', syncInputs);

        function formatSearchOption(state) {
            if (!state.id) return state.text;
            const isChild = state.element && state.element.parentElement && state.element.parentElement.tagName === 'OPTGROUP';
            const padding = isChild ? '20px' : '0';
            const $state = $(
                '<div style="display: flex; align-items: center; padding-left: ' + padding + ';">' +
                    '<span style="color: inherit; font-weight: inherit;">' + state.text + '</span>' +
                '</div>'
            );
            return $state;
        }

        if (typeof $().select2 === 'function') {
            $('.filter-control select').not('[name="bedrooms"], [name="property_status"]').select2({
                templateResult: formatSearchOption,
                width: '100%',
                allowClear: true,
                minimumResultsForSearch: Infinity,
                dropdownCssClass: 'premium-search-dropdown'
            });
            $('.filter-control select[name="bedrooms"], .filter-control select[name="property_status"]').select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });
        }
    });
</script>
@endpush
