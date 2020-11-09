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
<?php if(count($arResult["ITEMS"]) > 0):?>
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

                    <li class="news-item item_bottom swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        
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
                        <div class="news-item_desc item__gradient" data-href="<?=$arItem["DETAIL_PAGE_URL"]?>">

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
<?php endif;?>


