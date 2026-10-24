// Site-wide JS (was the CDN <script> tags + the inline block in
// include/script.blade.php + public/custom/custom_js.js).
// Module scripts are deferred and run before DOMContentLoaded, so the inline
// page scripts that wait for DOMContentLoaded still find $, Swiper, whenNear.
import $ from 'jquery';
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';
import Swiper from 'swiper/bundle';
import { animate, inView } from 'motion';

// Same globals the CDN <script> tags used to define.
window.$ = window.jQuery = $;
window.bootstrap = bootstrap;
window.Swiper = Swiper;

// Gallery button on property cards (onclick="openGallery(this)"). Fancybox is
// only downloaded the first time someone opens a gallery.
window.openGallery = async function (btn) {
    try {
        const images = JSON.parse(btn.dataset.images);
        if (images && images.length > 0) {
            const [{ Fancybox }] = await Promise.all([
                import('@fancyapps/ui/dist/fancybox/fancybox.esm.js'),
                import('@fancyapps/ui/dist/fancybox/fancybox.css'),
            ]);
            Fancybox.show(images.map((img) => ({ src: img, type: 'image', caption: 'Property Image' })));
        }
    } catch (e) {
        console.error('Error parsing images for gallery', e);
    }
};

// Run fn(el) once, when el comes within 200px of the viewport.
window.whenNear = function (el, fn) {
    if (!el) return;
    if (!('IntersectionObserver' in window)) return fn(el);
    const io = new IntersectionObserver((entries) => {
        if (entries.some((e) => e.isIntersecting)) {
            io.disconnect();
            fn(el);
        }
    }, { rootMargin: '200px' });
    io.observe(el);
};

// Subtle reveal (fade + 20px rise, 0.4s) of card rows as they scroll into
// view. Only for things below the fold at load, so nothing visible blinks out;
// skipped for reduced motion. Homepage: whole slider rows (individual slides
// would re-animate as autoplay moves them). Listing pages: each grid card.
// Inline styles are removed afterwards so the end state is the original markup.
if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('#featuredPropertiesSlider, .main-property-slider, .container-90 .property-card-global')
        .forEach((el) => {
            if (el.getBoundingClientRect().top < innerHeight) return;
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            inView(el, () => {
                animate(el, { opacity: [0, 1], transform: ['translateY(20px)', 'translateY(0px)'] }, { duration: 0.4 })
                    // next frame: motion re-commits the final keyframe right after resolving
                    .then(() => requestAnimationFrame(() => {
                        el.style.removeProperty('opacity');
                        el.style.removeProperty('transform');
                    }));
            }, { amount: 0.1 });
        });
}

// Card slides after the first ship as inert <template>s (no request, no
// DOM node). Materialise a card's images the first time it is hovered,
// touched or focused — always before its inner slider can be moved.
['pointerover', 'touchstart', 'focusin'].forEach((type) => {
    document.addEventListener(type, (e) => {
        const card = e.target.closest && e.target.closest('.property-card-global');
        if (!card || card.dataset.hydrated) return;
        card.dataset.hydrated = '1';
        card.querySelectorAll('.card-inner-slider template').forEach((t) => t.replaceWith(t.content));
    }, { passive: true, capture: true });
});

// Jump instead of animating the scroll for users who prefer reduced motion.
const scrollBehavior = () => (matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth');

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
                behavior: scrollBehavior()
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
        window.scrollTo({ top: 0, behavior: scrollBehavior() });
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
    //
    // rewind (not loop): loop cloned every slide, multiplying <img> tags.
    // Small sets (≤ 4, fewer than a desktop row) keep loop so the row is
    // filled with clones exactly as before; that costs only a few nodes.
    // Each slider is created only when its section nears the viewport.
    const initSectionSlider = (selector, reverse) => whenNear(document.querySelector(selector), (el) => {
        const few = el.querySelectorAll(':scope > .swiper-wrapper > .swiper-slide').length <= 4;
        const swiper = new Swiper(el, {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: few,
            rewind: !few,
            watchOverflow: true,
            autoplay: {
                delay: autoplayDelay,
                disableOnInteraction: false,
                reverseDirection: reverse,
                pauseOnMouseEnter: true
            },
            navigation: {
                nextEl: selector + ' .section-slider-next',
                prevEl: selector + ' .section-slider-prev',
            },
            breakpoints: {
                640:  { slidesPerView: 2 },
                768:  { slidesPerView: 2.5 },
                1024: { slidesPerView: 3 },
                1280: { slidesPerView: 4 }
            }
        });
        observeAutoplay(swiper, el);
        // loop clones are created after the inner-slider observer ran
        // (a clone copies the original's "ready" flag but not its Swiper instance).
        el.querySelectorAll('.swiper-slide-duplicate .card-inner-slider').forEach((s) => {
            delete s.dataset.swiperReady;
            initInnerSlider(s);
        });
    });

    // Inner Card Sliders — lazy-initialized when the card scrolls into
    // view, NOT eagerly at page load. Before: ~48 Swiper instances were
    // created upfront with `loop: true`, which clones each slide 2-3x
    // and produces hundreds of duplicate <img> DOM nodes. That's what
    // pushed Safari past its memory ceiling. Now each card's Swiper is
    // only created on first scroll-in; loop is OFF so no slide cloning.
    function initInnerSlider(slider) {
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
    }

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
    function observeAutoplay(swiper, el) {
        if (!swiper || !('IntersectionObserver' in window)) return;
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
    }
    initSectionSlider('.rent-slider', false);
    initSectionSlider('.sell-slider', true); // Sell autoplays in reverse
});
