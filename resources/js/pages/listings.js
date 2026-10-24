// Moved verbatim from pages/listings.blade.php (was an inline <script>).
// ===========================================================================
// FILTER FORM — DUPLICATE-NAME DEFENCE
// ---------------------------------------------------------------------------
// The form has TWO inputs per filter sharing the same `name` (one for desktop
// Select2, one for the mobile custom picker). To stop both being submitted
// we use two complementary defences:
//
//   1. PRIMARY: a JS submit handler that builds the URL ourselves, picking
//      the last non-empty value per name.
//
//   2. FALLBACK: disable the input that belongs to the inactive viewport
//      via `el.disabled = true`. Disabled inputs are never serialised by
//      the browser, so even if the JS handler crashes or never attaches,
//      a NATIVE form submission still produces a clean URL.
//
// Both are registered at the very TOP of DOMContentLoaded so they survive
// any error in the page-specific picker code further down.
// ===========================================================================
(function attachFilterFormDefences() {
    // For every filter, list the desktop-card input(s) and the
    // mobile-view input(s) that share the same `name`. The handler
    // disables the inactive viewport's inputs so they aren't serialised.
    const FILTER_PAIRS = [
        { desktopId: 'locationSelectDesktop',     mobileId: 'locationMobileValue' },
        { desktopId: 'propertyTypeSelectDesktop', mobileId: 'propertyTypeMobileValue' },
        { desktopId: 'bedValueDesktop',           mobileId: 'bedroomsMobileSelect' },
        { desktopId: 'minAreaDesktop',            mobileId: 'minAreaMobile' },
        { desktopId: 'maxAreaDesktop',            mobileId: 'maxAreaMobile' },
        { desktopId: 'minPriceDesktop',           mobileId: 'minPriceMobile' },
        { desktopId: 'maxPriceDesktop',           mobileId: 'maxPriceMobile' },
    ];

    function syncDisabledState() {
        const isMobile = window.innerWidth <= 991;
        FILTER_PAIRS.forEach(p => {
            const d = document.getElementById(p.desktopId);
            const m = document.getElementById(p.mobileId);
            if (d) d.disabled = isMobile;
            if (m) m.disabled = !isMobile;
        });
    }

    function attachOnce() {
        syncDisabledState();
        window.addEventListener('resize', syncDisabledState);

        // The form is inside #mobileFilterForm now. Match it by name.
        const filterForm = document.querySelector('#mobileFilterForm form');
        if (!filterForm) return;

        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            syncDisabledState();

            const collected = {};
            const formData  = new FormData(this);
            for (const [key, raw] of formData.entries()) {
                if (key === '_token' || key === '_method') continue;
                const value = (raw ?? '').toString().trim();
                if (value === '' || value === 'any') continue;
                collected[key] = value;
            }

            const params  = new URLSearchParams(collected).toString();
            const baseUrl = window.location.origin + window.location.pathname;
            window.location.assign(baseUrl + (params ? '?' + params : ''));
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', attachOnce);
    } else {
        attachOnce();
    }
})();

