@extends('master')

@section('content')

<div class="pt-5 mt-4"></div> <!-- Spacer for fixed navbar -->

<section class="py-5 bg-white">
    <div class="container py-4">
        @if(count($abouts))
            @foreach($abouts as $key => $about)
                <div class="about-section mb-5 pb-5">
                 
                    
                    <div class="row align-items-center {{ $key % 2 != 0 ? 'flex-row-reverse' : '' }} g-5">
                        <div class="{{ $about->image ? 'col-lg-6' : 'col-lg-12' }}">
                            <div class="text-center mb-5">
                        <h2 class="fw-bold" style="color: #333; font-size: 2rem;">{{ $about->title }}</h2>
                    </div>
                            <div class="text-muted" style="text-align:justify; line-height: 1.8; font-size: 1.05rem;">
                                {!! nl2br(e($about->description)) !!}
                            </div>
                        </div>
                        @if($about->image)
                        <div class="col-lg-6 text-center">
                            <img src="{{ asset($about->image) }}" class="img-fluid" alt="{{ $about->title }}" style="max-height: 450px; object-fit: contain;">
                        </div>
                        @endif
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
@include('component.testimony')

@endsection
