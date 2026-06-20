@php
    // wa.me needs a digits-only international number — strip every non-digit
    // and prepend 880 (Bangladesh country code) when the saved number is in
    // local "01XXXXXXXXX" format. Returns null when there's no phone at all
    // so the WhatsApp icon below can render as a no-op or be hidden.
    $navWa = preg_replace('/\D+/', '', (string) ($settings?->phone ?? ''));
    if ($navWa !== '' && str_starts_with($navWa, '0')) {
        $navWa = '880' . ltrim($navWa, '0');
    }
    $navLogo = $settings?->logo ?: asset('images/logo_main.png');
@endphp
<header class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="{{url('/')}}">
            <img src="{{ $navLogo }}" alt="DProperty — Real Estate in Bangladesh" height="40" class="me-2 headerLogo">
        </a>

        <div class="d-flex align-items-center">
            @if($navWa)
                <a href="https://wa.me/{{ $navWa }}" target="_blank" rel="noopener" class="whatsapp-icon me-4 d-lg-none">
                    <i class="bi bi-whatsapp" style="font-size: 1.7rem; color: #25D366;"></i>
                </a>
            @endif
            <button class="navbar-toggler d-lg-none navbar-light" type="button" id="mobileNavToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{url('/')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('buy*') ? 'active' : '' }}" href="{{ route('buy') }}">Buy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rent*') ? 'active' : '' }}" href="{{ route('rent') }}">Rent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('post-property') ? 'active' : '' }}" href="{{ route('post-property') }}">Post Property</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('service') ? 'active' : '' }}" href="{{ route('service') }}">Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}" href="{{ route('about-us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('blog') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<div class="mobile-nav-overlay" id="mobileNavOverlay">
    <div class="mobile-nav-content">
       <div>
           <div class="mobile-nav-header">
               <a href="{{url('/')}}">
                   <img src="{{ $navLogo }}" alt="DProperty — Real Estate in Bangladesh" height="25" class="headerLogo">
               </a>
               <button class="mobile-nav-close" id="mobileNavClose">
                   <i class="bi bi-x"></i>
               </button>
           </div>

       </div>
        <ul class="mobile-nav-menu">
            <li><a href="{{url('/')}}" class="mobile-nav-link">Home</a></li>
            <li><a href="{{route('buy')}}" class="mobile-nav-link">Buy</a></li>
            <li><a href="{{route('rent')}}" class="mobile-nav-link">Rent</a></li>
            <li><a href="{{ route('post-property') }}" class="mobile-nav-link {{ request()->routeIs('post-property') ? 'active' : '' }}">Post Property</a></li>
            <li><a href="{{ route('service') }}" class="mobile-nav-link">Service</a></li>
            <li><a href="{{ route('about-us') }}" class="mobile-nav-link {{ request()->routeIs('about-us') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{ route('blog') }}" class="mobile-nav-link {{ Request::is('blog') ? 'active' : '' }}">Blog</a></li>
            <li><a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a></li>
        </ul>
    </div>
</div>
