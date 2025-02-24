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
    var swiper = new Swiper('.auto-swiper-3', {
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
                slidesPerView: 3,
            }
        }
    });

    var swiper = new Swiper('.home-auto-swiper', {
        autoplay: {
            delay: 3000, // 3 seconds
            disableOnInteraction: false, // Continue autoplay after interaction
        },
        loop: true, // Loop the slides
        effect: 'slide', // Default "slide" effect for carousel behavior
        
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});

