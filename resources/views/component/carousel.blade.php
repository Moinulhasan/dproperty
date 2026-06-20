<!-- Carousel Section -->
<section id="home" class="hero-carousel-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if(count($sliders))
                @foreach($sliders as $slider)
                    <div class="carousel-item {{$loop->index == 0 ? 'active' : ''}}">
                        <div class="hero-slide" style="background-image: url('{{$slider->image}}');">
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
                        <form action="#" method="GET" class="search-form">
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
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{$loop->index}}" class="{{$slider->first() ?'active':''}}"></button>
                @endforeach
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data for Property Type
        const categories = @json($categories);
        const tabs = document.querySelectorAll('.search-tab');
        
        function formatSearchOption(state) {
            if (!state.id) return state.text;
            
            // Get level from data attribute if available
            const level = $(state.element).data('level') || state.level || 0;
            const padding = level === 1 ? '20px' : '0';
            
            // For Select2, we can strip the &nbsp; since we use padding-left
            const cleanText = state.text.replace(/&nbsp;|\s\s\s/g, '');
            
            const $state = $(
                '<div style="display: flex; align-items: center; padding-left: ' + padding + ';">' +
                    '<span style="color: inherit; font-weight: inherit;">' + cleanText + '</span>' +
                '</div>'
            );
            
            return $state;
        }

        function initializeSelect2() {
            if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') return;
            
            // Only initialize Select2 on desktop/larger screens
            if (window.innerWidth <= 991) return;

            const baseOptions = {
                allowClear: true,
                width: '100%',
                templateResult: formatSearchOption,
                minimumResultsForSearch: Infinity,
                dropdownCssClass: 'premium-search-dropdown'
            };

            // Add custom CSS to hide native choices for property type to prevent layout stretching
            if (!$('style#select2-property-type-fixes').length) {
                $('head').append(`
                    <style id="select2-property-type-fixes">
                        .property-type-select2 .select2-selection__choice {
                            display: none !important;
                        }
                    </style>
                `);
            }

            $('.select2-location, .select2-property-type').each(function() {
                const $el = $(this);
                const isPropertyType = $el.hasClass('select2-property-type');
                
                $el.select2({
                    ...baseOptions,
                    placeholder: $el.hasClass('select2-location') ? 'All Locations' : 'Select Type',
                    dropdownParent: $el.closest('.search-card'),
                    closeOnSelect: !isPropertyType
                });

                // Custom "Select All" for Select2 Property Type
                if (isPropertyType) {
                    $el.next('.select2-container').addClass('property-type-select2');

                    // Parent <-> child cascade. Selecting a parent option (data-level="0")
                    // auto-selects all its children (data-parent matches parent's id).
                    // Deselecting a parent deselects its children. Toggling a child
                    // keeps the parent in sync (parent selected only when ALL children are).
                    let __ptPrev = new Set(($el.val() || []).map(String));
                    let __ptCascading = false;
                    $el.on('change.cascade', function() {
                        if (__ptCascading) return;
                        __ptCascading = true;

                        const curr = new Set(($el.val() || []).map(String));
                        const added = [...curr].filter(v => !__ptPrev.has(v));
                        const removed = [...__ptPrev].filter(v => !curr.has(v));
                        let mutated = false;

                        const setOpt = (opt, on) => {
                            if (opt.selected !== on) {
                                opt.selected = on;
                                if (on) curr.add(String(opt.value)); else curr.delete(String(opt.value));
                                mutated = true;
                            }
                        };

                        added.forEach(id => {
                            const $opt = $el.find('option[value="' + id + '"]');
                            const level = $opt.attr('data-level');
                            if (level === '0') {
                                const pid = $opt.attr('data-parent-id') || id;
                                $el.find('option[data-parent="' + pid + '"]').each(function() { setOpt(this, true); });
                            } else if (level === '1') {
                                const pid = $opt.attr('data-parent');
                                const $parent = $el.find('option[data-parent-id="' + pid + '"]');
                                const $siblings = $el.find('option[data-parent="' + pid + '"]');
                                const allOn = $siblings.toArray().every(o => o.selected);
                                if (allOn && $parent.length) setOpt($parent[0], true);
                            }
                        });

                        removed.forEach(id => {
                            const $opt = $el.find('option[value="' + id + '"]');
                            const level = $opt.attr('data-level');
                            if (level === '0') {
                                const pid = $opt.attr('data-parent-id') || id;
                                $el.find('option[data-parent="' + pid + '"]').each(function() { setOpt(this, false); });
                            } else if (level === '1') {
                                const pid = $opt.attr('data-parent');
                                const $parent = $el.find('option[data-parent-id="' + pid + '"]');
                                if ($parent.length && $parent[0].selected) setOpt($parent[0], false);
                            }
                        });

                        __ptPrev = new Set([...curr].map(String));
                        __ptCascading = false;
                        if (mutated) $el.trigger('change');
                    });

                    $el.on('change', function() {
                        setTimeout(function() {
                            const selectedOptions = $el.val() || [];
                            const $container = $el.next('.select2-container');
                            const $rendered = $container.find('.select2-selection__rendered');
                            
                            // Remove any existing custom summary text
                            $rendered.find('.custom-summary-text').remove();
                            
                            if (selectedOptions.length > 0) {
                                // We don't need to hide .select2-selection__choice via JS anymore (CSS does it)
                                
                                // Hide the inline search field placeholder to prevent overlap
                                $rendered.find('.select2-search__field').attr('placeholder', '').css('width', '0');
                                
                                // Determine the summary text
                                const totalOptions = $el.find('option').length;
                                let summaryText = '';
                                
                                if (selectedOptions.length === 1) {
                                    // If only 1, show its name cleanly
                                    summaryText = $el.find('option:selected').text().replace(/&nbsp;|-/g, '').trim();
                                } else if (selectedOptions.length === totalOptions) {
                                    summaryText = 'All types selected';
                                } else {
                                    summaryText = selectedOptions.length + ' types selected';
                                }
                                
                                // Add our custom summary text
                                const summaryHTML = `
                                    <li class="custom-summary-text" style="list-style: none; display: flex; align-items: center; padding-left: 8px; margin-top: 6px; color: #6c757d; font-size: 14px;">
                                        ${summaryText}
                                    </li>
                                `;
                                $rendered.prepend(summaryHTML);
                            } else {
                                // Restore placeholder if empty
                                $rendered.find('.select2-search__field').attr('placeholder', 'Select Type').css('width', '');
                            }
                        }, 0);
                    });

                    $el.on('select2:open', function() {
                        const $dropdown = $('.select2-dropdown--below, .select2-dropdown--above');
                        if (!$dropdown.find('.select2-all-actions').length) {
                            $dropdown.prepend(`
                                <div class="select2-all-actions d-flex align-items-center border-bottom bg-white">
                                    <button type="button" class="btn-selection-action flex-grow-1 btn-select-all-s2">Select All</button>
                                    <div class="action-divider"></div>
                                    <button type="button" class="btn-selection-action flex-grow-1 btn-deselect-all-s2">Deselect All</button>
                                </div>
                            `);
                            
                            $dropdown.find('.btn-select-all-s2').on('click', function() {
                                $el.find('option').prop('selected', 'selected');
                                $el.trigger('change');
                            });
                            
                            $dropdown.find('.btn-deselect-all-s2').on('click', function() {
                                $el.val(null).trigger('change');
                            });
                        }
                    });
                }
            });
        }

        // Initialize Select2
        $(document).ready(function() {
            initializeSelect2();
            
            // Handle form submission based on type
            $('.search-form').on('submit', function(e) {
                e.preventDefault();

                const type = $('#search_type').val();
                let targetUrl;
                if (type === 'rent') {
                    targetUrl = "{{ route('rent') }}";
                } else {
                    // "buy" tab is labelled "FOR SELL" - routes to sell page
                    targetUrl = "{{ route('sell') }}";
                }

                // Desktop (Select2) and mobile (custom picker) share the same
                // `name` for each filter. Iterate FormData and KEEP each key
                // exactly once with its last non-empty value, so the URL has
                // no duplicate params like `?location=2&location=`.
                const collected = {};
                const formData  = new FormData(this);
                for (const [key, raw] of formData.entries()) {
                    if (key === 'search_type' || key === '_token' || key === '_method') continue;
                    const value = (raw ?? '').toString().trim();
                    if (value === '' || value === 'any') continue;
                    collected[key] = value;
                }

                const queryString = new URLSearchParams(collected).toString();
                window.location.href = targetUrl + (queryString ? '?' + queryString : '');
            });
        });

        // Global Search Card Click Logic
        $(document).on('click', '.search-card', function(e) {
            const $select = $(this).find('select');
            const $customDropdown = $(this).find('.custom-dropdown');
            
            // If it's a select2 element, open it
            if ($select.length && $select.hasClass('select2-hidden-accessible')) {
                e.stopPropagation();
                $select.select2('open');
                return;
            }

            // If it's a custom dropdown element, toggle it
            if ($customDropdown.length) {
                e.stopPropagation();
                $('.custom-dropdown').not($customDropdown).removeClass('active');
                $customDropdown.toggleClass('active');
                return;
            }
        });

        // Close custom dropdowns when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-card').length) {
                $('.custom-dropdown').removeClass('active');
            }
        });

        // Tab switching logic
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const type = this.getAttribute('data-type');
                document.getElementById('search_type').value = type;
            });
        });

        // Card Click logic for custom dropdowns
        const locationCard = document.getElementById('locationCard');
        if (locationCard) {
            locationCard.addEventListener('click', function(e) {
                e.stopPropagation();
                closeAllDropdowns(document.getElementById('locationDropdown'));
                if (document.getElementById('locationDropdown')) {
                    document.getElementById('locationDropdown').classList.toggle('active');
                }
            });
        }

        document.getElementById('propertyTypeCard').addEventListener('click', function(e) {
            e.stopPropagation();
            closeAllDropdowns(document.getElementById('propertyTypeDropdown'));
            if (document.getElementById('propertyTypeDropdown')) {
                document.getElementById('propertyTypeDropdown').classList.toggle('active');
            }
        });

        document.getElementById('bedCard').addEventListener('click', function(e) {
            e.stopPropagation();
            closeAllDropdowns(document.getElementById('bedDropdown'));
            document.getElementById('bedDropdown').classList.toggle('active');
        });
        document.getElementById('areaCard').addEventListener('click', function(e) {
            e.stopPropagation();
            closeAllDropdowns(document.getElementById('areaDropdown'));
            document.getElementById('areaDropdown').classList.toggle('active');
        });
        document.getElementById('priceCard').addEventListener('click', function(e) {
            e.stopPropagation();
            closeAllDropdowns(document.getElementById('priceDropdown'));
            document.getElementById('priceDropdown').classList.toggle('active');
        });

        function closeAllDropdowns(except = null) {
            document.querySelectorAll('.custom-dropdown').forEach(d => {
                if (d !== except) d.classList.remove('active');
            });
        }

        // Custom Dropdown logic
        const dropdowns = document.querySelectorAll('.custom-dropdown');
        
        dropdowns.forEach(dropdown => {
            const clearBtn = dropdown.querySelector('.btn-clear-dropdown');
            const applyBtn = dropdown.querySelector('.btn-apply-dropdown');

            // Skip dropdowns without clear/apply buttons (location/type pickers)
            if (!clearBtn || !applyBtn) return;

            // Prevent closing when clicking inside dropdown content
            const content = dropdown.querySelector('.dropdown-content-custom');
            if (content) content.addEventListener('click', (e) => e.stopPropagation());

            // Clear button
            clearBtn.addEventListener('click', () => {
                if (dropdown.id === 'bedDropdown') {
                    dropdown.querySelectorAll('.bed-btn').forEach(btn => btn.classList.remove('active'));
                    document.getElementById('bedValue').value = '';
                    document.getElementById('bedToggle').innerText = 'Bedrooms';
                } else if (dropdown.id === 'areaDropdown') {
                    document.getElementById('minArea').value = '';
                    document.getElementById('maxArea').value = '';
                    document.getElementById('areaToggle').innerText = 'Any Size';
                } else if (dropdown.id === 'priceDropdown') {
                    document.getElementById('minPrice').value = '';
                    document.getElementById('maxPrice').value = '';
                    document.getElementById('priceToggle').innerText = 'Max. Price';
                }
                dropdown.classList.remove('active');
            });

            // Apply button
            applyBtn.addEventListener('click', () => {
                if (dropdown.id === 'bedDropdown') {
                    const activeBed = dropdown.querySelector('.bed-btn.active');
                    if (activeBed) {
                        const val = activeBed.getAttribute('data-value');
                        document.getElementById('bedToggle').innerText = val === 'any' ? 'Any' : val + ' Bed';
                    }
                } else if (dropdown.id === 'areaDropdown') {
                    const min = document.getElementById('minArea').value;
                    const max = document.getElementById('maxArea').value;
                    if (min && max) document.getElementById('areaToggle').innerText = min + ' - ' + max + ' SFT';
                    else if (min) document.getElementById('areaToggle').innerText = min + '+ SFT';
                    else if (max) document.getElementById('areaToggle').innerText = 'Up to ' + max + ' SFT';
                    else document.getElementById('areaToggle').innerText = 'Any Size';
                } else if (dropdown.id === 'priceDropdown') {
                    const min = document.getElementById('minPrice').value;
                    const max = document.getElementById('maxPrice').value;
                    if (min && max) document.getElementById('priceToggle').innerText = min + ' - ' + max + ' BDT';
                    else if (min) document.getElementById('priceToggle').innerText = min + '+ BDT';
                    else if (max) document.getElementById('priceToggle').innerText = 'Up to ' + max + ' BDT';
                    else document.getElementById('priceToggle').innerText = 'Max. Price';
                }
                dropdown.classList.remove('active');
            });
        });

        // Property Type Picker Logic (Multi-select)
        const propertyTypeDropdown = document.getElementById('propertyTypeDropdown');
        if (propertyTypeDropdown) {
            const typeItems = propertyTypeDropdown.querySelectorAll('.type-item:not(.all-types)');
            const allTypesItem = propertyTypeDropdown.querySelector('.type-item.all-types');
            const toggleText = propertyTypeDropdown.querySelector('.toggle-text');
            const hiddenInput = document.getElementById('propertyTypeMobileValue');
            const btnSelectAll = document.getElementById('btnSelectAllTypes');
            const btnDeselectAll = document.getElementById('btnDeselectAllTypes');
            const btnClear = document.getElementById('btnClearTypes');
            const btnApply = document.getElementById('btnApplyTypes');

            // Helper: keep parent <-> children in sync inside the mobile picker.
            function cascadeMobileType(clicked, becameSelected) {
                if (clicked.classList.contains('parent')) {
                    const pid = clicked.getAttribute('data-parent-id') || clicked.getAttribute('data-value');
                    propertyTypeDropdown.querySelectorAll('.type-item.child[data-parent="' + pid + '"]').forEach(c => {
                        c.classList.toggle('selected', becameSelected);
                    });
                } else if (clicked.classList.contains('child')) {
                    const pid = clicked.getAttribute('data-parent');
                    if (!pid) return;
                    const parent = propertyTypeDropdown.querySelector('.type-item.parent[data-parent-id="' + pid + '"]');
                    if (!parent) return;
                    const siblings = propertyTypeDropdown.querySelectorAll('.type-item.child[data-parent="' + pid + '"]');
                    const allSelected = Array.from(siblings).every(s => s.classList.contains('selected'));
                    parent.classList.toggle('selected', allSelected);
                }
            }

            typeItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('selected');
                    const becameSelected = this.classList.contains('selected');
                    cascadeMobileType(this, becameSelected);
                    if (allTypesItem) allTypesItem.classList.remove('selected');
                    updatePropertyTypeToggle();
                });
            });

            if (allTypesItem) {
                allTypesItem.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isSelected = this.classList.contains('selected');
                    if (!isSelected) {
                        typeItems.forEach(i => i.classList.remove('selected'));
                        this.classList.add('selected');
                    } else {
                        this.classList.remove('selected');
                    }
                    updatePropertyTypeToggle();
                });
            }

            if (btnSelectAll) {
                btnSelectAll.addEventListener('click', (e) => {
                    e.stopPropagation();
                    typeItems.forEach(i => i.classList.add('selected'));
                    if (allTypesItem) allTypesItem.classList.remove('selected');
                    updatePropertyTypeToggle();
                });
            }

            if (btnDeselectAll) {
                btnDeselectAll.addEventListener('click', (e) => {
                    e.stopPropagation();
                    typeItems.forEach(i => i.classList.remove('selected'));
                    if (allTypesItem) allTypesItem.classList.remove('selected');
                    updatePropertyTypeToggle();
                });
            }

            if (btnClear) {
                btnClear.addEventListener('click', (e) => {
                    e.stopPropagation();
                    typeItems.forEach(i => i.classList.remove('selected'));
                    if (allTypesItem) allTypesItem.classList.remove('selected');
                    updatePropertyTypeToggle();
                    propertyTypeDropdown.classList.remove('active');
                });
            }

            if (btnApply) {
                btnApply.addEventListener('click', (e) => {
                    e.stopPropagation();
                    propertyTypeDropdown.classList.remove('active');
                });
            }

            function updatePropertyTypeToggle() {
                const selectedItems = propertyTypeDropdown.querySelectorAll('.type-item.selected');
                
                if (allTypesItem && allTypesItem.classList.contains('selected')) {
                    hiddenInput.value = '';
                    toggleText.innerText = 'All Types';
                    return;
                }

                const values = Array.from(selectedItems).map(i => i.getAttribute('data-value'));
                hiddenInput.value = values.join(',');
                
                if (selectedItems.length === 0) {
                    toggleText.innerText = 'Select Type';
                } else if (selectedItems.length === 1) {
                    toggleText.innerText = selectedItems[0].getAttribute('data-text');
                } else if (selectedItems.length === typeItems.length) {
                    toggleText.innerText = 'All Types Selected';
                } else {
                    toggleText.innerText = selectedItems.length + ' Types Selected';
                }
            }
        }

        // Location Picker Logic
        const locationDropdown = document.getElementById('locationDropdown');
        if (locationDropdown) {
            const locItems = locationDropdown.querySelectorAll('.type-item');
            const locToggleText = locationDropdown.querySelector('.toggle-text');
            const locHiddenInput = document.getElementById('locationMobileValue');

            locItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    locItems.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    const val = this.getAttribute('data-value');
                    const text = this.getAttribute('data-text');
                    locHiddenInput.value = val;
                    locToggleText.innerText = text;
                    locationDropdown.classList.remove('active');
                });
            });
        }

        // On refresh or back, ensure mobile/desktop inputs are exclusive
        function syncInputs() {
            const locSelect = document.getElementById('locationSelect');
            const locMobile = document.getElementById('locationMobileValue');
            const typeSelect = document.getElementById('propertyTypeSelect');
            const typeMobile = document.getElementById('propertyTypeMobileValue');
            
            if (window.innerWidth <= 991) {
                if (locSelect) locSelect.name = '';
                if (locMobile) locMobile.name = 'location';
                if (typeSelect) typeSelect.name = '';
                if (typeMobile) typeMobile.name = 'property_category_id';
            } else {
                if (locSelect) locSelect.name = 'location';
                if (locMobile) locMobile.name = '';
                if (typeSelect) typeSelect.name = 'property_category_id';
                if (typeMobile) typeMobile.name = '';
            }
        }
        syncInputs();
        window.addEventListener('resize', syncInputs);

        // Bed button selection
        const bedBtns = document.querySelectorAll('.bed-btn');
        bedBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                bedBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('bedValue').value = this.getAttribute('data-value');
            });
        });

        // Close dropdowns on outside click
        window.addEventListener('click', () => {
            closeAllDropdowns();
        });
    });
</script>
@endpush
