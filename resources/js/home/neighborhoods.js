// Moved verbatim from component/neighborhoods.blade.php (was an inline <script>).
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 768) return;

    const slider = document.querySelector('.neighborhood-slider');
    const many = slider && Number(slider.dataset.count) > 4;

    whenNear(slider, (el) => new Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 30,
        rewind: many,
        autoplay: many ? { delay: 5000, disableOnInteraction: false } : false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 4,
            },
            1440: {
                slidesPerView: 5,
            }
        }
    }));
});
