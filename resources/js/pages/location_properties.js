// Moved verbatim from pages/location_properties.blade.php (was an inline <script>).
// Same dual-defence approach as listings.blade.php (see comments there).
(function attachFilterFormDefences() {
    const FILTER_PAIRS = [
        { desktopId: 'propertyStatusDesktop',     mobileId: 'propertyStatusMobile' },
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

    // Custom Dropdown Logic for mobile
    $(document).on('click', '#propertyTypeToggleMobile', function(e) {
        e.stopPropagation();
        $('#propertyTypeDropdownMobile').toggleClass('active');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#propertyTypeDropdownMobile').length) {
            $('#propertyTypeDropdownMobile').removeClass('active');
        }
    });

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
    if (window.innerWidth >= 992 && typeof $ !== 'undefined' && typeof $.fn.select2 === 'function') {

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

        if (!$('style#listings-type-fixes').length) {
            $('head').append(
                '<style id="listings-type-fixes">' +
                '.listings-type-select2 .select2-selection__choice { display: none !important; }' +
                '</style>'
            );
        }

        // ---- STATUS (single-select) ----
        $('.select2-listings-status').select2({
            placeholder: 'All',
            width: '100%',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownCssClass: 'premium-search-dropdown',
            dropdownParent: $('.select2-listings-status').closest('.search-card'),
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

            $typeSelect.trigger('change');
        }

        $(document).on('click', '#listingsStatusCard, #listingsTypeCard', function (e) {
            const $sel = $(this).find('select');
            if ($sel.length && $sel.hasClass('select2-hidden-accessible')) {
                e.stopPropagation();
                $sel.select2('open');
            }
        });

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

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#listingsBedDropdown, #listingsAreaDropdown, #listingsPriceDropdown, .search-card')) {
                desktopDropdowns.forEach(id => {
                    const dd = document.getElementById(id);
                    if (dd) dd.classList.remove('active');
                });
            }
        });

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
});
