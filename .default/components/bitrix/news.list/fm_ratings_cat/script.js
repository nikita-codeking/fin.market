$(document).ready(function(){
	/*$('#owl_carousel_3').owlCarousel({
        items: 5,
        loop:true, //Зацикливаем слайдер
        margin:20, //Отступ от элемента справа в ...px
        nav:true, //Отключение навигации
        autoplay:false, //Автозапуск слайдера
        smartSpeed:1000, //Время движения слайда
        autoplayTimeout:6000, //Время смены слайда
        responsive:{ 
			0:{
				items:2
			},
			451:{
				items:3
			},
			1300:{
				items:5
			},
        }
    });*/
    if($(window).width() > 800) {
        $('#owl_carousel_3').owlCarousel({
            loop: true,
            center: true,
            margin: 10,
            nav: true,
            merge: true,
            pullDrag: true,
            autoWidth: false,
            mouseDrag: true,
            touchDrag: true,
            smartSpeed: 500,
            fluidSpeed: 500,
            navSpeed: 500,
            dragEndSpeed: 1000,
            items: 5,
            slideBy: 3,
            responsive: {
                0: {
                    items: 2,
                    navSpeed: 700,
                    slideBy: 3,
                },
                451: {
                    items: 3,
                    navSpeed: 700,
                    slideBy: 3,
                },
				800: {
                    items: 4,
                    navSpeed: 700,
                    slideBy: 3,
                },
                1200: {
                    items: 5,
                    navSpeed: 700,
                    slideBy: 3,
                },
            }
        });
    }
    /*function zenColoursOne() {
        var
            ac = new FastAverageColor(),
            items = document.querySelectorAll('.slider_team_item');

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
                    color = ac.getColor(image, isBottom ? {top: height - size, height: size} : {height: size}),
                    colorEnd = [].concat(color.value.slice(0, 3), 0).join(','),
                    colorFive = [].concat(color.value.slice(0, 3), 0.5).join(','),
                    colorSeven = [].concat(color.value.slice(0, 3), 0.7).join(',');

                item.style.background =  color.rgb;
                gradient.style.color = color.isDark ? 'white' : 'black';

                if (isBottom) {
                    gradient.style.background = 'linear-gradient( to top, ' +
                        color.rgba + ' 0%,' + color.rgba + ' 50%,rgba(' + colorSeven + ') 70%,rgba(' + colorFive + ') 100% )';
                    gradientElse.style.background = 'linear-gradient( to right, ' +
                        color.rgba + ' 0%,' + color.rgba + ' 50%,rgba(' + colorSeven + ') 70%,rgba(' + colorFive + ') 100% )';
                } else if (isTop) {
                    gradient.style.background = 'linear-gradient( to bottom, ' +
                        color.rgba + ' 0%,' + color.rgba + ' 50%,rgba(' + colorSeven + ') 70%,rgba(' + colorEnd + ') 100% )';
                }
            } else {
                item.style.color = 'black';
            }
        }
    }
    zenColoursOne();*/
});