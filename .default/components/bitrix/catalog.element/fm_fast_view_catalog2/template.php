<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="basket_props_block" id="bx_basket_div_<?=$arResult["ID"];?>" style="display: none;">
    <?if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])){
        foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo){?>
            <input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
            <?if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
                unset($arResult['PRODUCT_PROPERTIES'][$propID]);
        }
    }
    $arResult["EMPTY_PROPS_JS"]="Y";
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if (!$emptyProductProperties){
        $arResult["EMPTY_PROPS_JS"]="N";?>
        <div class="wrapper">
            <table>
                <?foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo){?>
                    <tr>
                        <td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
                        <td>
                            <?if('L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']){
                                foreach($propInfo['VALUES'] as $valueID => $value){?>
                                    <label>
                                        <input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
                                    </label>
                                <?}
                            }else{?>
                                <select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]">
                                    <?foreach($propInfo['VALUES'] as $valueID => $value){?>
                                        <option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
                                    <?}?>
                                </select>
                            <?}?>
                        </td>
                    </tr>
                <?}?>
            </table>
        </div>
    <?}?>
</div>
<?
$this->setFrameMode(true);
$currencyList = '';
if (!empty($arResult['CURRENCIES'])){
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'STORES' => array(
        "USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
        "SCHEDULE" => $arParams["SCHEDULE"],
        "USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
        "MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
        "ELEMENT_ID" => $arResult["ID"],
        "STORE_PATH"  =>  $arParams["STORE_PATH"],
        "MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
        "MAX_AMOUNT"=>$arParams["MAX_AMOUNT"],
        "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
        "SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
        "SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
        "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
        "USER_FIELDS" => $arParams['USER_FIELDS'],
        "FIELDS" => $arParams['FIELDS'],
        "STORES" => $arParams['STORES'] = array_diff($arParams['STORES'], array('')),
    )
);
unset($currencyList, $templateLibrary);


$arSkuTemplate = array();
if (!empty($arResult['SKU_PROPS'])){
    $arSkuTemplate=CNext::GetSKUPropsArray($arResult['SKU_PROPS'], $arResult["SKU_IBLOCK_ID"], "list", $arParams["OFFER_HIDE_NAME_PROPS"]);
}
$strMainID = $this->GetEditAreaId($arResult['ID']);

$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

$arResult["strMainID"] = $this->GetEditAreaId($arResult['ID'])."f";
$arItemIDs=CNext::GetItemsIDs($arResult, "Y");
$totalCount = CNext::GetTotalCount($arResult, $arParams);

$arQuantityData = CNext::GetQuantityArray($totalCount, $arItemIDs["ALL_ITEM_IDS"], "Y");

$arParams["BASKET_ITEMS"]=($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());
$useStores = $arParams["USE_STORE"] == "Y" && $arResult["STORES_COUNT"] && $arQuantityData["RIGHTS"]["SHOW_QUANTITY"];
$showCustomOffer=(($arResult['OFFERS'] && $arParams["TYPE_SKU"] !="N") ? true : false);
if($showCustomOffer){
    $templateData['JS_OBJ'] = $strObName;
}
$strMeasure='';
$arAddToBasketData = array();
if($arResult["OFFERS"]){
    $strMeasure=$arResult["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
    $templateData["STORES"]["OFFERS"]="Y";
    foreach($arResult["OFFERS"] as $arOffer){
        $templateData["STORES"]["OFFERS_ID"][]=$arOffer["ID"];
    }
}else{
    if (($arParams["SHOW_MEASURE"]=="Y")&&($arResult["CATALOG_MEASURE"])){
        $arMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arResult["CATALOG_MEASURE"]), false, false, array())->GetNext();
        $strMeasure=$arMeasure["SYMBOL_RUS"];
    }
    $arAddToBasketData = CNext::GetAddToBasketArray($arResult, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], true, $arItemIDs["ALL_ITEM_IDS"], 'big_btn w_icons', $arParams);
}
$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);

