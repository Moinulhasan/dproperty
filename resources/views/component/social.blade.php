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
                @if(count($properties))
                    @foreach($properties as $property)
                        <div class="swiper-slide h-auto">
                            <div class="card h-100 property-card">
                                <div class="property-image">
                                    <div class="ratio ratio-16x9">
                                        {!! $property->link !!}
                                    </div>
                                </div>
                                <div class="card-content p-3">
                                    <p class="mb-0">{{$property->description}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
        const featuredSwiper = new Swiper('#featuredPropertiesSlider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 6000,
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
                }
            }
        });
    });
</script>
@endpush
