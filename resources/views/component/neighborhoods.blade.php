<section class="neighborhoods-section">
    <div class="container-fluid px-5">
        <div class="section-header">
            <h2 class="text-primary">Explore The Neighborhoods</h2>
            <p>Find your dream apartment with our listing</p>
        </div>

        <div class="neighborhood-slider swiper">
            <div class="swiper-wrapper">
                <!-- Neighborhood item 1 -->
                <div class="swiper-slide">
                    <div class="neighborhood-card">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80" alt="New York">
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <div class="property-count">421 Properties</div>
                            <h3 class="neighborhood-name">Los Angeles, New York</h3>
                        </div>
                    </div>
                </div>

                <!-- Neighborhood item 2 -->
                <div class="swiper-slide">
                    <div class="neighborhood-card">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" alt="Seoul">
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <div class="property-count">321 Properties</div>
                            <h3 class="neighborhood-name">Seoul, South Korea</h3>
                        </div>
                    </div>
                </div>

                <!-- Neighborhood item 3 -->
                <div class="swiper-slide">
                    <div class="neighborhood-card">
                        <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=800&q=80" alt="Seoul">
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <div class="property-count">212 Properties</div>
                            <h3 class="neighborhood-name">Seoul, South Korea</h3>
                        </div>
                    </div>
                </div>

                <!-- Neighborhood item 4 -->
                <div class="swiper-slide">
                    <div class="neighborhood-card">
                        <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=800&q=80" alt="London">
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <div class="property-count">432 Properties</div>
                            <h3 class="neighborhood-name">London, United Kingdom</h3>
                        </div>
                    </div>
                </div>

                <!-- Neighborhood item 5 -->
                <div class="swiper-slide">
                    <div class="neighborhood-card">
                        <img src="https://images.unsplash.com/photo-1523217582562-09d0def993a6?auto=format&fit=crop&w=800&q=80" alt="New Jersey">
                        <div class="card-overlay"></div>
                        <div class="featured-badge">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="card-content">
                            <div class="property-count">211 Properties</div>
                            <h3 class="neighborhood-name">New Jersey, New York</h3>
                        </div>
                    </div>
                </div>

                <!-- Neighborhood item 6 (Duplicate for slider feel) -->
                <div class="swiper-slide">
                    <div class="neighborhood-card">
                        <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=80" alt="Miami">
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <div class="property-count">150 Properties</div>
                            <h3 class="neighborhood-name">Miami, Florida</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Swiper Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.neighborhood-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
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
                },
                1440: {
                    slidesPerView: 5,
                }
            }
        });
    });
</script>
@endpush
