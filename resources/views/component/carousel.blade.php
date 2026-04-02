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
                    <!-- Tabs -->
                    <div class="search-tabs-outer">
                        <div class="search-tabs">
                            <button class="search-tab active" data-type="sell">SELL</button>
                            <button class="search-tab" data-type="rent">RENT</button>
                        </div>
                    </div>
                    
                    <!-- Search Box -->
                    <div class="search-box card shadow">
                        <form action="#" method="GET" class="search-form">
                            <input type="hidden" name="search_type" id="search_type" value="sell">
                            
                            <div class="compact-search-grid">
                                <!-- Location Card -->
                                <div class="search-card" onclick="$('#locationSelect').select2('open')">
                                    <div class="card-label">LOCATION</div>
                                    <div class="search-field">
                                        <select class="form-select select2-location" name="location" id="locationSelect">
                                            <option value=""></option>
                                            @foreach($locations as $loc)
                                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="card-sub-label" id="locationSubLabel">Select City</div>
                                </div>

                                <!-- Property Type Card -->
                                <div class="search-card" onclick="$('#propertyTypeSelect').select2('open')">
                                    <div class="card-label">PROPERTY TYPE</div>
                                    <div class="search-field">
                                        <select class="form-select select2-property-type" name="property_type" id="propertyTypeSelect">
                                            <option value=""></option>
                                            @foreach($property_types as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
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
            sell: [
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
            }).on('change', function() {
                const data = $(this).select2('data')[0];
                const subLabel = data && data.text ? 'Selected in ' + data.text : 'Select City';
                document.getElementById('locationSubLabel').innerText = subLabel;
            });

            $('#propertyTypeSelect').select2({
                ...select2Options,
                placeholder: 'Property Type'
            }).on('change', function() {
                const data = $(this).select2('data')[0];
                const subLabel = data && data.text ? 'Type: ' + data.text : 'Residential/Commercial';
                document.getElementById('propertyTypeSubLabel').innerText = subLabel;
            });
            
            // Handle form submission based on type
            $('.search-form').on('submit', function(e) {
                const type = $('#search_type').val();
                if (type === 'rent') {
                    $(this).attr('action', "{{ route('rent') }}");
                } else if (type === 'sell') {
                    $(this).attr('action', "{{ route('sell') }}");
                } else {
                    $(this).attr('action', "{{ route('buy') }}");
                }
            });
        });

        // Tab switching logic
        const tabs = document.querySelectorAll('.search-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const type = this.getAttribute('data-type');
                document.getElementById('search_type').value = type;
                
                document.getElementById('propertyTypeSubLabel').innerText = 'Residential/Commercial';
            });
        });

        // Card Click logic for custom dropdowns
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

            // Prevent closing when clicking inside dropdown content
            dropdown.querySelector('.dropdown-content-custom').addEventListener('click', (e) => e.stopPropagation());

            // Clear button
            clearBtn.addEventListener('click', () => {
                if (dropdown.id === 'bedDropdown') {
                    dropdown.querySelectorAll('.bed-btn').forEach(btn => btn.classList.remove('active'));
                    document.getElementById('bedValue').value = '';
                    document.getElementById('bedSubLabel').innerText = 'Number of Beds';
                } else if (dropdown.id === 'areaDropdown') {
                    document.getElementById('minArea').value = '';
                    document.getElementById('maxArea').value = '';
                    document.getElementById('areaSubLabel').innerText = 'Area in SFT';
                } else if (dropdown.id === 'priceDropdown') {
                    document.getElementById('minPrice').value = '';
                    document.getElementById('maxPrice').value = '';
                    document.getElementById('priceSubLabel').innerText = 'Budget Range';
                }
                dropdown.classList.remove('active');
            });

            // Apply button
            applyBtn.addEventListener('click', () => {
                if (dropdown.id === 'bedDropdown') {
                    const activeBed = dropdown.querySelector('.bed-btn.active');
                    document.getElementById('bedSubLabel').innerText = activeBed ? activeBed.innerText + ' Bedrooms Selected' : 'Number of Beds';
                } else if (dropdown.id === 'areaDropdown') {
                    const min = document.getElementById('minArea').value;
                    const max = document.getElementById('maxArea').value;
                    if (min && max) document.getElementById('areaSubLabel').innerText = min + ' - ' + max + ' SFT';
                    else if (min) document.getElementById('areaSubLabel').innerText = min + '+ SFT';
                    else if (max) document.getElementById('areaSubLabel').innerText = 'Up to ' + max + ' SFT';
                    else document.getElementById('areaSubLabel').innerText = 'Area in SFT';
                } else if (dropdown.id === 'priceDropdown') {
                    const min = document.getElementById('minPrice').value;
                    const max = document.getElementById('maxPrice').value;
                    if (min && max) document.getElementById('priceSubLabel').innerText = min + ' - ' + max + ' BDT';
                    else if (min) document.getElementById('priceSubLabel').innerText = min + '+ BDT';
                    else if (max) document.getElementById('priceSubLabel').innerText = 'Up to ' + max + ' BDT';
                    else document.getElementById('priceSubLabel').innerText = 'Budget Range';
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
            closeAllDropdowns();
        });
    });
</script>
@endpush
