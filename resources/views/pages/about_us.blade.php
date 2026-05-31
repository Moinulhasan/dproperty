@extends('master')

@section('title', 'About Us — DProperty')
@section('meta_description', 'Learn about DProperty, our mission, and how we help thousands of clients buy, sell, and rent properties across Bangladesh with confidence.')

@section('content')
<div class="service-page-hero">
    <div class="container px-md-5 px-3">
        <nav aria-label="breadcrumb" class="breadcrumb-listing mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </nav>
        <h1>About Us</h1>
        <p class="mb-0 text-white-50">Who we are, what we believe in, and how we help you find the right property.</p>
    </div>
</div>

<section class="py-5 bg-white">
    <div class="container py-4">
        @if(count($abouts))
            @foreach($abouts as $key => $about)
                <div class="about-section mb-5 pb-5">
                 
                    
                    {{-- Image first in DOM so mobile (stacked) shows it on top.
                         On desktop we alternate left/right using Bootstrap's
                         order utilities. flex-row-reverse is intentionally NOT
                         used here because it would flip mobile order too. --}}
                    <div class="row align-items-center g-5">
                        @if($about->image)
                        <div class="col-lg-6 text-center order-lg-{{ $key % 2 == 0 ? 2 : 1 }}">
                            <img loading="lazy" src="{{ asset($about->image) }}" class="img-fluid" alt="{{ $about->title }}" style="max-height: 450px; object-fit: contain;">
                        </div>
                        @endif
                        <div class="{{ $about->image ? 'col-lg-6' : 'col-lg-12' }} order-lg-{{ $key % 2 == 0 ? 1 : 2 }}">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold" style="color: #333; font-size: 2rem;">{{ $about->title }}</h2>
                            </div>
                            <div class="text-muted" style="text-align:justify; line-height: 1.8; font-size: 1.05rem;">
                                {!! nl2br(e($about->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <div class="empty-listings">
                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Information Coming Soon</h4>
                    <p class="text-muted">We will update our about us section shortly.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- What People Think About Us -->
{{-- @include('component.testimony') --}}

@endsection
