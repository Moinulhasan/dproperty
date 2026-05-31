<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- JavaScript -->
<!--Uncomment this line-->
<script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/script.js"></script>
<script src="{{asset('custom/custom_js.js')}}"></script>
<!-- Custom JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.offsetTop;
                const offsetPosition = elementPosition - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Back to top with circular progress
    const backToTopButton = document.getElementById('backToTop');
    const progressFill = backToTopButton ? backToTopButton.querySelector('.progress-ring-fill') : null;

    if (backToTopButton && progressFill) {
        const radius = 26;
        const circumference = 2 * Math.PI * radius;
        progressFill.style.strokeDasharray = circumference;
        progressFill.style.strokeDashoffset = circumference;

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercent = docHeight > 0 ? scrollTop / docHeight : 0;
            const offset = circumference - (scrollPercent * circumference);
            progressFill.style.strokeDashoffset = offset;

            if (scrollTop > 300) {
                backToTopButton.classList.add('visible');
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.classList.remove('visible');
                backToTopButton.style.display = 'none';
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Active navigation highlighting
    window.addEventListener('scroll', () => {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });

    // Transparent navbar on scroll
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.remove('navbar-light');
            navbar.classList.add('navbar-dark', 'bg-primary');
            navbar.querySelectorAll('.nav-link, .navbar-brand').forEach(link => {
                link.classList.remove('text-white');
            });
        } else {
            navbar.classList.remove('navbar-dark', 'bg-primary');
            navbar.classList.add('navbar-light');
            navbar.querySelectorAll('.nav-link, .navbar-brand').forEach(link => {
                link.classList.add('text-white');
            });
        }
    });

    // Mobile Navigation
    const mobileNavToggle = document.getElementById('mobileNavToggle');
    const mobileNavOverlay = document.getElementById('mobileNavOverlay');
    const mobileNavClose = document.getElementById('mobileNavClose');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    mobileNavToggle.addEventListener('click', () => {
        mobileNavOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    mobileNavClose.addEventListener('click', () => {
        mobileNavOverlay.classList.remove('active');
        document.body.style.overflow = 'auto';
    });

    mobileNavLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileNavOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    });

    // Close mobile nav when clicking outside
    mobileNavOverlay.addEventListener('click', (e) => {
        if (e.target === mobileNavOverlay) {
            mobileNavOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });

    // Initialize Swiper Sliders
    document.addEventListener('DOMContentLoaded', function() {
        // Helper function for conditional slider
        function initConditionalSlider(selector, options) {
            const element = document.querySelector(selector);
            if (!element) return null;

            let swiper = null;

            function handleResize() {
                const isDesktop = window.innerWidth >= 992;
                if (isDesktop && swiper) {
                    swiper.destroy(true, true);
                    swiper = null;
                } else if (!isDesktop && !swiper) {
                    swiper = new Swiper(element, options);
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize();
            return swiper;
        }

        // Detect iOS Safari — its per-tab memory ceiling is roughly half of
        // Chrome/Firefox on the same device, so we calm the homepage carousels
        // down: slower autoplay (less GC pressure), fewer simultaneous Swiper
        // instances. Without this, scrolling between For-Sell and For-Rent on
        // iPhone Safari triggers "A problem repeatedly occurred" (tab kill).
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) ||
                      (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
        const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        const lowMem = isIOS || isSafari;
        const autoplayDelay = lowMem ? 6000 : 3000;

        // Rent Slider — visible on every screen size, scrolls horizontally
        // through every active rent listing. NOT routed through
        // initConditionalSlider (which would destroy it on desktop).
        //
        // observer/observeParents were removed: Swiper was re-running its
        // re-layout pass every time an inner card slider mutated the DOM
        // (which happens constantly with autoplay), producing a feedback
        // loop that exhausted Safari's memory.
        let rentSwiper = null;
        if (document.querySelector('.rent-slider')) {
            rentSwiper = new Swiper('.rent-slider', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                watchOverflow: true,
                autoplay: {
                    delay: autoplayDelay,
                    disableOnInteraction: false,
                    reverseDirection: false,
                    pauseOnMouseEnter: true
                },
                navigation: {
                    nextEl: '.rent-slider .section-slider-next',
                    prevEl: '.rent-slider .section-slider-prev',
                },
                breakpoints: {
                    640:  { slidesPerView: 2 },
                    768:  { slidesPerView: 2.5 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 }
                }
            });
        }

        // Sell Slider — same responsive behaviour, autoplay reversed.
        let sellSwiper = null;
        if (document.querySelector('.sell-slider')) {
            sellSwiper = new Swiper('.sell-slider', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                watchOverflow: true,
                autoplay: {
                    delay: autoplayDelay,
                    disableOnInteraction: false,
                    reverseDirection: true,
                    pauseOnMouseEnter: true
                },
                navigation: {
                    nextEl: '.sell-slider .section-slider-next',
                    prevEl: '.sell-slider .section-slider-prev',
                },
                breakpoints: {
                    640:  { slidesPerView: 2 },
                    768:  { slidesPerView: 2.5 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 }
                }
            });
        }

        // Inner Card Sliders — lazy-initialized when the card scrolls into
        // view, NOT eagerly at page load. Before: ~48 Swiper instances were
        // created upfront with `loop: true`, which clones each slide 2-3x
        // and produces hundreds of duplicate <img> DOM nodes. That's what
        // pushed Safari past its memory ceiling. Now each card's Swiper is
        // only created on first scroll-in; loop is OFF so no slide cloning.
        const initInnerSlider = (slider) => {
            if (slider.dataset.swiperReady) return;
            slider.dataset.swiperReady = '1';
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: false,
                watchOverflow: true,
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
            });
        };

        const innerSliders = document.querySelectorAll('.card-inner-slider');
        if ('IntersectionObserver' in window) {
            const innerObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        initInnerSlider(entry.target);
                        innerObserver.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '300px 0px' });
            innerSliders.forEach((slider) => innerObserver.observe(slider));
        } else {
            // Fallback for ancient browsers — eager init as before.
            innerSliders.forEach(initInnerSlider);
        }

        // Pause outer slider autoplay when the section scrolls off-screen.
        // Cuts Safari background JS work and keeps autoplay from "catching up"
        // in a burst when the user scrolls back.
        const observeAutoplay = (swiper, selector) => {
            if (!swiper || !('IntersectionObserver' in window)) return;
            const el = document.querySelector(selector);
            if (!el) return;
            const obs = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!swiper.autoplay) return;
                    if (entry.isIntersecting) {
                        swiper.autoplay.start();
                    } else {
                        swiper.autoplay.stop();
                    }
                });
            }, { threshold: 0.1 });
            obs.observe(el);
        };
        observeAutoplay(rentSwiper, '.rent-slider');
        observeAutoplay(sellSwiper, '.sell-slider');
    });


</script>
