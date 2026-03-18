<section id="projects" class="py-5" style="margin-top: 75px;">
    <div class="container-fluid px-md-5 px-3">
        <div class="section-header text-center w-100">
            <h2 class="text-primary">Featured Properties</h2>
            <p>
                {{$tags->where('service_type','featured_project')->first()->tag_line ??'Discover our exclusive selection of premium properties'}}
            </p>
        </div>

        <div class="custom-card-slider swiper px-4" id="featuredPropertiesSlider">
            <div class="swiper-wrapper">
                @if(isset($featured_properties) && count($featured_properties) > 0)
                    @foreach($featured_properties as $property)
                        <div class="swiper-slide h-auto">
                            <div class="card h-100 property-card">
                                <div class="property-image position-relative card-image-box">
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
                                    <div class="ratio ratio-16x9 card-inner-slider swiper">
                                        <div class="swiper-wrapper">
                                            @foreach($allImages as $sliderImg)
                                                <div class="swiper-slide"><img src="{{ $sliderImg }}" alt="" style="object-fit: cover;"></div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                                <div class="card-content p-3 card-body-global">
                                    <p class="mb-0">{{ $property->title }}</p>
                                    <p class="mb-0 small text-muted">{{ Str::limit(strip_tags($property->description), 100) }}</p>
                                </div>
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
