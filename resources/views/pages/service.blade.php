@extends('master')

@section('content')
<div class="service-page-hero">
    <div class="container px-md-5 px-3">
        <nav aria-label="breadcrumb" class="breadcrumb-listing mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Our Services</li>
            </ol>
        </nav>
        <h1>Our Services</h1>
        <p class="mb-0 text-white-50">Professional property solutions tailored to your needs.</p>
    </div>
</div>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            @if(count($services))
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card h-100">
                            <div class="service-image mb-4">
                                <img src="{{$service->image}}" class="img-fluid" alt="{{ $service->title }}">
                            </div>
                            <h5 class="service-title fw-bold mb-3">{{$service->title}}</h5>
                            <p class="service-description text-muted" style="text-align:justify;">{{$service->description}}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <div class="empty-listings">
                        <i class="fas fa-concierge-bell fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Services Available</h4>
                        <p class="text-muted">Our services will be listed here soon.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
