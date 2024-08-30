import { Swiper } from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    slidesPerView: 1,
    allowTouchMove: true,
    modules: [Navigation, Pagination, Autoplay],
    pagination: {
        el: '.swiper-pagination',
    },
    spaceBetween: 20,

    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },

    breakpoints: {
        // when window width is >= 320px
        320: {
            navigation: {
                enabled: false,
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        },

        // when window width is >= 1024px
        1024: {
            navigation: {
                enabled: true,
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        }
      }
});
