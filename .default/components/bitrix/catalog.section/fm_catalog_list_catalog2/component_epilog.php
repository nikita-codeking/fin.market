<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])){
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency){?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
	<?}
}?>
<?
$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK'], 'ID'=>$arResult['ID']);
$arSelect = Array('ID','PICTURE');
$db_list = CIBlockSection::GetList(Array('ID'=>'DESC'), $arFilter, true, $arSelect);
while($ar_result = $db_list->GetNext())
{
    $APPLICATION->AddHeadString('<meta property="og:image" content="https://'.SITE_SERVER_NAME.CFile::GetPath($ar_result['PICTURE']).'"/>');
}

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/owl.carousel.js");
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH.'/css/owl.carousel.css');
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH.'/css/owl.theme.default.css');
$is_main = $APPLICATION->GetCurPage(false)==SITE_DIR;
?>
<script>
$(function(){
	//console.log("Web:"+window.location);
	var lazy_flag        = false;
	/**
     * установим шаг
    */
	if($('.lastScrollToElem').text()=='no')
    {
        $('.lastScrollToElem').text($('.ajax_load.list').height() * 0.6);
    }


    var timerAjax = null;

    /*setInterval(function () {
        if(stepAjax>=3){
            $('.bottom_nav .ajax_load_btn').attr('style','display:block;');
        }
    },1000);*/
	$(window).scroll(function(){
            var topCatalog       = $('.ajax_load.list').offset().top;
            var stepAjax         = +$('.stepAjax').text();
            var thisPage = null;
            $('.bottom_nav.list .cur').each(function () {
                thisPage = +$(this).text();
            });
            var lastScrollToElem = +$('.lastScrollToElem').text();

            let scrollToElem = topCatalog + stepAjax*lastScrollToElem;
            let winScrollTop = $(this).scrollTop() + $(window).height();

            //console.log('winScrollTop - ' + winScrollTop + ' scrollToElem - ' + scrollToElem +  ' stepAjax - ' + stepAjax + ' thisPage - ' + thisPage);
            //Ленивая подгрузка слайдеров

            if(stepAjax>=3){
                $('.bottom_nav .ajax_load_btn').attr('style','display:block;');
            }

            if(winScrollTop > scrollToElem && stepAjax==thisPage){
                //console.log('2 - winScrollTop - ' + winScrollTop + ' scrollToElem - ' + scrollToElem);
                var bAj = null;
                $('.bottom_nav.list .ajax_load_btn').each(function () {
                    bAj = $(this);
                });

                if(bAj==null || stepAjax>=2)
                {
                    if(lazy_flag == false)
                    {
                        $('.bottom_nav .ajax_load_btn').attr('style','display:block;');
                        lazy_flag = true;
                        let laz_id = $('#temp_slide').data('sect_id');
                        $('#temp_slide').load('/ajax/temp_slide.php?lazy_id=' + laz_id);
                    }
                    stepAjax = stepAjax + 1;
                    $('.stepAjax').text(stepAjax);
                }else{
                    bAj.click();
                    stepAjax = stepAjax + 1;
                    $('.stepAjax').text(stepAjax);
                }
            }
	});
	/*$(".list_item_wrapp.item").each(function(){
		$(this).attr("scroll_top", $(this).offset().top);
	});*/
});
</script>
<div class="popap_ofo" style="display: none;">
    <label class="popap_ofo-closer" id="popap_ofo-closer">&#215;</label>
    <div></div>
</div>
<div style="position: absolute;" class="basket_animation" >
    <img style="width:119px; height:75px;" src="/local/templates/aspro_next/images/basket_fly.png">
</div>
<script>
//Полет сравнить
$(document).ready(function(){
    //console.log(11111111111);
    $('.like_icons').click(function () {
        var imgProduct = $(this).parent().children('.thumb').children().attr("src");
        if(document.location.href.search("/?oid") > 0){
            imgProduct = $(this).parent().parent().children('.item_slider').children('.slides').children('.offers_img').children('.popup_link').children('img').attr("src");
        }else if(document.location.href.search("/offers/") > 0) {
            imgProduct = $(this).parent().children('.thumb').children().attr("src");
        }else if(document.location.href.search("/catalog/") > 0) {
            imgProduct = $(this).parent().parent().parent().children('.image_block').children('.image_wrapper_block').children('.thumb').children().attr("src");
        }
        flyBacket($(this).offset()['top'],$(this).offset()['left'],imgProduct);
    });

});
function flyBacket(cTop,cLeft,src) {
    <?if(!$is_main):?>
    if(document.location.href.search("/offers/") > 0) {
    }else{
        if (document.documentElement.clientWidth > 991) {
            if(!$('#headerfixed').hasClass('fixed')){
                $('#headerfixed').addClass('fixed');
            }
            $('.basket_animation>img').attr("src", src);
            $('.basket_animation').css({'top': cTop - 50 + "px", 'left': cLeft - 50 + "px"});
            $('.basket_animation').clone()
                .css({
                    'position': 'absolute',
                    'display': 'block',
                    'z-index': '11100',
                    'top': cTop - 50,
                    'left': cLeft - 50
                })
                .appendTo("body")
                .animate({
                    opacity: 0.2,
                    left: $("#headerfixed .svg-inline-comparison").offset()['left'],
                    top: $("#headerfixed .svg-inline-comparison").offset()['top'],
                    width: 100
                }, 1000, function () {
                    $(this).remove();

                });
        }
        else{
            if(!$('#headerfixed').hasClass('fixed')){
                $('#headerfixed').addClass('fixed');
            }
            $('.basket_animation>img').attr("src", src);
            $('.basket_animation').css({'top': cTop - 50 + "px", 'left': cLeft - 50 + "px"});
            $('.basket_animation').clone()
                .css({
                    'position': 'absolute',
                    'display': 'block',
                    'z-index': '11100',
                    'top': cTop - 50,
                    'left': cLeft - 50
                })
                .appendTo("body")
                .animate({
                    opacity: 0.2,
                    left: $("#mobileheader .svg-inline-comparison").offset()['left'],
                    top: $("#mobileheader .svg-inline-comparison").offset()['top'],
                    width: 100
                }, 1000, function () {
                    $(this).remove();

                });
        }
    }
    <?endif;?>
}
</script>
