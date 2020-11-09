$(document).ready(function () {
    var reviewSwiper = new Swiper('.news-list-slider', {
        spaceBetween: 15,
        slidesPerGroup: 4,
        slidesPerView: 'auto',
        watchOverflow: true,
        observer: true,
        freeMode: true,
        mousewheel: true,
        navigation: {
            nextEl: ('.news-list-slider .swiper-button-next'),
            prevEl: ('.news-list-slider .swiper-button-prev'),
        },
        breakpoints: {
            890: {
                slidesPerGroup: 1,
                freeMode: false,
            },
            1023: {
                slidesPerGroup: 2,
            },
            1160: {
                slidesPerGroup: 3,
            }
        },
    });
    function zenColoursTwo() {
        var
            ac = new FastAverageColor(),
            items = document.querySelectorAll('.news-list-slider .news-item');

        for (var i = 0; i < items.length; i++) {
            var item = items[i],
                image = item.querySelector('img');
            if (image) {
                var
                    isBottom = item.classList.contains('item_bottom'),
                    isTop = item.classList.contains('item_top'),
                    gradient = item.querySelector('.item__gradient'),
                    gradientElse = item.querySelector('.item__gradient_horizontal'),
                    height = image.naturalHeight,
                    size = 50,
                    color = ac.getColor(image, isBottom ? { top: height - size, height: size } : { height: size }),
                    colorEnd = [].concat(color.value.slice(0, 3), 0).join(','),
                    colorFive = [].concat(color.value.slice(0, 3), 0.5).join(','),
                    colorSeven = [].concat(color.value.slice(0, 3), 0.1).join(',');

                item.style.background = color.rgb;
                gradient.style.color = color.isDark ? 'white' : 'black';

                if (isBottom) {
                    gradient.style.background = 'linear-gradient( to top, ' +
                        color.rgba + ' 0%,' + color.rgba + ' 50%,rgba(' + colorSeven + ') 70%,rgba(' + colorEnd + ') 100% )';
                } else if (isTop) {
                    gradient.style.background = 'linear-gradient( to bottom, ' +
                        color.rgba + ' 0%,' + color.rgba + ' 50%,rgba(' + colorSeven + ') 70%,rgba(' + colorEnd + ') 100% )';
                }
            } else {
                item.style.color = 'black';
            }
        }
    }
    zenColoursTwo();
    $('.news-list-slider img').load(function () {
        zenColoursTwo();
    })
});

