<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if( count( $arResult["ITEMS"] ) >= 1 ){?>
    <?
    $currencyList = '';
    if (!empty($arResult['CURRENCIES'])){
        $templateLibrary[] = 'currency';
        $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
    }
    $templateData = array(
        'TEMPLATE_LIBRARY' => $templateLibrary,
        'CURRENCIES' => $currencyList
    );
    unset($currencyList, $templateLibrary);
    ?>
	
    <div class="link_wrap">
		<!--<a class="srv_all btn btn-default" href="javascript:void(0);"><?=GetMessage('SRV_ALL');?></a>
		<span>или</span>-->
		<a class="btn btn-default equest_online" href="/request_online/card">Отправить 1 заявку во все банки</a>
	</div>
	
    <?$id_carousel = str_replace(":","_",date("H:i:s"));?>
    <div class="top_wrapper items_wrapper">
        <div class="fast_view_params" data-params="<?=urlencode(serialize($arTransferParams));?>"></div>
        <div id="owl_carousel_<?=$id_carousel?>" class="catalog_block items row margin0 ajax_load block owl-carousel owl-theme">

            <?
            $arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);

            // params for catalog elements compact view
            $arParamsCE_CMP = $arParams;
            $arParamsCE_CMP['TYPE_SKU'] = 'N';
            ?>
            <?$count_for_mobile = 0;?>
            <?foreach($arResult["ITEMS"] as $arItem){?>
                <?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

                $totalCount = CNext::GetTotalCount($arItem, $arParams);
                $arQuantityData = CNext::GetQuantityArray($totalCount, array(), "N", $arItem["PRODUCT"]["TYPE"]);

                $item_id = $arItem["ID"];
                $strMeasure = '';

                $arItem["strMainID"] = $this->GetEditAreaId($arItem['ID'])."_".$arParams["FILTER_HIT_PROP"];
                $arItemIDs=CNext::GetItemsIDs($arItem);

                if($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]){
                    if(isset($arItem["ITEM_MEASURE"]) && (is_array($arItem["ITEM_MEASURE"]) && $arItem["ITEM_MEASURE"]["TITLE"]))
                    {
                        $strMeasure = $arItem["ITEM_MEASURE"]["TITLE"];
                    }
                    else
                    {
                        $arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
                        $strMeasure = $arMeasure["SYMBOL_RUS"];
                    }
                }
                $bUseSkuProps = ($arItem["OFFERS"] && !empty($arItem['OFFERS_PROP']));

                $elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

                if($bUseSkuProps)
                {
                    if(!$arItem["OFFERS"])
                    {
                        $arAddToBasketData = CNext::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false,  $arItemIDs["ALL_ITEM_IDS"], 'small', $arParams);
                    }
                    elseif($arItem["OFFERS"])
                    {

                        $strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
                        $totalCount = CNext::GetTotalCount($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $arParams);
                        $arQuantityData = CNext::GetQuantityArray($totalCount, $arItemIDs["ALL_ITEM_IDS"], "N", $arItem["PRODUCT"]["TYPE"]);

                        $currentSKUIBlock = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"];
                        $currentSKUID = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"];

                        $arItem["DETAIL_PAGE_URL"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DETAIL_PAGE_URL"];
                        if($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"])
                            $arItem["PREVIEW_PICTURE"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"];
                        if($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"])
                            $arItem["DETAIL_PICTURE"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DETAIL_PICTURE"];

                        if($arParams["SET_SKU_TITLE"] === "Y"){
                            $skuName = ((isset($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['NAME']);
                            $arItem["NAME"] = $elementName = $skuName;
                        }

                        $item_id = $currentSKUID;

                        // ARTICLE
                        if($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"])
                        {
                            $arItem["ARTICLE"]["NAME"] = $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["NAME"];
                            $arItem["ARTICLE"]["VALUE"] = (is_array($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) ? reset($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) : $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]);
                        }

                        $arCurrentSKU = $arItem["JS_OFFERS"][$arItem["OFFERS_SELECTED"]];
                        $strMeasure = $arCurrentSKU["MEASURE"];
                    }
                }
                else
                {
                    $arAddToBasketData = CNext::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, array(), 'small', $arParams);
                }
                switch ($arParams["LINE_ELEMENT_COUNT"]){
                    case '2':
                        $col=6;
                        break;
                    case '4':
                        $col=3;
                        break;
                    default:
                        $col=4;
                        break;
                }
                ?>
                <?/*<div class="catalog_item_wrapp col-m-20 col-lg-<?=$col;?> col-md-4 col-sm-<?=floor(12 / round($arParams['LINE_ELEMENT_COUNT'] / 2))?> item item_block <?if($count_for_mobile>=4):?>disable_mobile<?endif;?>" data-col="<?=$col;?>">*/?>
                <?/*ниже изменена одна строка*/?>

                <div id="<?=$arItem['IBLOCK_SECTION_ID']?>" class="catalog_item_wrapp col-m-12 col-lg-<?=$col;?> col-md-4 col-sm-<?=floor(12 / round($arParams['LINE_ELEMENT_COUNT'] / 2))?> item item_block <?if($count_for_mobile>=4):?>disable_mobile<?endif;?>" data-col="<?=$col;?>">

                    <div class="basket_props_block" id="bx_basket_div_<?=$arItem["ID"];?>_<?=$arParams["FILTER_HIT_PROP"]?>" style="display: none;">
                        <?if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])){
                            foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo){?>
                                <input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
                                <?if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
                                    unset($arItem['PRODUCT_PROPERTIES'][$propID]);
                            }
                        }
                        $arItem["EMPTY_PROPS_JS"]="Y";
                        $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
                        if (!$emptyProductProperties){
                            $arItem["EMPTY_PROPS_JS"]="N";?>
                            <div class="wrapper">
                                <table>
                                    <?foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo){?>
                                        <tr>
                                            <td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
                                            <td>
                                                <?if('L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']	&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']){
                                                    foreach($propInfo['VALUES'] as $valueID => $value){?>
                                                        <label>
                                                            <input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
                                                        </label>
                                                    <?}
                                                }else{?>
                                                    <select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
                                                        foreach($propInfo['VALUES'] as $valueID => $value){?>
                                                            <option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
                                                        <?}?>
                                                    </select>
                                                <?}?>
                                            </td>
                                        </tr>
                                    <?}?>
                                </table>
                            </div>
                            <?
                        }?>
                    </div>

                    <div class="catalog_item item_wrap main_item_wrapper" id="<?=$this->GetEditAreaId($arItem['ID']);?>_<?=$arParams["FILTER_HIT_PROP"]?>">
                        <div class="inner_wrap">
                            <div class="image_wrapper_block">
                                <?if($arParams["DISPLAY_WISH_BUTTONS"] != "N" || $arParams["DISPLAY_COMPARE"] == "Y"):?>
                                    <div class="like_icons">
                                        <?if($arParams["DISPLAY_WISH_BUTTONS"] == "Y"):?>
                                            <?if(!$arItem["OFFERS"]):?>
                                                <div class="wish_item_button" <?=(CNext::checkShowDelay($arParams, $totalCount, $arItem) ? '' : 'style="display:none"');?>>
                                                    <span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item to" data-item="<?=$arItem["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>"><i></i></span>
                                                    <span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item in added" style="display: none;" data-item="<?=$arItem["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>"><i></i></span>
                                                </div>
                                            <?elseif($bUseSkuProps):?>
                                                <div class="wish_item_button ce_cmp_hidden">
                                                    <span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item to <?=$arParams["TYPE_SKU"];?>" data-item="<?=$currentSKUID;?>" data-iblock="<?=$currentSKUIBlock?>" data-offers="Y" data-props="<?=$arOfferProps?>"><i></i></span>
                                                    <span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-item="<?=$currentSKUID;?>" data-iblock="<?=$currentSKUIBlock?>"><i></i></span>
                                                </div>
                                            <?endif;?>
                                        <?endif;?>
                                        <?if($arParams["DISPLAY_COMPARE"] == "Y"):?>
                                            <?if(!$bUseSkuProps):?>
                                                <div class="compare_item_button">
                                                    <span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>" ><i></i></span>
                                                    <span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>"><i></i></span>
                                                </div>
                                            <?elseif($arItem["OFFERS"]):?>
                                                <div class="compare_item_button ce_cmp_hidden">
                                                    <span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to <?=$arParams["TYPE_SKU"];?>" data-item="<?=$currentSKUID;?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>" ><i></i></span>
                                                    <span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-item="<?=$currentSKUID;?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>"><i></i></span>
                                                </div>
                                                <div class="compare_item_button ce_cmp_visible">
                                                    <span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>" ><i></i></span>
                                                    <span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>"><i></i></span>
                                                </div>
                                            <?endif;?>
                                        <?endif;?>
                                    </div>
                                <?endif;?>


                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb shine">
                                    <?
                                    if($arParams["SET_SKU_TITLE"] === "Y" && $arItem['OFFERS']){
                                        $a_alt = ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"] && strlen($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] ? $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $skuName ));
                                        $a_title = ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"] && strlen($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] ? $arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $skuName ));
                                    }
                                    else{
                                        $a_alt = ($arItem["PREVIEW_PICTURE"] && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arItem["NAME"] ));
                                        $a_title = ($arItem["PREVIEW_PICTURE"] && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arItem["NAME"] ));
                                    }
                                    ?>
                                    <?	/*ниже исходный код в комментах*/?>
                                    <?/*
								<?if(!empty($arItem["PREVIEW_PICTURE"]) ):?>
									<img class="noborder" src="<?=$img["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
								<?elseif( !empty($arItem["DETAIL_PICTURE"])):?>
									<?$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array( "width" => 300, "height" => 300 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
									<img class="noborder" src="<?=$img["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
								<?else:?>
								*/?>
                                    <?if(!empty($arItem["DETAIL_PICTURE"]) ):?>
                                        <?$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array( "width" => 300, "height" => 300 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
                                        <img class="noborder" src="<?=$img["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                    <?elseif( !empty($arItem["PREVIEW_PICTURE"])):?>
                                        <img class="noborder" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                    <?else:?>
                                        <img class="noborder" src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_medium.png" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                    <?endif;?>
                                    <?if($fast_view_text_tmp = CNext::GetFrontParametrValue('EXPRESSION_FOR_FAST_VIEW'))
                                        $fast_view_text = $fast_view_text_tmp;
                                    else
                                        $fast_view_text = GetMessage('FAST_VIEW');?>
                                </a>
                                <div class="stickers 1">
                                    <?$prop = ($arParams["STIKERS_PROP"] ? $arParams["STIKERS_PROP"] : "HIT");?>
                                    <?foreach(CNext::GetItemStickers($arItem["PROPERTIES"][$prop]) as $arSticker):?>
                                        <div><div class="<?=$arSticker['CLASS']?>"><?=$arSticker['VALUE']?></div></div>
                                    <?endforeach;?>
                                    <?if($arParams["SALE_STIKER"] && $arItem["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"]){?>
                                        <div><div class="sticker_sale_text"><?=$arItem["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"];?></div></div>
                                    <?}?>
                                </div>
                                <div class="fast_view_block_href <?=$arItem["ID"];?>" onclick="fast_view_on(this);"></div>
                                <div class="fast_view_block <?=$arItem["ID"];?>" data-event="jqm" data-param-form_id="fast_view" data-param-iblock_id="<?=$arParams["IBLOCK_ID"];?>" data-param-id="<?=$arItem["ID"];?>" data-param-item_href="<?=urlencode($arItem["DETAIL_PAGE_URL"]);?>" data-name="fast_view" ><?=$fast_view_text;?></div>
                            </div>
                            <div class="item_info <?=$arParams["TYPE_SKU"]?>">
                                <div class="item-title">
                                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="dark_link"><span><?=$elementName;?></span></a>
                                </div>
                                <?if($arParams["SHOW_RATING"] == "Y"):?>
                                    <div class="rating">
                                        <?$APPLICATION->IncludeComponent(
                                            "bitrix:iblock.vote",
                                            "element_rating_front",
                                            Array(
                                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                                "IBLOCK_ID" => $arItem["IBLOCK_ID"],
                                                "ELEMENT_ID" =>$arItem["ID"],
                                                "MAX_VOTE" => 5,
                                                "VOTE_NAMES" => array(),
                                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                                "DISPLAY_AS_RATING" => 'vote_avg'
                                            ),
                                            $component, array("HIDE_ICONS" =>"Y")
                                        );?>
                                    </div>
                                <?endif;?>
                                <div class="cost prices clearfix">

                                </div>
                                <?if($arParams["SHOW_DISCOUNT_TIME"]=="Y"){?>
                                    <?$arUserGroups = $USER->GetUserGroupArray();?>
                                    <?if($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] != 'Y' || ($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] == 'Y' && !$arItem['OFFERS'])):?>
                                        <?$arDiscounts = CCatalogDiscount::GetDiscountByProduct($item_id, $arUserGroups, "N", $min_price_id, SITE_ID);
                                        $arDiscount=array();
                                        if($arDiscounts)
                                            $arDiscount=current($arDiscounts);
                                        if($arDiscount["ACTIVE_TO"]){?>
                                            <div class="view_sale_block <?=($arQuantityData["HTML"] ? '' : 'wq');?>">
                                                <div class="count_d_block">
                                                    <span class="active_to hidden"><?=$arDiscount["ACTIVE_TO"];?></span>
                                                    <div class="title"><?=GetMessage("UNTIL_AKC");?></div>
                                                    <span class="countdown values"><span class="item"></span><span class="item"></span><span class="item"></span><span class="item"></span></span>
                                                </div>
                                                <?if($arQuantityData["HTML"]):?>
                                                    <div class="quantity_block">
                                                        <div class="title"><?=GetMessage("TITLE_QUANTITY_BLOCK");?></div>
                                                        <div class="values">
														<span class="item">
															<span class="value"><?=$totalCount;?></span>
															<span class="text"><?=GetMessage("TITLE_QUANTITY");?></span>
														</span>
                                                        </div>
                                                    </div>
                                                <?endif;?>
                                            </div>
                                        <?}?>
                                    <?else:?>
                                        <?$arDiscounts = CCatalogDiscount::GetDiscountByProduct($item_id, $arUserGroups, "N", array(), SITE_ID);
                                        $arDiscount=array();
                                        if($arDiscounts)
                                            $arDiscount=current($arDiscounts);
                                        ?>
                                        <div class="view_sale_block <?=($arQuantityData["HTML"] ? '' : 'wq');?>" <?=($arDiscount["ACTIVE_TO"] ? '' : 'style="display:none;"');?> >
                                            <div class="count_d_block">
                                                <span class="active_to hidden"><?=($arDiscount["ACTIVE_TO"] ? $arDiscount["ACTIVE_TO"] : "");?></span>
                                                <div class="title"><?=GetMessage("UNTIL_AKC");?></div>
                                                <span class="countdown values"><span class="item"></span><span class="item"></span><span class="item"></span><span class="item"></span></span>
                                            </div>
                                            <?if($arQuantityData["HTML"]):?>
                                                <div class="quantity_block">
                                                    <div class="title"><?=GetMessage("TITLE_QUANTITY_BLOCK");?></div>
                                                    <div class="values">
													<span class="item">
														<span class="value"><?=$totalCount;?></span>
														<span class="text"><?=GetMessage("TITLE_QUANTITY");?></span>
													</span>
                                                    </div>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    <?endif;?>
                                <?}?>
                            </div>
                            <div class="footer_button">
                                <a class="btn btn-default basket read_more" rel="nofollow" href="<?=$arItem["DETAIL_PAGE_URL"]?>" data-item="<?=$arItem["ID"]?>"><?=GetMessage('BUTTON_OFO')?></a>
                                <?=$arAddToBasketData["HTML"]?>
                                <?$boolShowOfferProps = ($arItem['OFFERS_PROPS_DISPLAY']);
                                $boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));?>
                                <?if($boolShowProductProps || $boolShowOfferProps):?>
                                    <div class="props_list_wrapp">
                                        <table class="props_list prod">
                                            <?if ($boolShowProductProps){
                                                //отсортируем параметры - если есть сортировка
                                                $arPropItemsIt = Array();
                                                $isset_sort = false;
                                                foreach( $arItem["DISPLAY_PROPERTIES"] as $arPropTemp ){
                                                    $arPropItemsIt[] = $arPropTemp;
                                                }


                                                foreach( $arPropItemsIt as $arProp ){?>
                                                    <?if( !empty( $arProp["VALUE"] ) ){?>
                                                        <?php
                                                        $pr = "";
                                                        $val = $arProp["VALUE"];?>
                                                        <tr>
                                                            <td><span class="sm-text"><?=str_replace('Основные.','',$arProp["NAME"])?></span></td>
                                                            <td><span class="sm-text"><?=$val?><?=$pr?></span></td>
                                                        </tr>
                                                    <?}?>
                                                <?}
                                            }?>
                                        </table>
                                        <?if ($boolShowOfferProps){?>
                                            <table class="props_list offers" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>" style="display: none;"></table>
                                        <?}?>
                                    </div>
                                <?endif;?>
                                <?if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])){
                                    foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo){?>
                                        <input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
                                        <?if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
                                            unset($arItem['PRODUCT_PROPERTIES'][$propID]);
                                    }
                                }
                                $arItem["EMPTY_PROPS_JS"]="Y";
                                $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
                                if (!$emptyProductProperties){
                                    $arItem["EMPTY_PROPS_JS"]="N";?>
                                    <div class="wrapper">
                                        <table>
                                            <?foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo){?>
                                                <tr>
                                                    <td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
                                                    <td>
                                                        <?if('L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']	&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']){
                                                            foreach($propInfo['VALUES'] as $valueID => $value){?>
                                                                <label>
                                                                    <input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
                                                                </label>
                                                            <?}
                                                        }else{?>
                                                            <select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
                                                                foreach($propInfo['VALUES'] as $valueID => $value){?>
                                                                    <option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
                                                                <?}?>
                                                            </select>
                                                        <?}?>
                                                    </td>
                                                </tr>
                                            <?}?>
                                        </table>
                                    </div>
                                    <?
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?$count_for_mobile++;?>
            <?}?>
        </div>
    </div>
