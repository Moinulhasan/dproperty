// Moved verbatim from component/social.blade.php (was an inline <script>).
document.addEventListener('DOMContentLoaded', function() {
    const featuredEl = document.getElementById('featuredPropertiesSlider');
    if (!featuredEl) return;

    // Inner per-card sliders are created lazily by the shared observer in
    // include/script.blade.php. rewind (not loop) means no cloned slides,
    // so they no longer have to be wired up before the outer carousel.
    whenNear(featuredEl, function () {
        const slideCount = featuredEl.querySelectorAll(':scope > .swiper-wrapper > .swiper-slide').length;

        // observer/observeParents were removed. On Safari they fed into a
        // feedback loop with the per-card inner Swipers' DOM mutations and
        // exhausted the tab's memory ceiling, killing the page.
        const featuredSwiper = new Swiper(featuredEl, {
            slidesPerView: 1,
            spaceBetween: 20,
            rewind: slideCount >= 5,
            watchOverflow: true,
            autoplay: slideCount > 1 ? {
                delay: 6000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            navigation: {
                nextEl: featuredEl.querySelector('.featured-next'),
                prevEl: featuredEl.querySelector('.featured-prev'),
            },
            breakpoints: {
                640:  { slidesPerView: 2 },
                1024: { slidesPerView: 4 },
            },
        });

        // Pause autoplay when this section scrolls off-screen — keeps Safari
        // from burning cycles on a background animation and stops autoplay
        // from "catching up" in a burst when the user scrolls back.
        if (featuredSwiper && featuredSwiper.autoplay && 'IntersectionObserver' in window) {
            const obs = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!featuredSwiper.autoplay) return;
                    if (entry.isIntersecting) {
                        featuredSwiper.autoplay.start();
                    } else {
                        featuredSwiper.autoplay.stop();
                    }
                });
            }, { threshold: 0.1 });
            obs.observe(featuredEl);
        }
    });
});
