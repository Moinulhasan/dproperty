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

<div class=" px-md-5 px-3 mb-5">
    <div class="row g-4">
        @for($i = 0; $i < 8; $i++)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="property-card-global">
                <div class="card-image-box">
                    <div class="status-badge-container">
                        <span class="status-badge" style="background: {{ $title == 'Properties For Rent' ? '#00A699' : '#FF385C' }};">
                            {{ $title == 'Properties For Rent' ? 'For Rent' : 'For Sale' }}
                        </span>
                    </div>
                    <span class="type-badge">Residential</span>

                    <!-- Inner Card Slider -->
                    <div class="swiper card-inner-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" alt="Image 1"></div>
                            <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=800&q=80" alt="Image 2"></div>
                            <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=800&q=80" alt="Image 3"></div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <div class="card-body-global">
                    <h3 class="card-title-global">Premium Property {{ $i+1 }}</h3>

                    <div class="info-row">
                        <div class="price-text">{{ $title == 'Properties For Rent' ? '৳ 45,000 / mo' : '৳ 45,000,000.00' }}</div>
                        <div class="detail-item"><span class="info-label">Project ID:</span> DP-{{ 7000 + $i }}</div>
                    </div>

                    <div class="info-row">
                        <div class="location-text">
                            <i class="fas fa-map-marker-alt"></i> Banani, Dhaka
                        </div>
                        <div class="detail-item"><span class="info-label">Type:</span> Furnished</div>
                    </div>
                </div>
                <div class="card-footer-global">
                    <div class="feature-group">
                        <div class="feature-item-global">Bed 3</div>
                        <div class="feature-item-global">Bath 3</div>
                        <div class="feature-item-global">2100 sqft</div>
                    </div>
                    <a href="{{ route('property-details', 1) }}" class="btn-view-more">View More</a>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper text-center">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>
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
