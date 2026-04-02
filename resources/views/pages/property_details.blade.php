@extends('master')

@section('meta_description', Str::limit(strip_tags($property->description), 160))

@section('seo')
    <meta property="og:title" content="{{ $property->title }} | DProperty">
    <meta property="og:description" content="{{ Str::limit(strip_tags($property->description), 160) }}">
    <meta property="og:image" content="{{ asset($property->feature_image) }}">
    <meta property="og:image:alt" content="{{ $property->title }} - {{ $property->property_type }} in {{ $property->sub_route ?? $property->route }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $property->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($property->description), 160) }}">
    <meta name="twitter:image" content="{{ asset($property->feature_image) }}">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/details.css') }}">
@endsection()

@section('content')
<div class="details-page-wrapper">
    <div class="container-fluid px-md-5 px-3">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                @php
                    $status = strtolower($property->property_status);
                    $route = 'buy';
                    if (str_contains($status, 'rent')) $route = 'rent';
                    elseif (str_contains($status, 'sell') || str_contains($status, 'sale')) $route = 'sell';
                @endphp
                <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $property->property_status }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $property->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Left Side: Gallery & Description -->
            <div class="col-lg-8">
                <div class="detail-gallery-container shadow-sm">
                    <div class="gallery-header">
                        <h2 class="gallery-title">{{ $property->title }}</h2>
                        <div class="gallery-meta">
                            <span class="gallery-date"><i class="far fa-calendar-alt me-1"></i>Posted on {{ $property->created_at->format('d M Y, h:i a') }}{{ $property->location ? ', ' . $property->location->name : '' }}</span>
                        </div>
                    </div>
                    <!-- Main Swiper -->
                    <div class="swiper main-image-swiper">
                        <div class="swiper-wrapper">
                            @if($property->feature_image)
                            <div class="swiper-slide">
                                <img src="{{ asset($property->feature_image) }}" alt="{{ $property->title }} - {{ $property->property_type }} in {{ $property->sub_route ?? $property->route }}" title="{{ $property->title }}">
                            </div>
                            @endif
                            @php
                                $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                            @endphp
                            @foreach($gallery as $img)
                            <div class="swiper-slide">
                                <img src="{{ asset($img) }}" alt="{{ $property->title }} - Gallery Image" title="{{ $property->title }}">
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <!-- Thumbnails Swiper -->
                    <div class="swiper thumb-image-swiper mt-3">
                        <div class="swiper-wrapper">
                            @if($property->feature_image)
                            <div class="swiper-slide">
                                <img src="{{ asset($property->feature_image) }}" alt="Thumb">
                            </div>
                            @endif
                            @foreach($gallery as $img)
                            <div class="swiper-slide">
                                <img src="{{ asset($img) }}" alt="Thumb">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Mobile Title (shown only on mobile, after image) -->
                <div class="mobile-title-section d-lg-none mt-3">
                    <div class="badge bg-primary mb-2">
                        @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                            {{ $property->property_status }}
                        @else
                            For {{ $property->property_status }}
                        @endif
                    </div>
                    <h2 class="mobile-property-title">{{ $property->title }}</h2>
                    <div class="mobile-location">
                        <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $property->sub_route }}{{ $property->sub_route && $property->location ? ', ' : '' }}{{ $property->location ? $property->location->name : '' }}
                    </div>
                    <h3 class="mobile-price">৳ {{ number_format($property->price, 0) }}{{ in_array($property->property_status, ['Rent', 'For Rent']) ? '/mo' : '' }}</h3>
                </div>

                <!-- Lower Content (Ref Image 2 details) -->
                <div class="detail-content-box mt-4">
                    <div class="property-main-header">
                        <div class="price-box">
                            <h2 class="m-0">৳ {{ number_format($property->price, 2) }}{{ in_array($property->property_status, ['Rent', 'For Rent']) ? ' / mo' : '' }}</h2>
                            <div class="badge bg-primary mt-2">
                                @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                                    {{ $property->property_status }}
                                @else
                                    For {{ $property->property_status }}
                                @endif
                            </div>
                        </div>
                        <div class="meta-info">
                            <h3 class="m-0">ID: {{ $property->project_id }}</h3>
                            <div class="location-tag">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $property->sub_route }}{{ $property->sub_route && $property->route ? ', ' : '' }}{{ $property->route }}
                            </div>
                        </div>
                    </div>

                    <!-- Specs Grid -->
                    <h4 class="detail-section-title">Property Details</h4>
                    <div class="specs-grid">
                        @foreach($property->detailValues as $dv)
                            @if($dv->detail && $dv->value)
                                <div class="spec-item">
                                    <i class="{{ $dv->detail->icon ?? 'fas fa-info-circle' }} spec-icon"></i>
                                    <span class="spec-value">{{ $dv->value }}</span>
                                    <span class="spec-label">{{ $dv->detail->name }}</span>
                                </div>
                            @endif
                        @endforeach
                        <div class="spec-item">
                            <i class="fas fa-couch spec-icon"></i>
                            <span class="spec-value">{{ $property->is_furnished }}</span>
                            <span class="spec-label">Type</span>
                        </div>
                    </div>

                    <!-- Features & Amenities -->
                   @if(count($property->amenities))
                        <div class="features-container">
                            <h4 class="detail-section-title">Features & Amenities</h4>
                            <div class="features-grid">
                                @foreach($property->amenities as $amenity)
                                    <div class="feature-check">
                                        <i class="{{ $amenity->icon ?? 'fas fa-check-square' }}"></i> {{ $amenity->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                   @endif

                    <!-- Description -->
                   @if($property->description)
                        <h4 class="detail-section-title">Description</h4>
                        <div class="description-text">
                            {!! $property->description !!}
                        </div>
                   @endif

                    <!-- More Sections -->
                    @if($property->floor_plan)
                    <h4 class="detail-section-title">Floor Plan</h4>
                    <div class="mb-4 text-center">
                        <img src="{{ asset($property->floor_plan) }}" class="img-fluid rounded border" alt="Floor Plan for {{ $property->title }} - {{ $property->property_type }}" title="Floor Plan - {{ $property->title }}">
                    </div>
                    @endif

                    @if($property->video_link)
                        @php
                            $videoId = '';
                            if (str_contains($property->video_link, 'v=')) {
                                parse_str(parse_url($property->video_link, PHP_URL_QUERY), $vars);
                                $videoId = $vars['v'] ?? '';
                            } elseif (str_contains($property->video_link, 'youtu.be/')) {
                                $videoId = last(explode('/', parse_url($property->video_link, PHP_URL_PATH)));
                            } elseif (str_contains($property->video_link, 'embed/')) {
                                $videoId = last(explode('/', parse_url($property->video_link, PHP_URL_PATH)));
                            } else {
                                $videoId = $property->video_link;
                            }
                        @endphp
                        <h4 class="detail-section-title">Property Video</h4>
                        <div class="ratio ratio-16x9 mb-4 rounded overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="Property Video" allowfullscreen></iframe>
                        </div>
                    @endif

                    @if($property->map_link)
                        <h4 class="detail-section-title">Location</h4>
                        <div class="mb-4 rounded overflow-hidden border">
                            @if(str_contains($property->map_link, '<iframe'))
                                {!! $property->map_link !!}
                            @else
                                <iframe src="{{ $property->map_link }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            @endif
                        </div>
                    @else
                        <h4 class="detail-section-title">Location</h4>
                        <div class="mb-4 rounded overflow-hidden border">
                             <!-- Placeholder for Google Map if no link provided -->
                             <div style="height: 400px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">Interactive Map Placeholder</span>
                             </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Side: Sidebar (Ref Image 1 details) -->
            <div class="col-lg-4">
                <div class="details-sidebar">
                    <div class="seller-profile">
                        @if($property->user && $property->user->company && $property->user->company->logo)
                            <img src="{{ asset($property->user->company->logo) }}" class="seller-logo" alt="{{ $property->user->company->name }}">
                        @else
                            <div class="seller-logo d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-building text-muted"></i>
                            </div>
                        @endif
                        <div class="seller-info">
                            <h4>{{ $property->user->name ?? 'DProperty Agent' }}</h4>
                            <div class="verified-badge">
                                <i class="fas fa-check-circle"></i> VERIFIED SELLER
                            </div>
                            <p class="text-muted small mt-1">Agent ID: {{ $property->user->agent_id ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="contact-actions">
                        <button class="contact-btn btn-phone" id="showPhoneBtn">
                            <i class="fas fa-phone-alt"></i> {{ substr($property->user->phone ?? '01XXXXXXXXX', 0, 5) }}XXXXXX
                        </button>
                        <a href="mailto:{{ $property->user->email ?? '#' }}" class="contact-btn btn-chat">
                            <i class="fas fa-envelope"></i> Email Seller
                        </a>
                        <a href="https://wa.me/{{ $property->user->phone ?? '' }}" target="_blank" class="contact-btn btn-whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <h5 class="fw-bold mb-3">Safety Tips</h5>
                        <ul class="small text-muted ps-3">
                            <li>Meet the seller in a public place.</li>
                            <li>Check the property personally.</li>
                            <li>Don't pay upfront before visiting.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if(count($recommended_properties) > 0)
        <!-- Recommended Properties Section -->
        <div class="recommended-section mt-5 pb-5">
            <h3 class="detail-section-title mb-4">Recommended Properties</h3>
            <div class="row g-4">
                @foreach($recommended_properties as $rp)
                <div class="col-lg-3 col-md-6">
                    <div class="property-card-global">
                        <div class="card-image-box">
                            <div class="status-badge-container">
                                <span class="status-badge">For {{ $rp->property_status }}</span>
                            </div>
                            <div class="swiper card-inner-slider">
                                <div class="swiper-wrapper">
                                    @if($rp->feature_image)
                                        <div class="swiper-slide"><img src="{{ asset($rp->feature_image) }}" alt="{{ $rp->title }}"></div>
                                    @endif
                                    @php
                                        $gallery = is_array($rp->images) ? $rp->images : (json_decode($rp->images) ?? []);
                                    @endphp
                                    @foreach($gallery as $img)
                                        <div class="swiper-slide"><img src="{{ asset($img) }}" alt="{{ $rp->title }}"></div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="card-body-global">
                            <h3 class="card-title-global">
                                <a href="{{ route('property-details', $rp->id) }}">{{ $rp->title }}</a>
                            </h3>
                            <div class="info-grid">
                                <h4 class="price-text">৳ {{ number_format($rp->price, 0) }}{{ in_array($rp->property_status, ['Rent', 'For Rent']) ? '/mo' : '' }}</h4>
                                <div class="location-text">
                                    <i class="fas fa-map-marker-alt"></i> {{ $rp->location ? $rp->location->name : ($rp->sub_route ?: $rp->route) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer-global">
                            <div class="feature-item-global"><i class="fas fa-bed"></i> {{ $rp->bedrooms }} Bed</div>
                            <div class="feature-item-global"><i class="fas fa-bath"></i> {{ $rp->bathrooms }} Bath</div>
                            <div class="feature-item-global"><i class="fas fa-ruler-combined"></i> {{ $rp->area }} SFT</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Mobile Fixed Bottom Agent Bar -->
<div class="mobile-agent-bar d-lg-none">
    <div class="mobile-agent-info">
        @if($property->user && $property->user->company && $property->user->company->logo)
            <img src="{{ asset($property->user->company->logo) }}" class="mobile-agent-logo" alt="Agent">
        @else
            <div class="mobile-agent-logo d-flex align-items-center justify-content-center bg-light">
                <i class="fas fa-building text-muted"></i>
            </div>
        @endif
        <span class="mobile-agent-name">{{ $property->user->name ?? 'DProperty Agent' }}</span>
    </div>
    <div class="mobile-agent-actions">
        <a href="mailto:{{ $property->user->email ?? '#' }}" class="mobile-action-btn btn-email-m"><i class="fas fa-envelope"></i></a>
        <a href="https://wa.me/{{ $property->user->phone ?? '' }}" target="_blank" class="mobile-action-btn btn-wa-m"><i class="fab fa-whatsapp"></i></a>
        <a href="tel:{{ $property->user->phone ?? '' }}" class="mobile-action-btn btn-phone-m"><i class="fas fa-phone-alt"></i></a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Gallery Swipers
        var thumbsSwiper = new Swiper(".thumb-image-swiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        var mainSwiper = new Swiper(".main-image-swiper", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
        });

        // Initialize all inner card sliders for recommended properties
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

        // Phone Reveal Logic
        const phoneBtn = document.getElementById('showPhoneBtn');
        phoneBtn.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-phone-alt"></i> {{ $property->user->phone ?? "Private Number" }}';
            this.classList.add('bg-light');
        });
    });
</script>
@endpush
