<script>
	$(function() {
		let other_code = "";
		let other_id = 0;
		let section_id = 0;
		let all_lists_id = "";
		let hit_lists_id = 0;

		/**
         * первый запуск
         */
        section_id = $(".sections .fc-sections-item.active").data("sect_id");
        all_lists_id = $(".all_lists span.active").data("stic_id");
		//hit_lists_id = "";
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
                if($(this).hasClass('one_click_in_bank'))
                {
                    $('.choose_extra_links span').attr('style','display: inline-block;');
                    $('.choose_extra_links .otp_1').attr('style','display: inline-block;');
                }
                else if(section_id == 327 || section_id == 326 || section_id == 335){
                    $('.choose_extra_links span').attr('style','display: none;');
                    $('.choose_extra_links .pers_podbor').attr('style','display: none;');
                }
                else if(section_id != 327 || section_id != 326 || section_id != 335){
                    $('.choose_extra_links span').attr('style','display: inline-block;');
                    $('.choose_extra_links .pers_podbor').attr('style','display: inline-block;');
                }
                else{
                    $('.choose_extra_links span').attr('style','display: none;');
                    $('.choose_extra_links .otp_1').attr('style','display: none;');
                }
            }
        });

        $(".all-li span").on("click", function() {
            $(".all-li span").removeClass("active");
            $(".hit-li span").removeClass("active");
			$(".other-li span").removeClass("active");
            $(this).addClass("active");
            section_id = $(".sections .fc-sections-item.active").data("sect_id");
            all_lists_id = $(".all_lists span.active").data("stic_id");
            hit_lists_id = 0;
            $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id);
        });

        $(".hit-li span").on("click", function() {
            $(".all-li span").removeClass("active");
            $(".hit-li span").removeClass("active");
			$(".other-li span").removeClass("active");
            $(this).addClass("active");
            section_id = $(".sections .fc-sections-item.active").data("sect_id");
            hit_lists_id = $(".all_lists span.active").data("stic_id");
            $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&hit_lists_id="+hit_lists_id);
        });
		$(".other-li span").on("click", function(){
			section_id = $(".sections .fc-sections-item.active").data("sect_id");
			hit_lists_id = 0;
			all_lists_id = "";
			$(".all-li span").removeClass("active");
			$(".hit-li span").removeClass("active");
			$(".other-li span").removeClass("active");
            $(this).addClass("active");
			other_code = $(".other-li span.active").data("other_code");
			other_id = $(".other-li span.active").data("stic_id");
			$("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&other_code="+other_code+"&other_id="+ other_id);
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
            spaceBetween: 10,
            slidesPerGroup: 4,
            mousewheel: true,
            breakpoints: {
                360: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    slidesPerGroup: 1,
                },
                860: {
                    slidesPerGroup: 2,
                },
                1199: {
                    slidesPerGroup: 3,
                }
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
            spaceBetween: 10,
            slidesPerGroup: 3,
            freeMode: true,
            mousewheel: true,
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
            spaceBetween: 10,
            slidesPerGroup: 4,
            mousewheel: true,
            breakpoints: {
                360: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                480: {
                    slidesPerGroup: 1,
                },
                700: {
                    slidesPerGroup: 2,
                },
                980: {
                    slidesPerGroup: 3,
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