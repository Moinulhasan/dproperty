
var swiper = new Swiper(".slide-content", {
    slidesPerView: 3,
    spaceBetween: 25,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

    breakpoints:{
        0: {
            slidesPerView: 1,
        },
        520: {
            slidesPerView: 2,
        },
        950: {
            slidesPerView: 3,
        },
    },
});

function openGallery(btn) {
    if (typeof Fancybox !== 'undefined') {
        try {
            const images = JSON.parse(btn.dataset.images);
            if (images && images.length > 0) {
                const fancyboxImages = images.map(img => ({ src: img, type: "image", caption: "Property Image" }));
                Fancybox.show(fancyboxImages);
            }
        } catch (e) {
            console.error("Error parsing images for gallery", e);
        }
    } else {
        console.warn("Fancybox is not loaded.");
    }
}
