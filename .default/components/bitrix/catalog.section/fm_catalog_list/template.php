<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
if ($arResult['ID']=='309' || $arResult['ID']=='101' || $arResult['ID']=='116' || $arResult['ID']=='103' || $arResult['ID']=='322')
{?>
    <style>
        .right_block.wide_N{width:100%!important;}
        .adaptive_filter{display:none!important;}
        .bx_filter.bx_filter_vertical{display:none!important;}
        .left_block{display:none!important;}
        .wrapper1.catalog_page{padding:0!important}
    </style>
    <?
    if ($arResult['ID']=='309'){?>
        <div>
            <script data-product='strahovanie-ipoteki' src='https://sravni.ru/widgets/loader.js' data-inFrame='true' data-filters.debt='3000000' data-filters.percent-rate='10' data-filters.bank='' data-filters.gender='female' data-theme-Palette='{"elementsColor":"35, 35, 199","activeElementsColor":"35, 35, 199"}' affiliate='12' source='2002'></script>
        </div>
    <?}
    if ($arResult['ID']=='101'){?>
        <div style="width:100%">
            <script src="https://sravni.ru/f/apps/build/widgets/sravni-widgets.js"></script>
            <sravni-widget type='osago' theme='sravni_dark' width='100%' partner='1709' inIframe='true' hide-partners='true' carTypeDefault='' offer='1064' affiliate='1' source='ФинМаркет'></sravni-widget>
        </div>
    <?}
    if ($arResult['ID']=='116'){?>
        <div style="width:100%">
            <script src="https://sravni.ru/f/apps/build/widgets/sravni-widgets.js"></script>
            <sravni-widget type='kasko' theme='sravni_dark' width='100%' partner='1709' inIframe='true' hide-partners='true' carTypeDefault='' offer='1066' affiliate='3' source='2002'></sravni-widget>
        </div>
    <?}
    if ($arResult['ID']=='103'){?>
        <div style="width:100%">
            <script data-product='vzr' src='https://sravni.ru/widgets/loader.js' data-inFrame='true' data-theme-palette='{"elementsColor":"35, 35, 199","activeElementsColor":"35, 35, 199"}' data-aff_id='1709' data-offer_id='1068' data-aff_sub='10' data-source='2002'></script>
        </div>
    <?}
    if ($arResult['ID']=='322'){?>
        <div style="padding-bottom:20px">
            <script src="https://partner.prosto.insure/widget/common.js"></script>
            <iframe src="https://partner.prosto.insure/widget/sport?rel=u-Wb5Dsr9rZ9oDvU8&bg=blue"
                    scrolling="no" style="padding-bottom:20px;width:100%;min-height:670px;min-width:320px;border:none;border-radius:4px;" data-pi-widget="sport">
            </iframe></div>
    <?}
}?>
<?if( count( $arResult["ITEMS"] ) >= 1){?>
	<?if($arParams["AJAX_REQUEST"]=="N"){?>
		<div class="display_list <?=($arParams["SHOW_UNABLE_SKU_PROPS"] != "N" ? "show_un_props" : "unshow_un_props");?>">
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

		$arParams["BASKET_ITEMS"] = ($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());

		$arOfferProps = implode(';', $arParams['OFFERS_CART_PROPERTIES']);
		?>
		
		<?  //сортировка по параметрам
		  $array_param=array();
		  $array_none=array();
		  $is_sort=false;
		  foreach($arResult["ITEMS"] as $arItem)
		  {
			//получаем свойства элемента
			$check=false;
			foreach( $arItem["DISPLAY_PROPERTIES"] as $arPropTemp)
			{
			  if($arPropTemp["CODE"]=="OT_DO_PROZ_ST_MAX" || $arPropTemp["CODE"]=="OT_DO_CREDIT_LIM_MAX" || $arPropTemp["CODE"]=="OT_DO_LGOTNIY_PERIOD_MAX" || $arPropTemp["CODE"]=="OT_DO_GOD_OBSL_MAX")
			  {
				if(!empty($arPropTemp["VALUE"]) && $arPropTemp["VALUE"]>0)
				{
					$check=true;$is_sort=true;
					break;
				}
			  }
			}
			if($check)array_push($array_param,$arItem);
			else array_push($array_none,$arItem);
		  }
		  array_push($array_param, ...$array_none);
		  if ($is_sort) $arResult["ITEMS"]=$array_param;
		?>
		<?foreach($arResult["ITEMS"] as $arItem){?>
			
			<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

			$arItem["strMainID"] = $this->GetEditAreaId($arItem['ID']);
			$arItemIDs=CNext::GetItemsIDs($arItem);

			$totalCount = CNext::GetTotalCount($arItem, $arParams);
			$arQuantityData = CNext::GetQuantityArray($totalCount, $arItemIDs["ALL_ITEM_IDS"], "N", $arItem["PRODUCT"]["TYPE"]);

			$item_id = $arItem["ID"];
			$strMeasure = '';
			$arAddToBasketData = array();

			$arCurrentSKU = array();

			$elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

			if(!$arItem["OFFERS"] || $arParams['TYPE_SKU'] !== 'TYPE_1'){
				if($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]){
					$arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
					$strMeasure = $arMeasure["SYMBOL_RUS"];
				}
				$arAddToBasketData = CNext::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'small', $arParams);
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
			<div class="list_item_wrapp item_wrap item">
				<table class="list_item" id="<?=$arItemIDs["strMainID"];?>">
					<tr class="adaptive_name">
						<td colspan="3">
							<div class="desc_name"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><span><?=$elementName;?></span></a></div>
						</td>
					</tr>
					<tr>
					<td class="image_block">
						<div class="image_wrapper_block">
							<div class="overlay mobile"></div>
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
									<img data-title="Подробнее" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
								<?elseif( !empty($arItem["DETAIL_PICTURE"])):?>
									<?$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array( "width" => 200, "height" => 200 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
									<img data-title="Подробнее" src="<?=$img["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
								<?else:?>
									<img data-title="Подробнее" src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_medium.png" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
								<?endif;?>
							</a>
						</div>
						<?if($fast_view_text_tmp = CNext::GetFrontParametrValue('EXPRESSION_FOR_FAST_VIEW'))
							$fast_view_text = $fast_view_text_tmp;
						else
							$fast_view_text = GetMessage('FAST_VIEW');?>
						<div class="fast_view_block" data-event="jqm" data-param-form_id="fast_view" data-param-iblock_id="<?=$arParams["IBLOCK_ID"];?>" data-param-id="<?=$arItem["ID"];?>" data-param-item_href="<?=urlencode($arItem["DETAIL_PAGE_URL"]);?>" data-name="fast_view"><?=$fast_view_text;?></div>
						<a class="btn btn-default mobile img-button" target="_blank" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Подробнее</a>
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
							<?if(strlen(trim($arItem['OFFERS'][0]['PROPERTIES']['URL2']['VALUE']))>0):?>
                                <?
                                if(strpos(trim($arItem["OFFERS"][0]["PROPERTIES"]["URL2"]["VALUE"]) ,'admitad') >-1){
                                    $referer=trim($arItem["OFFERS"][0]["PROPERTIES"]["URL2"]["VALUE"]) . "subid/" .$_COOKIE['utm_source'] ;

                                }else{
                                    $referer=trim($arItem["OFFERS"][0]["PROPERTIES"]["URL2"]["VALUE"]) ."&sa=".$_COOKIE['utm_source'] ;
                                }
                                ?>
                                <a class="btn btn-default ofo-href desc" onClick="ym('56316898','reachGoal', 'oformit');" target="_blank" href="<?=$referer?>"><?=GetMessage("LIST_BUTTON_OFO");?></a>
                            <?endif;?>
                    </td>

					<td class="description_wrapp">
						<div class="description">
							<div class="item-title">
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="dark_link"><span><?=$elementName;?></span></a>
							</div>
							<div class="wrapp_stockers">
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
								<div class="article_block" <?if(isset($arItem['ARTICLE']) && $arItem['ARTICLE']['VALUE']):?>data-name="<?=$arItem['ARTICLE']['NAME'];?>" data-value="<?=$arItem['ARTICLE']['VALUE'];?>"<?endif;?>>
									<?if(isset($arItem['ARTICLE']) && $arItem['ARTICLE']['VALUE']){?>
										<?=$arItem['ARTICLE']['NAME'];?>: <?=$arItem['ARTICLE']['VALUE'];?>
									<?}?>
								</div>
							</div>
							<div class="preview_text">
                                <?
                                $abz = explode ("\n",$arItem["OFFERS"][0]["PROPERTIES"]["PREIMUSHCHESTVA"]["VALUE"]);
                                for($i=0;$i<count($abz);$i++):?>
                                    <?if(trim(strlen($abz[$i]))==0){continue;}?>
                                    <?=$abz[$i]?><br>
                                <?endfor;?>
                            </div>

                            <div class="stickers 6">
                                <?$prop = ($arParams["STIKERS_PROP"] ? $arParams["STIKERS_PROP"] : "HIT");?>
                                <?foreach(CNext::GetItemStickers($arItem["PROPERTIES"][$prop]) as $arSticker):?>
                                    <div><div class="<?=$arSticker['CLASS']?>"><?=$arSticker['VALUE']?></div></div>
                                <?endforeach;?>
                                <?if($arParams["SALE_STIKER"] && $arItem["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"]){?>
                                    <div><div class="sticker_sale_text"><?=$arItem["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"];?></div></div>
                                <?}?>
                            </div>

						</div>
						<?//if($arParams["SECTION_CODE"] == "kreditnye_karty"):?>

					</td>
					<td class="information_wrapp main_item_wrapper">
						<div class="information <?=($arItem["OFFERS"] && $arItem['OFFERS_PROP'] ? 'has_offer_prop' : '');?>  inner_content js_offers__<?=$arItem['ID'];?>">
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
															<span class="value" ><?=$totalCount;?></span>
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

                            <?if(count($arItem["DISPLAY_PROPERTIES"])>0 || count($arItem["OFFERS"][0]["DISPLAY_PROPERTIES"])>0):?>
                                <div class="like_icons btn btn-default">
                                    <?//if($arParams["SECTION_CODE"] == "kreditnye_karty"):?>
                                    <?if(!$arItem["OFFERS"] || ($arParams["TYPE_SKU"] !== 'TYPE_1' || ($arParams["TYPE_SKU"] == 'TYPE_1' && !$arItem["OFFERS_PROP"]))):?>
                                        <div class="compare_item_button">
                                            <span class="compare_item to" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>" ><i></i><span><?=GetMessage('CATALOG_COMPARE')?></span></span>
                                            <span class="compare_item in added" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>"><i></i><span><?=GetMessage('CATALOG_COMPARE_OUT')?></span></span>
                                        </div>
                                    <?elseif($arItem["OFFERS"]):?>
                                        <div class="compare_item_button">
                                            <span class="compare_item to <?=$arParams["TYPE_SKU"];?>" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$currentSKUID;?>" ><i></i><span><?=GetMessage('CATALOG_COMPARE')?></span></span>
                                            <span class="compare_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$currentSKUID;?>"><i></i><span><?=GetMessage('CATALOG_COMPARE_OUT')?></span></span>
                                        </div>
                                    <?endif;?>
                                    <?//endif;?>
                                </div>
                            <?endif;?>

                            <?$boolShowOfferProps = ($arItem['OFFERS_PROPS_DISPLAY']);
                            $boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));?>
                            <?if($boolShowProductProps || $boolShowOfferProps):?>
                                <div class="props_list_wrapp" style="display:block">
                                    <table class="props_list prod" >
                                        <?if ($boolShowProductProps){
                                            //отсортируем параметры - если есть сортировка
                                            $arPropItemsIt = Array();
                                            $isset_sort = false;
                                            global $APPLICATION;
                                            $this_url = $APPLICATION->GetCurPage();
                                            $pos_credit_cart = strpos($this_url, 'kreditnye_karty');
                                            $pos_credit_nal  = strpos($this_url, 'kredity_nalichnymi');
                                            $pos_debit_cart  = strpos($this_url, 'debetovye_karty');
                                            $pos_rko         = strpos($this_url, 'raschetnye_scheta');

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
                                                    }elseif($_GET["sort"] == "property_OT_DO_GOD_OBSL_MAX" && $arPropTemp["NAME"] == "Годовое обслуживание"){
                                                        $arPropItemsIt[] = $arPropTemp;
                                                        $isset_sort = true;
                                                        break;
                                                    }elseif($_GET["sort"] == "property_OT_DO_OBSLUGIVANIE_MAX" && $arPropTemp["NAME"] == "Обслуживание в месяц"){
                                                        $arPropItemsIt[] = $arPropTemp;
                                                        $isset_sort = true;
                                                        break;
                                                    }
                                                }else{
                                                    if($pos_credit_nal>0 || $pos_credit_cart>0){
                                                        if($arPropTemp["NAME"] == "Процентная ставка" && $pos_credit_nal>0){
                                                            $arPropItemsIt[] = $arPropTemp;
                                                            $isset_sort = true;
                                                            break;
                                                        }elseif($arPropTemp["NAME"] == "Кредитный лимит" && $pos_credit_cart>0){
                                                            $arPropItemsIt[] = $arPropTemp;
                                                            $isset_sort = true;
                                                            break;
                                                        }
                                                    }else{
                                                        $arPropItemsIt[] = $arPropTemp;
                                                    }
                                                }
                                            }
                                            if($isset_sort){
                                                foreach( $arItem["DISPLAY_PROPERTIES"] as $arPropTemp ){
                                                    if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX" && $arPropTemp["NAME"] == "Процентная ставка" || !isset($_GET["sort"]) && $arPropTemp["NAME"] == "Процентная ставка" && $pos_credit_nal>0){
                                                        continue;
                                                    }elseif($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX" && $arPropTemp["NAME"] == "Кредитный лимит" || !isset($_GET["sort"]) && $arPropTemp["NAME"] == "Кредитный лимит" && $pos_credit_cart>0){
                                                        continue;
                                                    }elseif($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX" && $arPropTemp["NAME"] == "Льготный период"){
                                                        continue;
                                                    }elseif($_GET["sort"] == "property_OT_DO_GOD_OBSL_MAX" && $arPropTemp["NAME"] == "Годовое обслуживание"){
                                                        continue;
                                                    }elseif($_GET["sort"] == "property_OT_DO_OBSLUGIVANIE_MAX" && $arPropTemp["NAME"] == "Обслуживание в месяц"){
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

                                                            if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX" || !isset($_GET["sort"]) && $pos_credit_nal>0){
                                                                $tag_b_start = '<b>';
                                                                $tag_b_end   = '</b>';
                                                            }

                                                            break;
                                                        case "Обслуживание в месяц":
                                                            $pr = " руб.";

                                                            if($_GET["sort"] == "property_OT_DO_OBSLUGIVANIE_MAX" || !isset($_GET["sort"]) && $pos_rko>0){
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

                                                            if($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX" || !isset($_GET["sort"]) && $pos_credit_cart>0){
                                                                $tag_b_start = '<b>';
                                                                $tag_b_end   = '</b>';
                                                            }

                                                            break;
                                                        case "Льготный период":
                                                            $pr = " " . tpl_tpluralForm((int)$val, "день", "дня", "дней");

                                                            if($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX"){
                                                                $tag_b_start = '<b>';
                                                                $tag_b_end   = '</b>';
                                                            }

                                                            break;
                                                        case "Годовое обслуживание":
                                                            $pr = " руб.";

                                                            if($_GET["sort"] == "property_OT_DO_GOD_OBSL_MAX" || !isset($_GET["sort"]) && $pos_debit_cart>0){
                                                                $tag_b_start = '<b>';
                                                                $tag_b_end   = '</b>';
                                                            }

                                                            break;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><span><?=$tag_b_start?><?=$arProp["NAME"]?><?=$tag_b_end?></span></td>
                                                        <td><span><?=$tag_b_start?><?=$val?><?=$pr?><?=$tag_b_end?></span></td>
                                                    </tr>
                                                <?}?>
                                            <?}
                                            foreach( $arItem["OFFERS"][0]["DISPLAY_PROPERTIES"] as $arPropTemp ){?>
                                                <?
                                                $name_prop_offer = $arPropTemp["NAME"];
                                                $pos_point_in_name = strpos($arPropTemp["NAME"], ".");
                                                if($pos_point_in_name>0) {
                                                    $name_prop_offer = substr($arPropTemp["NAME"], $pos_point_in_name + 1);
                                                }
                                                ?>
                                                <tr>
                                                    <td><span><?=$name_prop_offer?></span></td>
                                                    <td><span><?=$arPropTemp["DISPLAY_VALUE"]?></span></td>
                                                </tr>
                                            <?}
                                        }?>
                                    </table>
                                    <?if ($boolShowOfferProps){?>
                                        <table class="props_list offers" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>" style="display: none;"></table>
                                    <?}?>

                                </div>
                                <!--<div class="show_props dark_link">
									<span class="icons_fa char_title"><span><?//=GetMessage('PROPERTIES')?></span></span>
								</div>-->
                            <?endif;?>
                            <a class="btn btn-default ofo-href mobile" onClick="ym('56316898','reachGoal', 'oformit');" target="_blank" href="<?=$referer?>"><?=GetMessage("LIST_BUTTON_OFO");?></a>                  

							<?if(!$arItem["OFFERS"] || $arParams['TYPE_SKU'] !== 'TYPE_1'):?>
								<div class="counter_wrapp <?=($arItem["OFFERS"] && $arParams["TYPE_SKU"] == "TYPE_1" ? 'woffers' : '')?>">
									<?if(($arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] && $arAddToBasketData["ACTION"] == "ADD") && $arAddToBasketData["CAN_BUY"]):?>
										<div class="counter_block" data-offers="<?=($arItem["OFFERS"] ? "Y" : "N");?>" data-item="<?=$arItem["ID"];?>">
											<span class="minus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_DOWN']; ?>">-</span>
											<input type="text" class="text" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" />
											<span class="plus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_UP']; ?>" <?=($arAddToBasketData["MAX_QUANTITY_BUY"] ? "data-max='".$arAddToBasketData["MAX_QUANTITY_BUY"]."'" : "")?>>+</span>
										</div>
									<?endif;?>
									<div id="<?=$arItemIDs["ALL_ITEM_IDS"]['BASKET_ACTIONS']; ?>" class="button_block <?=(($arAddToBasketData["ACTION"] == "ORDER"/*&& !$arItem["CAN_BUY"]*/) || !$arAddToBasketData["CAN_BUY"] || !$arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] || $arAddToBasketData["ACTION"] == "SUBSCRIBE" ? "wide" : "");?>">
										<!--noindex-->
											<?=$arAddToBasketData["HTML"]?>
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
											"ID" => $arItemIDs["strMainID"],
										)?>
										<script type="text/javascript">
											var <? echo $arItemIDs["strObName"]; ?>el = new JCCatalogSectionOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
										</script>
									<?endif;?>
								<?}?>
							<?elseif($arItem["OFFERS"]):?>
								<?if(empty($arItem['OFFERS_PROP'])){?>
									<div class="offer_buy_block buys_wrapp woffers">
										<div class="counter_wrapp">
										<?
										$arItem["OFFERS_MORE"] = "Y";
										$arAddToBasketData = CNext::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'small read_more1', $arParams);?>
										<!--noindex-->
											<?=$arAddToBasketData["HTML"]?>
										<!--/noindex-->
										</div>
									</div>
								<?}else{?>
									<div class="offer_buy_block">
										<?
										$arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IS_OFFER'] = 'Y';
										$arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
										$arAddToBasketData = CNext::GetAddToBasketArray($arItem["OFFERS"][$arItem["OFFERS_SELECTED"]], $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'small', $arParams);
										?>
										<div class="counter_wrapp">
											<?if(($arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] && $arAddToBasketData["ACTION"] == "ADD") && $arAddToBasketData["CAN_BUY"]):?>
												<div class="counter_block" data-item="<?=$arItem["OFFERS"][$arItem["OFFERS_SELECTED"]]["ID"];?>">
													<span class="minus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_DOWN']; ?>">-</span>
													<input type="text" class="text" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" />
													<span class="plus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_UP']; ?>" <?=($arAddToBasketData["MAX_QUANTITY_BUY"] ? "data-max='".$arAddToBasketData["MAX_QUANTITY_BUY"]."'" : "")?>>+</span>
												</div>
											<?endif;?>
											<div id="<?=$arItemIDs["ALL_ITEM_IDS"]['BASKET_ACTIONS']; ?>" class="button_block <?=(($arAddToBasketData["ACTION"] == "ORDER"/*&& !$arItem["CAN_BUY"]*/)  || !$arAddToBasketData["CAN_BUY"] || !$arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] || $arAddToBasketData["ACTION"] == "SUBSCRIBE" ? "wide" : "");?>">
												<!--noindex-->
													<?=$arAddToBasketData["HTML"]?>
												<!--/noindex-->
											</div>
										</div>
									</div>
									<?
									if(isset($arCurrentSKU['PRICE_MATRIX']) && $arCurrentSKU['PRICE_MATRIX']) // USE_PRICE_COUNT
									{?>
										<?if($arCurrentSKU['ITEM_PRICE_MODE'] == 'Q' && count($arCurrentSKU['PRICE_MATRIX']['ROWS']) > 1):?>
											<?$arOnlyItemJSParams = array(
												"ITEM_PRICES" => $arCurrentSKU["ITEM_PRICES"],
												"ITEM_PRICE_MODE" => $arCurrentSKU["ITEM_PRICE_MODE"],
												"ITEM_QUANTITY_RANGES" => $arCurrentSKU["ITEM_QUANTITY_RANGES"],
												"MIN_QUANTITY_BUY" => $arAddToBasketData["MIN_QUANTITY_BUY"],
												"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
												"ID" => $arItemIDs["strMainID"],
												"NOT_SHOW" => "Y",
											)?>
											<script type="text/javascript">
												var <? echo $arItemIDs["strObName"]; ?>el = new JCCatalogSectionOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
											</script>
										<?endif;?>
									<?}?>
								<?}?>
							<?endif;?>
						</div>
						<div class="basket_props_block" id="bx_basket_div_<?=$arItem["ID"];?>">

							
                        </div>
					</td></tr>
				</table>
			</div>
		<?}?>
	<?if($arParams["AJAX_REQUEST"]=="N"){?>
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
<?}?>

<script>
	function realWidth(obj){
		var clone = obj.clone();
		clone.css("visibility","hidden");
		$('body').append(clone);
		var width = clone.width()+0;
		clone.remove();
		return width;
	}
	function setPropWidth(){
		if($('table.props_list.offers').length){
			$('table.props_list.offers').each(function(){
				$(this).width(realWidth($(this).closest('.props_list_wrapp').find("table.props_list.prod")));
			});
		}
	}
	setPropWidth();
	BX.message({
		QUANTITY_AVAILIABLE: '<? echo COption::GetOptionString("aspro.next", "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID); ?>',
		QUANTITY_NOT_AVAILIABLE: '<? echo COption::GetOptionString("aspro.next", "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS"), SITE_ID); ?>',
		ADD_ERROR_BASKET: '<? echo GetMessage("ADD_ERROR_BASKET"); ?>',
		ADD_ERROR_COMPARE: '<? echo GetMessage("ADD_ERROR_COMPARE"); ?>',
	})
	
</script>
