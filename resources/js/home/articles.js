// Moved verbatim from component/articles.blade.php (was an inline <script>).
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('articlesSlider');
    if (!el) return;

    whenNear(el, () => new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 30,
        rewind: true,
        watchOverflow: true,
        // Faster autoplay on mobile since the nav buttons are hidden.
        autoplay: {
            delay: window.innerWidth <= 991 ? 4000 : 7000,
            disableOnInteraction: false,
        },
        // Scope nav to THIS slider; otherwise Swiper picks up the first
        // .swiper-button-next in the DOM (which may be inside a card).
        navigation: {
            nextEl: el.querySelector('.articles-slider-next'),
            prevEl: el.querySelector('.articles-slider-prev'),
        },
        breakpoints: {
            640:  { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    }));
});
