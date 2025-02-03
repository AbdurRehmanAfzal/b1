document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.auto-swiper', {
        slidesPerView: 1,  
        spaceBetween: 30,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false, 
        },
        pagination: {
            el: '.auto-swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: { 
                slidesPerView: 2,
            },
            1024: { 
                slidesPerView: 4,
            }
        }
    });
});