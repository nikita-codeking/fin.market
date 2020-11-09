<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if( count( $arResult["ITEMS"] ) >= 1 ){?>
	<?if(($arParams["AJAX_REQUEST"]=="N") || !isset($arParams["AJAX_REQUEST"])){?>
		<?if(isset($arParams["TITLE"]) && $arParams["TITLE"]):?>
			<hr/>
			<h5><?=$arParams['TITLE'];?></h5>
		<?endif;?>
		<div class="top_wrapper row margin0 <?=($arParams["SHOW_UNABLE_SKU_PROPS"] != "N" ? "show_un_props" : "unshow_un_props");?>">
			<div class="catalog_block items block_list">
            <?$srv_export = "";?>
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?if(strlen($srv_export)==0)
                {
                    $srv_export = $arItem['ID'];
                }
                else
                {
                    $srv_export = $srv_export . '|' . $arItem['ID'];
                }
            ?>
            <?endforeach;?>
            <div class="steck_sravnenie_rait" style="display: none;"><?=$srv_export?></div>
	<?}?>
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

		$arParams["BASKET_ITEMS"]=($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());
		$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);

		// params for catalog elements compact view
		$arParamsCE_CMP = $arParams;
		$arParamsCE_CMP['TYPE_SKU'] = 'N';

		switch ($arParams["LINE_ELEMENT_COUNT"]){
			case '1':
			case '2':
				$col=2;
				break;
			case '3':
				$col=3;
				break;
			case '5':
				$col=5;
				break;
			default:
				$col=4;
				break;
		}
		if($arParams["LINE_ELEMENT_COUNT"] > 5) $col = 5;?>
        <?$id_carousel = str_replace(":","_",date("H:i:s")) . rand(100, 999);?>
        <div class="catalog_block items row margin0 ajax_load block swiper-container">
            <div class="wrapper_item_block swiper-wrapper">
                <?foreach($arResult["ITEMS"] as $arItem){?>
                    <div class="item_block col-<?=$col;?> col-md-12 col-sm-<?=ceil(12/round($col / 2))?> col-xs-6 swiper-slide">
                        <div class="catalog_item_wrapp item">
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
                            <?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

                            $arItem["strMainID"] = $this->GetEditAreaId($arItem['ID']);
                            $arItemIDs=CNext::GetItemsIDs($arItem);

                            $totalCount = CNext::GetTotalCount($arItem, $arParams);
                            $arQuantityData = CNext::GetQuantityArray($totalCount, $arItemIDs["ALL_ITEM_IDS"], "N", $arItem["PRODUCT"]["TYPE"]);

                            $bLinkedItems = (isset($arParams["LINKED_ITEMS"]) && $arParams["LINKED_ITEMS"]);
                            if($bLinkedItems)
                                $arItem["FRONT_CATALOG"]="Y";
                            $elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);


                            $item_id = $arItem["ID"];
                            $strMeasure = '';
                            $arAddToBasketData = array();

                            $arCurrentSKU = array();

                            if(!$arItem["OFFERS"] || $arParams['TYPE_SKU'] !== 'TYPE_1'){
                                if($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]){
                                    $arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
                                    $strMeasure = $arMeasure["SYMBOL_RUS"];
                                }
                                $arAddToBasketData = CNext::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], ($bLinkedItems ? true : false), $arItemIDs["ALL_ITEM_IDS"], 'small', $arParams);
                            }
                            elseif($arItem["OFFERS"]){
                                $strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
                                if($arParams['TYPE_SKU'] == 'TYPE_1' && $arItem['OFFERS_PROP'])
                                {
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

                            ?>
                            <div class="catalog_item main_item_wrapper item_wrap <?=(($_GET['q'])) ? 's' : ''?>" id="<?=$arItemIDs["strMainID"];?>">
                                <div>
                                    <div class="image_wrapper_block">
                                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb shine" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['PICT']; ?>">
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
                                            <?if( !empty($arItem["PREVIEW_PICTURE"]) ):?>
                                                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                            <?elseif( !empty($arItem["DETAIL_PICTURE"])):?>
                                                <?$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
                                                <img src="<?=$img["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                            <?else:?>
                                                <img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_medium.png" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
                                            <?endif;?>
                                            <?if($fast_view_text_tmp = CNext::GetFrontParametrValue('EXPRESSION_FOR_FAST_VIEW'))
                                                $fast_view_text = $fast_view_text_tmp;
                                            else
                                                $fast_view_text = GetMessage('FAST_VIEW');?>
                                        </a>
                                        <div class="fast_view_block" data-event="jqm" data-param-form_id="fast_view" data-param-iblock_id="<?=$arParams["IBLOCK_ID"];?>" data-param-id="<?=$arItem["ID"];?>" data-param-item_href="<?=urlencode($arItem["DETAIL_PAGE_URL"]);?>" data-name="fast_view"><?=$fast_view_text;?></div>
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
                                        <?if($arParams["SHOW_DISCOUNT_TIME"]=="Y" && $arParams['SHOW_COUNTER_LIST'] != 'N'){?>
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
                                        <?$boolShowOfferProps = ($arItem['OFFERS_PROPS_DISPLAY']);
                                        $boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));?>
                                        <?if($boolShowProductProps || $boolShowOfferProps):?>
                                            <div class="props_list_wrapp">
                                                <table class="props_list prod">
                                                    <?if ($boolShowProductProps){
                                                    }?>
                                                </table>
                                                <?if ($boolShowOfferProps){?>
                                                    <table class="props_list offers" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>" style="display: none;"></table>
                                                <?}?>
                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <script>
            ratingSlider();
        </script>
	<?if(($arParams["AJAX_REQUEST"]=="N") || !isset($arParams["AJAX_REQUEST"])){?>
			</div>
		</div>
	<?}?>
	<?if($arParams["AJAX_REQUEST"]=="Y"){?>
		<div class="wrap_nav">
	<?}?>
	<div class="bottom_nav <?=$arParams["DISPLAY_TYPE"];?>" <?=($arParams["AJAX_REQUEST"]=="Y" ? "style='display: none; '" : "");?>>
		<?if( $arParams["DISPLAY_BOTTOM_PAGER"] == "Y" ){?><?=$arResult["NAV_STRING"]?><?}?>
	</div>
	<?if($arParams["AJAX_REQUEST"]=="Y"){?>
		</div>
	<?}?>
<?}else{?>
	<script>
		// $(document).ready(function(){
			$('.sort_header').animate({'opacity':'1'}, 500);
		// })
	</script>
	<div class="no_goods catalog_block_view">
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
<?}?>

