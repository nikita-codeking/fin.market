<?
$this_url = $APPLICATION->GetCurPage();
$pos_kredcard = strpos($this_url, '/karty/kreditnye_karty/');
$pos_rassrcard = strpos($this_url, '/karty/karty_rassrochki/');
$pos_debetcard = strpos($this_url, '/karty/debetovye_karty/');
$pos_crednal = strpos($this_url, '/kredity/kredity_nalichnymi/');
$pos_zaymy = strpos($this_url, '/kredity/zaymy/');
$pos_ipoteka = strpos($this_url, '/kredity/ipoteka/');
$pos_autocred = strpos($this_url, '/kredity/avtokredity/');
$pos_refin = strpos($this_url, '/kredity/refinansirovanie/');
$pos_rko = strpos($this_url, '/dlya_biznesa/raschetnye_scheta/');
$pos_bizserv = strpos($this_url, '/dlya_biznesa/servisy/');
$pos_kasko = strpos($this_url, '/strakhovanie/kasko/');
$pos_osago = strpos($this_url, '/strakhovanie/osago/');
$pos_tourist = strpos($this_url, '/strakhovanie/strakhovanie_puteshestvennikov/');
$pos_medicine = strpos($this_url, '/strakhovanie/meditsinskoe_strakhovanie/');
$pos_imusch = strpos($this_url, '/strakhovanie/strakhovanie_imushchestva/');
$pos_ipotechstrah = strpos($this_url, '/strakhovanie/ipotechnoe_strakhovanie/');
$pos_sport = strpos($this_url, '/strakhovanie/sportivnoe_strakhovanie/');
$modclass = '';
if($pos_kredcard>0) {
    $modclass = ' wide-header-page wide-cred';
} elseif($pos_rassrcard>0) {
    $modclass = ' wide-header-page wide-rassr';
} elseif($pos_debetcard>0) {
    $modclass = ' wide-header-page wide-debet';
} elseif($pos_crednal>0) {
    $modclass = ' wide-header-page wide-cash';
} elseif($pos_zaymy>0) {
    $modclass = ' wide-header-page wide-zaymy';
} elseif($pos_ipoteka>0) {
    $modclass = ' wide-header-page wide-ipoteka';
} elseif($pos_autocred>0) {
    $modclass = ' wide-header-page wide-autocred';
} elseif($pos_refin>0) {
    $modclass = ' wide-header-page wide-refin';
}  elseif($pos_rko>0) {
    $modclass = ' wide-header-page wide-rko';
} elseif($pos_bizserv>0) {
    $modclass = ' wide-header-page wide-bizserv';
} elseif($pos_kasko>0) {
    $modclass = ' wide-header-page wide-kasko';
} elseif($pos_osago>0) {
    $modclass = ' wide-header-page wide-osago';
} elseif($pos_tourist>0) {
    $modclass = ' wide-header-page wide-tourist';
} elseif($pos_medicine>0) {
    $modclass = ' wide-header-page wide-medicine';
} elseif($pos_imusch>0) {
    $modclass = ' wide-header-page wide-imusch';
} elseif($pos_ipotechstrah>0) {
    $modclass = ' wide-header-page wide-ipotechstrah';
} elseif($pos_sport>0) {
    $modclass = ' wide-header-page wide-sport';
}

