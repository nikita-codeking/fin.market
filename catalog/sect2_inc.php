<?
//#netwiz start баннеры одна заявка во все банки
$this_url = $APPLICATION->GetCurPage();

$pos_kreditnye_karty1 = strpos($this_url,'kreditnye_karty');
$pos_online_kredit1 = strpos($this_url,'kredity_nalichnymi');
$pos_online_mikrozaimy1 = strpos($this_url,'zaymy');
?>

<?php
include '/bitrix/templates/.default/components/bitrix/catalog.section/fm_catalog_list_catalog2/result_modifier.php/';

?>

<?/*if($pos_kreditnye_karty1 > 0):?>
    <a class="svgzaimi svg_second" href="/request_online/card/">
       <img src="/local/templates/aspro_next/images/banners/svg-lg/1-credcard-lg.svg" alt="">
    </a>
	<a class="svgzaimi_mob svg_second" href="/request_online/card/">
        <img src="/local/templates/aspro_next/images/banners/svg-lg/1-credcard-sm.svg" alt="">
    </a>
<?endif;?>


<?if($pos_online_kredit1 > 0):?>
    <a class="svgzaimi svg_second" href="/request_online/kredit_nalichnimy/">
        <img src="/local/templates/aspro_next/images/banners/svg-lg/1-credit-lg.svg" alt="">
    </a>
    <a class="svgzaimi_mob svg_second" href="/request_online/kredit_nalichnimy/">
        <img src="/local/templates/aspro_next/images/banners/svg-lg/1-credit-sm.svg" alt="">
    </a>
<?endif;?>

<?if($pos_online_mikrozaimy1 > 0):?>
	<a class="svgzaimi svg_second" href="/request_online/zaim/">
        <img src="/local/templates/aspro_next/images/banners/svg-lg/1-zaymy-lg.svg" alt="">
	</a>
	<a class="svgzaimi_mob svg_second" href="/request_online/zaim/">
        <img src="/local/templates/aspro_next/images/banners/svg-lg/1-zaymy-sm.svg" alt="">
	</a>
<?endif;*/?>

<?//#netwiz end баннеры одна заявка во все банки?>