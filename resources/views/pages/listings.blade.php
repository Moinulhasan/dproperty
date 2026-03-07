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
        <div class="filter-card border-0">
            <form action="#" class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label class="filter-label">Location</label>
                    <select class="filter-control select2-basic">
                        <option value="">All Locations</option>
                        <option value="banani">Banani, Dhaka</option>
                        <option value="gulshan">Gulshan, Dhaka</option>
                        <option value="dhanmondi">Dhanmondi, Dhaka</option>
                        <option value="uttara">Uttara, Dhaka</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">Property Type</label>
                    <select class="filter-control">
                        <option value="">All Types</option>
                        <option value="apartment">Apartment</option>
                        <option value="house">Independent House</option>
                        <option value="villa">Luxury Villa</option>
                        <option value="office">Office Space</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">Bedrooms</label>
                    <select class="filter-control">
                        <option value="">Any</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">Price Range</label>
                    <select class="filter-control">
                        <option value="">Any Price</option>
                        <option value="low">Under ৳ 1,000,000</option>
                        <option value="mid">৳ 1,000,000 - ৳ 5,000,000</option>
                        <option value="high">Above ৳ 5,000,000</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-12">
                    <button type="submit" class="btn-filter-apply py-3">
                        <i class="fas fa-search me-2"></i> Find properties
                    </button>
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
                        <span class="status-badge" style="background: {{ $property->property_status == 'Rent' ? '#00A699' : '#FF385C' }};">
                            For {{ $property->property_status }}
                        </span>
                    </div>
                    <span class="type-badge">{{ $property->category }}</span>

                    <!-- Inner Card Slider -->
                    <div class="swiper card-inner-slider">
                        <div class="swiper-wrapper">
                            @if($property->feature_image)
                                <div class="swiper-slide"><img src="{{ asset($property->feature_image) }}" alt="{{ $property->title }}"></div>
                            @endif
                            @php
                                $gallery = $property->images ?? [];
                            @endphp
                            @foreach($gallery as $img)
                                <div class="swiper-slide"><img src="{{ asset($img) }}" alt="{{ $property->title }}"></div>
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
                    <h3 class="card-title-global">{{ $property->title }}</h3>

                    <div class="info-row">
                        <div class="price-text">৳ {{ number_format($property->price, 0) }}{{ $property->property_status == 'Rent' ? ' / mo' : '' }}</div>
                        <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                    </div>

                    <div class="info-row">
                        <div class="location-text">
                            <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route }}{{ $property->sub_route && $property->route ? ', ' : '' }}{{ $property->route }}
                        </div>
                        <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                    </div>
                </div>
                <div class="card-footer-global">
                    <div class="feature-group">
                        <div class="feature-item-global">Bed {{ $property->bedrooms }}</div>
                        <div class="feature-item-global">Bath {{ $property->bathrooms }}</div>
                        <div class="feature-item-global">{{ number_format($property->area) }} sqft</div>
                    </div>
                    <a href="{{ route('property-details', $property->id) }}" class="btn-view-more">View More</a>
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