document.addEventListener('DOMContentLoaded', function() {

    // Inner card sliders are created lazily (same options, loop off so
    // the feature image stays slide 0) by the shared observer in
    // include/script.blade.php.

    // No Select2 initialization needed for standard selects
    
    // Custom Dropdown Logic for mobile
    $(document).on('click', '#locationToggleMobile', function(e) {
        e.stopPropagation();
        $('#locationDropdownMobile').toggleClass('active');
        $('#propertyTypeDropdownMobile').removeClass('active');
    });

    $(document).on('click', '#propertyTypeToggleMobile', function(e) {
        e.stopPropagation();
        $('#propertyTypeDropdownMobile').toggleClass('active');
        $('#locationDropdownMobile').removeClass('active');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#propertyTypeDropdownMobile, #locationDropdownMobile').length) {
            $('#propertyTypeDropdownMobile, #locationDropdownMobile').removeClass('active');
        }
    });

    // Location Picker Logic
    const locationDropdown = document.getElementById('locationDropdownMobile');
    if (locationDropdown) {
        const locItems = locationDropdown.querySelectorAll('.type-item');
        const locToggleText = locationDropdown.querySelector('.toggle-text');
        const locHiddenInput = document.getElementById('locationMobileValue');
        const locSelectAllBtn = locationDropdown.querySelector('.btn-location-select-all');
        const locDeselectAllBtn = locationDropdown.querySelector('.btn-location-deselect-all');

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

        // These "Select All" / "Deselect All" buttons aren't rendered for
        // the location picker; guard against null to avoid halting the
        // rest of the page script.
        if (locSelectAllBtn) {
            locSelectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const firstItem = locItems[0];
                if (firstItem) firstItem.click();
            });
        }

        if (locDeselectAllBtn) {
            locDeselectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                locItems.forEach(i => i.classList.remove('selected'));
                locHiddenInput.value = '';
                locToggleText.innerText = 'All Locations';
                locationDropdown.classList.remove('active');
            });
        }
    }

    const propertyTypeDropdown = document.getElementById('propertyTypeDropdownMobile');
    if (propertyTypeDropdown) {
        const typeItems = propertyTypeDropdown.querySelectorAll('.type-item');
        const toggleText = propertyTypeDropdown.querySelector('.toggle-text');
        const hiddenInput = document.getElementById('propertyTypeMobileValue');
        const selectAllBtn = propertyTypeDropdown.querySelector('.btn-select-all');
        const deselectAllBtn = propertyTypeDropdown.querySelector('.btn-deselect-all');

        typeItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                typeItems.forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');
                const val = this.getAttribute('data-value');
                const text = this.getAttribute('data-text');
                hiddenInput.value = val;
                toggleText.innerText = text;
                propertyTypeDropdown.classList.remove('active');
            });
        });

        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const firstItem = typeItems[0];
                if (firstItem) firstItem.click();
            });
        }

        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                typeItems.forEach(i => i.classList.remove('selected'));
                hiddenInput.value = '';
                toggleText.innerText = 'All Categories';
                propertyTypeDropdown.classList.remove('active');
            });
        }
    }

    // ===== DESKTOP carousel-style search cards =====
    // Initialised only on screens wide enough for the desktop view.
    if (window.innerWidth >= 992 && typeof $ !== 'undefined' && typeof $.fn.select2 === 'function') {

        // Indented option formatter — parent flush left, child indented 20px.
        function formatTypeOption(state) {
            if (!state.id) return state.text;
            const level = $(state.element).data('level') || 0;
            const padding = level === 1 ? '20px' : '0';
            const cleanText = state.text.replace(/&nbsp;|\s\s\s/g, '');
            return $(
                '<div style="display:flex;align-items:center;padding-left:' + padding + ';">' +
                    '<span>' + cleanText + '</span>' +
                '</div>'
            );
        }

        // Inject the CSS that hides Select2's default choice pills for the
        // property type dropdown — we render a custom "N types selected"
        // summary in their place.
        if (!$('style#listings-type-fixes').length) {
            $('head').append(
                '<style id="listings-type-fixes">' +
                '.listings-type-select2 .select2-selection__choice { display: none !important; }' +
                '</style>'
            );
        }

        // ---- LOCATION (single-select) ----
        $('.select2-listings-location').select2({
            placeholder: 'Select Location',
            width: '100%',
            allowClear: true,
            minimumResultsForSearch: 6,
            dropdownCssClass: 'premium-search-dropdown',
            dropdownParent: $('.select2-listings-location').closest('.search-card'),
        });

        // ---- PROPERTY TYPE (multi-select, carousel design) ----
        const $typeSelect = $('.select2-listings-type');
        if ($typeSelect.length) {
            $typeSelect.select2({
                placeholder: 'Select Type',
                width: '100%',
                allowClear: true,
                templateResult: formatTypeOption,
                minimumResultsForSearch: Infinity,
                closeOnSelect: false,
                dropdownCssClass: 'premium-search-dropdown',
                dropdownParent: $typeSelect.closest('.search-card'),
            });
            $typeSelect.next('.select2-container').addClass('listings-type-select2');

            // Render a compact "1 type / N types / All types selected"
            // summary in the trigger instead of stacked pills.
            $typeSelect.on('change', function () {
                setTimeout(function () {
                    const selected = $typeSelect.val() || [];
                    const $rendered = $typeSelect.next('.select2-container').find('.select2-selection__rendered');
                    $rendered.find('.custom-summary-text').remove();
                    if (selected.length > 0) {
                        $rendered.find('.select2-search__field').attr('placeholder', '').css('width', '0');
                        const total = $typeSelect.find('option').length;
                        let summaryText;
                        if (selected.length === 1) {
                            summaryText = $typeSelect.find('option:selected').text().replace(/&nbsp;|-/g, '').trim();
                        } else if (selected.length === total) {
                            summaryText = 'All types selected';
                        } else {
                            summaryText = selected.length + ' types selected';
                        }
                        $rendered.prepend(
                            '<li class="custom-summary-text" style="list-style:none;display:flex;align-items:center;padding-left:8px;margin-top:6px;color:#6c757d;font-size:14px;">' +
                            summaryText +
                            '</li>'
                        );
                    } else {
                        $rendered.find('.select2-search__field').attr('placeholder', 'Select Type').css('width', '');
                    }
                }, 0);
            });

            // Parent ↔ child cascade. Selecting a parent option auto-selects
            // its children; deselecting parent deselects children. Toggling
            // the last child also deselects the parent.
            let __ptPrev = new Set(($typeSelect.val() || []).map(String));
            let __ptCascading = false;
            $typeSelect.on('change.cascade', function () {
                if (__ptCascading) return;
                __ptCascading = true;
                const curr  = new Set(($typeSelect.val() || []).map(String));
                const added = [...curr].filter(v => !__ptPrev.has(v));
                const removed = [...__ptPrev].filter(v => !curr.has(v));
                let mutated = false;
                const setOpt = (opt, on) => {
                    if (opt.selected !== on) { opt.selected = on; if (on) curr.add(String(opt.value)); else curr.delete(String(opt.value)); mutated = true; }
                };
                added.forEach(id => {
                    const $opt = $typeSelect.find('option[value="' + id + '"]');
                    const level = $opt.attr('data-level');
                    if (level === '0') {
                        const pid = $opt.attr('data-parent-id') || id;
                        $typeSelect.find('option[data-parent="' + pid + '"]').each(function () { setOpt(this, true); });
                    } else if (level === '1') {
                        const pid = $opt.attr('data-parent');
                        const $parent = $typeSelect.find('option[data-parent-id="' + pid + '"]');
                        const $siblings = $typeSelect.find('option[data-parent="' + pid + '"]');
                        if ($parent.length && $siblings.toArray().every(o => o.selected)) setOpt($parent[0], true);
                    }
                });
                removed.forEach(id => {
                    const $opt = $typeSelect.find('option[value="' + id + '"]');
                    const level = $opt.attr('data-level');
                    if (level === '0') {
                        const pid = $opt.attr('data-parent-id') || id;
                        $typeSelect.find('option[data-parent="' + pid + '"]').each(function () { setOpt(this, false); });
                    } else if (level === '1') {
                        const pid = $opt.attr('data-parent');
                        const $parent = $typeSelect.find('option[data-parent-id="' + pid + '"]');
                        if ($parent.length && $parent[0].selected) setOpt($parent[0], false);
                    }
                });
                __ptPrev = new Set([...curr].map(String));
                __ptCascading = false;
                if (mutated) $typeSelect.trigger('change');
            });

            // Inject "Select All / Deselect All" header into the dropdown
            // when it opens — same as homepage.
            $typeSelect.on('select2:open', function () {
                const $dropdown = $('.select2-dropdown--below, .select2-dropdown--above').last();
                if (!$dropdown.find('.select2-all-actions').length) {
                    $dropdown.prepend(
                        '<div class="select2-all-actions d-flex align-items-center border-bottom bg-white">' +
                            '<button type="button" class="btn-selection-action flex-grow-1 btn-select-all-s2">Select All</button>' +
                            '<div class="action-divider"></div>' +
                            '<button type="button" class="btn-selection-action flex-grow-1 btn-deselect-all-s2">Deselect All</button>' +
                        '</div>'
                    );
                    $dropdown.find('.btn-select-all-s2').on('click', function () {
                        $typeSelect.find('option').prop('selected', 'selected');
                        $typeSelect.trigger('change');
                    });
                    $dropdown.find('.btn-deselect-all-s2').on('click', function () {
                        $typeSelect.val(null).trigger('change');
                    });
                }
            });

            // Trigger an initial render so any pre-selected items show
            // the summary text immediately on page load.
            $typeSelect.trigger('change');
        }

        // Card-click opens the underlying Select2.
        $(document).on('click', '#listingsLocationCard, #listingsTypeCard', function (e) {
            const $sel = $(this).find('select');
            if ($sel.length && $sel.hasClass('select2-hidden-accessible')) {
                e.stopPropagation();
                $sel.select2('open');
            }
        });

        // Bed / Area / Price custom dropdowns.
        const desktopDropdowns = ['listingsBedDropdown', 'listingsAreaDropdown', 'listingsPriceDropdown'];
        desktopDropdowns.forEach(id => {
            const dd = document.getElementById(id);
            if (!dd) return;
            const toggle = dd.querySelector('.dropdown-toggle-custom');
            if (toggle) {
                toggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    desktopDropdowns.forEach(otherId => {
                        if (otherId !== id) {
                            const other = document.getElementById(otherId);
                            if (other) other.classList.remove('active');
                        }
                    });
                    dd.classList.toggle('active');
                });
            }
            const content = dd.querySelector('.dropdown-content-custom');
            if (content) content.addEventListener('click', e => e.stopPropagation());
        });

        // Close all desktop dropdowns when clicking outside.
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#listingsBedDropdown, #listingsAreaDropdown, #listingsPriceDropdown, .search-card')) {
                desktopDropdowns.forEach(id => {
                    const dd = document.getElementById(id);
                    if (dd) dd.classList.remove('active');
                });
            }
        });

        // Bed buttons.
        const bedDropdown = document.getElementById('listingsBedDropdown');
        if (bedDropdown) {
            const bedBtns  = bedDropdown.querySelectorAll('.bed-btn');
            const bedInput = document.getElementById('bedValueDesktop');
            const bedToggle = document.getElementById('listingsBedToggle');
            bedBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    bedBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            const clearBtn = bedDropdown.querySelector('.btn-clear-dropdown');
            const applyBtn = bedDropdown.querySelector('.btn-apply-dropdown');
            if (clearBtn) clearBtn.addEventListener('click', function () {
                bedBtns.forEach(b => b.classList.remove('active'));
                const any = bedDropdown.querySelector('.bed-btn[data-value="any"]');
                if (any) any.classList.add('active');
                bedInput.value = '';
                bedToggle.innerText = 'Bedrooms';
                bedDropdown.classList.remove('active');
            });
            if (applyBtn) applyBtn.addEventListener('click', function () {
                const active = bedDropdown.querySelector('.bed-btn.active');
                const val = active ? active.getAttribute('data-value') : 'any';
                bedInput.value = (val === 'any') ? '' : val;
                bedToggle.innerText = (val === 'any') ? 'Bedrooms' : (val === '5' ? '5+ Bed' : val + ' Bed');
                bedDropdown.classList.remove('active');
            });
        }

        // Area + Price range dropdowns share the same Clear/Apply pattern.
        function wireRangeDropdown(dropdownId, minId, maxId, toggleId, defaultText, suffix) {
            const dd = document.getElementById(dropdownId);
            if (!dd) return;
            const minEl = document.getElementById(minId);
            const maxEl = document.getElementById(maxId);
            const toggle = document.getElementById(toggleId);
            const clearBtn = dd.querySelector('.btn-clear-dropdown');
            const applyBtn = dd.querySelector('.btn-apply-dropdown');
            function renderToggle() {
                const mn = minEl.value, mx = maxEl.value;
                if (mn && mx)       toggle.innerText = mn + ' - ' + mx + ' ' + suffix;
                else if (mn)        toggle.innerText = mn + '+ ' + suffix;
                else if (mx)        toggle.innerText = 'Up to ' + mx + ' ' + suffix;
                else                toggle.innerText = defaultText;
            }
            if (clearBtn) clearBtn.addEventListener('click', function () {
                minEl.value = '';
                maxEl.value = '';
                renderToggle();
                dd.classList.remove('active');
            });
            if (applyBtn) applyBtn.addEventListener('click', function () {
                renderToggle();
                dd.classList.remove('active');
            });
        }
        wireRangeDropdown('listingsAreaDropdown',  'minAreaDesktop',  'maxAreaDesktop',  'listingsAreaToggle',  'Any Size',  'SFT');
        wireRangeDropdown('listingsPriceDropdown', 'minPriceDesktop', 'maxPriceDesktop', 'listingsPriceToggle', 'Max. Price', 'BDT');
    }

    // (Submit handler is registered at the very top of this block.)
});
