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
        <div class="search-section-wrapper animate-slide-up">
            <div class="container">
                <div class="search-container content-align-left">
                    <!-- Tabs -->
                    <div class="search-tabs-outer">
                        <div class="search-tabs">
                            <button class="search-tab active" data-type="sale">SALE</button>
                            <button class="search-tab" data-type="rent">RENT</button>
                        </div>
                    </div>
                    
                    <!-- Search Box -->
                    <div class="search-box card shadow">
                        <form action="#" method="GET" class="search-form">
                            <input type="hidden" name="search_type" id="search_type" value="sale">
                            <div class="row align-items-end g-2">
                                <div class="col-lg-2 col-md-6">
                                    <div class="search-field">
                                        <label>LOCATION</label>
                                        <select class="form-select select2-location" name="location" id="locationSelect">
                                            <option value=""></option>
                                            <option value="dhaka">Dhaka</option>
                                            <option value="chattogram">Chattogram</option>
                                            <option value="sylhet">Sylhet</option>
                                            <option value="rajshahi">Rajshahi</option>
                                            <option value="khulna">Khulna</option>
                                            <option value="barishal">Barishal</option>
                                            <option value="rangpur">Rangpur</option>
                                            <option value="mymensingh">Mymensingh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="search-field">
                                        <label>PROPERTY TYPE</label>
                                        <select class="form-select select2-property-type" name="property_type" id="propertyTypeSelect">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="search-field">
                                        <label>BED</label>
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
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="search-field">
                                        <label>PROPERTY SIZE</label>
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
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <div class="search-field">
                                        <label>PRICE</label>
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
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 text-end">
                                    <button type="submit" class="btn btn-search w-100">Search</button>
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
        const propertyOptions = {
            rent: [
                {
                    text: 'Residential',
                    children: [
                        { id: 'rent_apt_head', text: '1. Apartment', level: 1, disabled: true },
                        { id: 'rent_apt_full', text: 'a. Full Furnished', level: 2 },
                        { id: 'rent_apt_semi', text: 'b. Semi Furnished', level: 2 },
                        { id: 'rent_apt_non', text: 'c. Non-Furnished', level: 2 },
                        { id: 'rent_duplex_head', text: '2. Duplex', level: 1, disabled: true },
                        { id: 'rent_duplex_full', text: 'a. Full Furnished', level: 2 },
                        { id: 'rent_duplex_semi', text: 'b. Semi Furnished', level: 2 },
                        { id: 'rent_duplex_non', text: 'c. Non-Furnished', level: 2 },
                        { id: 'rent_building', text: '3. Full Building', level: 1 },
                        { id: 'rent_land_head', text: '4. Land', level: 1, disabled: true },
                        { id: 'rent_land_agri', text: 'a. Agricultural', level: 2 },
                        { id: 'rent_land_res', text: 'b. Residential', level: 2 }
                    ]
                },
                {
                    text: 'Commercial',
                    children: [
                        { id: 'rent_comm_off_res_head', text: '1. Office Residential', level: 1, disabled: true },
                        { id: 'rent_comm_off_res_full', text: 'a. Full Furnished', level: 2 },
                        { id: 'rent_comm_off_res_semi', text: 'b. Semi Furnished', level: 2 },
                        { id: 'rent_comm_off_res_non', text: 'c. Non-Furnished', level: 2 },
                        { id: 'rent_comm_off_comm_head', text: '2. Office Commercial', level: 1, disabled: true },
                        { id: 'rent_comm_off_comm_full', text: 'a. Full Furnished', level: 2 },
                        { id: 'rent_comm_off_comm_semi', text: 'b. Semi Furnished', level: 2 },
                        { id: 'rent_comm_off_comm_non', text: 'c. Non-Furnished', level: 2 },
                        { id: 'rent_comm_factory', text: '3. Godown/ Factory', level: 1 },
                        { id: 'rent_comm_building', text: '4. Full Building', level: 1 },
                        { id: 'rent_comm_land', text: '5. Land', level: 1 }
                    ]
                }
            ],
            sale: [
                {
                    text: 'Residential',
                    children: [
                        { id: 'sale_apt_head', text: '1. Apartment', level: 1, disabled: true },
                        { id: 'sale_apt_full', text: 'a. Full Furnished', level: 2 },
                        { id: 'sale_apt_semi', text: 'b. Semi Furnished', level: 2 },
                        { id: 'sale_apt_non', text: 'c. Non-Furnished', level: 2 },
                        { id: 'sale_duplex_head', text: '2. Duplex', level: 1, disabled: true },
                        { id: 'sale_duplex_full', text: 'a. Full Furnished', level: 2 },
                        { id: 'sale_duplex_semi', text: 'b. Semi Furnished', level: 2 },
                        { id: 'sale_duplex_non', text: 'c. Non-Furnished', level: 2 },
                        { id: 'sale_building', text: '3. Full Building', level: 1 },
                        { id: 'sale_land', text: '4. Land', level: 1 }
                    ]
                },
                {
                    text: 'Commercial',
                    children: [
                        { id: 'sale_off_head', text: '1. Office', level: 1, disabled: true },
                        { id: 'sale_off_full', text: 'a. Full Furnished', level: 2 },
                        { id: 'sale_off_semi', text: 'b. Semi Furnished', level: 2 },
                        { id: 'sale_off_non', text: 'c. Non-Furnished', level: 2 },
                        { id: 'sale_comm_factory', text: '2. Godown/ Factory', level: 1 },
                        { id: 'sale_comm_building', text: '3. Full Building', level: 1 },
                        { id: 'sale_comm_land', text: '4. Land', level: 1 }
                    ]
                }
            ]
        };

        function formatPropertyOption(state) {
            if (!state.id) return state.text;
            
            const level = state.level || 0;
            const $state = $(
                '<span class="select2-option-level-' + level + '">' + state.text + '</span>'
            );
            
            if (level === 1) {
                $state.css('font-weight', 'bold');
                $state.css('border-bottom', '1px solid #eee');
                $state.css('padding-bottom', '2px');
                $state.css('display', 'inline-block');
            }
            
            return $state;
        }

        function updatePropertyType(type) {
            const $select = $('#propertyTypeSelect');
            $select.empty();
            $select.append(new Option('', ''));
            
            const options = propertyOptions[type] || [];
            $select.select2({
                data: options,
                placeholder: 'Property Type',
                allowClear: true,
                width: '100%',
                templateResult: formatPropertyOption
            });
        }

        // Initialize Select2
        $(document).ready(function() {
            const select2Options = {
                allowClear: true,
                width: '100%'
            };

            $('#locationSelect').select2({
                ...select2Options,
                placeholder: 'All Cities'
            });

            const initialType = document.getElementById('search_type').value || 'sale';
            updatePropertyType(initialType);
        });

        // Tab switching logic
        const tabs = document.querySelectorAll('.search-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const type = this.getAttribute('data-type');
                document.getElementById('search_type').value = type;
                
                // Update Select2 options
                updatePropertyType(type);
            });
        });

        // Custom Dropdown logic
        const dropdowns = document.querySelectorAll('.custom-dropdown');
        
        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle-custom');
            const content = dropdown.querySelector('.dropdown-content-custom');
            const clearBtn = dropdown.querySelector('.btn-clear-dropdown');
            const applyBtn = dropdown.querySelector('.btn-apply-dropdown');

            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                // Close other dropdowns
                dropdowns.forEach(d => {
                    if (d !== dropdown) d.classList.remove('active');
                });
                dropdown.classList.toggle('active');
            });

            // Prevent closing when clicking inside dropdown content
            content.addEventListener('click', (e) => e.stopPropagation());

            // Clear button
            clearBtn.addEventListener('click', () => {
                if (dropdown.id === 'bedDropdown') {
                    dropdown.querySelectorAll('.bed-btn').forEach(btn => btn.classList.remove('active'));
                    document.getElementById('bedValue').value = '';
                    toggle.innerText = 'Bedrooms';
                } else if (dropdown.id === 'areaDropdown') {
                    document.getElementById('minArea').value = '';
                    document.getElementById('maxArea').value = '';
                    toggle.innerText = 'Any Size';
                } else if (dropdown.id === 'priceDropdown') {
                    document.getElementById('minPrice').value = '';
                    document.getElementById('maxPrice').value = '';
                    toggle.innerText = 'Max. Price';
                }
                dropdown.classList.remove('active');
            });

            // Apply button
            applyBtn.addEventListener('click', () => {
                if (dropdown.id === 'bedDropdown') {
                    const activeBed = dropdown.querySelector('.bed-btn.active');
                    toggle.innerText = activeBed ? activeBed.innerText + ' Bed' : 'Bedrooms';
                } else if (dropdown.id === 'areaDropdown') {
                    const min = document.getElementById('minArea').value;
                    const max = document.getElementById('maxArea').value;
                    if (min && max) toggle.innerText = min + ' - ' + max + ' SFT';
                    else if (min) toggle.innerText = min + '+ SFT';
                    else if (max) toggle.innerText = 'Up to ' + max + ' SFT';
                    else toggle.innerText = 'Any Size';
                } else if (dropdown.id === 'priceDropdown') {
                    const min = document.getElementById('minPrice').value;
                    const max = document.getElementById('maxPrice').value;
                    if (min && max) toggle.innerText = min + ' - ' + max + ' BDT';
                    else if (min) toggle.innerText = min + '+ BDT';
                    else if (max) toggle.innerText = 'Up to ' + max + ' BDT';
                    else toggle.innerText = 'Max. Price';
                }
                dropdown.classList.remove('active');
            });
        });

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
            dropdowns.forEach(d => d.classList.remove('active'));
        });
    });
</script>
@endpush
