<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

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
<?php if(!empty($arResult["ITEMS"])):?>
<div class="top_blocks">
    <div class="title_wrapper">
        <div class="title_block sm">Сторис</div>
        <a href="/articles/" class="itsall_href">Все &gt;&gt;&gt;</a>
    </div>
</div>
<div class="sub_container fixed_wrapper">
    <div class="row">
        <div class="news-list stories-slider swiper-container">
            <div class="swiper-wrapper">
                <?if($arParams["DISPLAY_TOP_PAGER"]):?>
                    <?=$arResult["NAV_STRING"]?><br />
                <?endif;?>
                <?foreach($arResult["ITEMS"] as $arItem):?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>

                    <li class="news-item swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <?php
                        $arFileTmp = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]['ID'], array("width" => 178, "height" => 310), BX_RESIZE_IMAGE_EXACT,true);
                        ?>
                        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                <div class="news-item_img">
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                    <img
                                            class="preview_picture"
                                            border="0"
                                            src="<?=$arFileTmp["src"]?>"
                                            width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                                            height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                                            alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                            title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                    /></a>
                            <?else:?>
                                <img
                                        class="preview_picture"
                                        border="0"
                                        src="<?=$arFileTmp["src"]?>"
                                        width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                                        height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                                        alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                                        title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                                />

                            <?endif;?>
                            </div>
                        <?endif?>
                        <?if($arItem["USER"]["ID"] != 1):?>
                            <div class="preview-user-info">
                                <?if($arItem["USER"]["PERSONAL_PHOTO"]):?>
                                    <a href="<?=$arItem["USER"]["PERSONAL_ICQ"]?>"  class="preview-user-image">
                                        <img src="<?=$arItem["USER"]["PERSONAL_PHOTO"]?>" alt="">
                                    </a>
                                <?endif?>
                                <?if($arItem["USER"]["NAME"] || $arItem["USER"]["LAST_NAME"]):?>
                                    <div class="preview-user-links">
                                        <a href="<?=$arItem["USER"]["PERSONAL_ICQ"]?>" class="preview-user-social">
                                            <?if($arItem["USER"]["NAME"]):?>
                                                <span><?=$arItem["USER"]["NAME"]?></span>
                                            <?endif?>
                                            <?if($arItem["USER"]["LAST_NAME"]):?>
                                                <span><?=$arItem["USER"]["LAST_NAME"]?></span>
                                            <?endif?>
                                        </a>
                                    </div>
                                <?endif?>
                            </div>
                        <?endif?>
                        <div class="news-item_desc" data-href="<?=$arItem["DETAIL_PAGE_URL"]?>">

                            <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
                                <span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
                            <?endif?>
                            <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                                    <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><p><b><?echo $arItem["NAME"]?></b></p></a>
                                <?else:?>
                                    <p><b><?echo $arItem["NAME"]?></b></p>
                                <?endif;?>
                            <?endif;?>
                            <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                                <div class="news_preview_text">
                                    <?echo $arItem["PREVIEW_TEXT"];?>
                                </div>
                            <?endif;?>
                            <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                                <!--<div style="clear:both"></div>-->
                            <?endif?>
                            <?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
                                <small>
                                    <?=$arProperty["NAME"]?>:&nbsp;
                                    <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
                                        <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
                                    <?else:?>
                                        <?=$arProperty["DISPLAY_VALUE"];?>
                                    <?endif?>
                                </small>
                            <?endforeach;?>
                        </div>

                    </li>

                <?endforeach;?>
                <!--<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <?=$arResult["NAV_STRING"]?>
        <?endif;?>-->
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</div>
<script>
$(function(){
    var storiesSwiper = new Swiper('.stories-slider', {
        spaceBetween: 15,
        slidesPerGroup: 8,
        slidesPerView: 'auto',
        watchOverflow: true,
        observer: true,
        freeMode: true,
        mousewheel: true,
        navigation: {
            nextEl: ('.stories-slider .swiper-button-next'),
            prevEl: ('.stories-slider .swiper-button-prev'),
        },
        breakpoints: {
            890: {
                slidesPerGroup: 1,
                freeMode: false,
            },
            1023: {
                slidesPerGroup: 6,
            },
            1160: {
                slidesPerGroup: 7,
            }
        },
    });
});
</script>
<style>
    .news-list{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: stretch;
        width: 100%;
    }
    .news-item{
        box-shadow: 0 0 0 1px #f2f2f2;
        margin: 0 0 0 0;
        position: relative;
        height: 310px;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s;
        max-width: 180px;
        font-size: 15px;
        line-height: 17px;
        border: 1px solid #e6e6e6;
        box-sizing: border-box;
    }
    .news-item:hover{
        box-shadow: 0 0 27px 0 rgba(0,0,0,.1);
        transition: all 0.3s;
    }
    .news-item_img a {
        line-height: 0;
        font-size: 0;
    }
    .news-list .preview_picture{
        width: 100%;
        height: 310px;
        object-fit: cover;
        opacity: 0.9;
        transition: all 0.3s;
    }
    .news-list .news-item:hover .preview_picture{
        opacity: 1;
        height: 105%;
        width: 105%;
        transition: all 0.3s;
    }
    .news-item_img {
        height: 310px;
        overflow: hidden;
    }

    .news-item_desc {
        padding: 10px;
        position: absolute;
        bottom: 0;
        box-sizing: border-box;
        background-image: linear-gradient(0deg, rgba(256, 256, 256, 0.8)40%, rgba(256, 256, 256, 0.6)70%,transparent 100% );
        height: fit-content;
        min-height: 110px;
        max-height: 100%;
        width: 100%;
        display: flex;
        align-items: flex-end;
        color: #222;
        cursor: pointer;
        padding-top: 30px;
    }
    .news-item_desc p{
        margin: 5px 0;
    }
    .news-item_desc b,
    .news-item_desc a {
        color: inherit;
    }
    .news_preview_text {
        display: none;
    }
    .news_list_block {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: stretch;
    }
    @media screen and (max-width: 1024px){
        .news-list .news-item:hover .preview_picture{height: 100%; width: 100%;}

    }
    @media screen and (max-width: 550px){
        .news-item{margin: 0 0px;}
        .news-item{	font-size: 12px; line-height: 15px;}

    }
</style>
<?php endif;?>