@if(count($rent_properties))
    <section class="py-1" id="for-rent">
        <div class="container-fluid px-md-5 px-3">
            <div class="section-header-modern mb-3">
                <h2 class="text-primary">Properties For Rent</h2>
                <a href="{{ route('rent') }}" class="view-all-btn">
                    View All &rarr;
                </a>
            </div>

            <!-- Scrollable carousel for ALL active rent properties.
                 Visible on every screen size — breakpoints in script.blade.php
                 control how many cards are visible per view (1 / 2 / 2.5 / 4). -->
            <div class="property-slider-container">
                <div class="swiper main-property-slider rent-slider">
                    <div class="swiper-wrapper">
                        @foreach($rent_properties as $property)
                            <div class="swiper-slide">
                                <div class="property-card-global">
                                    <div class="card-image-box">
                                        <div class="status-badge-container">
                                            @php
                                                $statusLower = strtolower($property->property_status);
                                                $statusClass = 'status-sell'; // Default
                                                if (str_contains($statusLower, 'rent')) $statusClass = 'status-rent';
                                                elseif (str_contains($statusLower, 'buy')) $statusClass = 'status-buy';
                                            @endphp
                                            <div class="status-badge {{ $statusClass }}">
                                                <span class="badge-dot left"></span>
                                                <span class="badge-dot right"></span>
                                                @if(str_starts_with($property->property_status, 'For') || $property->property_status == 'Buy')
                                                    {{ $property->property_status }}
                                                @else
                                                    For {{ $property->property_status }}
                                                @endif
                                            </div>
                                            <span class="type-badge">{{ $property->category }}</span>
                                        </div>
                                        
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
                                            <button class="action-btn gallery-btn" title="View All Image" data-images="{{ json_encode($allImages) }}" onclick="event.preventDefault(); openGallery(this);">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </div>

                                        <!-- Inner Card Slider -->
                                        <div class="swiper card-inner-slider">
                                            <div class="swiper-wrapper">
                                                @if($property->feature_image)
                                                    <div class="swiper-slide"><img loading="lazy" src="{{ asset($property->feature_image) }}" alt="{{ $property->title }}"></div>
                                                @endif
                                                @php
                                                    $gallery = is_array($property->images) ? $property->images : (json_decode($property->images) ?? []);
                                                @endphp
                                                @foreach($gallery as $img)
                                                    <div class="swiper-slide"><img loading="lazy" src="{{ asset($img) }}" alt="{{ $property->title }}"></div>
                                                @endforeach
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <div class="card-body-global">
                                        <h3 class="card-title-global">
                                            <a href="{{ route('property-details', $property->id) }}" target="_blank">{{ $property->title }}</a>
                                        </h3>

                                        <div class="info-grid">
                                            <h4 class="price-text">৳ {{ number_format($property->price, 0) }} / mo</h4>
                                            <div class="detail-item"><span class="info-label">Project ID:</span> {{ $property->project_id }}</div>
                                            
                                            <div class="location-text">
                                                <i class="fas fa-map-marker-alt"></i> {{ $property->displayLocation() }}
                                            </div>
                                            <div class="detail-item"><span class="info-label">Type:</span> {{ $property->is_furnished }}</div>
                                        </div>
                                    </div>
                                    @include('component._card_footer', ['p' => $property])
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Navigation -->
                    <div class="section-slider-next swiper-button-next"></div>
                    <div class="section-slider-prev swiper-button-prev"></div>
                </div>
            </div>




        </div>
    </section>
@endif
