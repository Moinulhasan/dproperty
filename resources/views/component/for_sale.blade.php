@if(count($sale_properties))
    <section class="py-5 bg-light" id="for-sale">
        <div class="container-fluid px-md-5 px-3">
            <div class="section-header text-center mb-5">
                <h2 class="text-primary">Properties For Sell</h2>
                <p>Explore our best selection of properties available for purchase</p>
            </div>

            <div class="row d-none d-lg-flex">
                @forelse($sale_properties as $property)
                    <div class="col-lg-3">
                        <div class="property-card-global">
                            <div class="card-image-box">
                                <div class="status-badge-container">
                                    <div class="status-badge">
                                        <span class="badge-dot left"></span>
                                        <span class="badge-dot right"></span>
                                        @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                                            {{ $property->property_status }}
                                        @else
                                            For {{ $property->property_status }}
                                        @endif
                                    </div>
                                </div>
                                <span class="type-badge">{{ $property->category }}</span>
                                
                                @php
                                    $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                                    $allImages = [];
                                    if ($property->feature_image) $allImages[] = asset($property->feature_image);
                                    foreach ($gallery as $img) $allImages[] = asset($img);
                                @endphp
                                <div class="card-image-hover-actions">
                                    <button class="action-btn share-btn" title="Share" onclick="event.preventDefault(); navigator.clipboard.writeText('{{ route('property-details', $property->id) }}'); alert('Link copied to clipboard!');">
                                        <i class="fas fa-bookmark"></i>
                                    </button>
                                    <button class="action-btn gallery-btn" title="View Gallery" data-images="{{ json_encode($allImages) }}" onclick="event.preventDefault(); openGallery(this);">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>

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
                                    <h4 class="price-text">৳ {{ number_format($property->price, 0) }}</h4>
                                    <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                                    
                                    <div class="location-text">
                                        <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: $property->route }}
                                    </div>
                                    <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                                </div>
                            </div>
                            <div class="card-footer-global">
                                <div class="feature-group">
                        @foreach($property->detailValues->take(3) as $dv)
                            @if($dv->detail && $dv->value)
                                <div class="feature-item-global">{{ $dv->value }} <span>{{ $dv->detail->name }}</span></div>
                            @endif
                        @endforeach
                                </div>
                                <a href="{{ route('property-details', $property->id) }}" class="btn-view-more">View More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No properties available for purchase.</div>
                @endforelse
            </div>

            <!-- Mobile Slider View (Slider only) -->
            <div class="property-slider-container d-lg-none">
                <div class="swiper main-property-slider sell-slider">
                    <div class="swiper-wrapper">
                        @foreach($sale_properties as $property)
                            <div class="swiper-slide">
                                <div class="property-card-global">
                                    <div class="card-image-box">
                                        <div class="status-badge-container">
                                            <div class="status-badge">
                                                <span class="badge-dot left"></span>
                                                <span class="badge-dot right"></span>
                                                For {{ $property->property_status }}
                                            </div>
                                        </div>
                                        <span class="type-badge">{{ $property->category }}</span>
                                        
                                        @php
                                            $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                                            $allImages = [];
                                            if ($property->feature_image) $allImages[] = asset($property->feature_image);
                                            foreach ($gallery as $img) $allImages[] = asset($img);
                                        @endphp
                                        <div class="card-image-hover-actions">
                                            <button class="action-btn share-btn" title="Share" onclick="event.preventDefault(); navigator.clipboard.writeText('{{ route('property-details', $property->id) }}'); alert('Link copied to clipboard!');">
                                                <i class="fas fa-bookmark"></i>
                                            </button>
                                            <button class="action-btn gallery-btn" title="View Gallery" data-images="{{ json_encode($allImages) }}" onclick="event.preventDefault(); openGallery(this);">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </div>

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
                                            <h4 class="price-text">৳ {{ number_format($property->price, 0) }}</h4>
                                            <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                                            
                                            <div class="location-text">
                                                <i class="fas fa-map-marker-alt"></i> {{ $property->sub_route ?: $property->route }}
                                            </div>
                                            <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                                        </div>
                                    </div>
                                    <div class="card-footer-global">
                                        <div class="feature-group">
                                            @foreach($property->detailValues->take(3) as $dv)
                                                @if($dv->detail && $dv->value)
                                                    <div class="feature-item-global">{{ $dv->value }} <span>{{ $dv->detail->name }}</span></div>
                                                @endif
                                            @endforeach
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
                <a href="{{ route('sell') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold">View All Properties</a>
            </div>
        </div>
    </section>

    @section('scripts')
    @endsection


@endif
