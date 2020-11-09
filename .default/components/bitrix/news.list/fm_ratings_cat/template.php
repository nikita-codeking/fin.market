<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?php if(!empty($arResult["ITEMS"])):?>
<div id="cat-blocks">
	<div class="top_blocks">
	<div class="title_wrapper">
		<div class="title_block sm">Рейтинги</div>
        <a href="/ratings/" class="itsall_href">Все &gt;&gt;&gt;</a>
	</div>
</div>
<div class="" style="position: relative">
    <div class="slider_team_new zen-colour swiper-container">
        <ul  id="" class="slider_team_new_list swiper-wrapper">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <li class="slider_team_item item_bottom swiper-slide">
                    <div class="slider_team_img">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                            <?php
                            $arFileTmp = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]['ID'], array("width" => 212, "height" => 90), BX_RESIZE_IMAGE_EXACT,true);
                            ?>
                            <div class="title_name item__gradient"><?=$arItem["NAME"]?></div>
                            <img class="" src="<?=$arFileTmp["src"]?>" alt="<?=$arItem["DETAIL_PICTURE"]["ALT"]?>">
                        </a>
                    </div>
                </li>
            <?endforeach;?>
        </ul>
    </div>
    <div class="rateswiper-control swiper-button-prev"></div>
    <div class="rateswiper-control swiper-button-next"></div>
</div>
<script>
	$(function(){
        var rateSwiper = new Swiper('.slider_team_new', {
            spaceBetween: 15,
            slidesPerGroup: 4,
            slidesPerView: 'auto',
            watchOverflow: true,
            observer: true,
            freeMode: true,
            mousewheel: true,
            navigation: {
                nextEl: ('.rateswiper-control.swiper-button-next'),
                prevEl: ('.rateswiper-control.swiper-button-prev'),
            },
            breakpoints: {
                480: {
                    slidesPerGroup: 1,
                    freeMode: false,
                },
                700: {
                    slidesPerGroup: 2,
                },
                965: {
                    slidesPerGroup: 3,
                }
            },
        });
	});
</script>
    <style>
        .slider_team_new {
    padding-top: 1px;
    width: 100% !important;
    margin-bottom: 60px;
}

.slider_team_new_list {
    margin-top: 36px;
}

.slider_team_new .owl-dots {
    margin: 24px 0 43px 0;
}

.slider_team_new .slider_team_bl {
    background: #E7F9FF;
    font-size: 12px;
    padding: 8px;
}

.slider_team_new .slider_team_bl p {
    margin-bottom: 0px;
    padding-bottom: 3px;
}

.slider_team_new .slider_team_bl span {
    font-weight: bold;
    color: #000;
    font-size: 12px;
}

.slider_team_new .owl-dots {
    display: none;
}

.slider_team_new .owl-nav {
    /*display: none;*/
}

.slider_team_new .owl-nav button.owl-prev {
    width: 25px;
    border: 1px solid gray !important;
    color: #555555 !important;
}

.slider_team_new .owl-nav button.owl-next {
    width: 25px;
    border: 1px solid gray !important;
    color: #555555 !important;
}

.slider_team_new li {
    list-style-type: none !important;
    max-width: 250px;
    padding: 0;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #cccccc;
}

.slider_team_new li:before {
    display: none !important;
}

.slider_team_new .name_sl>a {
    font-size: 14px;
    color: #fff;
    line-height: 16px;
}

.slider_team_new .name_sl {
    position: absolute;
    font-size: 14px;
    top: 0;
    padding: 8px;
    color: #fff;
    line-height: 14px;
    color: #fff;
    font-weight: 500;
    background: linear-gradient(181deg, #009bd6, transparent);
    border-radius: 10px;
    z-index: 1;
}

.button_razborka {
    width: 100%;
    height: 49px;
    background: #4DA4DC;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.47);
    display: block;
    color: #FFFFFF;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    text-decoration: none;
    font-weight: bold;
    text-align: center;
    font-size: 16px;
    line-height: 49px;
    margin-bottom: 40px;
}

.slider_team_new .slider_team_item .slider_team_img {
    overflow: hidden;
    height: auto;
    border-radius: 8px;
}

.slider_team_img a {
    display: block;
    height: 210px;
}

.slider_team_new img {
    width: 100%;
    height: 65%;
    max-height: 120px;
    object-fit: cover;
    object-position: top;
    opacity: 0.8;
    transition: all 0.3s;
}

@media screen and (min-width: 1200px) {
    .slider_team_new .slider_team_item .slider_team_img {
        max-height: 210px;
        height: 210px;
    }
}

@media screen and (min-width: 800px) and (max-width: 1200px) {
    .slider_team_new .slider_team_item .slider_team_img {
        max-height: 168px;
    }
}

.slider_team_new .title_name {
    position: absolute;
    bottom: 0;
    z-index: 2;
    padding: 30px 10px 20px;
    color: #000;
    font-weight: bold;
    line-height: 16px;
    min-height: 110px;
    height: 110px;
    border-radius: 30px 30px 8px 8px;
    -webkit-transition: all .5s;
    -o-transition: all .5s;
    transition: all .5s;
    background: #fff;
    text-align: center;
}

.slider_team_new .slider_team_item:hover img {
    transition: all 0.3s;
    /*transform: scale(1.05);*/
}

.slider_team_new .slider_team_item:hover .title_name {
    color: #6fa5f3;
}

    </style>
<?php endif;?>