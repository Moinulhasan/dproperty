@extends('master')

@section('title', 'Contact Us — DProperty')
@section('meta_description', 'Get in touch with DProperty. Talk to our expert real-estate consultants for any question about buying, selling, or renting property in Bangladesh.')

@section('content')
<div class="service-page-hero">
    <div class="container px-md-5 px-3">
        <nav aria-label="breadcrumb" class="breadcrumb-listing mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ol>
        </nav>
        <h1>Contact Us</h1>
        <p class="mb-0 text-white-50">Talk to our team — we're here to help with any property question.</p>
    </div>
</div>

@include('component.contact')
@endsection

@section('scripts')
<script>
    // Any contact page specific script can go here
</script>
@endsection
