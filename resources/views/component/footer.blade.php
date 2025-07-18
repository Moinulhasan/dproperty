<footer class="footerBackground text-white py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3">
                    <a href="{{url('/')}}">
                        <img src="{{asset('images/logo_main.png')}}" alt="logo" class="mb-2" style="height: 40px;">
                    </a>
                </h5>
                <p class="text-light mb-3">Leading property solutions company in Bangladesh providing comprehensive real estate services with professional expertise and customer satisfaction.</p>
            </div>

            <div  id="footerRep"  class="col-lg-2 col-md-6 col-sm-3">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#home" class="text-light text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="#services" class="text-light text-decoration-none">Services</a></li>
                    <li class="mb-2"><a href="#about" class="text-light text-decoration-none">About</a></li>
                    <li class="mb-2"><a href="#contact" class="text-light text-decoration-none">Contact</a></li>
                    <li class="mb-2"><a href="#reviews" class="text-light text-decoration-none">Reviews</a></li>
                </ul>
            </div>

            <div  id="footerRep"  class="col-lg-3 col-md-6 col-sm-3">
                <h6 class="fw-bold mb-3">Services</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#services" class="text-light text-decoration-none">Buy Property</a></li>
                    <li class="mb-2"><a href="#services" class="text-light text-decoration-none">Sell Property</a></li>
                    <li class="mb-2"><a href="#services" class="text-light text-decoration-none">Rent Property</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <h6 class="fw-bold mb-3">Contact Info</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        123 Business Street, Suite 100
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        +1 (555) 123-4567
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        info@yourbusiness.com
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-6 text-md-end mt-4" id="footerCap">
            <a href="#home" class="btn btn-outline-light mb-2">Home</a>
            <a href="#services" class="btn btn-outline-light mb-2">Services</a>
            <a href="#about" class="btn btn-outline-light mb-2">About</a>
            <a href="#contact" class="btn btn-outline-light mb-2">Contact</a>
            <a href="#reviews" class="btn btn-outline-light mb-2">Reviews</a>
            <a href="#services" class="btn btn-outline-light mb-2">Buy Property</a>
            <a href="#services" class="btn btn-outline-light mb-2">Sell Property</a>
            <a href="#services" class="btn btn-outline-light mb-2">Rent Property</a>

        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2024 Your Business. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{route('privacy-policy')}}" class="text-light text-decoration-none me-3">Privacy Policy</a>
                <a href="{{route('terms-of-use')}}" class="text-light text-decoration-none me-3">Terms of Service</a>
                <a href="{{route('site-map')}}" class="text-light text-decoration-none">Sitemap</a>
            </div>
        </div>
        <div class="d-flex gap-2" id="footerCap" >
            <a href="#" class="btn btn-outline-light btn-sm">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm">
                <i class="bi bi-youtube"></i>
            </a>
        </div>
    </div>
</footer>
<button id="backToTop" class="btn btn-primary position-fixed bottom-0 end-0 m-3 rounded-circle" style="display: none; z-index: 1000;padding: 12px 14px">
    <i class="bi bi-arrow-up"></i>
</button>
