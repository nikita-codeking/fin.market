<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?
$frame = $this->createFrame()->begin("");
$templateData = array(
	//'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);
$injectId = $arParams['UNIQ_COMPONENT_ID'];

if (isset($arResult['REQUEST_ITEMS']))
{
	// code to receive recommendations from the cloud
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>
    <?//=$signedParameters . '</br>';?>
    <?//=$signedTemplate . '</br>';?>
    <?//=SITE_ID . '</br>';?>

	<span id="<?=$injectId?>"></span>

	<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
            $("#tbs").on({
                mouseenter: function () {
                    if ($("#tbs").height()>0)
                {
                    if ($("#tbs .sm-text").length>1) $("#tbs").height($("#tbs").height()+120);
                    else $("#tbs").height($("#tbs").height()+50);
                }
                },
                mouseleave: function () {
                    if ($("#tbs").height()>0)
                {
                    if ($("#tbs .sm-text").length>1) $("#tbs").height($("#tbs").height()-120);
                    else $("#tbs").height($("#tbs").height()-50);
                }
                }
            });
		});
	</script>
	<?
	$frame->end();
	return;

	// \ end of the code to receive recommendations from the cloud
}
if($arResult['ITEMS']){?>
	<?$arResult['RID'] = ($arResult['RID'] ? $arResult['RID'] : (\Bitrix\Main\Context::getCurrent()->getRequest()->get('RID') != 'undefined' ? \Bitrix\Main\Context::getCurrent()->getRequest()->get('RID') : '' ));?>
	<input type="hidden" name="bigdata_recommendation_id" value="<?=htmlspecialcharsbx($arResult['RID'])?>">
	<div id="<?=$injectId?>_items" class="bigdata_recommended_products_items">
		<?$class_block="s_".$this->randString();?>
		<div class="viewed_slider common_product wrapper_block recomendation <?=$class_block;?>">
			<div class="top_block">
				<?
				$arParams["TITLE_BLOCK"] = "Вас заинтересует";
				$title_block=($arParams["TITLE_BLOCK"] ? $arParams["TITLE_BLOCK"] : GetMessage('RECOMENDATION_TITLE'));?>
				<div class="title_block"><?=$title_block;?></div>
			</div>
			<ul class="viewed_navigation slider_navigation top_big custom_flex border"></ul>
			<div class="all_wrapp basket">
				<div class="content_inner tab flexslider loading_state shadow border custom_flex top_right" data-plugin-options='{"animation": "slide", "animationSpeed": 600, "directionNav": true, "controlNav" :false, "animationLoop": true, "slideshow": false, "controlsContainer": ".viewed_navigation", "counts": [5,4,3,2,1]}'>
					<ul class="tabs_slider slides catalog_block">
						<?foreach ($arResult['ITEMS'] as $key => $arItem){?>
							<?$strMainID = $this->GetEditAreaId($arItem['ID'] . $key);?>
							<li class="catalog_item visible" id="<?=$strMainID;?>">
								<?
								$totalCount = CNext::GetTotalCount($arItem, $arParams);
								$arQuantityData = CNext::GetQuantityArray($totalCount);
								$arItem["FRONT_CATALOG"]="Y";
								$arItem["RID"]=$arResult["RID"];
								$arAddToBasketData = CNext::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], true);

								$elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);

								$strMeasure='';
								if($arItem["OFFERS"]){
									$strMeasure=$arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
								}else{
									if (($arParams["SHOW_MEASURE"]=="Y")&&($arItem["CATALOG_MEASURE"])){
										$arMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
										$strMeasure=$arMeasure["SYMBOL_RUS"];
									}
								}
								?>

								<div class="inner_wrap">
									<div class="image_wrapper_block">
										<a href="<?=$arItem["DETAIL_PAGE_URL"]?><?=($arResult["RID"] ? '?RID='.$arResult["RID"] : '')?>" class="thumb shine">
											<div class="stickers 28">
												<?$prop = ($arParams["STIKERS_PROP"] ? $arParams["STIKERS_PROP"] : "HIT");?>
												<?foreach(CNext::GetItemStickers($arItem["PROPERTIES"][$prop]) as $arSticker):?>
													<div><div class="<?=$arSticker['CLASS']?>"><?=$arSticker['VALUE']?></div></div>
												<?endforeach;?>
												<?if($arParams["SALE_STIKER"] && $arItem["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"]){?>
													<div><div class="sticker_sale_text"><?=$arItem["PROPERTIES"][$arParams["SALE_STIKER"]]["VALUE"];?></div></div>
												<?}?>
											</div>
											<?if($arParams["DISPLAY_WISH_BUTTONS"] != "N" || $arParams["DISPLAY_COMPARE"] == "Y"):?>
												<div class="like_icons">
													<?if($arAddToBasketData["CAN_BUY"] && empty($arItem["OFFERS"]) && $arParams["DISPLAY_WISH_BUTTONS"] != "N"):?>
														<div class="wish_item_button" <?=($arAddToBasketData["CAN_BUY"] ? '' : 'style="display:none"');?>>
															<span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item to" data-item="<?=$arItem["ID"]?>"><i></i></span>
															<span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item in added" style="display: none;" data-item="<?=$arItem["ID"]?>"><i></i></span>
														</div>
													<?endif;?>
													<?if($arParams["DISPLAY_COMPARE"] == "Y"):?>
														<div class="compare_item_button">
															<span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>" ><i></i></span>
															<span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>"><i></i></span>
														</div>
													<?endif;?>
												</div>
											<?endif;?>
											<?
											$a_alt = ($arItem["PREVIEW_PICTURE"] && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"] : $arItem["NAME"] ));
											$a_title = ($arItem["PREVIEW_PICTURE"] && strlen($arItem["PREVIEW_PICTURE"]['DESCRIPTION']) ? $arItem["PREVIEW_PICTURE"]['DESCRIPTION'] : ($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"] : $arItem["NAME"] ));
											?>
											<?if(!empty($arItem["PREVIEW_PICTURE"])):?>
												<img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
											<?elseif(!empty($arItem["DETAIL_PICTURE"])):?>
												<?$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array("width" => 170, "height" => 170), BX_RESIZE_IMAGE_PROPORTIONAL, true );?>
												<img border="0" src="<?=$img["src"]?>" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
											<?else:?>
												<img border="0" src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_medium.png" alt="<?=$a_alt;?>" title="<?=$a_title;?>" />
											<?endif;?>
											
										</a>
									</div>
									<div class="item_info">
										<div class="item-title">
											<a href="<?=$arItem["DETAIL_PAGE_URL"]?><?=($arResult["RID"] ? '?RID='.$arResult["RID"] : '')?>" class="dark_link"><span><?=$elementName?></span></a>
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
									</div>
									<div class="footer_button">
										<? $arAddToBasketData["HTML"] = str_replace("Подробнее","Оформить",$arAddToBasketData["HTML"]);
										?>
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
                                                        <td><span class="sm-text"><?=$tag_b_start?><?=$arProp["NAME"]?><?=$tag_b_end?></span></td>
                                                        <td><span class="sm-text"><?=$tag_b_start?><?=$val?><?=$pr?><?=$tag_b_end?></span></td>
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
							</li>
						<?}?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?}
$frame->end();?>