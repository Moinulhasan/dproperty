<style>
    /* Pre-init layout: stop the lone Featured slide from stretching to full
       width during the brief window before Swiper applies its inline widths.
       Mirrors the post-init slidesPerView breakpoints. */
    #featuredPropertiesSlider:not(.swiper-initialized) .swiper-wrapper {
        display: flex;
        flex-wrap: nowrap;
        gap: 20px;
    }
    #featuredPropertiesSlider:not(.swiper-initialized) .swiper-slide {
        flex: 0 0 100%;
        max-width: 100%;
    }
    @media (min-width: 640px) {
        #featuredPropertiesSlider:not(.swiper-initialized) .swiper-slide {
            flex: 0 0 calc(50% - 10px);
            max-width: calc(50% - 10px);
        }
    }
    @media (min-width: 1024px) {
        #featuredPropertiesSlider:not(.swiper-initialized) .swiper-slide {
            flex: 0 0 calc(25% - 15px);
            max-width: calc(25% - 15px);
        }
    }
    /* Hide the nav arrows until Swiper has wired them up. */
    #featuredPropertiesSlider:not(.swiper-initialized) .swiper-navBtn {
        visibility: hidden;
    }

    /* Mobile search box now flows in document order with its own bottom
       margin, so we only need a small extra breath here. Desktop still has
       the absolutely-positioned search box and gets a tighter gap. */
    #projects {
        margin-top: 8px;
    }
    @media (min-width: 992px) {
        #projects {
            margin-top: 15px;
        }
    }
    #projects .section-header h2 {
        margin-bottom: 12px;
    }
    @media (max-width: 576px) {
        #projects .section-header h2 {
            font-size: 1.6rem;
        }
    }
</style>
<section id="projects" class="py-1 bg-light">
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
                                            <i class="fas fa-map-marker-alt"></i> {{ $property->displayLocation() }}
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

            <!-- Outer carousel navigation. Use a unique class so the inner
                 card-image carousels don't hijack the buttons. -->
            <div class="swiper-button-next swiper-navBtn featured-next"></div>
            <div class="swiper-button-prev swiper-navBtn featured-prev"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const featuredEl = document.getElementById('featuredPropertiesSlider');
        if (!featuredEl) return;

        // 1) Initialize the inner per-card image sliders FIRST. Their nav
        //    buttons must be wired up before the outer Swiper looks at the
        //    DOM, otherwise loop mode clones unwired buttons and the layout
        //    breaks after the first set.
        featuredEl.querySelectorAll('.card-inner-slider').forEach(function (slider) {
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

        // 2) Outer carousel. Loop disabled when there isn't enough content to
        //    fill the visible area (Swiper's clone logic mis-renders below
        //    that threshold on mobile and can crash on scroll-back).
        const slideCount = featuredEl.querySelectorAll(':scope > .swiper-wrapper > .swiper-slide').length;
        const enableLoop = slideCount >= 5;

        // observer/observeParents were removed. On Safari they fed into a
        // feedback loop with the per-card inner Swipers' DOM mutations and
        // exhausted the tab's memory ceiling, killing the page.
        const featuredSwiper = new Swiper(featuredEl, {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: enableLoop,
            loopAdditionalSlides: enableLoop ? 2 : 0,
            watchOverflow: true,
            autoplay: slideCount > 1 ? {
                delay: 6000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            navigation: {
                nextEl: featuredEl.querySelector('.featured-next'),
                prevEl: featuredEl.querySelector('.featured-prev'),
            },
            breakpoints: {
                640:  { slidesPerView: 2, loop: enableLoop && slideCount >= 5 },
                1024: { slidesPerView: 4, loop: enableLoop && slideCount >= 8 },
            },
        });

        // Pause autoplay when this section scrolls off-screen — keeps Safari
        // from burning cycles on a background animation and stops autoplay
        // from "catching up" in a burst when the user scrolls back.
        if (featuredSwiper && featuredSwiper.autoplay && 'IntersectionObserver' in window) {
            const obs = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!featuredSwiper.autoplay) return;
                    if (entry.isIntersecting) {
                        featuredSwiper.autoplay.start();
                    } else {
                        featuredSwiper.autoplay.stop();
                    }
                });
            }, { threshold: 0.1 });
            obs.observe(featuredEl);
        }
    });
</script>
@endpush
