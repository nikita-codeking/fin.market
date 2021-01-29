<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?//php see($arResult["LISTS"]["OTHER"]);?>
<div class="fast-choose-wrap">
<h3>Быстрый подбор</h3>
<div class="sections">
    <div class="swiper-container fc-sections-slider">
        <ul class="swiper-wrapper">
            <?$first = true;?>
            <?//see($arResult["SECTIONS"]);?>
            <?php foreach($arResult["SECTIONS"] as $idsec => $sec):?>
                <li class="swiper-slide fc-sections-item <?if($first):?>active<?endif;?> <?if($sec["BANNER"]>0):?>one_click_in_bank<?endif;?>" data-sect_id="<?=$idsec?>">
                    <span><?=$sec['NAME']?></span>
                </li>
                <?/*
                <div class="swiper-slide fc-sections-item <?if($first):?>active<?endif;?> <?if($sec["BANNER"]>0):?>one_click_in_bank<?endif;?>" data-sect_id="<?=$idsec?>">
                    <?$img = CFile::ResizeImageGet($sec["PICTURE"], array( "width" => 300,"height" => 300), BX_RESIZE_IMAGE_PROPORTIONAL, true );?>
                    <span ><?=$sec['NAME']?></span>
                </div>
            */?>
                <?$first=false;?>
            <?php endforeach;?>
        </ul>
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
			<?php foreach($arResult["LISTS"]["OTHER"] as $code => $vars):?>
				<?php foreach($vars as $var):?>
					<li class="swiper-slide sticker other-li">
						<span data-other_code="<?=$code?>" data-stic_id="<?=$var["ID"]?>"><?=$var["VALUE"]?></span>
					</li>
				<?php endforeach;?>
			<?php endforeach;?>
        </ul>
    </div>
    <div class="fc-all_lists swiper-button-prev"></div>
    <div class="fc-all_lists swiper-button-next"></div>
</div>

<div class="choose-result-wrap">
    <div class="swiper-container">
        <div class="swiper-wrapper" id="choose_result">

        </div>
    </div>
    <div class="fc-result swiper-button-prev"></div>
    <div class="fc-result swiper-button-next"></div>
</div>
<div class="links choose_extra_links">
    <a class="btn btn-default compar" href="javascript:void(0);">Сравнить все</a>
    <span>или</span>
    <a class="btn btn-default otp_1" href="/request_online/card">Отправить 1 заявку во все банки</a>
    <span>или</span>
    <a class="btn btn-default otp_1" href="/personalny-podbor-kredita/">Персональный подбор кредита</a>
</div>
</div>