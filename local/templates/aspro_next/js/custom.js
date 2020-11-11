/**
 * отследить попап на мобильном телефоне и вынести из спрятанного дива
 */
var intervalIderror_fly = newBlock();

function newBlock(){
    return setInterval(function (){
        let widthBraus = $(window).width();
        if(widthBraus <= 400){
            if(!$(".error_fly").hasClass('fly_mobile')){
                $(".error_fly").appendTo(".inline-search-block").addClass('fly_mobile');
            }
        };
    }, 1000);
};
$(window).resize(function() {
    clearInterval(intervalIderror_fly);
    intervalIderror_fly = newBlock();
});
/**
 * попап по кнопке оформить
 */
$(document).ready(function() {
    $(".compare_count.small").mousemove(function (eventObject) {
        var thisOb = null;
        var thisY  = eventObject.pageY;
        var raz    = 10000;
        $(".compare_count.small").children('#compare_fly').children().each(function () {
            tempOb = $(this);
            tempY = tempOb.offset().top
            if(Math.abs(tempY-thisY)<raz){
                raz = Math.abs(tempY-thisY);
                thisOb = tempOb;
            }
        });
    }).mouseout(function () {
        $("#tooltip").hide()
            .html("")
            .css({
                "top": 0,
                "right": 0
            });
    });

    /* сворачивающийся текст - начало */
    $('.elastic_block_button').click(function(){
        event.preventDefault();
        /* var tH = getTotalHeigh($(this).parent().prev(".elastic_block")); */
        if($(this).parent().prev(".elastic_block").hasClass("off")){
            var animSpeed = 2000;
            if($(this).parent().prev(".elastic_block").hasClass('props_list_wrapp')) {
                animSpeed = 600;
            }
            var tH = getTotalHeigh($(this).parent().prev(".elastic_block.off"));
            $(this).parent().prev(".elastic_block").removeClass('off').animate({'height': tH,}, animSpeed);
            $(this).parent().prev(".elastic_block").find(".gradient").hide();
            $(this).addClass('on');
            $(this).prev().slideUp('.elastic_text');

        }else{
            var blockH = 200;
            var animSpeed = 1500;
            if($(this).parent().prev(".elastic_block").hasClass('props_list_wrapp')) {
                blockH = 20;
                animSpeed = 600;
            }
            $(this).parent().prev(".elastic_block").addClass('off').animate({ 'height': blockH}, animSpeed);
            $(this).parent().prev(".elastic_block").find(".gradient").show();
            $(this).removeClass('on');
            $(this).prev().slideDown('.elastic_text');
        }
    });
    function getTotalHeigh(obj)
    {
        var totalHeight = 0;
        var totalHeight_1 = 0;
        var totalHeight_2 = 0;
        obj.children().each(function(){
            totalHeight_1 += $(this).outerHeight(true);
            totalHeight_2 += $(this).height();
            /* totalHeight = totalHeight_1 ; */
            totalHeight = totalHeight_2 + ((totalHeight_1 - totalHeight_2)/1.3) ;
        });
        return totalHeight;
    }
    /* сворачивающийся текст - конец */

    $('#footer .footer_inner .is_parent').click(function (e) {
        if($(window).width()<767){
            clickParent = $(this).children().children().html();
            $('#footer .footer_inner .is_child').removeAttr('style');
            if(clickParent=="Рейтинги" || clickParent=="Сторис" || clickParent=="Обзоры"){

            }else{
                e.preventDefault();
                //console.log('1 - ' + clickParent);
                startVis = false;
                $('#footer .column_bottom_menu.column_menu_1 .item_block').each(function () {
                    thisElement = $(this).children().children().html();

                    if(startVis){
                        //console.log($(this).hasClass('is_child'));
                        if($(this).hasClass('is_child')){
                            //console.log($(this).css('display'));
                            if($(this).css('display')=="block"){
                                $(this).removeAttr('style');
                            }else{
                                $(this).attr('style','display:block;');
                            }
                        }else{
                            startVis = false;
                        }
                    }

                    if(thisElement==clickParent){
                        startVis = true;
                    }

                });
            }
        }
    });
    var hoverEl = null;
    if($(window).width()>=767) {
        $('#footer .colum_menu_footer').hover(
            function () {
                if ($(this) != hoverEl) {
                    hoverEl = $(this);
                    //countEl = 0;
                    hoverEl.children().each(function () {
                        $(this).removeAttr("style");
                        //countEl++;
                    });
                    /*countEl = countEl - 3;
                    if(countEl>0){
                        hoverEl.attr('style','margin-top:-' + countEl*18 + 'px;');
                    }*/
                    //console.log('Новая колонка');
                }
            },
            function () {
                el = 0;
                hoverEl.children().each(function () {
                    el++;
                    if (el >= 5) {
                        $(this).attr("style", "display:block;");
                    }
                });
                //hoverEl.removeAttr("style");
            }
        );
    }

    //фикс заголовка на страницах с виджетом wl
    function headerHider() {
        var hideHeader = false;
        if ($('.ajax_load.list .wl-widget').length > 0) {
            hideHeader = true;
        }
        if (hideHeader) {
            $('#pagetitle').addClass('visually-hidden');
        }
        else {
            $('#pagetitle').removeClass('visually-hidden');
        }
    }
    //headerHider();
    
    //перенос баннеров вниз на страницах с касттомной шапкой
    function moveBanner() {
        var svgFirst = $('.svg_first').detach();
        var ww = $(window).width();
        $('.display_list.show_un_props').prepend(svgFirst);
        if(ww > 500) {
            $('.svgzaimi_mob').css('display', 'none');
            $('.svgzaimi').css('display', 'block');
        }
        else {
            $('.svgzaimi').css('display', 'none');
            $('.svgzaimi_mob').css('display', 'block');
        }
    }
    moveBanner();
    $(window).on('resize', function () {
        moveBanner();
    });
    if($("div").is(".catalog_detail")) {
        $('.wide-header-page').removeClass('wide-header-page');
    }
    if($("div").is(".wide-header-page")) {
        //$('#header').addClass('wide-header');
        //$('#mobileheader').addClass('wide-mob');
        //$('#header .logo img').attr('src', '/local/templates/aspro_next/images/flogo_wite.svg');
        //$('#mobileheader .logo img').attr('src', '/local/templates/aspro_next/images/flogo_wite.svg');
    }

    
    //#netwiz start плашка с тегами для мобильных
    function tagPosition() {
        var ww = $(window).width();
        if(ww <= 550) {
            $('.description_wrapp .stickers').each(function( i ) {
                var targetPosition = $(this).parents('.description_wrapp');
                var tagLine = $(this).detach();
                tagLine.insertAfter(targetPosition).wrap('<div class="stickers_wrapp"></div>').show();
            });
        }
        else {
            $('.stickers_wrapp .stickers').each(function( i ) {
                var tagWrapper = $(this).parents('.stickers_wrapp');
                var targetPosition = tagWrapper.siblings('.description_wrapp').children('.description');
                var tagLine = $(this).detach();
                tagWrapper.remove();
                tagLine.appendTo(targetPosition);
            });
        }
    }
    //tagPosition();
    $(window).on('resize', function () {
        //tagPosition();
    });
    //#netwiz end плашка с тегами для мобильных

//#netwiz start перстроить теги сторис для мобильных
    if($(window).width() <= 768) {
        $('.blog-sidebar .search-tags-cloud .tags a').each(function ( i ) {
            $(this).addClass('first-wrap');
        });
        $('.first-wrap').wrapAll('<div />');
    }
//#netwiz end перстроить теги сторис для мобильных
});



