<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if( count( $arResult["ITEMS"] ) >= 1 ){?>
    <?$arParams["BASKET_ITEMS"]=($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());?>
    <?if($arParams["AJAX_REQUEST"]=="N"){?>
    <table class="module_products_list">
        <tbody>
        <?}?>
        <?$currencyList = '';
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
        <?$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);?>
        <?foreach($arResult["ITEMS"]  as $arItem){
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
            $totalCount = CNext::GetTotalCount($arItem, $arParams);
            $arQuantityData = CNext::GetQuantityArray($totalCount, array(), "N", $arItem["PRODUCT"]["TYPE"]);

            $strMeasure = '';
            if(!$arItem["OFFERS"] || $arParams['TYPE_SKU'] === 'TYPE_2'){
                if($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]){
                    $arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
                    $strMeasure = $arMeasure["SYMBOL_RUS"];
                }
                $arItem["OFFERS_MORE"]="Y";
            }
            elseif($arItem["OFFERS"]){
                $strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
                $arItem["OFFERS_MORE"]="Y";
            }
            $elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);
            ?>
            <?$arAddToBasketData = CNext::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, array(), 'small', $arParams);?>
            <tr class="item main_item_wrapper" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <td class="wrapper_td">
                    <table>
                        <tbody>
                        <tr>
                            <td class="foto-cell">
                                <div class="image_wrapper_block">
                                    <?
                                    $a_alt = ($arItem["PREVIEW_PICTURE"] && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arItem["NAME"] ));
                                    $a_title = ($arItem["PREVIEW_PICTURE"] && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arItem["NAME"] ));
                                    ?>
                                    <?if( !empty($arItem["DETAIL_PICTURE"]) || !empty($arItem["PREVIEW_PICTURE"]) ){?>
                                        <?
                                        $picture=($arItem["PREVIEW_PICTURE"] ? $arItem["PREVIEW_PICTURE"] : $arItem["DETAIL_PICTURE"]);
                                        $img_preview = CFile::ResizeImageGet( $picture, array( "width" => 200, "height" => 140 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);?>
                                        <?if ($arParams["LIST_DISPLAY_POPUP_IMAGE"]=="Y"){?>
                                            <a class="popup_image fancy" href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" title="<?=$a_title;?>">
                                        <?}?>
                                        <img src="<?=$img_preview["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                        <?if ($arParams["LIST_DISPLAY_POPUP_IMAGE"]=="Y"){?>
                                            </a>
                                        <?}?>
                                    <?}else{?>
                                        <img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_small.png" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                    <?}?>
									<?if($fast_view_text_tmp = CNext::GetFrontParametrValue('EXPRESSION_FOR_FAST_VIEW'))
                                        $fast_view_text = $fast_view_text_tmp;
                                    else
										$fast_view_text = GetMessage('FAST_VIEW');?>
                                    <div class="fast_view_block" data-event="jqm" data-param-form_id="fast_view" data-param-iblock_id="<?=$arParams["IBLOCK_ID"];?>" data-param-id="<?=$arItem["ID"];?>" data-param-item_href="<?=urlencode($arItem["DETAIL_PAGE_URL"]);?>" data-name="fast_view"><?=$fast_view_text;?></div>
                                </div>
								<?if($arItem["OFFERS"]){?>
                                    <?if(!empty($arItem['OFFERS_PROP'])){?>
                                        <div class="sku_props">
                                            <div class="bx_catalog_item_scu wrapper_sku" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['PROP_DIV']; ?>" data-site_id="<?=SITE_ID;?>" data-id="<?=$arItem["ID"];?>" data-offer_id="<?=$arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"];?>" data-propertyid="<?=$arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["PROPERTIES"]["CML2_LINK"]["ID"];?>" data-offer_iblockid="<?=$arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["IBLOCK_ID"];?>">
                                                <?$arSkuTemplate = array();?>
                                                <?$arSkuTemplate=CNext::GetSKUPropsArray($arItem['OFFERS_PROPS_JS'], $arResult["SKU_IBLOCK_ID"], $arParams["DISPLAY_TYPE"], $arParams["OFFER_HIDE_NAME_PROPS"], "N", $arItem, $arParams['OFFER_SHOW_PREVIEW_PICTURE_PROPS']);?>
                                                <?foreach ($arSkuTemplate as $code => $strTemplate){
                                                    if (!isset($arItem['OFFERS_PROP'][$code]))
                                                        continue;
                                                    echo '<div class="item_wrapper">', str_replace('#ITEM#_prop_', $arItemIDs["ALL_ITEM_IDS"]['PROP'], $strTemplate), '</div>';
                                                }?>
                                            </div>
                                            <?$arItemJSParams=CNext::GetSKUJSParams($arResult, $arParams, $arItem);?>
                                        </div>
                                    <?}?>
                                <?}?>
                            </td>
                            <td class="item-name-cell">
                                <div class="title"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="dark_link"><?=$elementName?></a></div>
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
                                <?//=$arQuantityData["HTML"];?>
                            </td>
                            <td class="price-cell">
                                <div class="cost prices clearfix">

                                </div>

                                <div class="basket_props_block" id="bx_basket_div_<?=$arItem["ID"];?>" style="display: none;">
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
                                <div class="adaptive_button_buy">
                                    <!--noindex-->
                                    <?=$arAddToBasketData["HTML"]?>
                                    <!--/noindex-->
                                </div>
                            </td>
                            <td class="but-cell item_<?=$arItem["ID"]?>">
								<?$boolShowOfferProps = ($arItem['OFFERS_PROPS_DISPLAY']);
                                $boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));?>
                                <?if($boolShowProductProps || $boolShowOfferProps):?>
                                    <div class="props_list_wrapp" style="display: block;">
                                        <table class="props_list prod">
                                            <?if ($boolShowProductProps){
                                                //отсортируем параметры - если есть сортировка
                                                $arPropItemsIt = Array();
                                                $isset_sort = false;
                                                foreach( $arItem["DISPLAY_PROPERTIES"] as $arPropTemp ){
                                                    if(isset($_GET["sort"])&& !empty($_GET["sort"])){
                                                        if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX" && $arPropTemp["NAME"] == "Процентная ставка"){
                                                            $arPropItemsIt[] = $arPropTemp;
                                                            $isset_sort = true;
                                                            break;
                                                        }elseif($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX" && $arPropTemp["NAME"] == "Кредитный лимит"){
                                                            $arPropItemsIt[] = $arPropTemp;
                                                            $isset_sort = true;
                                                            break;
                                                        }elseif($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX" && $arPropTemp["NAME"] == "Льготный период"){
                                                            $arPropItemsIt[] = $arPropTemp;
                                                            $isset_sort = true;
                                                            break;
                                                        }
                                                    }else{
                                                        $arPropItemsIt[] = $arPropTemp;
                                                    }
                                                }

                                                if($isset_sort){
                                                    foreach( $arItem["DISPLAY_PROPERTIES"] as $arPropTemp ){
                                                        if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX" && $arPropTemp["NAME"] == "Процентная ставка"){
                                                            continue;
                                                        }elseif($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX" && $arPropTemp["NAME"] == "Кредитный лимит"){
                                                            continue;
                                                        }elseif($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX" && $arPropTemp["NAME"] == "Льготный период"){
                                                            continue;
                                                        }else{
                                                            $arPropItemsIt[] = $arPropTemp;
                                                        }
                                                    }
                                                }

                                                foreach( $arPropItemsIt as $arProp ){?>
                                                    <?if( !empty( $arProp["VALUE"] ) ){?>
                                                        <?php
                                                        $pr = "";
                                                        $val = "";
                                                        if(count($arProp["DISPLAY_VALUE"])>1) {
                                                            foreach($arProp["DISPLAY_VALUE"] as $key => $value) {
                                                                if ($arProp["DISPLAY_VALUE"][$key+1]) {
                                                                    $val = $value.", ";
                                                                } else {
                                                                    $val = $value;
                                                                }
                                                            }
                                                        } else {
                                                            $val = $arProp["DISPLAY_VALUE"];
                                                        }
                                                        $tag_b_start = "";
                                                        $tag_b_end   = "";
                                                        switch ($arProp["NAME"]) {
                                                            case "Процентная ставка":
                                                                $pr = " %";

                                                                if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX"){
                                                                    $tag_b_start = '<b>';
                                                                    $tag_b_end   = '</b>';
                                                                }

                                                                break;
                                                            case "Кредитный лимит":
                                                                $pr = " руб.";
                                                                $ar_limit = str_split($val,3);

                                                                if(count($ar_limit)>2){
                                                                    $val = (ceil($val/1000000))*1000000;
                                                                    $val = strval($val);
                                                                    $val = substr($val, 0,strlen($val)-6) . ' млн';
                                                                }elseif(count($ar_limit)>1){
                                                                    $val = (ceil($val/1000))*1000;
                                                                    $val = strval($val);
                                                                    $val = substr($val, 0,strlen($val)-3) . ' тыс';
                                                                }

                                                                if($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX"){
                                                                    $tag_b_start = '<b>';
                                                                    $tag_b_end   = '</b>';
                                                                }

                                                                break;
                                                            case "Льготный период":
                                                                $pr = " дней";

                                                                if($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX"){
                                                                    $tag_b_start = '<b>';
                                                                    $tag_b_end   = '</b>';
                                                                }

                                                                break;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><span><?=$tag_b_start?><?=$arProp["NAME"]?><?=$tag_b_end?></span></td>
                                                            <td>
															<span>
															<?=$tag_b_start?><?=$val?><?=$pr?><?=$tag_b_end?>
															</span>
                                                            </td>
                                                        </tr>
                                                    <?}?>
                                                <?}
                                            }?>
                                        </table>
                                        <?if ($boolShowOfferProps){?>
                                            <table class="props_list offers" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>" style="display: none;"></table>
                                        <?}?>
                                    </div>
                                    <!--<div class="show_props dark_link">
									<span class="icons_fa char_title"><span><?=GetMessage('PROPERTIES')?></span></span>
								</div>-->
                                <?endif;?>
                                <div class="counter_wrapp">
                                    <?if($arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] && !count($arItem["OFFERS"]) && $arAddToBasketData["ACTION"] == "ADD" && $arAddToBasketData["CAN_BUY"]):?>
                                        <div class="counter_block" data-item="<?=$arItem["ID"];?>" <?=(in_array($arItem["ID"], $arParams["BASKET_ITEMS"]) ? "style='display: none;'" : "");?>>
                                            <span class="minus">-</span>
                                            <input type="text" class="text" name="quantity" value="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" />
                                            <span class="plus" <?=($arAddToBasketData["MAX_QUANTITY_BUY"] ? "data-max='".$arAddToBasketData["MAX_QUANTITY_BUY"]."'" : "")?>>+</span>
                                        </div>
                                    <?endif;?>
                                    <div class="button_block <?=(in_array($arItem["ID"], $arParams["BASKET_ITEMS"])  || $arAddToBasketData["ACTION"] == "ORDER" || !$arAddToBasketData["CAN_BUY"] || !$arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] ? "wide" : "");?>">
                                        <!--noindex-->
                                        <?=str_replace(GetMessage("SEARCH_BUTTON"),GetMessage("REPLACE_BUTTON"),$arAddToBasketData["HTML"])?>
                                        <!--/noindex-->
                                    </div>
                                </div>
                                <?
                                if(isset($arItem['PRICE_MATRIX']) && $arItem['PRICE_MATRIX']) // USE_PRICE_COUNT
                                {?>
                                    <?if($arItem['ITEM_PRICE_MODE'] == 'Q' && count($arItem['PRICE_MATRIX']['ROWS']) > 1):?>
                                    <?$arOnlyItemJSParams = array(
                                        "ITEM_PRICES" => $arItem["ITEM_PRICES"],
                                        "ITEM_PRICE_MODE" => $arItem["ITEM_PRICE_MODE"],
                                        "ITEM_QUANTITY_RANGES" => $arItem["ITEM_QUANTITY_RANGES"],
                                        "MIN_QUANTITY_BUY" => $arAddToBasketData["MIN_QUANTITY_BUY"],
                                        "SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
                                        "ID" => $this->GetEditAreaId($arItem["ID"]),
                                    )?>
                                    <script type="text/javascript">
                                        var ob<? echo $this->GetEditAreaId($arItem["ID"]); ?>el = new JCCatalogSectionOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
                                    </script>
                                <?endif;?>
                                <?}?>
                            </td>
							<?/*<td class="prop_col">

</td>*/?>
                            <td class="like_icons <?=(((!$arItem["OFFERS"] && $arParams["DISPLAY_WISH_BUTTONS"] != "N" && $arAddToBasketData["CAN_BUY"]) && ($arParams["DISPLAY_COMPARE"] == "Y")) ? " full" : "")?>">
                                <div class="wrapp_stockers">
                                    <div class="like_icons">
                                        <?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"):?>
                                            <?if(!$arItem["OFFERS"]):?>
                                                <div class="wish_item_button" <?=($arAddToBasketData["CAN_BUY"] ? '' : 'style="display:none"');?>>
                                                    <span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item to" data-item="<?=$arItem["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>"><i></i></span>
                                                    <span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item in added" style="display: none;" data-item="<?=$arItem["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>"><i></i></span>
                                                </div>
                                            <?elseif($arItem["OFFERS"]):?>
                                                <?foreach($arItem["OFFERS"] as $arOffer):?>
                                                    <?if($arAddToBasketData['CAN_BUY']):?>
                                                        <div class="wish_item_button o_<?=$arOffer["ID"];?>" style="display: none;">
                                                            <span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item to <?=$arParams["TYPE_SKU"];?>" data-item="<?=$arOffer["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>" data-offers="Y" data-props="<?=$arOfferProps?>"><i></i></span>
                                                            <span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-item="<?=$arOffer["ID"]?>" data-iblock="<?=$arOffer["IBLOCK_ID"]?>"><i></i></span>
                                                        </div>
                                                    <?endif;?>
                                                <?endforeach;?>
                                            <?endif;?>
                                        <?endif;?>
                                        <?if($arParams["DISPLAY_COMPARE"] == "Y"):?>
                                            <?if(!$arItem["OFFERS"] || $arParams["TYPE_SKU"] !== 'TYPE_1'):?>
                                                <div class="compare_item_button">
                                                    <span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>" ><i></i></span>
                                                    <span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>"><i></i></span>
                                                </div>
                                            <?elseif($arItem["OFFERS"]):?>
                                                <?foreach($arItem["OFFERS"] as $arOffer):?>
                                                    <div class="compare_item_button o_<?=$arOffer["ID"];?>" style="display: none;">
                                                        <span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to <?=$arParams["TYPE_SKU"];?>" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arOffer["ID"]?>" ><i></i></span>
                                                        <span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arOffer["ID"]?>"><i></i></span>
                                                    </div>
                                                <?endforeach;?>
                                            <?endif;?>
                                        <?endif;?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        <?}?>
        <?if($arParams["AJAX_REQUEST"]=="N"){?>
        </tbody>
    </table>
    <script>
        $(document).ready(function(){
            $('.sort_header').fadeIn();
        })
    </script>
<?}?>
    <?if($arParams["AJAX_REQUEST"]=="Y"){?>
    <div class="wrap_nav">
        <tr <?=($arResult["NavPageCount"]>1 ? "" : "style='display: none;'");?>><td>
                <?}?>

                <div>
                    <div class="bottom_nav <?=$arParams["DISPLAY_TYPE"];?>" <?=($arParams["AJAX_REQUEST"]=="Y"  && $arResult["NavPageCount"]<=1 ? "style='display: none; '" : "");?>>
                        <?if( $arParams["DISPLAY_BOTTOM_PAGER"] == "Y" ){?><?=$arResult["NAV_STRING"]?><?}?>
                    </div>
                </div>

                <?if($arParams["AJAX_REQUEST"]=="Y"){?>
            </td></tr>
    </div>
<?}?>
    <script type="text/javascript">
        $('.module_products_list').removeClass('errors');
    </script>
<?}else{?>
    <?if($arParams["AJAX_REQUEST"]!="Y"){?>
        <table class="module_products_list errors">
        <tbody>
        <tr><td>
    <?}?>
    <script type="text/javascript">
        $('.module_products_list').addClass('errors');
    </script>
    <div class="module_products_list_b">
        <div class="no_goods">
            <div class="no_products">
                <div class="wrap_text_empty">
                    <?if($_REQUEST["set_filter"]){?>
                        <?$APPLICATION->IncludeFile(SITE_DIR."include/section_no_products_filter.php", Array(), Array("MODE" => "html",  "NAME" => GetMessage('EMPTY_CATALOG_DESCR')));?>
                    <?}else{?>
                        <?$APPLICATION->IncludeFile(SITE_DIR."include/section_no_products.php", Array(), Array("MODE" => "html",  "NAME" => GetMessage('EMPTY_CATALOG_DESCR')));?>
                    <?}?>
                </div>
            </div>
            <?if($_REQUEST["set_filter"]){?>
                <span class="button wide btn btn-default"><?=GetMessage('RESET_FILTERS');?></span>
            <?}?>
        </div>
    </div>
    <?if($arParams["AJAX_REQUEST"]!="Y"){?>
        </td></tr>
        </tbody>
        </table>
    <?}?>
<?}?>