// save item viewed
$arFirstPhoto = reset($arResult['MORE_PHOTO']);
$arItemPrices = $arResult['MIN_PRICE'];
if(isset($arResult['PRICE_MATRIX']) && $arResult['PRICE_MATRIX'])
{
    $rangSelected = $arResult['ITEM_QUANTITY_RANGE_SELECTED'];
    $priceSelected = $arResult['ITEM_PRICE_SELECTED'];
    if(isset($arResult['FIX_PRICE_MATRIX']) && $arResult['FIX_PRICE_MATRIX'])
    {
        $rangSelected = $arResult['FIX_PRICE_MATRIX']['RANGE_SELECT'];
        $priceSelected = $arResult['FIX_PRICE_MATRIX']['PRICE_SELECT'];
    }
    $arItemPrices = $arResult['ITEM_PRICES'][$priceSelected];
    $arItemPrices['VALUE'] = $arItemPrices['BASE_PRICE'];
    $arItemPrices['PRINT_VALUE'] = \Aspro\Functions\CAsproItem::getCurrentPrice('BASE_PRICE', $arItemPrices);
    $arItemPrices['DISCOUNT_VALUE'] = $arItemPrices['PRICE'];
    $arItemPrices['PRINT_DISCOUNT_VALUE'] = \Aspro\Functions\CAsproItem::getCurrentPrice('PRICE', $arItemPrices);
}
$arViewedData = array(
    'PRODUCT_ID' => $arResult['ID'],
    'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    'NAME' => $arResult['NAME'],
    'DETAIL_PAGE_URL' => $arResult['DETAIL_PAGE_URL'],
    'PICTURE_ID' => $arResult['PREVIEW_PICTURE'] ? $arResult['PREVIEW_PICTURE']['ID'] : ($arFirstPhoto ? $arFirstPhoto['ID'] : false),
    'CATALOG_MEASURE_NAME' => $arResult['CATALOG_MEASURE_NAME'],
    'MIN_PRICE' => $arItemPrices,
    'CAN_BUY' => $arResult['CAN_BUY'] ? 'Y' : 'N',
    'IS_OFFER' => 'N',
    'WITH_OFFERS' => $arResult['OFFERS'] ? 'Y' : 'N',
);
$actualItem = $arResult["OFFERS"] ? (isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]) ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] : reset($arResult['OFFERS'])) : $arResult;
$elementName = ((isset($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arResult['NAME']);
?>
<script type="text/javascript">
    setViewedProduct(<?=$arResult['ID']?>, <?=CUtil::PhpToJSObject($arViewedData, false)?>);
</script>
<div class="da-props swiper-container">
    <?php
    $copyArr = $arResult["PROPERTIES"];
    shuffle($arResult["PROPERTIES"]);
    ?>
    <div class="swiper-wrapper">
        <?php foreach($arResult["PROPERTIES"] as $prop): ?>
            <?php if($prop["VALUE"] == 'Да' && $prop["SHOW_IN_TAGS"] == 'Y'): ?>
                <span class="s-text swiper-slide"><?=$prop["NAME"];?></span>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php $arResult["PROPERTIES"] = $copyArr;?>
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
<div class="item_main_info <?=(!$showCustomOffer ? "noffer" : "");?> <?=($arParams["SHOW_UNABLE_SKU_PROPS"] != "N" ? "show_un_props" : "unshow_un_props");?>" id="<?=$arItemIDs["strMainID"];?>">
    <div class="img_wrapper">

        <div class="item_slider">
            <?reset($arResult['MORE_PHOTO']);
            $arFirstPhoto = current($arResult['MORE_PHOTO']);
            $viewImgType=$arParams["DETAIL_PICTURE_MODE"];?>
            <div class="slides">
                <?if($showCustomOffer && !empty($arResult['OFFERS_PROP'])){?>
                    <div class="offers_img wof">
                        <?$alt=$arFirstPhoto["ALT"];
                        $title=$arFirstPhoto["TITLE"];?>
                        <?if($arFirstPhoto["BIG"]["src"]){?>
                            <a href="<?=($viewImgType=="POPUP" ? $arFirstPhoto["BIG"]["src"] : "javascript:void(0)");?>" class="<?=($viewImgType=="POPUP" ? "popup_link" : "line_link");?>" title="<?=$title;?>">
                                <img id="<? echo $arItemIDs["ALL_ITEM_IDS"]['PICT']; ?>" src="<?=$arFirstPhoto['SMALL']['src']; ?>" <?=($viewImgType=="MAGNIFIER" ? 'data-large="" xpreview="" xoriginal=""': "");?> alt="<?=$alt;?>" title="<?=$title;?>" itemprop="image">
                                <div class="zoom"></div>
                            </a>
                        <?}else{?>
                            <a href="javascript:void(0)" class="" title="<?=$title;?>">
                                <img id="<? echo $arItemIDs["ALL_ITEM_IDS"]['PICT']; ?>" src="<?=$arFirstPhoto['SRC']; ?>" alt="<?=$alt;?>" title="<?=$title;?>" itemprop="image">
                                <div class="zoom"></div>
                            </a>
                        <?}?>
                    </div>
                <?}else{
                    if($arResult["MORE_PHOTO"]){
                        $bMagnifier = ($viewImgType=="MAGNIFIER");?>
                        <ul>
                            <?foreach($arResult["MORE_PHOTO"] as $i => $arImage){
                                if($i && $bMagnifier):?>
                                    <?continue;?>
                                <?endif;?>
                                <?$isEmpty=($arImage["SMALL"]["src"] ? false : true );?>
                                <?
                                $alt=$arImage["ALT"];
                                $title=$arImage["TITLE"];
                                ?>
                                <li id="photo-<?=$i?>" <?=(!$i ? 'class="current"' : 'style="display: none;"')?>>
                                    <div><img  src="<?=$arImage["SRC"]?>" alt="<?=$alt;?>" title="<?=$title;?>" /></div>
                                    <?php $key = array_search($arResult["PROPERTIES"]["HARAKTERISTIKI_PLATEZHNAYA_SISTEMA"]["VALUE"], $arResult["listOfVariants"]);?>
                                    <div class="card-data"><?php if($arResult["ORIGINAL_PARAMETERS"]["SECTION_CODE"] != 'kredity_nalichnymi' && $arResult["ORIGINAL_PARAMETERS"]["SECTION_CODE"] != 'zaymy' && $arResult["ORIGINAL_PARAMETERS"]["SECTION_CODE"] != 'ipoteka' && $arResult["ORIGINAL_PARAMETERS"]["SECTION_CODE"] != 'avtokredity' && $arResult["ORIGINAL_PARAMETERS"]["SECTION_CODE"] != 'refinansirovanie'):?><img height="20" alt="HARAKTERISTIKI_TIP_KARTY" class="har-logo" src="<?=$arResult["resultImgProp"]["VALUE"][$key];?>"><?php endif;?> <?= $arResult["PROPERTIES"]["HARAKTERISTIKI_TIP_KARTY"]["VALUE"] ?></div>
                                </li>
                            <?}?>
                        </ul>
                    <?}
                }?>
            </div>

        </div>

        <div class="sku_block">
            <?
            //ОФОРМИТЬ - НАЧАЛО
            if(strpos(trim($arResult["PROPERTIES"]["URL"]["VALUE"]) ,'admitad') >-1){
                $referer=trim($arResult["PROPERTIES"]["URL"]["VALUE"]) . "subid/" .$_COOKIE['utm_source'] ;

            }else{
                $referer=trim($arResult["PROPERTIES"]["URL"]["VALUE"]) ."&sa=".$_COOKIE['utm_source'] ;
            }
            $button_in_store = '';
            if(strlen(trim($arResult["PROPERTIES"]["URL"]["VALUE"]))>0):?>
                <?$button_in_store = $button_in_store . '<a rel="nofollow" style="display: block;margin-top:10px;" onClick="ym(\'56316898\',\'reachGoal\', \'oformit\');" href="'  . $referer . '"  class="btn btn-default basket read_more ofo"><span>' . GetMessage("OFO") . '</span></a>';
            endif;
            ?>
            <div class="sku_props">

                <div class="bx_catalog_item_scu wrapper_sku" id="bx_117848907_480_skudiv">
                    <div class="bx_item_detail_scu" style="" id="bx_117848907_480_prop_292_cont" data-display_type="LI" data-id="292">
                        <span class="show_class bx_item_section_name"><span></span></span><div class="bx_scu_scroller_container">
                            <div class="bx_scu">
                                <ul id="bx_117848907_480_prop_292_list" class="list_values_wrapper">
                                    <div>
                                        <?=$button_in_store?>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <?if($arResult['SECTION']['IBLOCK_SECTION_ID'] == 337){
                    ?><div class="like_icons btn btn-default" style="display: none;">

                    </div>
                <?}
                else{?>


                    <div class="like_icons btn btn-default">
                        <div class="compare_item_button o_">
                            <a class="add-comparison" href="javascript:void(0);" onclick="kk_add_to_comparisons(<?=$arResult['ID'];?>,'<?=session_id();?>');">В сравнение</a>
                        </div>
                    </div>
                <?}?>
            </div>
            <?
            //ОФОРМИТЬ - КОНЕЦ
            ?>
        </div>



        <div class="z stickers">
            <?$prop = ($arParams["STIKERS_PROP"] ? $arParams["STIKERS_PROP"] : "HIT");?>
            <?foreach(CNext::GetItemStickers($arResult["PROPERTIES"][$prop]) as $arSticker):?>
                <div><div class="<?=$arSticker['CLASS']?>"><?=$arSticker['VALUE']?></div></div>
            <?endforeach;?>
            <?if($arParams["SALE_STIKER"] && $arResult["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"]){?>
                <div><div class="sticker_sale_text"><?=$arResult["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"];?></div></div>
            <?}?>
        </div>


    </div>
    <div class="prices_item_block scrollbar">
        <div class="middle_info main_item_wrapper">
            <?$frame = $this->createFrame()->begin();?>
            <div class="prices_block" style="display: none;">
                <div class="cost prices clearfix">
                    <?if( count( $arResult["OFFERS"] ) > 0 ){?>
                        <div class="with_matrix" style="display:none;">
                            <div class="price price_value_block"><span class="values_wrapper"></span></div>
                            <?if($arParams["SHOW_OLD_PRICE"]=="Y"):?>
                                <div class="price discount"></div>
                            <?endif;?>
                            <?if($arParams["SHOW_DISCOUNT_PERCENT"]=="Y"){?>
                                <div class="sale_block matrix" style="display:none;">
                                    <div class="sale_wrapper">
                                        <?if($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] != "Y"):?>
                                            <span class="title"><?=GetMessage("CATALOG_ECONOMY");?></span>
                                            <div class="text"><span class="values_wrapper"></span></div>
                                        <?else:?>
                                            <div class="text">
                                                <span class="title"><?=GetMessage("CATALOG_ECONOMY");?></span>
                                                <span class="values_wrapper"></span>
                                            </div>
                                        <?endif;?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                        <?\Aspro\Functions\CAsproSku::showItemPrices($arParams, $arResult, $item_id, $min_price_id, $arItemIDs, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));?>
                    <?}else{?>
                        <?
                        $item_id = $arResult["ID"];
                        if(isset($arResult['PRICE_MATRIX']) && $arResult['PRICE_MATRIX']) // USE_PRICE_COUNT
                        {
                            if($arResult['PRICE_MATRIX']['COLS'])
                            {
                                $arCurPriceType = current($arResult['PRICE_MATRIX']['COLS']);
                                $min_price_id = $arCurPriceType['ID'];?>
                            <?}?>
                            <?if($arResult['ITEM_PRICE_MODE'] == 'Q' && count($arResult['PRICE_MATRIX']['ROWS']) > 1):?>
                            <?=CNext::showPriceRangeTop($arResult, $arParams, GetMessage("CATALOG_ECONOMY"));?>
                        <?endif;?>
                            <?=CNext::showPriceMatrix($arResult, $arParams, $strMeasure, $arAddToBasketData);?>
                            <?
                        }
                        else
                        {?>
                            <?\Aspro\Functions\CAsproItem::showItemPrices($arParams, $arResult["PRICES"], $strMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));?>
                        <?}?>
                    <?}?>
                </div>
                <?if($arParams["SHOW_DISCOUNT_TIME"]=="Y"){?>
                    <?$arUserGroups = $USER->GetUserGroupArray();?>
                    <?if($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] != 'Y' || ($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] == 'Y' && !$arResult['OFFERS'])):?>
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
												<span class="value" <?=((count( $arResult["OFFERS"] ) > 0 && $arParams["TYPE_SKU"] == 'TYPE_1' && $arResult["OFFERS_PROP"]) ? 'style="opacity:0;"' : '')?>><?=$totalCount;?></span>
												<span class="text"><?=GetMessage("TITLE_QUANTITY");?></span>
											</span>
                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
                        <?}?>
                    <?else:?>
                        <?if($arResult['JS_OFFERS'])
                        {

                            foreach($arResult['JS_OFFERS'] as $keyOffer => $arTmpOffer2)
                            {
                                $active_to = '';
                                $arDiscounts = CCatalogDiscount::GetDiscountByProduct( $arTmpOffer2['ID'], $arUserGroups, "N", array(), SITE_ID );
                                if($arDiscounts)
                                {
                                    foreach($arDiscounts as $arDiscountOffer)
                                    {
                                        if($arDiscountOffer['ACTIVE_TO'])
                                        {
                                            $active_to = $arDiscountOffer['ACTIVE_TO'];
                                            break;
                                        }
                                    }
                                }
                                $arResult['JS_OFFERS'][$keyOffer]['DISCOUNT_ACTIVE'] = $active_to;
                            }
                        }?>
                        <div class="view_sale_block" style="display:none;">
                            <div class="count_d_block">
                                <span class="active_to_<?=$arResult["ID"]?> hidden"><?=$arDiscount["ACTIVE_TO"];?></span>
                                <div class="title"><?=GetMessage("UNTIL_AKC");?></div>
                                <span class="countdown countdown_<?=$arResult["ID"]?> values"></span>
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
            <div class="buy_block" style="display: none;">

                <?if(!$arResult["OFFERS"]):?>
                    <div class="counter_wrapp">
                        <?if(($arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] && $arAddToBasketData["ACTION"] == "ADD") && $arAddToBasketData["CAN_BUY"]):?>
                            <div class="counter_block" data-offers="<?=($arResult["OFFERS"] ? "Y" : "N");?>" data-item="<?=$arResult["ID"];?>" <?=(($arResult["OFFERS"] && $arParams["TYPE_SKU"]=="N") ? "style='display: none;'" : "");?>>
                                <span class="minus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_DOWN']; ?>">-</span>
                                <input type="text" class="text" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" />
                                <span class="plus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_UP']; ?>" <?=($arAddToBasketData["MAX_QUANTITY_BUY"] ? "data-max='".$arAddToBasketData["MAX_QUANTITY_BUY"]."'" : "")?>>+</span>
                            </div>
                        <?endif;?>
                        <div id="<? echo $arItemIDs["ALL_ITEM_IDS"]['BASKET_ACTIONS']; ?>" class="button_block <?=(($arAddToBasketData["ACTION"] == "ORDER" /*&& !$arResult["CAN_BUY"]*/) || !$arAddToBasketData["CAN_BUY"] || !$arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] || ($arAddToBasketData["ACTION"] == "SUBSCRIBE" && $arResult["CATALOG_SUBSCRIBE"] == "Y")  ? "wide" : "");?>">
                            <!--noindex-->
                            <?=$arAddToBasketData["HTML"]?>
                            <!--/noindex-->
                        </div>
                    </div>
                <?if(isset($arResult['PRICE_MATRIX']) && $arResult['PRICE_MATRIX']) // USE_PRICE_COUNT
                {?>
                <?if($arResult['ITEM_PRICE_MODE'] == 'Q' && count($arResult['PRICE_MATRIX']['ROWS']) > 1):?>
                <?$arOnlyItemJSParams = array(
                    "ITEM_PRICES" => $arResult["ITEM_PRICES"],
                    "ITEM_PRICE_MODE" => $arResult["ITEM_PRICE_MODE"],
                    "ITEM_QUANTITY_RANGES" => $arResult["ITEM_QUANTITY_RANGES"],
                    "MIN_QUANTITY_BUY" => $arAddToBasketData["MIN_QUANTITY_BUY"],
                    "SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
                    "ID" => $arItemIDs["strMainID"],
                )?>
                    <script type="text/javascript">
                        var <? echo $arItemIDs["strObName"]; ?>el = new JCCatalogOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
                    </script>
                <?endif;?>
                <?}?>
                <?if($arAddToBasketData["ACTION"] !== "NOTHING"):?>
                <?if($arAddToBasketData["ACTION"] == "ADD" && $arAddToBasketData["CAN_BUY"] && $arParams["SHOW_ONE_CLICK_BUY"]!="N"):?>
                    <div class="wrapp_one_click">
								<span class="btn btn-default white one_click" data-item="<?=$arResult["ID"]?>" data-iblockID="<?=$arParams["IBLOCK_ID"]?>" data-quantity="<?=$arAddToBasketData["MIN_QUANTITY_BUY"];?>" onclick="oneClickBuy('<?=$arResult["ID"]?>', '<?=$arParams["IBLOCK_ID"]?>', this)">
									<span><?=GetMessage('ONE_CLICK_BUY')?></span>
								</span>
                    </div>
                <?endif;?>
                <?endif;?>
                <?elseif($arResult["OFFERS"] && $arParams['TYPE_SKU'] == 'TYPE_1'):?>
                    <div class="offer_buy_block buys_wrapp" style="display:none;">
                        <div class="counter_wrapp"></div>
                    </div>
                <?elseif($arResult["OFFERS"] && $arParams['TYPE_SKU'] != 'TYPE_1'):?>
                    <span class="slide_offer btn btn-default type_block"><i></i><span><?=GetMessage("MORE_TEXT_BOTTOM");?></span></span>
                <?endif;?>
            </div>
            <?if($arParams["DISPLAY_WISH_BUTTONS"] != "N" || $arParams["DISPLAY_COMPARE"] == "Y"):?>
                <div class="clearfix"></div>
                <div class="description_wrapp">
                    <div class="like_icons">
                        <?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"):?>
                            <?if(!$arResult["OFFERS"]):?>
                                <div class="wish_item text" <?=($arAddToBasketData['CAN_BUY'] ? '' : 'style="display:none"');?> data-item="<?=$arResult["ID"]?>" data-iblock="<?=$arResult["IBLOCK_ID"]?>">
                                    <span class="value"><i></i><span><?=GetMessage('CATALOG_WISH')?></span></span>
                                    <span class="value added"><i></i><span><?=GetMessage('CATALOG_WISH_OUT')?></span></span>
                                </div>
                            <?elseif($arResult["OFFERS"] && $arParams["TYPE_SKU"] === 'TYPE_1' && !empty($arResult['OFFERS_PROP'])):?>
                                <div class="wish_item text" <?=($arAddToBasketData['CAN_BUY'] ? '' : 'style="display:none"');?> data-item="" data-iblock="<?=$arResult["IBLOCK_ID"]?>" <?=(!empty($arResult['OFFERS_PROP']) ? 'data-offers="Y"' : '');?> data-props="<?=$arOfferProps?>">
                                    <span class="value <?=$arParams["TYPE_SKU"];?>"><i></i><span><?=GetMessage('CATALOG_WISH')?></span></span>
                                    <span class="value added <?=$arParams["TYPE_SKU"];?>"><i></i><span><?=GetMessage('CATALOG_WISH_OUT')?></span></span>
                                </div>
                            <?endif;?>
                        <?endif;?>
                        <?if($arParams["DISPLAY_COMPARE"] == "Y"):?>
                            <?if(!$arResult["OFFERS"] || ($arResult["OFFERS"] && $arParams["TYPE_SKU"] === 'TYPE_1' && !$arResult["OFFERS_PROP"])):?>
                                <div class="compare_item_button">
                                    <span class="compare_item to" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arResult["ID"]?>" ><i></i><div><?=GetMessage('CATALOG_COMPARE')?></div></span>
                                    <span class="compare_item in added" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arResult["ID"]?>"><i></i><div><?=GetMessage('CATALOG_COMPARE_OUT')?></div></span>
                                </div>
                            <?elseif($arResult["OFFERS"]):?>
                                <div class="compare_item_button">
                                    <span class="compare_item to <?=$arParams["TYPE_SKU"];?>" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="" ><i></i><div><?=GetMessage('CATALOG_COMPARE')?></div></span>
                                    <span class="compare_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item=""><i></i><div><?=GetMessage('CATALOG_COMPARE_OUT')?></div></span>
                                </div>
                            <?endif;?>
                        <?endif;?>
                    </div>
                </div>
            <?endif;?>
            <?$frame->end();?>

        </div>
    </div>
    <div class="right_info">
        <div class="info_item scrollbar">
            <div class="title hidden"><a href="<?=$arResult["DETAIL_PAGE_URL"];?>" class="dark_link"><?=$elementName;?></a></div>
            <div class="top_info">

                <?//if(strlen($arResult["DETAIL_TEXT"])):?>
                <div class="preview_text"><?//=$arResult["DETAIL_TEXT"]?>
                    <div class="tabs_section">
                        <?
                        $showProps = false;
                        if($arResult["DISPLAY_PROPERTIES"]){
                            foreach($arResult["DISPLAY_PROPERTIES"] as $arProp){
                                if(!in_array($arProp["CODE"], array("SERVICES", "BRAND", "HIT", "RECOMMEND", "NEW", "STOCK", "VIDEO", "VIDEO_YOUTUBE", "CML2_ARTICLE"))){
                                    if(!is_array($arProp["DISPLAY_VALUE"])){
                                        $arProp["DISPLAY_VALUE"] = array($arProp["DISPLAY_VALUE"]);
                                    }
                                    if(is_array($arProp["DISPLAY_VALUE"])){
                                        foreach($arProp["DISPLAY_VALUE"] as $value){
                                            if(strlen($value)){
                                                $showProps = true;
                                                break 2;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if(!$showProps && $arResult['OFFERS']){
                            foreach($arResult['OFFERS'] as $arOffer){
                                foreach($arOffer['DISPLAY_PROPERTIES'] as $arProp){
                                    if(!$arResult["TMP_OFFERS_PROP"][$arProp['CODE']])
                                    {
                                        if(!is_array($arProp["DISPLAY_VALUE"]))
                                            $arProp["DISPLAY_VALUE"] = array($arProp["DISPLAY_VALUE"]);

                                        foreach($arProp["DISPLAY_VALUE"] as $value)
                                        {
                                            if(strlen($value))
                                            {
                                                $showProps = true;
                                                break 3;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if($showProps && !$arResult["GROUPS_PROPS"])
                            $showProps = false;

                        $arVideo = array();
                        if(strlen($arResult["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"])){
                            $arVideo[] = $arResult["DISPLAY_PROPERTIES"]["VIDEO"]["~VALUE"];
                        }
                        if(isset($arResult["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["VALUE"])){
                            if(is_array($arResult["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["VALUE"])){
                                $arVideo = $arVideo + $arResult["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["~VALUE"];
                            }
                            elseif(strlen($arResult["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["VALUE"])){
                                $arVideo[] = $arResult["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["~VALUE"];
                            }
                        }
                        if(strlen($arResult["SECTION_FULL"]["UF_VIDEO"])){
                            $arVideo[] = $arResult["SECTION_FULL"]["~UF_VIDEO"];
                        }
                        if(strlen($arResult["SECTION_FULL"]["UF_VIDEO_YOUTUBE"])){
                            $arVideo[] = $arResult["SECTION_FULL"]["~UF_VIDEO_YOUTUBE"];
                        }
                        ?>
                        <?
                        //kk-->
                        $showProps = false;
                        //<--kk
                        ?>
                        <div class="tabs">
                            <ul class="nav nav-tabs">
                                <?$iTab = 0;?>
                                <?$instr_prop = ($arParams["DETAIL_DOCS_PROP"] ? $arParams["DETAIL_DOCS_PROP"] : "INSTRUCTIONS");?>

                                <?if(!empty($arResult["PROPERTIES"]["TEXT_PREIMUSHCHESTVA"]["VALUE"])):?>
                                    <li class="product_preimushchestva_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#preimushchestva" data-toggle="tab"><span><?=GetMessage("PREI_TAB")?></span><span class="count empty"></span></a>
                                    </li>
                                <?endif;?>
                                <?php
                                //проверка наличия значений
                                $ser = false;$har = false;
                                $usl = false;
                                $treb = false;
                                $doc = false;
                                $ser = false;
                                foreach ($arResult["PROPERTIES"] as $itemPropOf)
                                {
                                    $razdelP = "";
                                    $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_CODE_PROP'=>$itemPropOf['CODE']];
                                    $arSelectP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_CODE_PROP','PROPERTY_ED_IZM','PROPERTY_RAZDEL'];
                                    $resP = CIBlockElement::GetList(array(),$arFilterP,false,false,$arSelectP);
                                    while($itemResP = $resP->Fetch())
                                    {
                                        $razdelP = $itemResP['PROPERTY_RAZDEL_VALUE'];
                                    }
                                    if ($razdelP=="Требования")
                                    {
                                        if (strlen($itemPropOf['VALUE']) > 0 || count($itemPropOf['VALUE']) > 1) {
                                            $treb = true;
                                        }
                                    }//if ($razdelP=="Требования")
                                    if ($razdelP=="Условия")
                                    {
                                        if (strlen($itemPropOf['VALUE']) > 0 || count($itemPropOf['VALUE']) > 1) {
                                            $usl = true;
                                        }
                                    }//if ($razdelP=="Условия")
                                    if ($razdelP=="Характеристики")
                                    {
                                        if (strlen($itemPropOf['VALUE']) > 0 || count($itemPropOf['VALUE']) > 1) {
                                            $har = true;
                                        }
                                    }//if ($razdelP=="Характеристики")
                                    if ($razdelP=="Документы")
                                    {
                                        if (strlen($itemPropOf['VALUE']) > 0 || count($itemPropOf['VALUE']) > 1) {
                                            $doc = true;
                                        }
                                    }//if ($razdelP=="Документы")
                                    if ($razdelP=="Сервисы")
                                    {
                                        if (strlen($itemPropOf['VALUE']) > 0 || count($itemPropOf['VALUE']) > 1) {
                                            $ser = true;
                                        }
                                    }//if ($razdelP=="Сервисы")
                                }//foreach ($arResult["PROPERTIES"] as $itemPropOf)
                                ?>
                                <?if($har):?>
                                    <li class="product_documents_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#har" data-toggle="tab"><span><?=GetMessage("TR_HAR")?></span><span class="count empty"></span></a>
                                    </li>
                                <?endif;?>
                                <?if($usl):?>
                                    <li class="product_documents_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#usl" data-toggle="tab"><span><?=GetMessage("TR_USL")?></span><span class="count empty"></span></a>
                                    </li>
                                <?endif;?>
                                <?if($treb):?>
                                    <li class="product_documents_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#treb" data-toggle="tab"><span><?=GetMessage("TR_TAB")?></span><span class="count empty"></span></a>
                                    </li>
                                <?endif;?>
                                <?if($doc):?>
                                    <li class="product_documents_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#doc" data-toggle="tab"><span><?=GetMessage("TR_DOC")?></span><span class="count empty"></span></a>
                                    </li>
                                <?endif;?>
                                <?if($ser):?>
                                    <li class="product_documents_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#ser" data-toggle="tab"><span><?=GetMessage("TR_SER")?></span><span class="count empty"></span></a>
                                    </li>
                                <?endif;?>

                                <?if($arResult["OFFERS"] && $arParams["TYPE_SKU"]=="N"):?>
                                    <li class="prices_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#prices_offer" data-toggle="tab"><span><?=($arParams["TAB_OFFERS_NAME"] ? $arParams["TAB_OFFERS_NAME"] : GetMessage("OFFER_PRICES"));?></span></a>
                                    </li>
                                <?endif;?>
                                <?if($arResult["DETAIL_TEXT"] || $arResult['ADDITIONAL_GALLERY'] || count($arResult["SERVICES"]) || ((count($arResult["PROPERTIES"][$instr_prop]["VALUE"]) && is_array($arResult["PROPERTIES"][$instr_prop]["VALUE"])) || count($arResult["SECTION_FULL"]["UF_FILES"])) || ($showProps && $arParams["PROPERTIES_DISPLAY_LOCATION"] != "TAB")):?>
                                    <li class="<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#descr" data-toggle="tab"><span><?=($arParams["TAB_DESCR_NAME"] ? $arParams["TAB_DESCR_NAME"] : GetMessage("DESCRIPTION_TAB"));?></span></a>
                                    </li>
                                <?endif;?>
                                <?if($arParams["PROPERTIES_DISPLAY_LOCATION"] == "TAB" && $showProps):?>
                                    <li class="<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#props" data-toggle="tab"><span><?=($arParams["TAB_CHAR_NAME"] ? $arParams["TAB_CHAR_NAME"] : GetMessage("PROPERTIES_TAB"));?></span></a>
                                    </li>
                                <?endif;?>
                                <?if($arVideo):?>
                                    <li class="<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#video" data-toggle="tab">
                                            <span><?=($arParams["TAB_VIDEO_NAME"] ? $arParams["TAB_VIDEO_NAME"] : GetMessage("VIDEO_TAB"));?></span>
                                            <?if(count($arVideo) > 1):?>
                                                <span class="count empty">&nbsp;(<?=count($arVideo)?>)</span>
                                            <?endif;?>
                                        </a>
                                    </li>
                                <?endif;?>
                                <?//if($arParams["USE_REVIEW"] == "Y"):?>
                                <!--<li class="product_reviews_tab<?//=(!($iTab++) ? ' active' : '')?>">
					<a href="#review" data-toggle="tab"><span><?//=($arParams["TAB_REVIEW_NAME"] ? $arParams["TAB_REVIEW_NAME"] : GetMessage("REVIEW_TAB"))?></span><span class="count empty"></span></a>
				</li>-->



                                <?//endif;?>
                                <?if($useStores && ($showCustomOffer || !$arResult["OFFERS"] )):?>
                                    <li class="stores_tab<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#stores" data-toggle="tab"><span><?=($arParams["TAB_STOCK_NAME"] ? $arParams["TAB_STOCK_NAME"] : GetMessage("STORES_TAB"));?></span></a>
                                    </li>
                                <?endif;?>
                                <?if($arParams["SHOW_ADDITIONAL_TAB"] == "Y"):?>
                                    <li class="<?=(!($iTab++) ? ' active' : '')?>">
                                        <a href="#dops" data-toggle="tab"><span><?=($arParams["TAB_DOPS_NAME"] ? $arParams["TAB_DOPS_NAME"] : GetMessage("ADDITIONAL_TAB"));?></span></a>
                                    </li>
                                <?endif;?>
                            </ul>
                            <div class="tab-content" style="font-size: 13px; line-height: 15px;">
                                <?$show_tabs = false;?>
                                <?$iTab = 0;?>
                                <?
                                $showSkUName = ((in_array('NAME', $arParams['OFFERS_FIELD_CODE'])));
                                $showSkUImages = false;
                                if(((in_array('PREVIEW_PICTURE', $arParams['OFFERS_FIELD_CODE']) || in_array('DETAIL_PICTURE', $arParams['OFFERS_FIELD_CODE'])))){
                                    foreach ($arResult["OFFERS"] as $key => $arSKU){
                                        if($arSKU['PREVIEW_PICTURE'] || $arSKU['DETAIL_PICTURE']){
                                            $showSkUImages = true;
                                            break;
                                        }
                                    }
                                }?>
                                <?if($arResult["OFFERS"] && $arParams["TYPE_SKU"] !== "TYPE_1"):?>
                                    <script>
                                        $(document).ready(function() {
                                            $('.catalog_detail .tabs_section .tabs_content .form.inline input[data-sid="PRODUCT_NAME"]').attr('value', $('h1').text());
                                        });
                                    </script>
                                <?endif;?>
                                <?if($arResult["OFFERS"] && $arParams["TYPE_SKU"] !== "TYPE_1"):?>
                                    <div class="tab-pane prices_tab<?=(!($iTab++) ? ' active' : '')?>" id="prices_offer">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_OFFERS_NAME"] ? $arParams["TAB_OFFERS_NAME"] : GetMessage("OFFER_PRICES"));?></div>
                                        <div>
                                            <div class="bx_sku_props" style="display:none;">
                                                <?$arSkuKeysProp='';
                                                $propSKU=$arParams["OFFERS_CART_PROPERTIES"];
                                                if($propSKU){
                                                    $arSkuKeysProp=base64_encode(serialize(array_keys($propSKU)));
                                                }?>
                                                <input type="hidden" value="<?=$arSkuKeysProp;?>"></input>
                                            </div>
                                            <table class="offers_table">
                                                <thead>
                                                <tr>
                                                    <?if($useStores):?>
                                                        <td class="str"></td>
                                                    <?endif;?>
                                                    <?if($showSkUImages):?>
                                                        <td class="property img" width="50"></td>
                                                    <?endif;?>
                                                    <?if($showSkUName):?>
                                                        <td class="property names"><?=GetMessage("CATALOG_NAME")?></td>
                                                    <?endif;?>
                                                    <?if($arResult["SKU_PROPERTIES"]){
                                                        foreach ($arResult["SKU_PROPERTIES"] as $key => $arProp){?>
                                                            <?if(!$arProp["IS_EMPTY"]):?>
                                                                <td class="property">
                                                                    <div class="props_item char_name <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
                                                                        <?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
                                                                        <span><?=$arProp["NAME"]?></span>
                                                                    </div>
                                                                </td>
                                                            <?endif;?>
                                                        <?}
                                                    }?>
                                                    <td class="price_th"><?=GetMessage("CATALOG_PRICE")?></td>
                                                    <?if($arQuantityData["RIGHTS"]["SHOW_QUANTITY"]):?>
                                                        <td class="count_th"><?=GetMessage("AVAILABLE")?></td>
                                                    <?endif;?>
                                                    <?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"  || $arParams["DISPLAY_COMPARE"] == "Y"):?>
                                                        <td class="like_icons_th"></td>
                                                    <?endif;?>
                                                    <td colspan="3"></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?$numProps = count($arResult["SKU_PROPERTIES"]);
                                                if($arResult["OFFERS"]){
                                                    foreach ($arResult["OFFERS"] as $key => $arSKU){?>
                                                        <?
                                                        if($arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]){
                                                            $sMeasure = $arResult["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"].".";
                                                        }
                                                        else{
                                                            $sMeasure = GetMessage("MEASURE_DEFAULT").".";
                                                        }
                                                        $skutotalCount = CNext::GetTotalCount($arSKU, $arParams);
                                                        $arskuQuantityData = CNext::GetQuantityArray($skutotalCount, array('quantity-wrapp', 'quantity-indicators'));
                                                        $arSKU["IBLOCK_ID"]=$arResult["IBLOCK_ID"];
                                                        $arSKU["IS_OFFER"]="Y";
                                                        $arskuAddToBasketData = CNext::GetAddToBasketArray($arSKU, $skutotalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], true, array(), 'small w_icons', $arParams);
                                                        $arskuAddToBasketData["HTML"] = str_replace('data-item', 'data-props="'.$arOfferProps.'" data-item', $arskuAddToBasketData["HTML"]);
                                                        ?>
                                                        <?$collspan = 1;?>
                                                        <tr class="main_item_wrapper" id="<?=$this->GetEditAreaId($arSKU["ID"]);?>">
                                                            <?if($useStores):?>
                                                                <td class="opener top">
                                                                    <?$collspan++;?>
                                                                    <span class="opener_icon"><i></i></span>
                                                                </td>
                                                            <?endif;?>
                                                            <?if($showSkUImages):?>
                                                                <?$collspan++;?>
                                                                <td class="property">
                                                                    <?
                                                                    $srcImgPreview = $srcImgDetail = false;
                                                                    $imgPreviewID = ($arResult['OFFERS'][$key]['PREVIEW_PICTURE'] ? (is_array($arResult['OFFERS'][$key]['PREVIEW_PICTURE']) ? $arResult['OFFERS'][$key]['PREVIEW_PICTURE']['ID'] : $arResult['OFFERS'][$key]['PREVIEW_PICTURE']) : false);
                                                                    $imgDetailID = ($arResult['OFFERS'][$key]['DETAIL_PICTURE'] ? (is_array($arResult['OFFERS'][$key]['DETAIL_PICTURE']) ? $arResult['OFFERS'][$key]['DETAIL_PICTURE']['ID'] : $arResult['OFFERS'][$key]['DETAIL_PICTURE']) : false);
                                                                    if($imgPreviewID || $imgDetailID){
                                                                        $arImgPreview = CFile::ResizeImageGet($imgPreviewID ? $imgPreviewID : $imgDetailID, array('width' => 50, 'height' => 50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                                                                        $srcImgPreview = $arImgPreview['src'];
                                                                    }
                                                                    if($imgDetailID){
                                                                        $srcImgDetail = CFile::GetPath($imgDetailID);
                                                                    }
                                                                    ?>
                                                                    <?if($srcImgPreview || $srcImgDetail):?>
                                                                        <a href="<?=($srcImgDetail ? $srcImgDetail : $srcImgPreview)?>" class="fancy" data-fancybox-group="item_slider"><img src="<?=$srcImgPreview?>" alt="<?=$arSKU['NAME']?>" /></a>
                                                                    <?endif;?>
                                                                </td>
                                                            <?endif;?>
                                                            <?if($showSkUName):?>
                                                                <?$collspan++;?>
                                                                <td class="property names"><?=$arSKU['NAME']?></td>
                                                            <?endif;?>
                                                            <?foreach( $arResult["SKU_PROPERTIES"] as $arProp ){?>
                                                                <?if(!$arProp["IS_EMPTY"]):?>
                                                                    <?$collspan++;?>
                                                                    <td class="property">
                                                                        <?if($arResult["TMP_OFFERS_PROP"][$arProp["CODE"]]){
                                                                            echo $arResult["TMP_OFFERS_PROP"][$arProp["CODE"]]["VALUES"][$arSKU["TREE"]["PROP_".$arProp["ID"]]]["NAME"];?>
                                                                        <?}else{
                                                                            if (is_array($arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"])){
                                                                                echo implode("/", $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"]);
                                                                            }else{
                                                                                if($arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE"]=="directory" && isset($arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE_SETTINGS"]["TABLE_NAME"])){
                                                                                    $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('=TABLE_NAME'=>$arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE_SETTINGS"]["TABLE_NAME"])));
                                                                                    if ($arData = $rsData->fetch()){
                                                                                        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
                                                                                        $entityDataClass = $entity->getDataClass();
                                                                                        $arFilter = array(
                                                                                            'limit' => 1,
                                                                                            'filter' => array(
                                                                                                '=UF_XML_ID' => $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"]
                                                                                            )
                                                                                        );
                                                                                        $arValue = $entityDataClass::getList($arFilter)->fetch();
                                                                                        if(isset($arValue["UF_NAME"]) && $arValue["UF_NAME"]){
                                                                                            echo $arValue["UF_NAME"];
                                                                                        }else{
                                                                                            echo $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"];
                                                                                        }
                                                                                    }
                                                                                }else{
                                                                                    echo $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"];
                                                                                }
                                                                            }
                                                                        }?>
                                                                    </td>
                                                                <?endif;?>
                                                            <?}?>
                                                            <td class="price">
                                                                <div class="cost prices clearfix">
                                                                    <?
                                                                    $collspan++;
                                                                    $arCountPricesCanAccess = 0;
                                                                    if(isset($arSKU['PRICE_MATRIX']) && $arSKU['PRICE_MATRIX'] && count($arSKU['PRICE_MATRIX']['ROWS']) > 1) // USE_PRICE_COUNT
                                                                    {?>
                                                                        <?=CNext::showPriceRangeTop($arSKU, $arParams, GetMessage("CATALOG_ECONOMY"));?>
                                                                        <?echo CNext::showPriceMatrix($arSKU, $arParams, $arSKU["CATALOG_MEASURE_NAME"]);
                                                                    }
                                                                    else
                                                                    {?>
                                                                        <?\Aspro\Functions\CAsproItem::showItemPrices($arParams, $arSKU["PRICES"], $arSKU["CATALOG_MEASURE_NAME"], $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));?>
                                                                    <?}?>
                                                                </div>
                                                            </td>
                                                            <?if(strlen($arskuQuantityData["TEXT"])):?>
                                                                <?$collspan++;?>
                                                                <td class="count">
                                                                    <?=$arskuQuantityData["HTML"]?>
                                                                </td>
                                                            <?endif;?>
                                                            <!--noindex-->
                                                            <?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"  || $arParams["DISPLAY_COMPARE"] == "Y"):?>
                                                                <td class="like_icons">
                                                                    <?$collspan++;?>
                                                                    <?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"):?>
                                                                        <?if($arskuAddToBasketData['CAN_BUY']):?>
                                                                            <div class="wish_item_button o_<?=$arSKU["ID"];?>">
                                                                                <span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item text to <?=$arParams["TYPE_SKU"];?>" data-item="<?=$arSKU["ID"]?>" data-iblock="<?=$arResult["IBLOCK_ID"]?>" data-offers="Y" data-props="<?=$arOfferProps?>"><i></i></span>
                                                                                <span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item text in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-item="<?=$arSKU["ID"]?>" data-iblock="<?=$arSKU["IBLOCK_ID"]?>"><i></i></span>
                                                                            </div>
                                                                        <?endif;?>
                                                                    <?endif;?>
                                                                    <?if($arParams["DISPLAY_COMPARE"] == "Y"):?>
                                                                        <div class="compare_item_button o_<?=$arSKU["ID"];?>">
                                                                            <span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to text <?=$arParams["TYPE_SKU"];?>" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arSKU["ID"]?>" ><i></i></span>
                                                                            <span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added text <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arSKU["ID"]?>"><i></i></span>
                                                                        </div>
                                                                    <?endif;?>
                                                                </td>
                                                            <?endif;?>
                                                            <?if($arskuAddToBasketData["ACTION"] == "ADD"):?>
                                                                <?if($arskuAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] && !count($arSKU["OFFERS"]) && $arskuAddToBasketData["ACTION"] == "ADD" && $arskuAddToBasketData["CAN_BUY"]):?>
                                                                    <td class="counter_wrapp counter_block_wr">
                                                                        <div class="counter_block" data-item="<?=$arSKU["ID"];?>">
                                                                            <?$collspan++;?>
                                                                            <span class="minus">-</span>
                                                                            <input type="text" class="text" name="quantity" value="<?=$arskuAddToBasketData["MIN_QUANTITY_BUY"];?>" />
                                                                            <span class="plus">+</span>
                                                                        </div>
                                                                    </td>
                                                                <?endif;?>
                                                            <?endif;?>
                                                            <?if(isset($arSKU['PRICE_MATRIX']) && $arSKU['PRICE_MATRIX'] && count($arSKU['PRICE_MATRIX']['ROWS']) > 1) // USE_PRICE_COUNT
                                                            {?>
                                                                <?$arOnlyItemJSParams = array(
                                                                "ITEM_PRICES" => $arSKU["ITEM_PRICES"],
                                                                "ITEM_PRICE_MODE" => $arSKU["ITEM_PRICE_MODE"],
                                                                "ITEM_QUANTITY_RANGES" => $arSKU["ITEM_QUANTITY_RANGES"],
                                                                "MIN_QUANTITY_BUY" => $arskuAddToBasketData["MIN_QUANTITY_BUY"],
                                                                "SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
                                                                "ID" => $this->GetEditAreaId($arSKU["ID"]),
                                                            )?>
                                                                <script type="text/javascript">
                                                                    var ob<? echo $this->GetEditAreaId($arSKU["ID"]); ?>el = new JCCatalogOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
                                                                </script>
                                                            <?}?>
                                                            <td class="buy" <?=($arskuAddToBasketData["ACTION"] !== "ADD" || !$arskuAddToBasketData["CAN_BUY"] || $arParams["SHOW_ONE_CLICK_BUY"]=="N" ? 'colspan="3"' : "")?>>
                                                                <?if($arskuAddToBasketData["ACTION"] !== "ADD"  || !$arskuAddToBasketData["CAN_BUY"]):?>
                                                                    <?$collspan += 3;?>
                                                                <?else:?>
                                                                    <?$collspan++;?>
                                                                <?endif;?>
                                                                <div class="counter_wrapp">
                                                                    <?=$arskuAddToBasketData["HTML"]?>
                                                                </div>
                                                            </td>
                                                            <?if($arskuAddToBasketData["ACTION"] == "ADD" && $arskuAddToBasketData["CAN_BUY"] && $arParams["SHOW_ONE_CLICK_BUY"]!="N"):?>
                                                                <td class="one_click_buy">
                                                                    <?$collspan++;?>
                                                                    <span class="btn btn-default white one_click" data-item="<?=$arSKU["ID"]?>" data-offers="Y" data-iblockID="<?=$arParams["IBLOCK_ID"]?>" data-quantity="<?=$arskuAddToBasketData["MIN_QUANTITY_BUY"];?>" data-props="<?=$arOfferProps?>" onclick="oneClickBuy('<?=$arSKU["ID"]?>', '<?=$arParams["IBLOCK_ID"]?>', this)">
														<span><?=GetMessage('ONE_CLICK_BUY')?></span>
													</span>
                                                                </td>
                                                            <?endif;?>
                                                            <!--/noindex-->
                                                            <?if($useStores):?>
                                                                <td class="opener bottom">
                                                                    <?$collspan++;?>
                                                                    <span class="opener_icon"><i></i></span>
                                                                </td>
                                                            <?endif;?>
                                                        </tr>
                                                        <?if($useStores):?>
                                                            <?$collspan--;?>
                                                            <tr class="offer_stores"><td colspan="<?=$collspan?>">
                                                                    <?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "main", array(
                                                                        "PER_PAGE" => "10",
                                                                        "USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
                                                                        "SCHEDULE" => $arParams["SCHEDULE"],
                                                                        "USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
                                                                        "MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
                                                                        "ELEMENT_ID" => $arSKU["ID"],
                                                                        "STORE_PATH"  =>  $arParams["STORE_PATH"],
                                                                        "MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
                                                                        "MAX_AMOUNT"=>$arParams["MAX_AMOUNT"],
                                                                        "SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
                                                                        "SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
                                                                        "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
                                                                        "USER_FIELDS" => $arParams['USER_FIELDS'],
                                                                        "FIELDS" => $arParams['FIELDS'],
                                                                        "STORES" => $arParams['STORES'],
                                                                        "CACHE_TYPE" => "A",
                                                                        "SET_ITEMS" => $arResult["SET_ITEMS"],
                                                                    ),
                                                                        $component
                                                                    );?>
                                                            </tr>
                                                        <?endif;?>
                                                    <?}
                                                }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?endif;?>
                                <?$strGrupperType = $arParams["GRUPPER_PROPS"];?>
                                <?if($arResult["DETAIL_TEXT"] || count($arResult["SERVICES"]) || ((count($arResult["PROPERTIES"][$instr_prop]["VALUE"]) && is_array($arResult["PROPERTIES"][$instr_prop]["VALUE"])) || $arResult['ADDITIONAL_GALLERY'] || count($arResult["SECTION_FULL"]["UF_FILES"])) || ($showProps && $arParams["PROPERTIES_DISPLAY_LOCATION"] != "TAB")):?>
                                    <div class="tab-pane <?=(!($iTab++) ? ' active' : '')?>" id="descr">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_DESCR_NAME"] ? $arParams["TAB_DESCR_NAME"] : GetMessage("DESCRIPTION_TAB"));?></div>
                                        <div>
                                            <?if(strlen($arResult["DETAIL_TEXT"])):?>
                                                <div class="detail_text"><?=$arResult["DETAIL_TEXT"]?></div>
                                            <?endif;?>
                                            <?if($showProps && $arParams["PROPERTIES_DISPLAY_LOCATION"] != "TAB"):?>
                                                <div class="wraps">
                                                    <hr>
                                                    <h4><?=($arParams["TAB_CHAR_NAME"] ? $arParams["TAB_CHAR_NAME"] : GetMessage("PROPERTIES_TAB"));?></h4>
                                                    <?if($strGrupperType == "GRUPPER"):?>
                                                        <div class="char_block">
                                                            <?$APPLICATION->IncludeComponent(
                                                                "redsign:grupper.list",
                                                                "",
                                                                Array(
                                                                    "CACHE_TIME" => "3600000",
                                                                    "CACHE_TYPE" => "A",
                                                                    "COMPOSITE_FRAME_MODE" => "A",
                                                                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                                                                    "DISPLAY_PROPERTIES" => $arResult["GROUPS_PROPS"]
                                                                ),
                                                                $component, array('HIDE_ICONS'=>'Y')
                                                            );?>
                                                            <table class="props_list" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                        </div>
                                                    <?elseif($strGrupperType == "WEBDEBUG"):?>
                                                        <div class="char_block">
                                                            <?$APPLICATION->IncludeComponent(
                                                                "webdebug:propsorter",
                                                                "linear",
                                                                array(
                                                                    "IBLOCK_TYPE" => $arResult['IBLOCK_TYPE'],
                                                                    "IBLOCK_ID" => $arResult['IBLOCK_ID'],
                                                                    "PROPERTIES" => $arResult['GROUPS_PROPS'],
                                                                    "EXCLUDE_PROPERTIES" => array(),
                                                                    "WARNING_IF_EMPTY" => "N",
                                                                    "WARNING_IF_EMPTY_TEXT" => "",
                                                                    "NOGROUP_SHOW" => "Y",
                                                                    "NOGROUP_NAME" => "",
                                                                    "MULTIPLE_SEPARATOR" => ", "
                                                                ),
                                                                $component, array('HIDE_ICONS'=>'Y')
                                                            );?>
                                                            <table class="props_list" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                        </div>
                                                    <?elseif($strGrupperType == "YENISITE_GRUPPER"):?>
                                                        <div class="char_block">
                                                            <?$APPLICATION->IncludeComponent(
                                                                'yenisite:ipep.props_groups',
                                                                '',
                                                                array(
                                                                    'DISPLAY_PROPERTIES' => $arResult['GROUPS_PROPS'],
                                                                    'IBLOCK_ID' => $arParams['IBLOCK_ID']
                                                                ),
                                                                $component, array('HIDE_ICONS'=>'Y')
                                                            )?>
                                                            <table class="props_list colored_char" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                        </div>
                                                    <?else:?>
                                                        <?if($arParams["PROPERTIES_DISPLAY_TYPE"] != "TABLE"):?>
                                                            <div class="props_block" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>">
                                                                <?foreach($arResult["PROPERTIES"] as $propCode => $arProp):?>
                                                                    <?if(isset($arResult["DISPLAY_PROPERTIES"][$propCode])):?>
                                                                        <?$arProp = $arResult["DISPLAY_PROPERTIES"][$propCode];?>
                                                                        <?if(!in_array($arProp["CODE"], array("SERVICES", "BRAND", "HIT", "RECOMMEND", "NEW", "STOCK", "VIDEO", "VIDEO_YOUTUBE", "CML2_ARTICLE"))):?>
                                                                            <?if((!is_array($arProp["DISPLAY_VALUE"]) && strlen($arProp["DISPLAY_VALUE"])) || (is_array($arProp["DISPLAY_VALUE"]) && implode('', $arProp["DISPLAY_VALUE"]))):?>
                                                                                <div class="char" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                                                                    <div class="char_name">
                                                                                        <?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
                                                                                        <div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
                                                                                            <span itemprop="name"><?=$arProp["NAME"]?></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="char_value" itemprop="value">
                                                                                        <?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
                                                                                            <?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
                                                                                        <?else:?>
                                                                                            <?=$arProp["DISPLAY_VALUE"];?>
                                                                                        <?endif;?>
                                                                                    </div>
                                                                                </div>
                                                                            <?endif;?>
                                                                        <?endif;?>
                                                                    <?endif;?>
                                                                <?endforeach;?>
                                                            </div>
                                                        <?else:?>
                                                            <div class="char_block">
                                                                <table class="props_list">
                                                                    <?foreach($arResult["DISPLAY_PROPERTIES"] as $arProp):?>
                                                                        <?if(!in_array($arProp["CODE"], array("SERVICES", "BRAND", "HIT", "RECOMMEND", "NEW", "STOCK", "VIDEO", "VIDEO_YOUTUBE", "CML2_ARTICLE"))):?>
                                                                            <?if((!is_array($arProp["DISPLAY_VALUE"]) && strlen($arProp["DISPLAY_VALUE"])) || (is_array($arProp["DISPLAY_VALUE"]) && implode('', $arProp["DISPLAY_VALUE"]))):?>
                                                                                <tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                                                                    <td class="char_name">
                                                                                        <?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
                                                                                        <div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
                                                                                            <span itemprop="name"><?=$arProp["NAME"]?></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="char_value">
																	<span itemprop="value">
																		<?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
                                                                            <?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
                                                                        <?else:?>
                                                                            <?=$arProp["DISPLAY_VALUE"];?>
                                                                        <?endif;?>
																	</span>
                                                                                    </td>
                                                                                </tr>
                                                                            <?endif;?>
                                                                        <?endif;?>
                                                                    <?endforeach;?>
                                                                </table>
                                                                <table class="props_list" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                            </div>
                                                        <?endif;?>
                                                    <?endif;?>
                                                </div>
                                            <?endif;?>
                                            <?if($arResult["SERVICES"]):?>
                                                <?global $arrSaleFilter; $arrSaleFilter = array("ID" => $arResult["PROPERTIES"]["SERVICES"]["VALUE"]);?>
                                                <?$APPLICATION->IncludeComponent(
                                                    "bitrix:news.list",
                                                    "items-services",
                                                    array(
                                                        "IBLOCK_TYPE" => "aspro_next_content",
                                                        "IBLOCK_ID" => $arResult["PROPERTIES"]["SERVICES"]["LINK_IBLOCK_ID"],
                                                        "NEWS_COUNT" => "20",
                                                        "SORT_BY1" => "SORT",
                                                        "SORT_ORDER1" => "ASC",
                                                        "SORT_BY2" => "ID",
                                                        "SORT_ORDER2" => "DESC",
                                                        "FILTER_NAME" => "arrSaleFilter",
                                                        "FIELD_CODE" => array(
                                                            0 => "NAME",
                                                            1 => "PREVIEW_TEXT",
                                                            3 => "PREVIEW_PICTURE",
                                                            4 => "",
                                                        ),
                                                        "PROPERTY_CODE" => array(
                                                            0 => "PERIOD",
                                                            1 => "REDIRECT",
                                                            2 => "",
                                                        ),
                                                        "CHECK_DATES" => "Y",
                                                        "DETAIL_URL" => "",
                                                        "AJAX_MODE" => "N",
                                                        "AJAX_OPTION_JUMP" => "N",
                                                        "AJAX_OPTION_STYLE" => "Y",
                                                        "AJAX_OPTION_HISTORY" => "N",
                                                        "CACHE_TYPE" => "N",
                                                        "CACHE_TIME" => "36000000",
                                                        "CACHE_FILTER" => "Y",
                                                        "CACHE_GROUPS" => "N",
                                                        "PREVIEW_TRUNCATE_LEN" => "",
                                                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                                        "SET_TITLE" => "N",
                                                        "SET_STATUS_404" => "N",
                                                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                                        "ADD_SECTIONS_CHAIN" => "N",
                                                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                                        "PARENT_SECTION" => "",
                                                        "PARENT_SECTION_CODE" => "",
                                                        "INCLUDE_SUBSECTIONS" => "Y",
                                                        "PAGER_TEMPLATE" => ".default",
                                                        "DISPLAY_TOP_PAGER" => "N",
                                                        "DISPLAY_BOTTOM_PAGER" => "Y",
                                                        "PAGER_TITLE" => "�������",
                                                        "PAGER_SHOW_ALWAYS" => "N",
                                                        "PAGER_DESC_NUMBERING" => "N",
                                                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                                        "PAGER_SHOW_ALL" => "N",
                                                        "VIEW_TYPE" => "list",
                                                        "BIG_BLOCK" => "Y",
                                                        "IMAGE_POSITION" => "left",
                                                        "COUNT_IN_LINE" => ($arParams['HIDE_LEFT_BLOCK'] === 'Y' ? 2 : 1),
                                                        "TITLE" => ($arParams["BLOCK_SERVICES_NAME"] ? $arParams["BLOCK_SERVICES_NAME"] : GetMessage("SERVICES_TITLE")),
                                                    ),
                                                    $component, array("HIDE_ICONS" => "Y")
                                                );?>
                                            <?endif;?>
                                            <?
                                            $arFiles = array();
                                            if($arResult["PROPERTIES"][$instr_prop]["VALUE"]){
                                                $arFiles = $arResult["PROPERTIES"][$instr_prop]["VALUE"];
                                            }
                                            else{
                                                $arFiles = $arResult["SECTION_FULL"]["UF_FILES"];
                                            }
                                            if(is_array($arFiles)){
                                                foreach($arFiles as $key => $value){
                                                    if(!intval($value)){
                                                        unset($arFiles[$key]);
                                                    }
                                                }
                                            }
                                            ?>
                                            <?if($arFiles):?>
                                                <div class="wraps">
                                                    <hr>
                                                    <h4><?=($arParams["BLOCK_DOCS_NAME"] ? $arParams["BLOCK_DOCS_NAME"] : GetMessage("DOCUMENTS_TITLE"))?></h4>
                                                    <div class="files_block">
                                                        <div class="row flexbox">
                                                            <?foreach($arFiles as $arItem):?>
                                                                <div class="col-md-3 col-sm-6">
                                                                    <?$arFile=CNext::GetFileInfo($arItem);?>
                                                                    <div class="file_type clearfix <?=$arFile["TYPE"];?>">
                                                                        <i class="icon"></i>
                                                                        <div class="description">
                                                                            <a target="_blank" href="<?=$arFile["SRC"];?>" class="dark_link"><?=$arFile["DESCRIPTION"];?></a>
                                                                            <span class="size">
															<?=$arFile["FILE_SIZE_FORMAT"];?>
														</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?endforeach;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?endif;?>
                                            <?if($arResult['ADDITIONAL_GALLERY']):?>
                                                <div class="wraps galerys-block with-padding<?=($arResult['OFFERS'] && 'TYPE_1' === $arParams['TYPE_SKU'] ? ' hidden' : '')?>">
                                                    <hr>
                                                    <h4><?=($arParams["BLOCK_ADDITIONAL_GALLERY_NAME"] ? $arParams["BLOCK_ADDITIONAL_GALLERY_NAME"] : GetMessage("ADDITIONAL_GALLERY_TITLE"))?></h4>
                                                    <?if($arParams['ADDITIONAL_GALLERY_TYPE'] === 'SMALL'):?>
                                                        <div class="small-gallery-block">
                                                            <div class="flexslider unstyled front border small_slider custom_flex top_right color-controls" data-plugin-options='{"animation": "slide", "useCSS": true, "directionNav": true, "controlNav" :true, "animationLoop": true, "slideshow": false, "counts": [4, 3, 2, 1]}'>
                                                                <ul class="slides items">
                                                                    <?if(!$arResult['OFFERS'] || 'TYPE_1' !== $arParams['TYPE_SKU']):?>
                                                                        <?foreach($arResult['ADDITIONAL_GALLERY'] as $i => $arPhoto):?>
                                                                            <li class="col-md-3 item visible">
                                                                                <div>
                                                                                    <img src="<?=$arPhoto['PREVIEW']['src']?>" class="img-responsive inline" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
                                                                                </div>
                                                                                <a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy dark_block_animate" rel="gallery" target="_blank" title="<?=$arPhoto['TITLE']?>"></a>
                                                                            </li>
                                                                        <?endforeach;?>
                                                                    <?endif;?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    <?else:?>
                                                        <div class="gallery-block">
                                                            <div class="gallery-wrapper">
                                                                <div class="inner">
                                                                    <?if(count($arResult['ADDITIONAL_GALLERY']) > 1 || ($arResult['OFFERS'] && 'TYPE_1' === $arParams['TYPE_SKU'])):?>
                                                                        <div class="small-gallery-wrapper">
                                                                            <div class="flexslider unstyled small-gallery center-nav ethumbs" data-plugin-options='{"slideshow": false, "useCSS": true, "animation": "slide", "animationLoop": true, "itemWidth": 60, "itemMargin": 20, "minItems": 1, "maxItems": 9, "slide_counts": 1, "asNavFor": ".gallery-wrapper .bigs"}' id="carousel1">
                                                                                <ul class="slides items">
                                                                                    <?if(!$arResult['OFFERS'] || 'TYPE_1' !== $arParams['TYPE_SKU']):?>
                                                                                        <?foreach($arResult['ADDITIONAL_GALLERY'] as $arPhoto):?>
                                                                                            <li class="item">
                                                                                                <img class="img-responsive inline" border="0" src="<?=$arPhoto['THUMB']['src']?>" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
                                                                                            </li>
                                                                                        <?endforeach;?>
                                                                                    <?endif;?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    <?endif;?>
                                                                    <div class="flexslider big_slider dark bigs color-controls" id="slider" data-plugin-options='{"animation": "slide", "useCSS": true, "directionNav": true, "controlNav" :true, "animationLoop": true, "slideshow": false, "sync": "#carousel1"}'>
                                                                        <ul class="slides items">
                                                                            <?if(!$arResult['OFFERS'] || 'TYPE_1' !== $arParams['TYPE_SKU']):?>
                                                                                <?foreach($arResult['ADDITIONAL_GALLERY'] as $i => $arPhoto):?>
                                                                                    <li class="col-md-12 item">
                                                                                        <a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy" rel="gallery" target="_blank" title="<?=$arPhoto['TITLE']?>">
                                                                                            <img src="<?=$arPhoto['PREVIEW']['src']?>" class="img-responsive inline" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
                                                                                            <span class="zoom"></span>
                                                                                        </a>
                                                                                    </li>
                                                                                <?endforeach;?>
                                                                            <?endif;?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?endif;?>
                                                </div>
                                            <?endif;?>
                                        </div>
                                    </div>
                                <?endif;?>
                                <?if($arParams["USE_REVIEW"] == "Y"):?>
                                    <?if(!empty($arResult["PROPERTIES"]["TEXT_PREIMUSHCHESTVA"]["VALUE"])):?>
                                        <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="preimushchestva">
                                            <div class="title-tab-heading visible-xs">
                                                <?=GetMessage("PREI_TAB")?>
                                            </div>
                                            <div class="detail_text">
                                                <?
                                                $abz = explode ("\n",$arResult["PROPERTIES"]["TEXT_PREIMUSHCHESTVA"]["VALUE"]);
                                                for($i=0;$i<count($abz);$i++):?>
                                                    <?if(trim(strlen($abz[$i]))==0){continue;}?>
                                                    <?=$abz[$i]?><br>
                                                <?endfor;?>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <?
                                    #упорядочим свойства по признаку основной - НАЧАЛО
                                    $arrPropertiesMain  = array();
                                    $arrPropertiesOther = array();
                                    $arrProperties      = array();

                                    foreach ($arResult["PROPERTIES"] as $itemPropOf)
                                    {
                                        $arFilterPr = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_CODE_PROP'=>$itemPropOf['CODE'],'PROPERTY_INCLUDE_MAIN' => $arResult['SECTION']['ID']];
                                        $arSelectPr = ['ID','NAME'];
                                        $resPr = CIBlockElement::GetList(array(),$arFilterPr,false,false,$arSelectPr);
                                        if($itemPr = $resPr->Fetch())
                                        {
                                            $arrPropertiesMain[]  = $itemPropOf;
                                        }
                                        else
                                        {
                                            $arrPropertiesOther[] = $itemPropOf;
                                        }

                                    }//foreach ($arResult["PROPERTIES"] as $itemPropIdOsn)
                                    foreach ($arrPropertiesMain as $item)
                                    {
                                        $arrProperties[] = $item;
                                    }
                                    //see($arrPropertiesMain,true);
                                    foreach ($arrPropertiesOther as $item)
                                    {
                                        $arrProperties[] = $item;
                                    }
                                    #упорядочим свойства по признаку основной - КОНЕЦ
                                    ?>
                                    <?if($har):?>
                                        <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="har">
                                            <div class="title-tab-heading visible-xs">
                                                <?=GetMessage("TR_HAR")?>
                                            </div>
                                            <div class="detail_text">
                                                <table class="props_list">
                                                    <tbody>
                                                    <?//see($arResult["PROPERTIES"], true);?>
                                                    <?php
                                                    $start_property_nocontact = false;
                                                    $value_property_nocontact = "";
                                                    ?>
                                                    <?foreach ($arrProperties as $itemPropOf):?>
                                                        <?
                                                        $razdelP = "";
                                                        $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_CODE_PROP'=>$itemPropOf['CODE']];
                                                        $arSelectP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_CODE_PROP','PROPERTY_ED_IZM','PROPERTY_RAZDEL'];
                                                        $resP = CIBlockElement::GetList(array(),$arFilterP,false,false,$arSelectP);
                                                        while($itemResP = $resP->Fetch())
                                                        {
                                                            $razdelP = $itemResP['PROPERTY_RAZDEL_VALUE'];
                                                        }
                                                        if($razdelP == 'Характеристики')
                                                        {
                                                            if(strlen($itemPropOf['VALUE'])>0 || count($itemPropOf['VALUE'])>1):?>
                                                                <tr itemprop="additionalProperty">
                                                                    <td class="char_name">
                                                                        <div class="props_item ">
                                                                            <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                                <details>
                                                                                    <summary><span class="kk-tooltip listElement" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span></summary>
                                                                                    <?$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => 35, "CODE" => $itemPropOf['CODE']));
                                                                                    while($enum_fields = $property_enums->GetNext())
                                                                                    {
                                                                                        ?><div class="prop_row"><span><?
                                                                                            echo $enum_fields['VALUE']  . "</span><span class='yeaElementMutl'>";
                                                                                            $valuePropList = $enum_fields["VALUE"];

                                                                                            if(in_array($valuePropList, $itemPropOf['VALUE'])){

                                                                                                echo 'Да' . "" ;

                                                                                            }else{echo ' - ' . "" ;}
                                                                                            ?></span></div><?                                                              }
                                                                                    ?>

                                                                                </details>
                                                                            <?}
                                                                            else{
                                                                                ?><span class="kk-tooltip" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span>
                                                                                <?
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </td>
                                                                    <?$edIzm = getEdIzm($itemPropOf['CODE'],$itemPropOf['VALUE']);?>
                                                                    <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                        <td class="char_value" style="display:none;"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span>
                                                                    </td>
                                                                    <?}
                                                                    else{?>
                                                                        <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span>
                                                                        </td>
                                                                    <?}?>
                                                                </tr>
                                                                <?
                                                            endif;
                                                        }//if($razdelP == 'Характеристики')
                                                        ?>
                                                    <?endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <?if($usl):?>
                                        <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="usl">
                                            <div class="title-tab-heading visible-xs">
                                                <?=GetMessage("TR_USL")?>
                                            </div>
                                            <div class="detail_text">
                                                <table class="props_list">
                                                    <tbody>
                                                    <?foreach ($arrProperties as $itemPropOf):?>
                                                        <?
                                                        $razdelP = "";
                                                        $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_CODE_PROP'=>$itemPropOf['CODE']];
                                                        $arSelectP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_CODE_PROP','PROPERTY_ED_IZM','PROPERTY_RAZDEL'];
                                                        $resP = CIBlockElement::GetList(array(),$arFilterP,false,false,$arSelectP);
                                                        while($itemResP = $resP->Fetch())
                                                        {

                                                            $razdelP = $itemResP['PROPERTY_RAZDEL_VALUE'];
                                                        }
                                                        if($razdelP == 'Условия')
                                                        {

                                                            //see($itemPropOf, true );
                                                            if(strlen($itemPropOf['VALUE'])>0 || count($itemPropOf['VALUE'])>1 || is_array($itemPropOf['VALUE'])):?>

                                                                <tr itemprop="additionalProperty">
                                                                    <td class="char_name">
                                                                        <div class="props_item ">
                                                                            <!-- netwiz  выведение выпадающего списка множествееннх свойств. -->

                                                                            <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>

                                                                                <details open>
                                                                                    <summary><span class="kk-tooltip listElement" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span></summary>

                                                                                    <?$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => 35, "CODE" => $itemPropOf['CODE']));
                                                                                    while($enum_fields = $property_enums->GetNext())
                                                                                    {
                                                                                    $valuePropList = $enum_fields["VALUE"];
                                                                                    if(in_array($valuePropList, $itemPropOf['VALUE'])){
                                                                                    ?><div class="prop_row"><span><?
                                                                                            echo $enum_fields['VALUE']  . "</span><span class='yeaElementMutl'>";

                                                                                            echo 'Да' . "" ;
                                                                                            }else{?>
                                                                                    <div class="prop_row" style="display: none"><span><?
                                                                                            echo $enum_fields['VALUE']  . "</span><span class='yeaElementMutl'>";

                                                                                            echo '-' . "" ;;
                                                                                            }
                                                                                            ?></span></div><?
                                                                                            }?>

                                                                                </details>
                                                                            <?}

                                                                            elseif($itemPropOf['CODE'] == 'USLOVIYA_KREDIT_LIMIT' && $arResult['ORIGINAL_PARAMETERS']['SECTION_CODE'] == 'zaymy'){?>
                                                                                <span class="kk-tooltip" itemprop="name"><?='Сумма займа' ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span>
                                                                            <?}elseif($itemPropOf['CODE'] == 'USLOVIYA_M_PROTSENTNAYA_STAVKA_PROTSENT' && $arResult['ORIGINAL_PARAMETERS']['SECTION_CODE'] == 'zaymy'){?>
                                                                                <?//see($itemPropOf['CODE'], true);?>
                                                                                <span class="kk-tooltip" itemprop="name"><?='Ставка в день' ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span>

                                                                            <?}else{?>
                                                                                <span class="kk-tooltip" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span>
                                                                            <?}?>
                                                                        </div>
                                                                    </td>

                                                                    <?$edIzm = getEdIzm($itemPropOf['CODE'],$itemPropOf['VALUE']);?>
                                                                    <?php if($edIzm == 'руб.' && getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) > 999):?>
                                                                    <td class="char_value"><span itemprop="value"><?=formatToHuman(getObProp($itemPropOf['NAME'], round($itemPropOf['VALUE'])))?> <?=$edIzm?></span>
                                                                        <?elseif(is_array($itemPropOf['VALUE']) && $itemPropOf['MULTIPLE'] =='N'):?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], round($itemPropOf['VALUE'][0]) . '-' .  round($itemPropOf['VALUE'][1]))?> <?=$edIzm?></span>
                                                                        <?elseif($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'):?>
                                                                    <td class="char_value" style="display: none;"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span></td>
                                                                <?elseif($itemPropOf['CODE'] == 'USLOVIYA_SROK_KREDITA_LET'):?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE'] . ' ' . declension($itemPropOf['VALUE'], array('год', 'года', 'лет')))?> <?=$edIzm?></span>
                                                                        <?elseif($itemPropOf['CODE'] == 'SROK_ZAIMA'):?>
                                                                        <?if($itemPropOf['VALUE'] == 30 || $itemPropOf['VALUE'] == 31):?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], 1)?> <?echo 'мес.'?></span>
                                                                        <?elseif($itemPropOf['VALUE'] > 31 && $itemPropOf['VALUE'] < 365):?>
                                                                        <?$monthSrokZaim = intdiv($itemPropOf['VALUE'], 31);?>
                                                                        <?$daySrokZaim = $itemPropOf['VALUE'] % 31?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $monthSrokZaim)?> <?echo 'мес.' . ' '?><?= $daySrokZaim . ' ' . 'дн.'?></span>
                                                                        <?elseif($itemPropOf['VALUE'] == 365 || $itemPropOf['VALUE'] == 366):?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], 1)?> <?echo 'год'?></span>
                                                                        <?elseif($itemPropOf['VALUE'] > 366):?>
                                                                        <?$yearsSrokZaim = intdiv($itemPropOf['VALUE'], 365);?>
                                                                        <?$monthSrokZaim = $itemPropOf['VALUE'] % 12?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], declension($yearsSrokZaim, array('год', 'года', 'лет')))?><?= $monthSrokZaim . ' ' . 'мес.'?></span>
                                                                        <?else:?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE'])?> <?echo 'дн.'?></span>
                                                                        <?endif;?>
                                                                        <?php else:?>
                                                                    <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE'])?> <?=$edIzm?></span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?endif;
                                                        }//if($razdelP == 'Условия')
                                                        ?>
                                                    <?endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <?if($treb):?>
                                        <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="treb">
                                            <div class="title-tab-heading visible-xs">
                                                <?=GetMessage("TR_TAB")?>
                                            </div>
                                            <div class="detail_text">
                                                <table class="props_list">
                                                    <tbody>
                                                    <?foreach ($arrProperties as $itemPropOf):?>
                                                        <?
                                                        $razdelP = "";
                                                        $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_CODE_PROP'=>$itemPropOf['CODE']];
                                                        $arSelectP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_CODE_PROP','PROPERTY_ED_IZM','PROPERTY_RAZDEL'];
                                                        $resP = CIBlockElement::GetList(array(),$arFilterP,false,false,$arSelectP);
                                                        while($itemResP = $resP->Fetch())
                                                        {
                                                            $razdelP = $itemResP['PROPERTY_RAZDEL_VALUE'];
                                                        }
                                                        if($razdelP == 'Требования')
                                                        {
                                                            if(strlen($itemPropOf['VALUE'])>0 || count($itemPropOf['VALUE'])>1):?>
                                                                <tr itemprop="additionalProperty">
                                                                    <td class="char_name">
                                                                        <div class="props_item ">
                                                                            <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                                <details>
                                                                                    <summary><span class="kk-tooltip listElement" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span></summary>
                                                                                    <?$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => 35, "CODE" => $itemPropOf['CODE']));
                                                                                    while($enum_fields = $property_enums->GetNext())
                                                                                    {
                                                                                        ?><div class="prop_row"><span><?
                                                                                            echo $enum_fields['VALUE']  . "</span><span class='yeaElementMutl'>";
                                                                                            $valuePropList = $enum_fields["VALUE"];

                                                                                            if(in_array($valuePropList, $itemPropOf['VALUE'])){

                                                                                                echo 'Да' . "" ;

                                                                                            }else{echo ' - ' . "" ;}
                                                                                            ?></span></div><?                                                              }
                                                                                    ?>

                                                                                </details>
                                                                            <?}
                                                                            else{
                                                                                ?><span class="kk-tooltip" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span>
                                                                                <?
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </td>
                                                                    <?$edIzm = getEdIzm($itemPropOf['CODE'],$itemPropOf['VALUE']);?>
                                                                    <?if($edIzm == 'руб.' && getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) > 999){?>
                                                                        <td class="char_value"><span itemprop="value"><?=formatToHuman(getObProp($itemPropOf['NAME'], round($itemPropOf['VALUE'])))?> <?=$edIzm?></span>
                                                                    <?}elseif($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                        <td class="char_value" style="display: none;"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span></td>
                                                                    <?}elseif($itemPropOf['CODE'] == 'TREBOVANIYA_OBSHCHIY_STAZH_RABOTY_LET'){?>
                                                                        <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE'] . ' ' . declension($itemPropOf['VALUE'], array('год', 'года', 'лет')))?> <?=$edIzm?></span>
                                                                    <?}elseif($itemPropOf['CODE'] == 'TREBOVANIYA_VOZRAST_ZAYEMSHCHIKA'){?>
                                                                        <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE'][0] . ' - ' . $itemPropOf['VALUE'][1] . ' ' . declension($itemPropOf['VALUE'][1], array('год', 'года', 'лет')))?> <?=$edIzm?></span>
                                                                    <?}else{?>
                                                                        <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span></td>
                                                                    <?}?>
                                                                </tr>
                                                                <?
                                                            endif;
                                                        }//if($razdelP == 'Требования')
                                                        ?>
                                                    <?endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <?if($doc):?>
                                        <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="doc">
                                            <div class="title-tab-heading visible-xs">
                                                <?=GetMessage("TR_DOC")?>
                                            </div>
                                            <div class="detail_text">
                                                <table class="props_list">
                                                    <tbody>
                                                    <?foreach ($arrProperties as $itemPropOf):?>
                                                        <?
                                                        $razdelP = "";
                                                        $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_CODE_PROP'=>$itemPropOf['CODE']];
                                                        $arSelectP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_CODE_PROP','PROPERTY_ED_IZM','PROPERTY_RAZDEL'];
                                                        $resP = CIBlockElement::GetList(array(),$arFilterP,false,false,$arSelectP);
                                                        while($itemResP = $resP->Fetch())
                                                        {
                                                            $razdelP = $itemResP['PROPERTY_RAZDEL_VALUE'];
                                                        }
                                                        if($razdelP == 'Документы')
                                                        {
                                                            if(strlen($itemPropOf['VALUE'])>0 || count($itemPropOf['VALUE'])>1):?>
                                                                <tr itemprop="additionalProperty">
                                                                    <td class="char_name">
                                                                        <div class="props_item ">
                                                                            <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                                <details>
                                                                                    <summary><span class="kk-tooltip listElement" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span></summary>
                                                                                    <?$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => 35, "CODE" => $itemPropOf['CODE']));
                                                                                    while($enum_fields = $property_enums->GetNext())
                                                                                    {
                                                                                        ?><div class="prop_row"><span><?
                                                                                            echo $enum_fields['VALUE']  . "</span><span class='yeaElementMutl'>";
                                                                                            $valuePropList = $enum_fields["VALUE"];

                                                                                            if(in_array($valuePropList, $itemPropOf['VALUE'])){

                                                                                                echo 'Да' . "" ;

                                                                                            }else{echo ' - ' . "" ;}
                                                                                            ?></span></div><?                                                              }
                                                                                    ?>

                                                                                </details>
                                                                            <?}
                                                                            else{
                                                                                ?><span class="kk-tooltip" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span>
                                                                                <?
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </td>
                                                                    <?$edIzm = getEdIzm($itemPropOf['CODE'],$itemPropOf['VALUE']);?>
                                                                    <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                        <td class="char_value" style="display:none;"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span>
                                                                        </td>
                                                                    <?}
                                                                    else{?>
                                                                        <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span>
                                                                        </td>
                                                                    <?}?>
                                                                </tr>
                                                                <?
                                                            endif;
                                                        }//if($razdelP == 'Документы')
                                                        ?>
                                                    <?endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <?if($ser):?>
                                        <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="ser">
                                            <div class="title-tab-heading visible-xs">
                                                <?=GetMessage("TR_SER")?>
                                            </div>
                                            <div class="detail_text">
                                                <table class="props_list">
                                                    <tbody>
                                                    <?foreach ($arrProperties as $itemPropOf):?>
                                                        <?
                                                        $razdelP = "";
                                                        $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_CODE_PROP'=>$itemPropOf['CODE']];
                                                        $arSelectP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_CODE_PROP','PROPERTY_ED_IZM','PROPERTY_RAZDEL'];
                                                        $resP = CIBlockElement::GetList(array(),$arFilterP,false,false,$arSelectP);
                                                        while($itemResP = $resP->Fetch())
                                                        {
                                                            $razdelP = $itemResP['PROPERTY_RAZDEL_VALUE'];
                                                        }
                                                        if($razdelP == 'Сервисы')
                                                        {
                                                            if(strlen($itemPropOf['VALUE'])>0 || count($itemPropOf['VALUE'])>1):?>
                                                                <tr itemprop="additionalProperty">
                                                                    <td class="char_name">
                                                                        <div class="props_item ">
                                                                            <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                                <details>
                                                                                    <summary><span class="kk-tooltip listElement" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span></summary>
                                                                                    <?$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => 35, "CODE" => $itemPropOf['CODE']));
                                                                                    while($enum_fields = $property_enums->GetNext())
                                                                                    {
                                                                                        ?><div class="prop_row"><span><?
                                                                                            echo $enum_fields['VALUE']  . "</span><span class='yeaElementMutl'>";
                                                                                            $valuePropList = $enum_fields["VALUE"];

                                                                                            if(in_array($valuePropList, $itemPropOf['VALUE'])){

                                                                                                echo 'Да' . "" ;

                                                                                            }else{echo ' - ' . "" ;}
                                                                                            ?></span></div><?                                                              }
                                                                                    ?>

                                                                                </details>
                                                                            <?}
                                                                            else{
                                                                                ?><span class="kk-tooltip" itemprop="name"><?=$itemPropOf['NAME'] ?><?if(strlen($itemPropOf['DESCRIPTION'])>0):?><span><?=$itemPropOf['DESCRIPTION']?></span><?endif;?></span>
                                                                                <?
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </td>
                                                                    <?$edIzm = getEdIzm($itemPropOf['CODE'],$itemPropOf['VALUE']);?>
                                                                    <?if($itemPropOf['PROPERTY_TYPE'] == 'L' && $itemPropOf['MULTIPLE'] == 'Y'){?>
                                                                        <td class="char_value" style="display:none;"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span>
                                                                        </td>
                                                                    <?}
                                                                    else{?>
                                                                        <td class="char_value"><span itemprop="value"><?=getObProp($itemPropOf['NAME'], $itemPropOf['VALUE']) ?> <?=$edIzm?></span>
                                                                        </td>
                                                                    <?}?>
                                                                </tr>
                                                                <?
                                                            endif;
                                                        }//if($razdelP == 'Сервисы')
                                                        ?>
                                                    <?endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?endif;?>
                                <?endif;?>
                                <?if($showProps && $arParams["PROPERTIES_DISPLAY_LOCATION"] == "TAB"):?>
                                    <div class="tab-pane <?=(!($iTab++) ? ' active' : '')?>" id="props">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_CHAR_NAME"] ? $arParams["TAB_CHAR_NAME"] : GetMessage("PROPERTIES_TAB"));?></div>
                                        <div>
                                            <?if($strGrupperType == "GRUPPER"):?>
                                                <div class="char_block">
                                                    <?$APPLICATION->IncludeComponent(
                                                        "redsign:grupper.list",
                                                        "",
                                                        Array(
                                                            "CACHE_TIME" => "3600000",
                                                            "CACHE_TYPE" => "A",
                                                            "COMPOSITE_FRAME_MODE" => "A",
                                                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                                                            "DISPLAY_PROPERTIES" => $arResult["GROUPS_PROPS"]
                                                        ),
                                                        $component, array('HIDE_ICONS'=>'Y')
                                                    );?>
                                                    <table class="props_list" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                </div>
                                            <?elseif($strGrupperType == "WEBDEBUG"):?>
                                                <div class="char_block">
                                                    <?$APPLICATION->IncludeComponent(
                                                        "webdebug:propsorter",
                                                        "linear",
                                                        array(
                                                            "IBLOCK_TYPE" => $arResult['IBLOCK_TYPE'],
                                                            "IBLOCK_ID" => $arResult['IBLOCK_ID'],
                                                            "PROPERTIES" => $arResult['GROUPS_PROPS'],
                                                            "EXCLUDE_PROPERTIES" => array(),
                                                            "WARNING_IF_EMPTY" => "N",
                                                            "WARNING_IF_EMPTY_TEXT" => "",
                                                            "NOGROUP_SHOW" => "Y",
                                                            "NOGROUP_NAME" => "",
                                                            "MULTIPLE_SEPARATOR" => ", "
                                                        ),
                                                        $component, array('HIDE_ICONS'=>'Y')
                                                    );?>
                                                    <table class="props_list" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                </div>
                                            <?elseif($strGrupperType == "YENISITE_GRUPPER"):?>
                                                <div class="char_block">
                                                    <?$APPLICATION->IncludeComponent(
                                                        'yenisite:ipep.props_groups',
                                                        '',
                                                        array(
                                                            'DISPLAY_PROPERTIES' => $arResult['GROUPS_PROPS'],
                                                            'IBLOCK_ID' => $arParams['IBLOCK_ID']
                                                        ),
                                                        $component, array('HIDE_ICONS'=>'Y')
                                                    )?>
                                                    <table class="props_list colored_char" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                </div>
                                            <?else:?>
                                                <?if($arParams["PROPERTIES_DISPLAY_TYPE"] != "TABLE"):?>
                                                    <div class="props_block" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>">
                                                        <?foreach($arResult["PROPERTIES"] as $propCode => $arProp):?>
                                                            <?if(isset($arResult["DISPLAY_PROPERTIES"][$propCode])):?>
                                                                <?$arProp = $arResult["DISPLAY_PROPERTIES"][$propCode];?>
                                                                <?if(!in_array($arProp["CODE"], array("SERVICES", "BRAND", "HIT", "RECOMMEND", "NEW", "STOCK", "VIDEO", "VIDEO_YOUTUBE", "CML2_ARTICLE"))):?>
                                                                    <?if((!is_array($arProp["DISPLAY_VALUE"]) && strlen($arProp["DISPLAY_VALUE"])) || (is_array($arProp["DISPLAY_VALUE"]) && implode('', $arProp["DISPLAY_VALUE"]))):?>
                                                                        <div class="char" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                                                            <div class="char_name">
                                                                                <?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
                                                                                <div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
                                                                                    <span itemprop="name"><?=$arProp["NAME"]?></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="char_value" itemprop="value">
                                                                                <?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
                                                                                    <?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
                                                                                <?else:?>
                                                                                    <?=$arProp["DISPLAY_VALUE"];?>
                                                                                <?endif;?>
                                                                            </div>
                                                                        </div>
                                                                    <?endif;?>
                                                                <?endif;?>
                                                            <?endif;?>
                                                        <?endforeach;?>
                                                    </div>
                                                <?else:?>
                                                    <table class="props_list">
                                                        <?foreach($arResult["DISPLAY_PROPERTIES"] as $arProp):?>
                                                            <?if(!in_array($arProp["CODE"], array("SERVICES", "BRAND", "HIT", "RECOMMEND", "NEW", "STOCK", "VIDEO", "VIDEO_YOUTUBE", "CML2_ARTICLE"))):?>
                                                                <?if((!is_array($arProp["DISPLAY_VALUE"]) && strlen($arProp["DISPLAY_VALUE"])) || (is_array($arProp["DISPLAY_VALUE"]) && implode('', $arProp["DISPLAY_VALUE"]))):?>
                                                                    <tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                                                                        <td class="char_name">
                                                                            <?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
                                                                            <div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
                                                                                <span itemprop="name"><?=$arProp["NAME"]?></span>
                                                                            </div>
                                                                        </td>
                                                                        <td class="char_value">
                                                                            <?if($arProp["NAME"]=="Тип"):?>
                                                                                <?php
                                                                                $parent_sec_name = "";
                                                                                $res_sec = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
                                                                                if($ar_res_sec = $res_sec->GetNext()){
                                                                                    $res_sec_parent = CIBlockSection::GetByID($ar_res_sec["IBLOCK_SECTION_ID"]);
                                                                                    if($ar_res_sec_parent = $res_sec_parent->GetNext()){
                                                                                        $parent_sec_name = $ar_res_sec_parent["NAME"];
                                                                                    }
                                                                                }
                                                                                if(strlen($parent_sec_name)>0){
                                                                                    echo $parent_sec_name;
                                                                                }else{
                                                                                    echo "услуга";
                                                                                }
                                                                                ?>
                                                                            <?else:?>
                                                                                <?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
                                                                                    <?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
                                                                                <?else:?>
                                                                                    <?=$arProp["DISPLAY_VALUE"];?>
                                                                                <?endif;?>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                <?endif;?>
                                                            <?endif;?>
                                                        <?endforeach;?>
                                                    </table>
                                                    <table class="props_list" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
                                                <?endif;?>
                                            <?endif;?>
                                        </div>
                                    </div>
                                <?endif;?>
                                <?if($arVideo):?>
                                    <div class="tab-pane<?=(!($iTab++) ? ' active' : '')?> " id="video">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_VIDEO_NAME"] ? $arParams["TAB_VIDEO_NAME"] : GetMessage("VIDEO_TAB"));?>
                                            <?if(count($arVideo) > 1):?>
                                                <span class="count empty">&nbsp;(<?=count($arVideo)?>)</span>
                                            <?endif;?></div>
                                        <div class="video_block">
                                            <?if(count($arVideo) > 1):?>
                                                <table class="video_table">
                                                    <tbody>
                                                    <?foreach($arVideo as $v => $value):?>
                                                        <?if(($v + 1) % 2):?>
                                                            <tr>
                                                        <?endif;?>
                                                        <td width="50%"><?=str_replace('src=', 'width="458" height="257" src=', str_replace(array('width', 'height'), array('data-width', 'data-height'), $value));?></td>
                                                        <?if(!(($v + 1) % 2)):?>
                                                            </tr>
                                                        <?endif;?>
                                                    <?endforeach;?>
                                                    <?if(($v + 1) % 2):?>
                                                        </tr>
                                                    <?endif;?>
                                                    </tbody>
                                                </table>
                                            <?else:?>
                                                <?=$arVideo[0]?>
                                            <?endif;?>
                                        </div>
                                    </div>
                                <?endif;?>

                                <?if(($arParams["SHOW_ASK_BLOCK"] == "Y") && (intVal($arParams["ASK_FORM_ID"]))):?>
                                    <div class="tab-pane<?=(!($iTab++) ? ' acive' : '')?>" id="ask">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_FAQ_NAME"] ? $arParams["TAB_FAQ_NAME"] : GetMessage('ASK_TAB'))?></div>
                                        <div class="row">
                                            <div class="col-md-3 hidden-sm text_block">
                                                <?$APPLICATION->IncludeFile(SITE_DIR."include/ask_tab_detail_description.php", array(), array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_ASK_DESCRIPTION')));?>
                                            </div>
                                            <div class="col-md-9 form_block">
                                                <div id="ask_block"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?endif;?>
                                <?if($useStores && ($showCustomOffer || !$arResult["OFFERS"] )):?>
                                    <div class="tab-pane stores_tab<?=(!($iTab++) ? ' active' : '')?>" id="stores">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_STOCK_NAME"] ? $arParams["TAB_STOCK_NAME"] : GetMessage("STORES_TAB"));?></div>
                                        <div class="stores_wrapp">
                                            <?if($arResult["OFFERS"]){?>
                                                <span></span>
                                            <?}else{?>
                                                <?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "main", array(
                                                    "PER_PAGE" => "10",
                                                    "USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
                                                    "SCHEDULE" => $arParams["SCHEDULE"],
                                                    "USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
                                                    "MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
                                                    "ELEMENT_ID" => $arResult["ID"],
                                                    "STORE_PATH"  =>  $arParams["STORE_PATH"],
                                                    "MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
                                                    "MAX_AMOUNT"=>$arParams["MAX_AMOUNT"],
                                                    "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
                                                    "SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
                                                    "SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
                                                    "USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
                                                    "USER_FIELDS" => $arParams['USER_FIELDS'],
                                                    "FIELDS" => $arParams['FIELDS'],
                                                    "STORES" => $arParams['STORES'],
                                                    "SET_ITEMS" => $arResult["SET_ITEMS"],
                                                ),
                                                    $component
                                                );?>
                                            <?}?>
                                        </div>
                                    </div>
                                <?endif;?>

                                <?if($arParams["SHOW_ADDITIONAL_TAB"] == "Y"):?>
                                    <div class="tab-pane additional_block<?=(!($iTab++) ? ' active' : '')?>" id="dops">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_DOPS_NAME"] ? $arParams["TAB_DOPS_NAME"] : GetMessage("ADDITIONAL_TAB"));?></div>
                                        <div>
                                            <?$APPLICATION->IncludeFile(SITE_DIR."include/additional_products_description.php", array(), array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_ADDITIONAL_DESCRIPTION')));?>
                                        </div>
                                    </div>
                                <?endif;?>
                                <?if($arParams["USE_REVIEW"] == "Y"):?>
                                    <div class="tab-pane media_review<?=(!($iTab++) ? ' active' : '')?> product_reviews_tab visible-xs">
                                        <div class="title-tab-heading visible-xs"><?=($arParams["TAB_REVIEW_NAME"] ? $arParams["TAB_REVIEW_NAME"] : GetMessage("REVIEW_TAB"))?><span class="count empty"></span></div>
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                    </div>

                </div>
                <?//endif;?>
                <?$strGrupperType = $arParams["GRUPPER_PROPS"];?>

            </div>
        </div>
    </div>
    <?
    if($arResult['CATALOG'] && $actualItem['CAN_BUY'] && $arParams['USE_PREDICTION'] === 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale')){
        $APPLICATION->IncludeComponent(
            'bitrix:sale.prediction.product.detail',
            'main',
            array(
                'BUTTON_ID' => false,
                'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                'POTENTIAL_PRODUCT_TO_BUY' => array(
                    'ID' => $arResult['ID'],
                    'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
                    'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
                    'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
                    'IBLOCK_ID' => $arResult['IBLOCK_ID'],
                    'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
                    'SECTION' => array(
                        'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
                        'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
                        'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
                        'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
                    ),
                ),
                'REQUEST_ITEMS' => true,
                'RCM_TEMPLATE' => 'main',
            ),
            $component,
            array('HIDE_ICONS' => 'Y')
        );
    }
    ?>
