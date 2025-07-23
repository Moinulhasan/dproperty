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
                                        @if($propertie->type == 'youtube')
                                            <iframe
                                                src="{{$propertie->link}}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                referrerpolicy="strict-origin-when-cross-origin"
                                                allowfullscreen></iframe>
                                        @else
                                            <iframe
                                                src="{{$propertie->link}}"
                                                title="Facebook video player" frameborder="0"
                                                allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                referrerpolicy="strict-origin-when-cross-origin"
                                                allowfullscreen></iframe>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p>{{$propertie->description}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{--                    <div class="card swiper-slide">--}}
                    {{--                        <div class="image-content">--}}
                    {{--                            <span class="overlay"></span>--}}

                    {{--                            <div class="card-image">--}}
                    {{--                                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjxivAs4UknzmDfLBXGMxQkayiZDhR2ftB4jcIV7LEnIEStiUyMygioZnbLXCAND-I_xWQpVp0jv-dv9NVNbuKn4sNpXYtLIJk2-IOdWQNpC2Ldapnljifu0pnQqAWU848Ja4lT9ugQex-nwECEh3a96GXwiRXlnGEE6FFF_tKm66IGe3fzmLaVIoNL/s1600/img_avatar.png" alt="" class="card-img">--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div class="card-content">--}}
                    {{--                            <h2 class="name">Mohamed Yousef--}}
                    {{--                            </h2>--}}
                    {{--                            <p class="description">The lorem text the section that contains header with having open functionality. Lorem dolor sit amet consectetur adipisicing elit.</p>--}}

                    {{--                            <button class="button">View More</button>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>

            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