<script>
	BX.message({
		QUANTITY_AVAILIABLE: '<? echo COption::GetOptionString("aspro.next", "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID); ?>',
		QUANTITY_NOT_AVAILIABLE: '<? echo COption::GetOptionString("aspro.next", "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS"), SITE_ID); ?>',
		ADD_ERROR_BASKET: '<? echo GetMessage("ADD_ERROR_BASKET"); ?>',
		ADD_ERROR_COMPARE: '<? echo GetMessage("ADD_ERROR_COMPARE"); ?>',
	})
	sliceItemBlock();
</script>
<script>
    $(document).ready(function(){
        //запускаем карусель

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
            items:3,
            slideBy: 2,
            responsive:{
                0:{
                    items:2,
                    navSpeed:700,
                    slideBy: 1
                },
                451:{
                    items:2,
                    navSpeed:700,
                    slideBy: 2
                },
                1300:{
                    items:3,
                    navSpeed:700,
                    slideBy: 2
                },
            }
        });


    });
    $(document).ready(function() {
        $('.image_wrapper_block').hover(function(e){
            //e.preventDefault();
            $(this).children('.fast_view_block').attr('style','visibility: visible !important;');
            console.log('hover');
        }, function () {
            //e.preventDefault();
            $(this).children('.fast_view_block').removeAttr('style');
            console.log('unhover');
        });
    });
</script>