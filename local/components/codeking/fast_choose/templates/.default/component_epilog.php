<script>
	$(function() {
		let section_id = 0;
		let all_lists_id = "";
		let hit_lists_id = 0;

		/**
         * первый запуск
         */
        section_id = $(".sections .fc-sections-item.active").data("sect_id");
        all_lists_id = $(".all_lists span.active").data("stic_id");
        hit_lists_id = "";
        if(section_id != 0 && all_lists_id!= ""){
            $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
        }
        /**
         * кликеры
         */
		$(".sections .fc-sections-item").on("click", function() {
			$(".sections .fc-sections-item").removeClass("active");
			$(this).addClass("active");
			section_id = $(".sections .fc-sections-item.active").data("sect_id");
			if(section_id != 0){
			    console.log(section_id);
			    $('.all_lists .swiper-wrapper').load("/ajax/fast_choose_all_lists_ajax.php?section_id="+section_id);
                //$('.hit_lists .swiper-wrapper').load("/ajax/fast_choose_hit_lists_ajax.php?section_id="+section_id);
            }

			/*if(section_id != 0 && (all_lists_id != "" || hit_lists_id != 0)){
				$("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
			}*/
		});

        $(".all-li span").on("click", function() {
            $(".all-li span").removeClass("active");
            $(".hit-li span").removeClass("active");
            $(this).addClass("active");
            section_id = $(".sections .fc-sections-item.active").data("sect_id");
            all_lists_id = $(".all_lists span.active").data("stic_id");
            hit_lists_id = "";
            $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
        });

        $(".hit-li span").on("click", function() {
            $(".all-li span").removeClass("active");
            $(".hit-li span").removeClass("active");
            $(this).addClass("active");
            section_id = $(".sections .fc-sections-item.active").data("sect_id");
            hit_lists_id = $(".all_lists span.active").data("stic_id");
            all_lists_id = "";
            $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
        });

        /**
         * Сравнить все
         * @type {Array}
         */
		let elID = [];
		$(".compar").on("click", function() {
			$("#choose_result .card-item").each(function() {
				elID.push($(this).data("el_id"));
			});
			//console.log(elID.join("|"));
			setTimeout(function () {
               			location.href = "/catalog/comparisons?products="+elID.join("|");
           		},500);
		});
        /**
         * Слайдер разделов
         * @type {Swiper}
         */
        let sectionsSwiper = new Swiper(".fc-sections-slider", {
            direction: 'horizontal',
            slidesPerView: 'auto',
            spaceBetween: 30,
            breakpoints: {
                360: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
            },
            freeMode: true,
            navigation: {
                nextEl: ('.fc-sections.swiper-button-next'),
                prevEl: ('.fc-sections.swiper-button-prev'),
            },
            watchOverflow: true,
        });
        /**
         * Слайдер свойств
         * @type {Swiper}
         */
        let allListsSwiper = new Swiper(".all_lists .swiper-container", {
            direction: 'horizontal',
            slidesPerView: 'auto',
            spaceBetween: 30,
            freeMode: true,
            navigation: {
                nextEl: ('.fc-all_lists.swiper-button-next'),
                prevEl: ('.fc-all_lists.swiper-button-prev'),
            },
            watchOverflow: true,
        });
        /**
         * Слайдер результатов
         * @type {Swiper}
         */
        let fcResultSwiper = new Swiper(".choose-result-wrap .swiper-container", {
            direction: 'horizontal',
            slidesPerView: 'auto',
            spaceBetween: 30,
            breakpoints: {
                360: {
                    slidesPerView: 1,
                    spaceBetween: 20
                }
            },
            freeMode: true,
            navigation: {
                nextEl: ('.fc-result.swiper-button-next'),
                prevEl: ('.fc-result.swiper-button-prev'),
            },
            watchOverflow: true,
            slideClass: 'card-item',
            observer: true
        });

	});
</script>