<?}?>
<script>
    function fast_view_on(el) {
        var fast_view = el.nextElementSibling;
        //var fast_view_id = fast_view.dataset.paramId;
        fast_view.style.display = 'block';
    }

    if (window.screen.width >= 992 && window.screen.width <= 1340) {
        $(".fast_view_block").on("click", function(){
            var fast_view_href = this.previousElementSibling;
            fast_view_href.style.display = 'none';
            this.style.display = 'none';
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest(".image_wrapper_block").length) {
                $('.fast_view_block').hide();
            }
            e.stopPropagation();
        });
    }

    $(document).ready(function(){

        //при клике по разделу
        $('.tab_slider_wrapp .top_blocks .title_block').click(function (e) {
            e.preventDefault();
            idEl = $(this).children('a').attr('id');
            $('.tab_slider_wrapp .top_blocks .title_block img').addClass('black_img');
            $('.tab_slider_wrapp .top_blocks .title_block a').addClass('black_title');
            $(this).children('a').removeClass('black_title');
            $(this).children('img').removeClass('black_img');
            if(idEl>0){
                $('.section_id_slider').html(idEl);
                //alert(333);
                filterCatalogForSection();
                //alert(444);
                tabsDisplayForSectionTest(true);
            }
        });
        //при клике по табу
        filterCatalogForSection();
        //спрятать не нужные табсы
        tabsDisplayForSection();
        //запускаем карусель
        if($(window).width() > 800) {
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
                items:5,
                slideBy: 2,
                responsive:{
                    0:{
                        items:2,
                        navSpeed:700,
                        slideBy: 2
                    },
                    451:{
                        items:4,
                        navSpeed:700,
                        slideBy: 2
                    },
                    1300:{
                        items:5,
                        navSpeed:700,
                        slideBy: 2
                    },
                }
            });
        }

        setTimeout(function () {
            $('#owl_carousel_<?=$id_carousel?> .owl-stage').attr('style','transform:translate3d(0px, 0px, 0px);transition: all 0s ease 0s;width:' + $('.owl-carousel .owl-stage').css('width')+';');
            //console.log(11111);
        },2000);

    });
    function filterCatalogForSection() {
        setTimeout(function () {
            stepFilter();
        },1000);
        setTimeout(function () {
            stepFilter();
        },3000);
        setTimeout(function () {
            stepFilter();
        },5000);
    }
    function tabsDisplayForSection(click) {
        idEl = $('.section_id_slider').html();
        if(idEl==325){
            $('.tab_slider_wrapp ul.tabs > li:nth-child(1)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(2)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(5)').removeAttr('style');

            $('.tab_slider_wrapp ul.tabs > li:nth-child(3)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(6)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(7)').attr('style','display:none;');

            if(click){
                setTimeout(function () {
                    $('.tab_slider_wrapp ul.tabs > li:nth-child(1)').click();
                },1000);
            }

        }else if(idEl==327){
            $('.tab_slider_wrapp ul.tabs > li:nth-child(3)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(6)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(7)').removeAttr('style');

            $('.tab_slider_wrapp ul.tabs > li:nth-child(1)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(2)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(5)').attr('style','display:none;');

            if(click){
                setTimeout(function () {
                    $('.tab_slider_wrapp ul.tabs > li:nth-child(3)').click();
                },1000);
            }
        }
    }
    function tabsDisplayForSectionTest(click) {
        //alert(555);
        idEl = $('.section_id_slider').html();
        if(idEl==325){
            $('.tab_slider_wrapp ul.tabs > li:nth-child(1)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(2)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(5)').removeAttr('style');

            $('.tab_slider_wrapp ul.tabs > li:nth-child(3)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(6)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(7)').attr('style','display:none;');

            if(click){
                setTimeout(function () {
                    $('.tab_slider_wrapp ul.tabs > li:nth-child(1)').click();
                },1000);
            }

        }else if(idEl==327){
            $('.tab_slider_wrapp ul.tabs > li:nth-child(3)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(6)').removeAttr('style');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(7)').removeAttr('style');

            $('.tab_slider_wrapp ul.tabs > li:nth-child(1)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(2)').attr('style','display:none;');
            $('.tab_slider_wrapp ul.tabs > li:nth-child(5)').attr('style','display:none;');

            if(click){
                setTimeout(function () {
                    $('.tab_slider_wrapp ul.tabs > li:nth-child(3)').click();
                },1000);
            }
        }
    }
    function stepFilter() {
        idEl = $('.section_id_slider').html();
        //console.log(idEl);
        countWidth = 0;
        allCountWidth = 0;
        widthEl    = 0;
        $('.tab_slider_wrapp .catalog_block .catalog_item_wrapp.item').each(function () {
            idThisCatalog = $(this).attr('id');
            if(idEl!=idThisCatalog){
                $(this).parent().addClass('invise_tabs');
                countWidth++;
            }else{
                $(this).parent().removeClass('invise_tabs');
                allCountWidth++;
                widthEl = $(this).parent().css('width').replace("px","");
            }
        });
        if(countWidth>0){
            smEl = allCountWidth*widthEl;
        }
    }
