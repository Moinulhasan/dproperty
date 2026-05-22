<section id="projects" class="py-1 bg-light" style="margin-top: 15px;">
    <div class="container-fluid px-md-5 px-3">
        <div class="section-header text-center w-100">
            <h2 class="text-primary">Featured Properties</h2>
        </div>

        <div class="custom-card-slider swiper" id="featuredPropertiesSlider">
            <div class="swiper-wrapper">
                @if(isset($featured_properties) && count($featured_properties) > 0)
                    @foreach($featured_properties as $property)
                        <div class="swiper-slide h-auto">
                            <div class="property-card-global h-100">
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
                                    <div class="card-inner-slider swiper">
                                        <div class="swiper-wrapper">
                                            @foreach($allImages as $sliderImg)
                                                <div class="swiper-slide"><img src="{{ $sliderImg }}" alt="" class="w-100 h-100" style="object-fit: cover;"></div>
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
                                        <h4 class="price-text">৳ {{ number_format($property->price, 0) }}</h4>
                                        <div class="location-text">
                                            <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: $property->route }}
                                        </div>
                                    </div>
                                </div>
                                @include('component._card_footer', ['p' => $property])
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted py-5">
                        <p>No featured properties available at the moment.</p>
                    </div>
                @endif
            </div>

            <!-- Add Swiper Navigation -->
            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slideCount = {{ isset($featured_properties) ? count($featured_properties) : 0 }};
        const featuredSwiper = new Swiper('#featuredPropertiesSlider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: slideCount > 4,
            watchOverflow: true,
            autoplay: slideCount > 1 ? {
                delay: 6000,
                disableOnInteraction: false,
            } : false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                }
            }
        });
    });
</script>
@endpush
