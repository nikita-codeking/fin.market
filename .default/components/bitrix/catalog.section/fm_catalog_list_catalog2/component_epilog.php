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
