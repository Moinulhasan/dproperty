@extends('master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/details.css') }}">
@endsection()

@section('content')
<div class="details-page-wrapper">
    <div class="container-fluid px-md-5 px-3">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Properties</a></li>
                <li class="breadcrumb-item active" aria-current="page">Modern City Apartment</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Left Side: Gallery & Description -->
            <div class="col-lg-8">
                <div class="detail-gallery-container shadow-sm">
                    <!-- Main Swiper -->
                    <div class="swiper main-image-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1600585154340-be6199fbfd0b?auto=format&fit=crop&w=1200" alt="Main Property">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1200" alt="Room 1">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1600607687940-477a4a6b4737?auto=format&fit=crop&w=1200" alt="Kitchen">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200" alt="Living Room">
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <!-- Thumbnails Swiper -->
                    <div class="swiper thumb-image-swiper mt-3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1600585154340-be6199fbfd0b?auto=format&fit=crop&w=200" alt="Thumb 1">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=200" alt="Thumb 2">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1600607687940-477a4a6b4737?auto=format&fit=crop&w=200" alt="Thumb 3">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=200" alt="Thumb 4">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lower Content (Ref Image 2 details) -->
                <div class="detail-content-box mt-4">
                    <div class="property-main-header">
                        <div class="price-box">
                            <h2 class="m-0">৳ 45,000,000.00</h2>
                            <div class="badge bg-success mt-2">For Sale</div>
                        </div>
                        <div class="meta-info">
                            <h3 class="m-0">ID: DP-7790</h3>
                            <div class="location-tag">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i> Banani, Dhaka
                            </div>
                        </div>
                    </div>

                    <!-- Specs Grid -->
                    <h4 class="detail-section-title">Property Details</h4>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <i class="fas fa-expand-arrows-alt spec-icon"></i>
                            <span class="spec-value">2100</span>
                            <span class="spec-label">Sqft</span>
                        </div>
                        <div class="spec-item">
                            <i class="fas fa-bed spec-icon"></i>
                            <span class="spec-value">3</span>
                            <span class="spec-label">Bedroom</span>
                        </div>
                        <div class="spec-item">
                            <i class="fas fa-bath spec-icon"></i>
                            <span class="spec-value">3</span>
                            <span class="spec-label">Bathroom</span>
                        </div>
                        <div class="spec-item">
                            <i class="fas fa-couch spec-icon"></i>
                            <span class="spec-value">Furnished</span>
                            <span class="spec-label">Type</span>
                        </div>
                        <div class="spec-item">
                            <i class="fas fa-car spec-icon"></i>
                            <span class="spec-value">1</span>
                            <span class="spec-label">Parking</span>
                        </div>
                        <div class="spec-item">
                            <i class="fas fa-building spec-icon"></i>
                            <span class="spec-value">6th</span>
                            <span class="spec-label">Floor</span>
                        </div>
                    </div>

                    <!-- Features & Amenities -->
                    <div class="features-container">
                        <h4 class="detail-section-title">Features & Amenities</h4>
                        <div class="features-grid">
                            <div class="feature-check"><i class="fas fa-check-square"></i> Gym</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Swimming Pool</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> BBQ Area</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Mosque</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Community Room</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Generator</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> 24*7 Security</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> CCTV</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Reception</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Gardening Area</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Broadband Internet</div>
                            <div class="feature-check"><i class="fas fa-check-square"></i> Soundproof Glass</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <h4 class="detail-section-title">Description</h4>
                    <div class="description-text">
                        <p>This luxurious 2100 Sqft apartment is located in the heart of Banani. Featuring 3 spacious bedrooms, 3 modern bathrooms, and a large balcony with a city view. The building offers premium amenities including a rooftop pool, state-of-the-art gym, and 24/7 high-level security.</p>
                        <p>Perfect for families looking for a premium lifestyle with all conveniences nearby. Well ventilated and natural light throughout the day. Includes 1 dedicated parking space.</p>
                    </div>

                    <!-- More Sections -->
                    <h4 class="detail-section-title">Floor Plan</h4>
                    <div class="mb-4 text-center">
                        <img src="https://images.unsplash.com/photo-1541888941255-081d746efdea?auto=format&fit=crop&w=800" class="img-fluid rounded border" alt="Floor Plan Mock">
                    </div>

                    <h4 class="detail-section-title">Property Video</h4>
                    <div class="ratio ratio-16x9 mb-4 rounded overflow-hidden">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Property Video" allowfullscreen></iframe>
                    </div>

                    <h4 class="detail-section-title">Location</h4>
                    <div class="mb-4 rounded overflow-hidden border">
                         <!-- Placeholder for Google Map -->
                         <div style="height: 400px; background: #eee; display: flex; align-items: center; justify-content: center;">
                            <span class="text-muted">Interactive Map Placeholder</span>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Sidebar (Ref Image 1 details) -->
            <div class="col-lg-4">
                <div class="details-sidebar">
                    <div class="seller-profile">
                        <img src="{{ asset('img/logo.png') }}" class="seller-logo" alt="DProperty">
                        <div class="seller-info">
                            <h4>DProperty Agent</h4>
                            <div class="verified-badge">
                                <i class="fas fa-check-circle"></i> VERIFIED SELLER
                            </div>
                            <p class="text-muted small mt-1">Member since April 2024</p>
                        </div>
                    </div>

                    <div class="contact-actions">
                        <button class="contact-btn btn-phone" id="showPhoneBtn">
                            <i class="fas fa-phone-alt"></i> 01600XXXXXX
                        </button>
                        <a href="#" class="contact-btn btn-chat">
                            <i class="fas fa-comment"></i> Chat with Seller
                        </a>
                        <a href="#" class="contact-btn btn-whatsapp">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <h5 class="fw-bold mb-3">Safety Tips</h5>
                        <ul class="small text-muted ps-3">
                            <li>Meet the seller in a public place.</li>
                            <li>Check the property personally.</li>
                            <li>Don't pay upfront before visiting.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Gallery Swipers
        var thumbsSwiper = new Swiper(".thumb-image-swiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });

        var mainSwiper = new Swiper(".main-image-swiper", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
        });

        // Phone Reveal Logic
        const phoneBtn = document.getElementById('showPhoneBtn');
        phoneBtn.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-phone-alt"></i> +880 1600-123456';
            this.classList.add('bg-light');
        });
    });
</script>
@endpush
