@extends('master')

@section('title', $property->title . ' — DProperty')
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

    @php
        $isRental    = in_array($property->property_status, ['Rent', 'For Rent']);
        // Schema.org streetAddress — same sequence as the on-page address.
        $addressLine = $property->fullAddress();
        $propertyImages = collect([$property->feature_image])
            ->merge(is_array($property->images) ? $property->images : [])
            ->filter()
            ->map(fn ($i) => asset($i))
            ->values();
    @endphp

    @php
        $statusForCrumb = strtolower($property->property_status);
        $crumbRoute = 'buy';
        if (str_contains($statusForCrumb, 'rent')) $crumbRoute = 'rent';
        elseif (str_contains($statusForCrumb, 'sell') || str_contains($statusForCrumb, 'sale')) $crumbRoute = 'sell';
    @endphp
    @include('component._breadcrumb_jsonld', ['crumbs' => [
        ['name' => 'Home',                       'url' => route('home')],
        ['name' => $property->property_status,   'url' => route($crumbRoute)],
        ['name' => $property->title,             'url' => url()->current()],
    ]])

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "{{ $isRental ? 'RentAction' : 'Product' }}",
        "name": "{{ addslashes($property->title) }}",
        "description": "{{ addslashes(Str::limit(strip_tags($property->description), 300)) }}",
        "url": "{{ url()->current() }}",
        @if($propertyImages->count())
        "image": {!! json_encode($propertyImages->all()) !!},
        @endif
        "offers": {
            "@type": "Offer",
            "price": "{{ $property->price }}",
            "priceCurrency": "BDT",
            "availability": "https://schema.org/InStock",
            "url": "{{ url()->current() }}",
            "businessFunction": "{{ $isRental ? 'http://purl.org/goodrelations/v1#LeaseOut' : 'http://purl.org/goodrelations/v1#Sell' }}"
        },
        "category": "{{ addslashes($property->category ?? $property->property_type ?? 'Real Estate') }}",
        @if($addressLine)
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ addslashes($addressLine) }}",
            "addressCountry": "BD"
        },
        @endif
        "additionalProperty": [
            @if($property->bedrooms) { "@type": "PropertyValue", "name": "Bedrooms",  "value": "{{ $property->bedrooms }}"  } @endif
            @if($property->bedrooms && ($property->bathrooms || $property->area)),@endif
            @if($property->bathrooms){ "@type": "PropertyValue", "name": "Bathrooms", "value": "{{ $property->bathrooms }}" } @endif
            @if($property->bathrooms && $property->area),@endif
            @if($property->area)     { "@type": "PropertyValue", "name": "Area (SFT)","value": "{{ $property->area }}"      } @endif
        ]
    }
    </script>
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
                                <img loading="lazy" src="{{ asset($img) }}" alt="{{ $property->title }} - Gallery Image" title="{{ $property->title }}">
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
                                <img loading="lazy" src="{{ asset($property->feature_image) }}" alt="{{ $property->title }} thumbnail">
                            </div>
                            @endif
                            @foreach($gallery as $img)
                            <div class="swiper-slide">
                                <img loading="lazy" src="{{ asset($img) }}" alt="{{ $property->title }} thumbnail">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Mobile Title (shown only on mobile, after image) -->
                @php
                    // Address parts are appended in this order:
                    //   lane → road → sub_route → route → location->name
                    // location->name is REQUIRED at the admin level and is the
                    // last (and most important) segment. The helper drops only
                    // truly empty optional parts and de-duplicates legacy
                    // route/sub_route values that already match the location.
                    $fullAddress = $property->fullAddress();
                @endphp
                <div class="mobile-title-section d-lg-none mt-3">
                    <h2 class="mobile-property-title mb-2">{{ $property->title }}</h2>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="mobile-price m-0">৳ {{ number_format($property->price, 0) }}{{ in_array($property->property_status, ['Rent', 'For Rent']) ? '/mo' : '' }}</h3>
                        <span class="mobile-meta-id">ID: {{ $property->project_id }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <span class="mobile-furnish-tag">{{ $property->is_furnished }}</span>
                        <div class="mobile-location m-0 text-end">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $fullAddress  }}
                        </div>
                    </div>
                </div>

                <!-- Lower Content (Ref Image 2 details) -->
                <div class="detail-content-box mt-4">
                    <div class="property-main-header">
                        <div class="price-box">
                            <h2 class="m-0">৳ {{ number_format($property->price, 2) }}{{ in_array($property->property_status, ['Rent', 'For Rent']) ? ' / mo' : '' }}</h2>
                            @php
                                $statusLower = strtolower($property->property_status);
                                $statusBadgeClass = 'bg-danger'; // Sell
                                if (str_contains($statusLower, 'rent')) $statusBadgeClass = 'bg-success';
                                elseif (str_contains($statusLower, 'buy')) $statusBadgeClass = 'bg-warning text-dark';
                            @endphp
                              
                        
                            <div class="location-tag">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $fullAddress }}
                            </div>
                        </div>
                        <div class="meta-info">
                            <h3 class="m-0">ID: {{ $property->project_id }}</h3>
                            <div class="badge {{ $statusBadgeClass }} mt-2">
                                    {{ $property->is_furnished }}
                        
                            </div>
                        </div>
                    </div>

                    <!-- Specs Grid -->
                    <h4 class="detail-section-title">Property Details</h4>
                    <div class="specs-grid">
                        {{-- Sorted ascending by PropertyDetail.sort_order (admin-controlled),
                             then alphabetically by name as a stable tiebreaker. --}}
                        @foreach($property->detailValues->sortBy(fn ($dv) => [optional($dv->detail)->sort_order ?? PHP_INT_MAX, optional($dv->detail)->name ?? '']) as $dv)
                            @if($dv->detail && $dv->value)
                                <div class="spec-item">
                                    <i class="{{ $dv->detail->icon ?? 'fas fa-info-circle' }} spec-icon"></i>
                                    <span class="spec-value">{{ $dv->value }}</span>
                                    <span class="spec-label">{{ $dv->detail->name }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Features & Amenities -->
                   @if(count($property->amenities))
                        <div class="features-container">
                            <h4 class="detail-section-title">Features & Amenities</h4>
                            <div class="features-grid">
                                {{-- Sorted ascending alphabetically by name. --}}
                                @foreach($property->amenities->sortBy('name') as $amenity)
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
                        <img loading="lazy" src="{{ asset($property->floor_plan) }}" class="img-fluid rounded border" alt="Floor Plan for {{ $property->title }} - {{ $property->property_type }}" title="Floor Plan - {{ $property->title }}">
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
                        <div class="video-container-half">
                            <div class="ratio ratio-16x9 rounded overflow-hidden">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="Property Video" allowfullscreen></iframe>
                            </div>
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
                    @endif
                </div>
            </div>

            <!-- Right Side: Sidebar (Ref Image 1 details) -->
            @php
                // Prefer the explicitly-selected property company; otherwise
                // fall back to the creator's company (legacy behavior).
                $sellerCompany = $property->company ?? optional($property->user)->company;
                $useCompany    = (bool) $property->company;

                $sellerName  = $useCompany ? $sellerCompany->name  : ($property->user->name  ?? 'DProperty Agent');
                $sellerLogo  = $sellerCompany && $sellerCompany->logo ? asset($sellerCompany->logo) : null;
                $sellerPhone = $useCompany ? ($sellerCompany->phone ?? $property->user->phone ?? '') : ($property->user->phone ?? '');
                $sellerEmail = $useCompany ? ($sellerCompany->email ?? $property->user->email ?? '') : ($property->user->email ?? '');
                $sellerBadge = $useCompany ? 'VERIFIED COMPANY' : 'VERIFIED SELLER';
                $sellerSub   = $useCompany
                    ? ($sellerCompany->address ?? null)
                    : 'Agent ID: ' . ($property->user->agent_id ?? 'N/A');
                $phoneMasked = $sellerPhone ? substr($sellerPhone, 0, 5) . 'XXXXXX' : '01XXXXXXXXX';

                // WhatsApp prefers the user's dedicated whatsapp_number when
                // present, then falls back to phone. wa.me requires a digits-
                // only international number — strip every non-digit and turn
                // a local "01XXXXXXXXX" Bangladesh format into "8801XXXXXXXXX".
                $sellerWaRaw = $useCompany
                    ? ($sellerCompany->phone ?? $property->user->whatsapp_number ?? $property->user->phone ?? '')
                    : ($property->user->whatsapp_number ?? $property->user->phone ?? '');
                $sellerWa = preg_replace('/\D+/', '', (string) $sellerWaRaw);
                if ($sellerWa !== '' && str_starts_with($sellerWa, '0')) {
                    $sellerWa = '880' . ltrim($sellerWa, '0');
                }
            @endphp
            <div class="col-lg-4">
                <div class="details-sidebar">
                    <div class="seller-profile">
                        @if($sellerLogo)
                            <img src="{{ $sellerLogo }}" class="seller-logo" alt="{{ $sellerName }}">
                        @else
                            <div class="seller-logo d-flex align-items-center justify-content-center bg-light">
                                <i class="fas fa-building text-muted"></i>
                            </div>
                        @endif
                        <div class="seller-info">
                            <h4>{{ $sellerName }}</h4>
                            <div class="verified-badge">
                                <i class="fas fa-check-circle"></i> {{ $sellerBadge }}
                            </div>
                            @if($sellerSub)
                                <p class="text-muted small mt-1">{{ $sellerSub }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="contact-actions">
                        <button class="contact-btn btn-phone" id="showPhoneBtn" data-full-phone="{{ $sellerPhone }}">
                            <i class="fas fa-phone-alt"></i> {{ $phoneMasked }}
                        </button>
                        <a href="mailto:{{ $sellerEmail ?: '#' }}" class="contact-btn btn-chat">
                            <i class="fas fa-envelope"></i> Email {{ $useCompany ? 'Company' : 'Seller' }}
                        </a>
                        @if($sellerWa)
                            <a href="https://wa.me/{{ $sellerWa }}" target="_blank" rel="noopener" class="contact-btn btn-whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        @endif
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
                                @php
                                    $statusLower = strtolower($rp->property_status);
                                    $statusClass = 'status-sell'; // Default
                                    if (str_contains($statusLower, 'rent')) $statusClass = 'status-rent';
                                    elseif (str_contains($statusLower, 'buy')) $statusClass = 'status-buy';
                                @endphp
                                <div class="status-badge {{ $statusClass }}">
                                    <span class="badge-dot left"></span>
                                    <span class="badge-dot right"></span>
                                    @if(str_starts_with($rp->property_status, 'For') || $rp->property_status == 'Buy')
                                        {{ $rp->property_status }}
                                    @else
                                        For {{ $rp->property_status }}
                                    @endif
                                </div>
                                <span class="type-badge">{{ $rp->category }}</span>
                            </div>
                            
                            @php
                                $gallery = is_array($rp->images) ? $rp->images : (json_decode($rp->images) ?? []);
                                $allImages = [];
                                if ($rp->feature_image) $allImages[] = asset($rp->feature_image);
                                foreach ($gallery as $img) $allImages[] = asset($img);
                                if (empty($allImages)) $allImages[] = 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80';
                            @endphp
                            <div class="card-image-hover-actions">
                                <button class="action-btn share-btn" title="Share" onclick="event.preventDefault(); navigator.clipboard.writeText('{{ route('property-details', $rp->id) }}'); alert('Link copied to clipboard!');">
                                    <i class="fas fa-bookmark"></i>
                                </button>
                                <button class="action-btn gallery-btn" title="View All Image" data-images="{{ json_encode($allImages) }}" onclick="event.preventDefault(); openGallery(this);">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>

                            <div class="swiper card-inner-slider">
                                <div class="swiper-wrapper">
                                    @if($rp->feature_image)
                                        <div class="swiper-slide"><img loading="lazy" src="{{ asset($rp->feature_image) }}" alt="{{ $rp->title }}"></div>
                                    @endif
                                    @foreach($gallery as $img)
                                        <div class="swiper-slide"><img loading="lazy" src="{{ asset($img) }}" alt="{{ $rp->title }}"></div>
                                    @endforeach
                                    @if(!$rp->feature_image && count($gallery) == 0)
                                        <div class="swiper-slide"><img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" alt="Default Image"></div>
                                    @endif
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="card-body-global">
                            <h3 class="card-title-global">
                                <a href="{{ route('property-details', $rp->id) }}" target="_blank">{{ $rp->title }}</a>
                            </h3>
                            <div class="info-grid">
                                <h4 class="price-text">৳ {{ number_format($rp->price, 0) }}{{ in_array($rp->property_status, ['Rent', 'For Rent']) ? ' / mo' : '' }}</h4>
                                <div class="detail-item"><span class="info-label">ID:</span> {{ $rp->project_id }}</div>
                                
                                <div class="location-text">
                                    <i class="fas fa-map-marker-alt"></i> {{ $rp->displayLocation() }}
                                </div>
                                <div class="detail-item"><span class="info-label">Type:</span> {{ $rp->is_furnished }}</div>
                            </div>
                        </div>
                        @include('component._card_footer', ['p' => $rp])
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
        @if($sellerLogo)
            <img src="{{ $sellerLogo }}" class="mobile-agent-logo" alt="{{ $sellerName }}">
        @else
            <div class="mobile-agent-logo d-flex align-items-center justify-content-center bg-light">
                <i class="fas fa-building text-muted"></i>
            </div>
        @endif
        <span class="mobile-agent-name">{{ $sellerName }}</span>
    </div>
    <div class="mobile-agent-actions">
        <a href="mailto:{{ $sellerEmail ?: '#' }}" class="mobile-action-btn btn-email-m"><i class="fas fa-envelope"></i></a>
        @if($sellerWa)
            <a href="https://wa.me/{{ $sellerWa }}" target="_blank" rel="noopener" class="mobile-action-btn btn-wa-m"><i class="fab fa-whatsapp"></i></a>
        @endif
        <a href="tel:{{ $sellerPhone }}" class="mobile-action-btn btn-phone-m"><i class="fas fa-phone-alt"></i></a>
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
        if (phoneBtn) {
            phoneBtn.addEventListener('click', function() {
                const phone = this.dataset.fullPhone || 'Private Number';
                this.innerHTML = '<i class="fas fa-phone-alt"></i> ' + phone;
                this.classList.add('bg-light');
            });
        }
    });
</script>
@endpush