</script>

<script>
    //Полет сравнить
    $(document).ready(function(){
        $('.srv_all').click(function () {
            <?unset($_SESSION['CATALOG_COMPARE_LIST'][35]["ITEMS"]);?>
            $('#srv_click').html('1');
            //получим все видимы элементы
            thisWrapper = $(this).parent().parent();
            var secClick = 1;
            thisWrapper.children('.top_wrapper').children('.catalog_block').children('.owl-stage-outer').children().children().each(function () {
                var li = $(this);
                if(!li.hasClass('invise_tabs') && !li.hasClass('cloned')){
                    console.log($(this).children().children('.catalog_item').children().children('.image_wrapper_block').children('.like_icons').html());
                    setTimeout(function () {
                        //console.log(li.children().children('.catalog_item').children().children('.image_wrapper_block').children('.like_icons').html());
                        li.children().children('.catalog_item').children().children('.image_wrapper_block').children('.like_icons').children('.compare_item_button').children('.compare_item.to').click();
                    },secClick*500);
                    secClick++;
                }
            });
            setTimeout(function () {
                $('#srv_click').html('');
                location.href = "/catalog/compare.php";
            },secClick*500);

            //location.href = "/catalog/compare.php?add_section="+$('.section_id_slider').html()+"&tag="+$('.tab_slider_wrapp ul.tabs li.cur.clicked').attr('data-code');
        });
        $('.like_icons').click(function () {
            var imgProduct = $(this).parent().children('.thumb').children().attr("src");
            if(document.location.href.search("/?oid") > 0){
                imgProduct = $(this).parent().parent().children('.item_slider').children('.slides').children('.offers_img').children('.popup_link').children('img').attr("src");
            }else if(document.location.href.search("/catalog/") > 0) {
                imgProduct = $(this).parent().parent().parent().children('.image_block').children('.image_wrapper_block').children('.thumb').children().attr("src");
            }
            flyBacket($(this).offset()['top'],$(this).offset()['left'],imgProduct);
        });
    });
    function flyBacket(cTop,cLeft,src) {
        console.log('top - ' + cTop);
        console.log('left - ' + cLeft);
        if (document.documentElement.clientWidth > 900) {
            $('.basket_animation>img').attr("src",src);
            $('.basket_animation').css({'top': cTop - 50 + "px", 'left': cLeft - 50 + "px"});
            $('.basket_animation').clone()
                .css({
                    'position': 'absolute',
                    'display': 'block',
                    'z-index': '11100',
                    'top': cTop - 50,
                    'left': cLeft - 50
                })
                .appendTo("body")
                .animate({
                    opacity: 0.2,
                    left: $("#compare_fly").offset()['left']+50,
                    top: $("#compare_fly").offset()['top'],
                    width: 100
                }, 1000, function () {
                    $(this).remove();

                });
        }
    }

</script>