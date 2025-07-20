<section id="reviews" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-3">
                <h2 class="display-5 fw-bold text-dark">What People Think About Our Services</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        @if(count($testimonials))
                            @foreach($testimonials as $testimonial)
                                <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                    <div class="testimonial-card text-center p-5">
                                        <p class="testimonial-text fst-italic text-muted mb-4">{{$testimonial->review}}</p>
                                        <div class="testimonial-author">
                                            <a href="" class="text-decoration-none">
                                                <img src="{{$testimonial->image}}" class="rounded-circle mb-3"
                                                     alt="{{$testimonial->name}}">
                                                <h6 class="fw-bold mb-1">{{$testimonial->name}}</h6>
                                                <p class="text-primary mb-0">{{$testimonial->designation}}</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <div class="carousel-indicators">
                        @if(count($testimonials))
                            @foreach($testimonials as $testimonial)
                                <button type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="{{$loop->index}}" class="{{$loop->first ?'active':''}}"></button>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
