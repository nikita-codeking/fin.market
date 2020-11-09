<?
// #netwiz start - баннеры сравни в каталоге
$this_url = $APPLICATION->GetCurPage();
$pos_zaymov = strpos($this_url, 'zaymy');
$pos_credits = strpos($this_url, 'kredity_nalichnymi');
/* $pos_osago = strpos($this_url,'osago'); */
$pos_ipoteka = strpos($this_url,'ipoteka');
$pos_debetovye_karty = strpos($this_url,'debetovye_karty');
$pos_kreditnye_karty = strpos($this_url,'kreditnye_karty');
$pos_karty_rassrochki = strpos($this_url,'karty_rassrochki');
$pos_avtokredity = strpos($this_url,'avtokredity');
$pos_refinansirovanie = strpos($this_url,'refinansirovanie');
$pos_rko = strpos($this_url,'raschetnye_scheta!!!!!');
?>


<?php
include '/bitrix/templates/.default/components/bitrix/catalog.section/fm_catalog_list_catalog2/result_modifier.php/';
$bannersDesktop = $arResult['BANNERS_COMPRESION']['DETAIL_TEXT'];
?>
<?if($pos_zaymov>0):?>
	<a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/zaymy-lg.svg" alt="">-->
	</a>
	<a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/zaymy-sm.svg" alt="">-->
	</a>
<?endif;?>

<?if($pos_credits>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/credit-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/credit-sm.svg" alt="">-->
    </a>
<?endif;?>

<?if($pos_osago>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <img src="/local/templates/aspro_next/images/banners/svg-lg/osago-lg.svg" alt="">
    </a>
<?endif;?>

<?if($pos_ipoteka>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/ipoteka-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/ipoteka-sm.svg" alt="">-->
    </a>
<?endif;?>

<?if($pos_debetovye_karty>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/debet-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/debet-sm.svg" alt="">-->
    </a>
<?endif;?>

<?if($pos_kreditnye_karty>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/credcard-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/credcard-sm.svg" alt="">-->
    </a>
<?endif;?>

<?if($pos_karty_rassrochki>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/rassrochka-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/rassrochka-sm.svg" alt="">-->
    </a>
<?endif;?>

<?if($pos_avtokredity>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!-- <img src="/local/templates/aspro_next/images/banners/svg-lg/avtokred-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/avtokred-sm.svg" alt="">-->
    </a>
<?endif;?>

<?if($pos_refinansirovanie>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/refinans-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/refinans-sm.svg" alt="">-->
    </a>
<?endif;?>

<?if($pos_rko>0):?>
    <a href="/catalog/comparisons/" class="svgzaimi svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_DESC');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/rko-lg.svg" alt="">-->
    </a>
    <a href="/catalog/comparisons/" class="svgzaimi_mob svg_first">
        <?$APPLICATION->ShowViewContent('BANNERS_SRAVNI_MOBILE');?>
        <!--<img src="/local/templates/aspro_next/images/banners/svg-lg/rko-sm.svg" alt="">-->
    </a>
<?endif;?>
<?// #netwiz end - баннеры сравни в каталоге?>


