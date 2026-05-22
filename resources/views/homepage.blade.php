@extends('master')

@section('title', ($settings->site_name ?? 'DProperty') . ' — Buy, Sell & Rent Properties in Bangladesh')
@section('meta_description', $settings->site_description ?? 'Find your next home, office, or investment property. DProperty lists thousands of verified apartments, houses, and commercial spaces for sale and rent across Bangladesh.')

@section('content')
    <h1 class="visually-hidden">Buy, Sell, and Rent Properties in Bangladesh — DProperty</h1>
    @include('component.carousel')
    @include('component.social')
    @include('component.for_rent')
    @include('component.for_sale')
    @include('component.neighborhoods')
    @include('component.articles')
    @include('component.why_us')
    @include('component.testimony')
@endsection

