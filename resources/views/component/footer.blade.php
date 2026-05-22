<footer class="footerBackground text-white py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3">
                    <a href="{{url('/')}}">
                        <img src="{{$settings->logo??asset('images/logo_main.png')}}" alt="DProperty — Real Estate in Bangladesh" class="mb-2"
                             style="height: 40px;">
                    </a>
                </h5>
                <p class="text-light mb-3" style="text-align: justify;">{{$settings->site_description}}</p>
                <!-- Social Media Icons -->
                <div class="d-flex gap-2 mt-3 footer-social-icons">
                    @if($settings->facebook)
                        <a href="{{$settings->facebook}}" class="btn btn-outline-light btn-sm" target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if($settings->instagram)
                        <a href="{{$settings->instagram}}" class="btn btn-outline-light btn-sm" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    @if($settings->youtube)
                        <a href="{{$settings->youtube}}" class="btn btn-outline-light btn-sm" target="_blank">
                            <i class="bi bi-youtube"></i>
                        </a>
                    @endif
                    @if($settings->twitter)
                        <a href="{{$settings->twitter}}" class="btn btn-outline-light btn-sm" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                            </svg>
                        </a>
                    @endif
                    @if($settings->linkedin)
                        <a href="{{$settings->linkedin}}" class="btn btn-outline-light btn-sm" target="_blank">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    @endif
                    @if($settings->pinterest)
                        <a href="{{$settings->pinterest}}" class="btn btn-outline-light btn-sm" target="_blank">
                            <i class="bi bi-pinterest"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="fw-bold mb-3 footer-heading">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="{{ route('buy') }}" class="text-light text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i>Buy</a></li>
                    <li class="mb-2"><a href="{{ route('rent') }}" class="text-light text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i>Rent</a></li>
                    <li class="mb-2"><a href="{{ route('service') }}" class="text-light text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i>Service</a></li>
                    <li class="mb-2"><a href="{{ Request::is('/') ? '#about' : route('home').'/#about' }}" class="text-light text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i>About</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-light text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i>Contact</a></li>
                    <li class="mb-2"><a href="{{ route('post-property') }}" class="text-light text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i>Post Property</a></li>
                </ul>
            </div>

            <!-- Explore Neighborhoods -->
            <div class="col-lg-3 col-md-6 col-6">
                <h6 class="fw-bold mb-3 footer-heading">Explore Neighborhoods</h6>
                <ul class="list-unstyled footer-links footer-neighborhoods-list">
                    @if(isset($footerNeighborhoods) && count($footerNeighborhoods) > 0)
                        @foreach($footerNeighborhoods as $neighborhood)
                            <li class="mb-2">
                                <a href="{{ route('location.properties', $neighborhood->id) }}" class="text-light text-decoration-none">
                                    <i class="bi bi-chevron-right me-1 small"></i>{{ $neighborhood->name }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li class="mb-2 text-light opacity-75">No locations available</li>
                    @endif
                </ul>
            </div>

            <!-- Contact Info (includes address, phone, email) -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 footer-heading">Contact Info</h6>
                <ul class="list-unstyled footer-contact-list">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill me-2 mt-1 footer-contact-icon"></i>
                        <span class="text-light">{{$settings->address ?? '123 Business Street, Suite 100, Dhaka, Bangladesh'}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-telephone-fill me-2 mt-1 footer-contact-icon"></i>
                        <span class="text-light">{{$settings->phone ?? '+8801234567890'}}</span>
                    </li>
                    @if($settings->alt_phone ?? false)
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-phone-fill me-2 mt-1 footer-contact-icon"></i>
                        <span class="text-light">{{$settings->alt_phone}}</span>
                    </li>
                    @endif
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-envelope-fill me-2 mt-1 footer-contact-icon"></i>
                        <span class="text-light">{{$settings->email ?? ''}}</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-light opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 mb-2 mb-md-0">
                <p class="mb-0 small">&copy; {{ date('Y') }} DProperty. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{route('privacy-policy')}}" class="text-light text-decoration-none me-3 small footer-legal-link" target="_blank">Privacy Policy</a>
                <a href="{{route('terms-of-use')}}" class="text-light text-decoration-none me-3 small footer-legal-link" target="_blank">Terms of Service</a>
                <a href="{{route('site-map')}}" class="text-light text-decoration-none small footer-legal-link" target="_blank">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
<div id="backToTop" class="scroll-progress-btn" style="display: none;">
    <svg class="progress-ring" viewBox="0 0 60 60">
        <circle class="progress-ring-bg" cx="30" cy="30" r="26" />
        <circle class="progress-ring-fill" cx="30" cy="30" r="26" />
    </svg>
    <span class="scroll-arrow"><i class="bi bi-arrow-up"></i></span>
</div>
