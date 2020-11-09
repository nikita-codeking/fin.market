$(document).ready(function(){
    $('.left_block').attr('style','width:0px !important;');
    $('.right_block').attr('style','width:100% !important;');
    var rateSwiper1 = new Swiper('.section_slider1', {
        spaceBetween: 15,
        slidesPerGroup: 4,
        slidesPerGroup: 3,
        slidesPerView: 'auto',
        watchOverflow: true,
        observer: true,
        freeMode: true,
        loop:false,
        navigation: {
            nextEl: ('.rateswiper-control.swiper-button-next'),
            prevEl: ('.rateswiper-control.swiper-button-prev'),
        },
        breakpoints: {
            480: {
                slidesPerGroup: 1,
            },
            700: {
                slidesPerGroup: 2,
            },
            965: {
                slidesPerGroup: 3,
            }
        },
    });
    var rateSwiper2 = new Swiper('.section_slider2', {
        spaceBetween: 15,
        slidesPerGroup: 4,
        slidesPerView: 'auto',
        watchOverflow: true,
        observer: true,
        freeMode: true,
        loop:false,
        navigation: {
            nextEl: ('.rateswiper-control.swiper-button-next'),
            prevEl: ('.rateswiper-control.swiper-button-prev'),
        },
        breakpoints: {
            480: {
                slidesPerGroup: 1,
            },
            700: {
                slidesPerGroup: 2,
            },
            965: {
                slidesPerGroup: 3,
            }
        },
    });
    var rateSwiper3 = new Swiper('.section_slider3', {
        spaceBetween: 15,
        slidesPerGroup: 4,
        slidesPerView: 'auto',
        watchOverflow: true,
        observer: true,
        freeMode: true,
        loop:false,
        navigation: {
            nextEl: ('.rateswiper-control.swiper-button-next'),
            prevEl: ('.rateswiper-control.swiper-button-prev'),
        },
        breakpoints: {
            480: {
                slidesPerGroup: 1,
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