</div>

<script type="text/javascript">
    BX.message({
        QUANTITY_AVAILIABLE: '<? echo COption::GetOptionString("aspro.next", "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID); ?>',
        QUANTITY_NOT_AVAILIABLE: '<? echo COption::GetOptionString("aspro.next", "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS"), SITE_ID); ?>',
        ADD_ERROR_BASKET: '<? echo GetMessage("ADD_ERROR_BASKET"); ?>',
        ADD_ERROR_COMPARE: '<? echo GetMessage("ADD_ERROR_COMPARE"); ?>',
        ONE_CLICK_BUY: '<? echo GetMessage("ONE_CLICK_BUY"); ?>',
        SITE_ID: '<? echo SITE_ID; ?>'
    })
</script>
<style>
    #fast_view_item .stickers{padding-right: 0px !important;}
    #fast_view_item .stickers > div{width: 50%;}
    #fast_view_item .stickers > div > div{font-size: 6px;width: 100%;text-align: center;}
    #fast_view_item .stickers { left: auto !important; top: auto !important; text-align: left !important; position: relative !important; padding-right: 0px; margin-top: 20px; }
    .fast_view_frame.popup .catalog_detail .item_main_info{border-bottom: 4px solid #fff;}

    .fast_view_frame.popup .catalog_detail .item_main_info .img_wrapper .sku_block{height: auto !important;}

    .fast_view_frame.popup .catalog_detail .item_main_info{border-radius: 0 0 8px 8px;}
    .fast_view_frame.popup .form .form_head{border-radius:8px 8px 0 0; display: flex;flex-wrap: nowrap;justify-content: space-between;}
    .fast_view_frame.popup .form .form_head .img_logo{padding: 0 0 0 15px;}
    .fast_view_frame.popup{border-radius: 8px;}

    .catalog_detail .item_slider .slides_block>li:nth-child(1){display: none !important;}
    #fast_view_item .item_slider .slides { height: 150px; line-height: 150px; }
    .catalog_detail .props_list td{font-size: 11px; width: 62%;}
    .catalog_detail .props_list td.char_value{width: 38%;}
    body .bx_catalog_item_scu .bx_item_detail_scu ul li.active{width: 100%; text-align: center; padding: 0px; margin: 0px; margin-bottom: 10px; display: none;}
    .show_un_props .sku_props .wrapper_sku > .logo_img{display: none;}
    .fast_view_frame.popup .catalog_detail .item_main_info .right_info .info_item{padding-left: 0px !important; padding-right: 10px !important;}
    .fast_view_frame.popup .catalog_detail .tabs .nav.nav-tabs a{/* padding: 20px; */}
    .fast_view_frame.popup .catalog_detail .item_main_info .img_wrapper .bx_catalog_item_scu ul>div{height: auto !important;}

    .fast_view_frame .bx_item_detail_scu{width: 50%; display: inline-block; vertical-align: top;}
    .fast_view_frame .like_icons.btn.btn-default{width: 40%; display: inline-block; position: relative; vertical-align: top; margin-top: 15px; height: 36px !important;left: 0;padding-left: 0px;padding-right: 0px;}

    .fast_view_frame .like_icons.btn.btn-default .compare_item{width: 100% !important; height: 100% !important; background: none !important;opacity: 1 !important;}
    /*.catalog_detail .like_icons.btn.btn-default .compare_item i{width: 100% !important; height: 100% !important; background: none !important;color: #1976d2;font-style: normal;}*/
    .fast_view_frame .like_icons span i {display:inline-block !important;margin-top: -5px;position:absolute;background-color:transparent !important;background-position: -159px -128px;}
    .fast_view_frame .like_icons.btn.btn-default{width: auto !important; width: 48% !important;}
    .fast_view_frame .compare_item_button .compare_item span{overflow:visible; display:inline-block; visibility: visible; width: 100% !important; height: 17px !important;  background: none !important; color: #006e3a; font-style: normal; opacity: 1; text-align: center; border-radius: unset; padding-left: 10px; }
    /**тултип - начало**/
    .props_item  span.kk-tooltip{cursor: pointer;}
    .props_item  span.kk-tooltip span {display: none;padding: 2px 3px; margin-right: 8px; width: 400px;font-size: 12px;}
    .props_item  span.kk-tooltip:hover span { display: inline; position: absolute;background: #ffffff;border: 1px solid #cccccc;color: #6c6c6c; left: 0px; top: 22px;z-index: 111;}
    /**тултип - конец**/
</style>
<script>
    function kk_add_to_comparisons(id,session){
        $.ajax({
            type:'post',//тип запроса: get,post либо head
            url:'/ajax/add_item_copmparison.php',//url адрес файла обработчика
            data:"session="+session+"&id=" + id,//параметры запроса
            response:'text',//тип возвращаемого ответа text либо xml
            success:function (data) {//возвращаемый результат от сервера
                //location.href = '/basket/';
                console.log(data);
            }
        });
    }
</script>