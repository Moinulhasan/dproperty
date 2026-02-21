<section id="projects" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-3">
                <h2 class="display-5 fw-bold text-primary">Featured Properties</h2>
                <p class="lead text-muted">
                    {{$tags->where('service_type','featured_project')->first()->tag_line ??'Discover our exclusive selection of premium properties'}}
                </p>
            </div>
        </div>
        <div class="swiper" id="sliderContent">
            <div class="slide-content">
                <div class="card-wrapper swiper-wrapper">
                    @if(count($properties))
                        @foreach($properties as $propertie)
                            <div class="card swiper-slide">
                                <div class="property-image">
                                    <div class="ratio ratio-16x9">
                                        {!! $propertie->link !!}
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p>{{$propertie->description}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

