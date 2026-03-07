<header class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNavbar">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{url('/')}}">
            <img src="{{$settings->logo??asset('images/logo_main.png')}}" alt="DProperty Logo" height="40" class="me-2 headerLogo">
        </a>

        <div class="d-flex align-items-center">
            <a href="https://wa.me/{{$settings->phone}}" target="_blank" class="whatsapp-icon me-4 d-lg-none">
{{--                <i class="bi bi-whatsapp" style="font-size: 1.7rem; color: #25D366;"></i>--}}
                <i class="bi bi-whatsapp" style="font-size: 1.7rem; color: #f5f9f9;"></i>
            </a>
            <button class="navbar-toggler d-lg-none navbar-light" type="button" id="mobileNavToggle">
                <span class="navbar-toggler-icon text-white" style="color: white !important;"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto">
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('/') ? 'active' : '' }}" href="{{url('/')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('buy') ? 'active' : '' }}" href="{{ route('buy') }}">Buy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('sell') ? 'active' : '' }}" href="{{ route('sell') }}">Sell</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('rent') ? 'active' : '' }}" href="{{ route('rent') }}">Rent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('services') ? 'active' : '' }}" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('projects') ? 'active' : '' }}" href="#projects">Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('about') ? 'active' : '' }}" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('contact') ? 'active' : '' }}" href="#contact">Contact Us</a>
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
                   <img src="{{asset('images/logo_main.png')}}" alt="DProperty" height="25" class="headerLogo">
               </a>
               <button class="mobile-nav-close" id="mobileNavClose">
                   <i class="bi bi-x"></i>
               </button>
           </div>

       </div>
        <ul class="mobile-nav-menu">
            <li><a href="#home" class="mobile-nav-link">Home</a></li>
            <li><a href="{{route('buy')}}" class="mobile-nav-link">Buy</a></li>
            <li><a href="{{route('rent')}}" class="mobile-nav-link">Rent</a></li>
            <li><a href="{{route('sell')}}" class="mobile-nav-link">Sell</a></li>
            <li><a href="#services" class="mobile-nav-link">Services</a></li>
            <li><a href="#projects" class="mobile-nav-link">Project</a></li>
            <li><a href="#contact" class="mobile-nav-link">Contact Us</a></li>
            <li><a href="#about" class="mobile-nav-link">About</a></li>
        </ul>
    </div>
</div>
