<section id="contact" class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-12 text-center section-header-global">
                <span class="badge rounded-pill bg-light text-primary px-3 py-2 mb-2 fw-bold text-uppercase">Contact Us</span>
                <h2 class="display-6 fw-bold">Get In Touch</h2>
                <div class="header-line mx-auto"></div>
            </div>
        </div>

        <!-- Contact Cards Row -->
        <div class="row g-4 mb-5">
            <!-- Address Card -->
            <div class="col-lg-4">
                <div class="contact-card-premium">
                    <div class="contact-icon-box">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="contact-info-box">
                        <h5>Our Office</h5>
                        <p>{{$settings->address ?? '123 Business Street, Dhaka, Bangladesh'}}</p>
                    </div>
                </div>
            </div>
            <!-- Phone Card -->
            <div class="col-lg-4">
                <div class="contact-card-premium">
                    <div class="contact-icon-box">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div class="contact-info-box">
                        <h5>Phone Number</h5>
                        <p>{{$settings->phone ?? '+880 123 456 789'}}<br>{{$settings->alt_phone ?? '+880 987 654 321'}}</p>
                    </div>
                </div>
            </div>
            <!-- Email Card -->
            <div class="col-lg-4">
                <div class="contact-card-premium">
                    <div class="contact-icon-box">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div class="contact-info-box">
                        <h5>Email Address</h5>
                        <p>{{$settings->email ?? 'info@dproperty.com'}}<br>{{$settings->support_email ?? 'support@dproperty.com'}}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map and Inquiry Form Row -->
        <div class="row g-4">
            <!-- Left: Map -->
            <div class="col-lg-7">
                <div class="contact-map-container h-100">
                    <iframe src="{{$settings->google_map??'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.909999999999!2d90.4125243153595!3d23.810301184581!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7b8b8b8b8b8%3A0x8b8b8b8b8b8b8b8b!2sDProperty%20Headquarters!5e0!3m2!1sen!2sbd!4v1616161616161'}}"
                            style="border:0; width: 100%; height: 100%; min-height: 450px; border-radius: 16px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Right: Inquiry Form -->
            <div class="col-lg-5">
                <div class="inquiry-form-card shadow-sm">
                    <h4 class="fw-bold mb-4">Send us an inquiry</h4>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">FULL NAME</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">PHONE NUMBER</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">MESSAGE</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
