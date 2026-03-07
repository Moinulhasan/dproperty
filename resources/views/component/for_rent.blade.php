@if(count($rent_properties))
    <section class="py-5" id="for-rent">
        <div class="container-fluid px-md-5 px-3">
            <div class="section-header text-center mb-5">
                <h2 class="text-primary">Properties For Rent</h2>
                <p>Discover our best selection of properties available for rent</p>
            </div>

            <div class="row d-none d-lg-flex">
                @forelse($rent_properties as $property)
                    <div class="col-lg-3">
                        <div class="property-card-global">
                            <div class="card-image-box">
                                <div class="status-badge-container">
                                    <span class="status-badge" style="background: #00A699;">
                                        @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                                            {{ $property->property_status }}
                                        @else
                                            For {{ $property->property_status }}
                                        @endif
                                    </span>
                                </div>
                                <span class="type-badge">{{ $property->category }}</span>

                                <!-- Inner Card Slider -->
                                <div class="swiper card-inner-slider">
                                    <div class="swiper-wrapper">
                                        @if($property->feature_image)
                                            <div class="swiper-slide"><img src="{{ asset($property->feature_image) }}" alt="{{ $property->title }}"></div>
                                        @endif
                                        @php
                                            $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                                        @endphp
                                        @foreach($gallery as $img)
                                            <div class="swiper-slide"><img src="{{ asset($img) }}" alt="{{ $property->title }}"></div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>
                            <div class="card-body-global">
                                <h3 class="card-title-global">{{ $property->title }}</h3>

                                <div class="info-grid">
                                    <h4 class="price-text">৳ {{ number_format($property->price, 0) }} / mo</h4>
                                    <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                                    
                                    <div class="location-text">
                                        <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: $property->route }}
                                    </div>
                                    <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                                </div>
                            </div>
                            <div class="card-footer-global">
                                <div class="feature-group">
                                    <div class="feature-item-global">{{ $property->bedrooms }} <span>Bed</span></div>
                                    <div class="feature-item-global">{{ $property->bathrooms }} <span>Bath</span></div>
                                    <div class="feature-item-global">{{ number_format($property->area) }} <span>sqft</span></div>
                                </div>
                                <a href="{{ route('property-details', $property->id) }}" class="btn-view-more">View More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No rental properties available.</div>
                @endforelse
            </div>

            <!-- Mobile Slider View (Slider only) -->
            <div class="property-slider-container d-lg-none">
                <div class="swiper main-property-slider rent-slider">
                    <div class="swiper-wrapper">
                        @foreach($rent_properties as $property)
                            <div class="swiper-slide">
                                <div class="property-card-global">
                                    <div class="card-image-box">
                                        <div class="status-badge-container">
                                            <span class="status-badge" style="background: #00A699;">
                                                @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                                                    {{ $property->property_status }}
                                                @else
                                                    For {{ $property->property_status }}
                                                @endif
                                            </span>
                                        </div>
                                        <span class="type-badge">{{ $property->category }}</span>

                                        <!-- Inner Card Slider -->
                                        <div class="swiper card-inner-slider">
                                            <div class="swiper-wrapper">
                                                @if($property->feature_image)
                                                    <div class="swiper-slide"><img src="{{ asset($property->feature_image) }}" alt="{{ $property->title }}"></div>
                                                @endif
                                                @php
                                                    $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                                                @endphp
                                                @foreach($gallery as $img)
                                                    <div class="swiper-slide"><img src="{{ asset($img) }}" alt="{{ $property->title }}"></div>
                                                @endforeach
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <div class="card-body-global">
                                        <h3 class="card-title-global">{{ $property->title }}</h3>

                                        <div class="info-grid">
                                            <h4 class="price-text">৳ {{ number_format($property->price, 0) }} / mo</h4>
                                            <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                                            
                                            <div class="location-text">
                                                <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: $property->route }}
                                            </div>
                                            <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                                        </div>
                                    </div>
                                    <div class="card-footer-global">
                                        <div class="feature-group">
                                            <div class="feature-item-global">{{ $property->bedrooms }} <span>Bed</span></div>
                                            <div class="feature-item-global">{{ $property->bathrooms }} <span>Bath</span></div>
                                            <div class="feature-item-global">{{ number_format($property->area) }} <span>sqft</span></div>
                                        </div>
                                        <a href="{{ route('property-details', $property->id) }}" class="btn-view-more">View More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Navigation -->
                    <div class="section-slider-next swiper-button-next"></div>
                    <div class="section-slider-prev swiper-button-prev"></div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('rent') }}" class="btn btn-outline-primary px-5 py-3 rounded-pill fw-bold">View All Rental Properties</a>
            </div>
        </div>
    </section>
@endif