$addGeo = false;
if ($pos_kredcard>0 && $APPLICATION->GetCurPage()=="/catalog/karty/kreditnye_karty/" or
    $pos_rassrcard>0 && $APPLICATION->GetCurPage()=="/catalog/karty/karty_rassrochki/" or
    $pos_debetcard>0 && $APPLICATION->GetCurPage()=="/catalog/karty/debetovye_karty/" or
    $pos_crednal>0 && $APPLICATION->GetCurPage()=="/catalog/kredity/kredity_nalichnymi/" or
    $pos_zaymy>0 && $APPLICATION->GetCurPage()=="/catalog/kredity/zaymy/" or
    $pos_ipoteka>0 && $APPLICATION->GetCurPage()=="/catalog/kredity/ipoteka/" or
    $pos_autocred>0 && $APPLICATION->GetCurPage()=="/catalog/kredity/avtokredity/" or
    $pos_refin>0 && $APPLICATION->GetCurPage()=="/catalog/kredity/refinansirovanie/" or
    $pos_kasko>0 && $APPLICATION->GetCurPage()=="/catalog/strakhovanie/kasko/" or
    $pos_rko>0 && $APPLICATION->GetCurPage()=="/catalog/dlya_biznesa/raschetnye_scheta/" or
    $pos_rko>0 && $APPLICATION->GetCurPage()=="/catalog/dlya_biznesa/raschetnye_scheta/raschetno_kassovoe_obsluzhivanie/"
    ) {
    $addGeo = true;
}
?>
<div class="top_inner_block_wrapper maxwidth-theme<?=$modclass?>">
	<div class="page-top-wrapper grey v3">
		<section class="page-top maxwidth-theme <?CNext::ShowPageProps('TITLE_CLASS');?>">
			<div class="page-top-main">
				<?=$APPLICATION->ShowViewContent('product_share')?>
				<h1 id="pagetitle"><?$APPLICATION->ShowTitle(false)?></h1>
				<?php if($APPLICATION->GetCurDir() == "/articles/" || $APPLICATION->GetCurDir() == "/reviews/" || ($APPLICATION->GetCurDir() == "/ratings/" && empty($_GET["ELEMENT_ID"]))):?>
				<p><?=$APPLICATION->GetProperty("ПОДЗАГОЛОВОК");?></p>
				<?php endif;?>
                <script src="/local/templates/aspro_next/js/js-header-change.js"></script>
				<?if($addGeo == true):?>
                    <?php
                    /**
                     * устанавливаем фильтр основного лендинга
                     */
                    GLOBAL $arRegionLink;
                    $regions = CNextRegionality::getCurrentRegion();
                    $arRegionLink = array("PROPERTY" => Array("LINK_REGION"=> $regions['ID']));
                    ?>
                    <div class="choose_region">
                        <?$APPLICATION->IncludeComponent("aspro:regionality.list.next", "fm_popup_regions", array(
	"SEO_FLAG" => $addGeo
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
                    </div>
				<?endif;?>
                <div class="logo_product_shop">
                    <?$APPLICATION->ShowViewContent("logo_product_shop")?>
                </div>
                <div class="header_sections_wrapper">
                    <div class="header_sections_wrap swiper-container">
						<div class="stickers swiper-wrapper">
                        <?$APPLICATION->ShowViewContent("header_sections_wrapper")?>
						</div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
                <script>
                    if($('.top_inner_block_wrapper').hasClass('wide-header-page')) {
                        if ($(window).width() < 768) {
                            var tagsHeaderSwiper = new Swiper('.header_sections_wrap', {
                                slidesPerView: 'auto',
                                slidesPerColumn: 1,
                                spaceBetween: 12,
                                freeMode: true,
                                mousewheel: true,
                                navigation: {
                                    nextEl: '.header_sections_wrapper .swiper-button-next',
                                    prevEl: '.header_sections_wrapper .swiper-button-prev',
                                }
                            });
                        } else {
                            var tagsHeaderSwiper = new Swiper('.header_sections_wrap', {
                                slidesPerView: 2,
                                slidesPerColumn: 2,
                                slidesPerGroup: 2,
                                spaceBetween: 12,
                                mousewheel: true,
                                navigation: {
                                    nextEl: '.header_sections_wrapper .swiper-button-next',
                                    prevEl: '.header_sections_wrapper .swiper-button-prev',
                                },
                                breakpoints: {
                                    768: {
                                        slidesPerView: 'auto',
                                        freeMode: true,
                                        //slidesPerColumn: 1,
                                    },
                                },
                            });
                        }

                    }
                </script>
			</div>
			<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "fm_next", array(
				"START_FROM" => "0",
					"PATH" => "",
					"SITE_ID" => SITE_ID,
					"SHOW_SUBSECTIONS" => "N"
				),
				false,
				array(
				"ACTIVE_COMPONENT" => "N"
				)
			);?>

		</section>
	</div>	
</div>
