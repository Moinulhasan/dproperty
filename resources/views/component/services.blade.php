<section id="services" class="pt-2 pb-3 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-3">
                <h2 class="display-5 fw-bold text-dark">Our Services</h2>
                <p class="lead text-muted">There is no greater benchmark for success than customer satisfaction.
                    Over the years, we’ve built a culture of service.</p>
            </div>
        </div>

        <div class="row g-4">
            @if(count($services))
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card h-100">
                            <div class="service-image mb-4">
                                <img src="{{$service->image}}" class="img-fluid" alt="Buy Propert">
                            </div>
                            <h5 class="service-title fw-bold mb-3">{{$service->title}}</h5>
                            <p class="service-description text-muted">{{$service->description}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
