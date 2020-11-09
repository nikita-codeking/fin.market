$(document).ready(function(){
	/*$('#owl-carousel_8').owlCarousel({
        items: 4,
        loop:true, //Зацикливаем слайдер
        margin:20, //Отступ от элемента справа в ...px
        nav:true, //Отключение навигации
        autoplay:false, //Автозапуск слайдера
        smartSpeed:1000, //Время движения слайда
        autoplayTimeout:6000, //Время смены слайда
        responsive:{ 
			0:{
				items:3
			},
			451:{
				items:6
			},
			1300:{
				items:8
			},
        }
    });*/
    if($(window).width() > 800) {
        $('#owl-carousel_9').owlCarousel({
            loop: false,
            center: false,
            margin: 10,
            nav: true,
            merge: true,
            pullDrag: true,
            autoWidth: true,
            mouseDrag: true,
            touchDrag: true,
            smartSpeed: 500,
            fluidSpeed: 500,
            navSpeed: 500,
            dragEndSpeed: 1000,
            items: 8,
            slideBy: 3,
            startPosition:3,
            responsive: {
                0: {
                    items: 3,
                    navSpeed: 700,
                    slideBy: 3,
                },
                451: {
                    items: 5,
                    navSpeed: 700,
                    slideBy: 3,
                },
                1300: {
                    items: 8,
                    navSpeed: 700,
                    slideBy: 3,
                },
            }
        });
    }
});