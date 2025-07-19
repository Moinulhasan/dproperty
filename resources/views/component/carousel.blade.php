<!-- Carousel Section -->
<section id="home" class="hero-carousel-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if(count($sliders))
                @foreach($sliders as $slider)
                    <div class="carousel-item {{$loop->index == 0 ? 'active' : ''}}">
                        <div class="hero-slide" style="background-image: url('{{$slider->image}}');">
                            <div class="hero-overlay"></div>
                            <div class="container">
                                <div class="row align-items-center min-vh-70">
                                                                <div class="col-lg-8">
                                    <div class="hero-content animate-slide-up">
                                        <p class="hero-subtitle">{{$slider->title}}</p>
                                    </div>
                                                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

{{--            <div class="carousel-item active">--}}
{{--                <div class="hero-slide" style="background-image: url('{{asset('images/carousal/pexels-fotoaibe-1743227.jpg')}}');">--}}
{{--                    <div class="hero-overlay"></div>--}}
{{--                    <div class="container">--}}
{{--                        <div class="row align-items-center min-vh-70">--}}
{{--                            <div class="col-lg-8">--}}
{{--                                <div class="hero-content animate-slide-up">--}}
{{--                                    <p class="hero-subtitle">Expert property management services with cutting-edge technology</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        <div class="carousel-indicators">
            @if(count($sliders))
                @foreach($sliders as $slider)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{$loop->index}}" class="{{$slider->first() ?'active':''}}"></button>
                @endforeach
            @endif
{{--            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>--}}
{{--            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>--}}
{{--            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>--}}
        </div>
    </div>
</section>
