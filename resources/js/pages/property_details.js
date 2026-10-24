// Moved verbatim from pages/property_details.blade.php (was an inline <script>).
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Gallery Swipers
    var thumbsSwiper = new Swiper(".thumb-image-swiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });

    var mainSwiper = new Swiper(".main-image-swiper", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: thumbsSwiper,
        },
    });

    // Inner card sliders for recommended properties, created on approach.
    // swiperReady stops the shared observer in include/script from
    // creating a second instance on the same element.
    document.querySelectorAll('.card-inner-slider').forEach(slider => {
        slider.dataset.swiperReady = '1';
        whenNear(slider, () => new Swiper(slider, {
            slidesPerView: 1,
            spaceBetween: 0,
            rewind: true,
            navigation: {
                nextEl: slider.querySelector('.swiper-button-next'),
                prevEl: slider.querySelector('.swiper-button-prev'),
            },
        }));
    });

    // Phone Reveal Logic
    const phoneBtn = document.getElementById('showPhoneBtn');
    if (phoneBtn) {
        phoneBtn.addEventListener('click', function() {
            const phone = this.dataset.fullPhone || 'Private Number';
            this.innerHTML = '<i class="fas fa-phone-alt"></i> ' + phone;
            this.classList.add('bg-light');
        });
    }
});
