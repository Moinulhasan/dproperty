<section class="neighborhoods-section">
    <div class="container-fluid px-md-5 px-3">
        <div class="section-header">
            <h2 class="text-primary">Explore The Neighborhoods</h2>
        </div>

        <div class="neighborhood-slider swiper" data-count="{{ count($neighborhoods) }}">
            <div class="swiper-wrapper">
                @forelse($neighborhoods as $neighborhood)
                <div class="swiper-slide">
                    <a href="{{ route('location.properties', $neighborhood->id) }}" class="neighborhood-card-link text-decoration-none">
                        <div class="neighborhood-card">
                            @if($neighborhood->image)
                                <img loading="lazy" decoding="async" src="{{ thumb($neighborhood->image) }}" srcset="{{ thumb($neighborhood->image, 480) }} 480w, {{ thumb($neighborhood->image, 960) }} 960w" sizes="(max-width:768px) 100vw, 480px" alt="Explore properties in {{ $neighborhood->name }} - DProperty Neighborhoods" title="Properties in {{ $neighborhood->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=800&q=80" alt="{{ $neighborhood->name }} Neighborhood - DProperty" title="{{ $neighborhood->name }}">
                            @endif
                            <div class="card-overlay"></div>
                            <div class="card-content">
{{--                                <div class="property-count">{{ $neighborhood->properties_count ?? 0 }} Properties</div>--}}
                                <h3 class="neighborhood-name">{{ $neighborhood->name }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                    <div class="swiper-slide">
                        <div class="text-center text-muted py-5">No neighborhoods available.</div>
                    </div>
                @endforelse
            </div>

            <!-- Add Swiper Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
