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
                        <select name="location" class="filter-control select2-basic">
                            <option value="">All Locations</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ request('location') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="filter-label">Property Type</label>
                        <select name="property_type" class="filter-control">
                            <option value="">All Types</option>
                            @foreach($property_types as $type)
                                <option value="{{ $type }}" {{ request('property_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
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
                    <div class="col-lg-2 col-md-6">
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
                        <div class="status-badge" style="background: {{ $property->property_status == 'Rent' || $property->property_status == 'For Rent' ? '#00A699' : '#FF385C' }} !important;">
                            <span class="badge-dot left"></span>
                            <span class="badge-dot right"></span>
                            @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                                {{ $property->property_status }}
                            @else
                                For {{ $property->property_status }}
                            @endif
                        </div>
                    </div>
                    <span class="type-badge">{{ $property->category }}</span>
                    
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
                        <button class="action-btn gallery-btn" title="View Gallery" data-images="{{ json_encode($allImages) }}" onclick="event.preventDefault(); openGallery(this);">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <!-- Inner Card Slider -->
                    <div class="swiper card-inner-slider">
                        <div class="swiper-wrapper">
                            @if($property->feature_image)
                                <div class="swiper-slide"><img src="{{ asset($property->feature_image) }}" alt="{{ $property->title }} - {{ $property->category }} in {{ $property->sub_route ?: $property->route }}" title="{{ $property->title }}"></div>
                            @endif
                            @php
                                $gallery = $property->images ?? [];
                            @endphp
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
                        <a href="{{ route('property-details', $property->id) }}">{{ $property->title }}</a>
                    </h3>

                    <div class="info-grid">
                        <h4 class="price-text">৳ {{ number_format($property->price, 0) }}{{ in_array($property->property_status, ['Rent', 'For Rent']) ? ' / mo' : '' }}</h4>
                        <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                        
                        <div class="location-text">
                            <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: $property->route }}
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

        // Initialize Select2 if available
        if (typeof $('.select2-basic').select2 === 'function') {
            $('.select2-basic').select2({
                placeholder: 'Select Location',
                allowClear: true,
                width: '100%'
            });
        }
    });
</script>
@endpush
