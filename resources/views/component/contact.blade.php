<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-3">
                <h2 class="display-5 fw-bold text-primary">Our Location & Contact</h2>
                <p class="lead text-muted">{{$tags->where('service_type','contact_us')->first()->tag_line ??'Get in touch with us today'}}</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe src="{{$settings->map_link??'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.909999999999!2d90.4125243153595!3d23.810301184581!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7b8b8b8b8b8%3A0x8b8b8b8b8b8b8b8b!2sDProperty%20Headquarters!5e0!3m2!1sen!2sbd!4v1616161616161'}}"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4">Contact Information</h5>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-geo-alt-fill text-primary me-3"></i>
                                <strong>Address:</strong>
                            </div>
                            <p class="text-muted ms-4 mb-0">{{$settings->address}}</p>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-telephone-fill text-primary me-3"></i>
                                <strong>Phone:</strong>
                            </div>
                            <p class="text-muted ms-4 mb-0">{{$settings->phone}}</p>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-envelope-fill text-primary me-3"></i>
                                <strong>Email:</strong>
                            </div>
                            <p class="text-muted ms-4 mb-0">{{$settings->email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
