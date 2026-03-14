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
                                <div class="property-image">
                                    <div class="ratio ratio-16x9">
                                        <img src="{{asset( $property->feature_image)}}" alt="">
                                    </div>
                                </div>
                                <div class="card-content p-3">
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
