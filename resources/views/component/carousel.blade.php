<!-- Carousel Section -->
<section id="home" class="hero-carousel-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if(count($sliders))
                @foreach($sliders as $slider)
                    <div class="carousel-item {{$loop->index == 0 ? 'active' : ''}}">
                        <div class="hero-slide">
                            <img class="hero-slide-img" src="{{ $slider->image }}" srcset="{{ $slider->heroSrcset() }}"
                                 sizes="(max-width: 1199px) 300vw, 100vw" alt="" decoding="async"
                                 @if($loop->first) fetchpriority="high" @else loading="lazy" @endif>
                            <div class="hero-overlay"></div>
                            <div class="container">
                                <div class="row align-items-center min-vh-70">
                                                                <div class="col-lg-8">
                                    <!-- <div class="hero-content animate-slide-up">
                                        <p class="hero-subtitle">{{$slider->title}}</p>
                                    </div> -->
                                                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Search Section Over Carousel -->
        <div class="search-section-wrapper">
            <div class="container">
                <div class="search-container content-align-left animate-slide-up">
                    <!-- Tabs (radio-card style, matches the "I Want to" buttons on the Post Property page) -->
                    <div class="search-tabs-outer">
                        <div class="search-tabs">
                            <button class="search-tab active" data-type="rent">
                                <i class="fas fa-key"></i><span>For Rent</span>
                            </button>
                            <button class="search-tab" data-type="buy">
                                <i class="fas fa-tag"></i><span>For Sell</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Search Box -->
                    <div class="search-box card shadow">
                        <form action="#" method="GET" class="search-form" data-rent-url="{{ route('rent') }}" data-sell-url="{{ route('sell') }}">
                            <input type="hidden" name="search_type" id="search_type" value="rent">
                            
                            <div class="compact-search-grid">
                                <!-- Location Card -->
                                <div class="search-card" id="locationCard">
                                    <div class="card-label">LOCATION</div>
                                    <div class="search-field">
                                        <!-- Desktop Version (Select2) -->
                                        <div class="d-none d-lg-block">
                                            <select class="form-select select2-location" name="location" id="locationSelect">
                                                <option value="">Select Location</option>
                                                @foreach($locations as $loc)
                                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Mobile Version (Custom Picker) -->
                                        <div class="custom-dropdown d-lg-none" id="locationDropdown">
                                            <div class="dropdown-toggle-custom picker-toggle" id="locationToggle">
                                                <span class="toggle-text">Select Location</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <div class="dropdown-content-custom picker-style">
                                                <div class="dropdown-body-custom scrollable-list">
                                                    <div class="property-type-list">
                                                        <div class="type-item" data-value="" data-text="Select Location">All Locations</div>
                                                        @foreach($locations as $loc)
                                                            <div class="type-item" data-value="{{ $loc->id }}" data-text="{{ $loc->name }}">
                                                               - {{ $loc->name }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="location" id="locationMobileValue" class="mobile-input">
                                        </div>
                                    </div>
                                    <div class="card-sub-label" id="locationSubLabel">Select City</div>
                                </div>

                                <!-- Property Type Card -->
                                <div class="search-card" id="propertyTypeCard">
                                    <div class="card-label">PROPERTY TYPE</div>
                                    <div class="search-field">
                                        <!-- Desktop Version (Select2) -->
                                        <div class="d-none d-lg-block">
                                            <select class="form-select select2-property-type" name="property_category_id[]" id="propertyTypeSelect" multiple="multiple">
                                                @foreach($categories as $parent)
                                                    <option value="{{ $parent->id }}" data-level="0" data-parent-id="{{ $parent->id }}">{{ $parent->name }} (All)</option>
                                                    @if(isset($parent->children) && count($parent->children) > 0)
                                                        @foreach($parent->children as $child)
                                                            <option value="{{ $child->id }}" data-level="1" data-parent="{{ $parent->id }}">&nbsp;&nbsp;&nbsp;- {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Mobile Version (Custom Picker) -->
                                        <div class="custom-dropdown d-lg-none" id="propertyTypeDropdown">
                                            <div class="dropdown-toggle-custom picker-toggle" id="propertyTypeToggle">
                                                <span class="toggle-text">Select Type</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <div class="dropdown-content-custom picker-style">
                                                <div class="dropdown-header-custom border-bottom">
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn-selection-action flex-grow-1" id="btnSelectAllTypes">Select All</button>
                                                        <div class="action-divider"></div>
                                                        <button type="button" class="btn-selection-action flex-grow-1" id="btnDeselectAllTypes">Deselect All</button>
                                                    </div>
                                                </div>
                                                <div class="dropdown-body-custom scrollable-list p-0">
                                                    <div class="property-type-list">
                                                        {{-- <div class="type-item all-types d-flex align-items-center justify-content-between" data-value="all" data-text="All Types">
                                                            <span>All Types</span>
                                                            <i class="fas fa-check check-icon"></i>
                                                        </div> --}}
                                                        @foreach($categories as $parent)
                                                            <div class="type-item parent d-flex align-items-center justify-content-between" data-value="{{ $parent->id }}" data-text="{{ $parent->name }}" data-parent-id="{{ $parent->id }}">
                                                                <span>{{ $parent->name }}</span>
                                                                <i class="fas fa-check check-icon"></i>
                                                            </div>
                                                            @if(isset($parent->children) && count($parent->children) > 0)
                                                                @foreach($parent->children as $child)
                                                                    <div class="type-item child d-flex align-items-center justify-content-between" data-value="{{ $child->id }}" data-text="{{ $child->name }}" data-parent="{{ $parent->id }}">
                                                                        <span>- {{ $child->name }}</span>
                                                                        <i class="fas fa-check check-icon"></i>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="dropdown-footer-custom border-top mt-0">
                                                    <button type="button" class="btn-clear-dropdown" id="btnClearTypes">Reset</button>
                                                    <button type="button" class="btn-apply-dropdown" id="btnApplyTypes">Apply</button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="property_category_id" id="propertyTypeMobileValue" class="mobile-input">
                                        </div>
                                    </div>
                                    <div class="card-sub-label" id="propertyTypeSubLabel">Residential/Commercial</div>
                                </div>

                                <!-- Bed Card -->
                                <div class="search-card" id="bedCard">
                                    <div class="card-label">BED</div>
                                    <div class="custom-dropdown" id="bedDropdown">
                                        <div class="dropdown-toggle-custom" id="bedToggle">Bedrooms</div>
                                        <div class="dropdown-content-custom">
                                            <div class="dropdown-header-custom">Bed</div>
                                            <div class="dropdown-body-custom">
                                                <div class="bed-options">
                                                    <div class="bed-btn" data-value="any">Any</div>
                                                    <div class="bed-btn" data-value="1">1</div>
                                                    <div class="bed-btn" data-value="2">2</div>
                                                    <div class="bed-btn" data-value="3">3</div>
                                                    <div class="bed-btn" data-value="4">4</div>
                                                    <div class="bed-btn" data-value="5">5</div>
                                                </div>
                                            </div>
                                            <div class="dropdown-footer-custom">
                                                <button type="button" class="btn-clear-dropdown">Clear</button>
                                                <button type="button" class="btn-apply-dropdown">Apply</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="bedrooms" id="bedValue">
                                    </div>
                                    <div class="card-sub-label" id="bedSubLabel">Number of Beds</div>
                                </div>

                                <!-- Property Size Card -->
                                <div class="search-card" id="areaCard">
                                    <div class="card-label">PROPERTY SIZE</div>
                                    <div class="custom-dropdown" id="areaDropdown">
                                        <div class="dropdown-toggle-custom" id="areaToggle">Any Size</div>
                                        <div class="dropdown-content-custom">
                                            <div class="dropdown-header-custom">Area (SFT)</div>
                                            <div class="dropdown-body-custom">
                                                <div class="range-container">
                                                    <div class="range-field">
                                                        <label>Minimum</label>
                                                        <div class="input-with-prefix">
                                                            <span class="prefix">SFT</span>
                                                            <input type="number" name="min_area" id="minArea" placeholder="MIN">
                                                        </div>
                                                    </div>
                                                    <div class="range-field">
                                                        <label>Maximum</label>
                                                        <div class="input-with-prefix">
                                                            <span class="prefix">SFT</span>
                                                            <input type="number" name="max_area" id="maxArea" placeholder="MAX">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-footer-custom">
                                                <button type="button" class="btn-clear-dropdown">Clear</button>
                                                <button type="button" class="btn-apply-dropdown">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-sub-label" id="areaSubLabel">Area in SFT</div>
                                </div>

                                <!-- Price Card -->
                                <div class="search-card" id="priceCard">
                                    <div class="card-label">PRICE</div>
                                    <div class="custom-dropdown" id="priceDropdown">
                                        <div class="dropdown-toggle-custom" id="priceToggle">Max. Price</div>
                                        <div class="dropdown-content-custom">
                                            <div class="dropdown-header-custom">Price</div>
                                            <div class="dropdown-body-custom">
                                                <div class="range-container">
                                                    <div class="range-field">
                                                        <label>Minimum</label>
                                                        <div class="input-with-prefix">
                                                            <span class="prefix">BDT</span>
                                                            <input type="number" name="min_price" id="minPrice" placeholder="MIN">
                                                        </div>
                                                    </div>
                                                    <div class="range-field">
                                                        <label>Maximum</label>
                                                        <div class="input-with-prefix">
                                                            <span class="prefix">BDT</span>
                                                            <input type="number" name="max_price" id="maxPrice" placeholder="MAX">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-footer-custom">
                                                <button type="button" class="btn-clear-dropdown">Clear</button>
                                                <button type="button" class="btn-apply-dropdown">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-sub-label" id="priceSubLabel">Budget Range</div>
                                </div>

                                <!-- Search Button -->
                                <div class="search-action-box">
                                    <button type="submit" class="btn-search-compact">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-indicators">
            @if(count($sliders))
                @foreach($sliders as $slider)
                    {{-- Always "active": the old $slider->first() was truthy for every slide (and cost a query each). --}}
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{$loop->index}}" class="active"></button>
                @endforeach
            @endif
        </div>
    </div>
</section>
