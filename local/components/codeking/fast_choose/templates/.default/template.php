<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?//php see($arResult);?>
<h3>Быстрый подбор</h3>
<div class="sections">
    <div class="swiper-container fc-sections-slider">
        <div class="swiper-wrapper">
            <?$first = true;?>
            <?php foreach($arResult["SECTIONS"] as $idsec => $sec):?>
                <div class="swiper-slide fc-sections-item <?if($first):?>active"<?endif;?>" data-sect_id ="<?=$idsec?>">
                    <?$img = CFile::ResizeImageGet($sec["PICTURE"], array( "width" => 300,"height" => 300), BX_RESIZE_IMAGE_PROPORTIONAL, true );?>
                    <img src="<?=$img['src'];?>" alt="<?=$sec['NAME']?>">
                </div>
                <?$first=false;?>
            <?php endforeach;?>
        </div>
        <div class="fc-sections swiper-button-prev"></div>
        <div class="fc-sections swiper-button-next"></div>
    </div>
</div>
<div class="all_lists">
    <div class="swiper-container">
        <ul class="swiper-wrapper">
            <?$first = true;?>
            <?php foreach($arResult["LISTS"]["ALL"] as $idstic => $stic):?>
                <li class="swiper-slide sticker all-li">
                    <span data-stic_id="<?=$idstic?>" <?if($first):?>class="active"<?endif;?>><?=$stic?></span>
                </li>
                <?$first=false;?>
            <?php endforeach;?>
            <?php foreach($arResult["LISTS"]["HIT"] as $idstic => $stic):?>
                <li class="swiper-slide sticker hit-li">
                    <span data-stic_id="<?=$idstic?>"><?=$stic?></span>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="fc-all_lists swiper-button-prev"></div>
    <div class="fc-all_lists swiper-button-next"></div>
</div>
<div class="links">
	<a class="btn btn-default compar" href="javascript:void(0);">Сравнить все</a>
	<span>или</span>
	<a class="btn btn-default" href="/request_online/card">Отправить 1 заявку во все банки</a>
</div>
<div class="choose-result-wrap">
    <div class="swiper-container">
        <div class="swiper-wrapper" id="choose_result">

        </div>
    </div>
    <div class="fc-result swiper-button-prev"></div>
    <div class="fc-result swiper-button-next"></div>
</div>