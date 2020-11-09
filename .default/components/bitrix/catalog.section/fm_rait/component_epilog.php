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
}

global $APPLICATION;
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/owl.carousel.js");
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH.'/css/owl.carousel.css');
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH.'/css/owl.theme.default.css');
?>
<script>
    $(document).ready(function(){
        //запускаем карусель

        $('#owl_carousel_<?=$id_carousel?>').owlCarousel({
            loop:true,
            center:true,
            margin:10,
            nav:true,
            merge:true,
            pullDrag:true,
            autoWidth:false,
            mouseDrag:true,
            touchDrag:true,
            smartSpeed: 500,
            fluidSpeed: 500,
            navSpeed:500,
            dragEndSpeed: 1000,
            items:3,
            slideBy: 2,
            responsive:{
                0:{
                    items:2,
                    navSpeed:700,
                    slideBy: 1
                },
                451:{
                    items:2,
                    navSpeed:700,
                    slideBy: 2
                },
                1300:{
                    items:3,
                    navSpeed:700,
                    slideBy: 2
                },
            }
        });


    });
    $(document).ready(function() {
        $('.image_wrapper_block').hover(function(e){
            //e.preventDefault();
            $(this).children('.fast_view_block').attr('style','visibility: visible !important;');
            console.log('hover');
        }, function () {
            //e.preventDefault();
            $(this).children('.fast_view_block').removeAttr('style');
            console.log('unhover');
        });
    });
</script>
