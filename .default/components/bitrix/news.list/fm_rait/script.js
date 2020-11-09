$(document).ready(function () {
    var rateSwiper = new Swiper('.slider_team_new', {
        spaceBetween: 15,
        slidesPerGroup: 4,
        slidesPerView: 'auto',
        watchOverflow: true,
        observer: true,
        freeMode: true,
        mousewheel: true,
        navigation: {
            nextEl: ('.rateswiper-control.swiper-button-next'),
            prevEl: ('.rateswiper-control.swiper-button-prev'),
        },
        breakpoints: {
            480: {
                slidesPerGroup: 1,
                freeMode: false,
            },
            700: {
                slidesPerGroup: 2,
            },
            965: {
                slidesPerGroup: 3,
            }
        },
    });
});