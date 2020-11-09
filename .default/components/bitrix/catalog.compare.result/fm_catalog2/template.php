<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$isAjax = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["ajax_action"]) && $_POST["ajax_action"] == "Y");?>
<!-- noindex -->
<?
$compare_sort = "";
if(isset($_SESSION['SORT_COMPARE'])){
    $compare_sort = $_SESSION['SORT_COMPARE'];
}
?>
<div class="scroll_btns">
    <span class="wrap_remove_button">
        <span class="btn btn-default white grey scroll_left icon_close"> < </span>
    </span>
    <span class="wrap_remove_button">
        <span class="btn btn-default white grey scroll_right icon_close"> > </span>
    </span>
</div>

<div class="bx_sort_container tabs">
	<span class="wrap_remove_button line_button">
        <?$sec_foreach = 0;?>
        <?$arr_in_sec = array();?>
        <?foreach($arResult["ITEMS"] as $arElement){?>
            <?if($sec_foreach!=$arElement['IBLOCK_SECTION_ID'] && !in_array($arElement['IBLOCK_SECTION_ID'],$arr_in_sec)):?>
                <?$nameSection = "";?>
                <?$arr_in_sec[] = $arElement['IBLOCK_SECTION_ID'];?>
                <?$resSectionName = CIBlockSection::GetByID($arElement['IBLOCK_SECTION_ID']);
                if($arSectionName = $resSectionName->GetNext())
                    $nameSection = $arSectionName['NAME'];
                ?>
                <span class="btn btn-default white grey filter_compare icon_close"><span style="display: none;"><?=$arElement['IBLOCK_SECTION_ID']?></span><?=$nameSection?></span>
            <?endif;?>
            <?$sec_foreach=$arElement['IBLOCK_SECTION_ID'];?>
        <?}?>
		<?$arStr=$arCompareIDs=array();
        if($arResult["ITEMS"])
        {
            foreach($arResult["ITEMS"] as $arItem)
            {
                $arCompareIDs[]=$arItem["ID"];
            }
        }
        $arStr=implode("&ID[]=", $arCompareIDs)?>
        <span class="btn btn-default white grey remove_all_compare icon_close" onclick="CatalogCompareObj.MakeAjaxAction('/catalog/compare.php?action=DELETE_FROM_COMPARE_RESULT&ID[]=<?=$arStr?>', 'Y');"><?=GetMessage("CLEAR_ALL_COMPARE")?></span>

    </span>
</div>
<!-- noindex -->
<div class="bx_compare" id="bx_catalog_compare_block">
<?if ($isAjax){
	$APPLICATION->RestartBuffer();
}?>

<?php
//kk-->
$typeVisa = Array(
    524 => "HARAKTERISTIKI_VISA_CLASSIC",
    529 => "HARAKTERISTIKI_VISA_PLATINUM",
    530 => "HARAKTERISTIKI_VISA_SIGNATURE",
    531 => "HARAKTERISTIKI_VISA_GOLD",
    532 => "HARAKTERISTIKI_VISA_PREPAID",
    533 => "HARAKTERISTIKI_VISA_UNEMBOSSED",
    534 => "HARAKTERISTIKI_VISA_INSTANT_ISSUE"
);
$typeMastercard  = Array(
    525 => "HARAKTERISTIKI_MASTERCARD_STANDARD",
    526 => "HARAKTERISTIKI_MASTERCARD_GOLD",
    527 => "HARAKTERISTIKI_MASTERCARD_PLATINUM",
    528 => "HARAKTERISTIKI_MASTERCARD_WORLD"
);
//<--kk
?>

<div class="table_compare wrap_sliders tabs-body">
	<?if($arResult["SHOW_FIELDS"]):?>
		<div class="frame top">
			<div class="wraps">
				<table class="compare_view top">
					<tr>
						<?foreach($arResult["ITEMS"] as &$arElement){?>
                            <?php
                            /**
                             * если есть отбор в сессии - оставляем только эти разделы
                             */
                            if(isset($_GET['section_compare'])){
                                if($_GET['section_compare']!=$arElement['IBLOCK_SECTION_ID']){
                                    continue;
                                }
                            }
                            ?>
							<td>
								<div class="item_block">
									<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arElement['~DELETE_URL'])?>', 'Y');" class="remove" title="<?=GetMessage("CATALOG_REMOVE_PRODUCT")?>"><i></i></span>
									<?$name = (isset($arElement["OFFER_FIELDS"]["NAME"]) ? $arElement["OFFER_FIELDS"]["NAME"] : $arElement["NAME"]);?>
									<?if($arParams['SKU_DETAIL_ID'] && isset($arElement["OFFER_FIELDS"]["ID"]))
										$arElement["DETAIL_PAGE_URL"] .= '?oid='.$arElement["OFFER_FIELDS"]["ID"];?>
									<div class="image_wrapper_block">
										<?if($arElement["OFFER_FIELDS"]["PREVIEW_PICTURE"]){
												if(is_array($arElement["OFFER_FIELDS"]["PREVIEW_PICTURE"]))
													$img = $arElement["OFFER_FIELDS"]["PREVIEW_PICTURE"];
												else
													$img = CFile::GetFileArray($arElement["OFFER_FIELDS"]["PREVIEW_PICTURE"]);?>
												<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=$img["SRC"]?>" alt="<?=$img["ALT"]?>" title="<?=$img["TITLE"]?>" /></a>
										<?}elseif($arElement["FIELDS"]["PREVIEW_PICTURE"]){
											if(is_array($arElement["FIELDS"]["PREVIEW_PICTURE"])):?>
												<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=$arElement["FIELDS"]["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement["FIELDS"]["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arElement["FIELDS"]["PREVIEW_PICTURE"]["TITLE"]?>" /></a>
											<?endif;?>
										<?}elseif($arElement["FIELDS"]["DETAIL_PICTURE"]){
											if(is_array($arElement["FIELDS"]["DETAIL_PICTURE"])):?>
												<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=$arElement["FIELDS"]["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arElement["FIELDS"]["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arElement["FIELDS"]["DETAIL_PICTURE"]["TITLE"]?>" /></a>
											<?endif;
										}else{?>
												<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=SITE_TEMPLATE_PATH?>/images/no_photo_medium.png" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a>
										<?}?>
									</div>
                                    <?
                                    $ulr_fast = $arElement["DETAIL_PAGE_URL"];
                                    $ulr_fast = str_replace('/','%2F',$ulr_fast);
                                    $ulr_fast = str_replace('?','%3F',$ulr_fast);
                                    $ulr_fast = str_replace('=','%3D',$ulr_fast);
                                    ?>
                                    <div class="fast_view_block" data-event="jqm" data-param-form_id="fast_view"
                                         data-param-iblock_id="17" data-param-id="<?=$arElement['ID']?>"
                                         data-param-item_href="<?=$ulr_fast?>"
                                         data-name="fast_view">
                                        Быстрый просмотр
                                    </div>
                                    <?if(strlen(trim($arElement['OFFER_PROPERTIES']['URL2']['VALUE']))>0):?>
                                        <?
                                        if(strpos(trim($arElement['OFFER_PROPERTIES']['URL2']['VALUE']) ,'admitad') >-1){
                                            $referer=trim($arElement['OFFER_PROPERTIES']['URL2']['VALUE']) . "subid/" .$_COOKIE['utm_source'] ;

                                        }else{
                                            $referer=trim($arElement['OFFER_PROPERTIES']['URL2']['VALUE']) ."&sa=".$_COOKIE['utm_source'] ;
                                        }
                                        ?>
                                        <a class="btn btn-default ofo-href desc" style="display: block;width: 100%;margin-top: 20px" onClick="ym('56316898','reachGoal', 'oformit');" target="_blank" href="<?=$referer?>"><?=GetMessage("LIST_BUTTON_OFO");?></a>
                                    <?endif;?>
									<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="title"><?=$arElement["NAME"];?></a>
									<div class="cost prices clearfix">
										<?
										$frame = $this->createFrame()->begin('');
										$frame->setBrowserStorage(true);
										?>
										<?if (isset($arElement['MIN_PRICE']) && is_array($arElement['MIN_PRICE'])):?>
											<div class="price"><?=(isset($arElement['MIN_PRICE']['SUFFIX']) && $arElement['MIN_PRICE']['SUFFIX'] ? $arElement['MIN_PRICE']['SUFFIX'] : '')?><?=$arElement['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];?></div>
										<?elseif(!empty($arElement['PRICE_MATRIX']) && is_array($arElement['PRICE_MATRIX'])):?>
											<?
											$matrix = $arElement['PRICE_MATRIX'];
											$rows = $matrix['ROWS'];
											$rowsCount = count($rows);
											if($rowsCount > 0):?>
												<div class="price_matrix_block">
													<div class="price_matrix_wrapper">
														<?if (count($rows) > 1):?>
															<?foreach ($rows as $index => $rowData):?>
																<?if (empty($matrix['MIN_PRICES'][$index]))
																	continue;?>
																<div class="price_wrapper_block">
																	<?if($rowData['QUANTITY_FROM'] == 0)
																		$rowData['QUANTITY_FROM'] = '';
																	if($rowData['QUANTITY_TO'] == 0)
																		$rowData['QUANTITY_TO'] = '';
																	?>
																	<div class="price_interval">
																		<?
																		$quantity_from = $rowData['QUANTITY_FROM'];
																		$quantity_to = $rowData['QUANTITY_TO'];
																		$text = ($quantity_to ? ($quantity_from ? $quantity_from.'-'.$quantity_to : '<'.$quantity_to ) : '>'.$quantity_from );
																		?>
																		<?=$text;?><?if($arParams['SHOW_MEASURE'] == 'Y'):?><?=GetMessage('MEASURE_UNIT');?><?endif;?>
																	</div>
																	<div class="price">
																		<span class="values_wrapper">
																			<?
																			$val = '';
																			$format_value = \CCurrencyLang::CurrencyFormat($matrix['MIN_PRICES'][$index]['PRICE'], $matrix['MIN_PRICES'][$index]['CURRENCY']);
																			echo $format_value;
																			?>
																		</span>
																	</div>
																</div>
															<?endforeach;?>
															<?unset($index, $rowData);?>
														<?else:?>
															<?$currentPrice = current($matrix['MIN_PRICES']);
															echo '<div class="price">'.\CCurrencyLang::CurrencyFormat($currentPrice['PRICE'], $currentPrice['CURRENCY']).'</div>';
															unset($currentPrice);?>
														<?endif;?>
													</div>
												</div>
											<?endif;?>
											<?unset($rowsCount, $rows, $matrix);?>
										<?endif;?>
										<?$frame->end();?>
									</div>
								</div>
							</td>
						<?}?>
					</tr>
				</table>
			</div>
		</div>
		<div class="swipeignore compare_wr_inner">
			<div class="wrapp_scrollbar">
				<div class="wr_scrollbar">
					<div class="scrollbar">
						<div class="handle">
							<div class="mousearea"></div>
						</div>
					</div>
				</div>
				<ul class="slider_navigation compare custom_flex">
					<ul class="flex-direction-nav">
						<li class="flex-nav-prev backward"><span class="flex-prev">Previous</span></li>
						<li class="flex-nav-next forward"><span class="flex-next">Next</span></li>
					</ul>
				</ul>
			</div>
		</div>
	<?endif;?>
	<?if($arResult["ALL_FIELDS"] || $arResult["ALL_PROPERTIES"] || $arResult["ALL_OFFER_FIELDS"] || $arResult["ALL_OFFER_PROPERTIES"]):?>
		<div class="swipeignore compare_wr_inner">
		<div class="bx_filtren_container ">
			<ul>
				<?if(!empty($arResult["ALL_FIELDS"])){
					foreach ($arResult["ALL_FIELDS"] as $propCode => $arProp){
						if (!isset($arResult['FIELDS_REQUIRED'][$propCode])){?>
							<li class="btn btn-default white <?=($arProp["IS_DELETED"] != "N" ? 'visible' : '');?>">
								<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">+<?=GetMessage("IBLOCK_FIELD_".$propCode)?></span>
							</li>
						<?}
					}
				}
				if(!empty($arResult["ALL_OFFER_FIELDS"])){
					foreach($arResult["ALL_OFFER_FIELDS"] as $propCode => $arProp){?>
						<li class="btn btn-default white <?=($arProp["IS_DELETED"] != "N" ? 'visible' : '');?>">
							<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">+<?=GetMessage("IBLOCK_FIELD_".$propCode)?></span>
						</li>
					<?}
				}
				if (!empty($arResult["ALL_PROPERTIES"])){
					foreach($arResult["ALL_PROPERTIES"] as $propCode => $arProp){?>
						<li class="btn btn-default white <?=($arProp["IS_DELETED"] != "N" ? 'visible' : '');?>">
							<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">+<?=$arProp["NAME"]?></span>
						</li>
					<?}
				}
				if (!empty($arResult["ALL_OFFER_PROPERTIES"])){
					foreach($arResult["ALL_OFFER_PROPERTIES"] as $propCode => $arProp){?>
						<li class="btn btn-default white <?=($arProp["IS_DELETED"] != "N" ? 'visible' : '');?>">
							<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">+<?=$arProp["NAME"]?></span>
						</li>
					<?}
				}?>
			</ul>
		</div>
		</div>
	<?endif;?>

	<?$arUnvisible = array("NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE");?>
	<div class="prop_title_table"></div>

	<?//make conditions array?>
	<?$arShowFileds = $arShowOfferFileds = $arShowProps = $arShowOfferProps = array();?>
	<?if($arResult["SHOW_FIELDS"])
	{
		foreach ($arResult["SHOW_FIELDS"] as $code => $arProp)
		{
			if(!in_array($code, $arUnvisible))
			{
				$showRow = true;
				if(!isset($arResult['FIELDS_REQUIRED'][$code]) || $arResult['DIFFERENT'])
				{
					$arCompare = array();
					foreach($arResult["ITEMS"] as &$arElement)
					{
						$arPropertyValue = $arElement["FIELDS"][$code];
						if(is_array($arPropertyValue))
						{
							sort($arPropertyValue);
							$arPropertyValue = implode(" / ", $arPropertyValue);
						}
						$arCompare[] = $arPropertyValue;
					}
					unset($arElement);
					$showRow = (count(array_unique($arCompare)) > 1);
				}
				if($showRow)
					$arShowFileds[$code] = $arProp;
			}
		}
	}
	if($arResult["SHOW_OFFER_FIELDS"])
	{
		foreach ($arResult["SHOW_OFFER_FIELDS"] as $code => $arProp)
		{
			$showRow = true;
			if ($arResult['DIFFERENT'])
			{
				$arCompare = array();
				foreach($arResult["ITEMS"] as &$arElement)
				{
					$Value = $arElement["OFFER_FIELDS"][$code];
					if(is_array($Value))
					{
						sort($Value);
						$Value = implode(" / ", $Value);
					}
					$arCompare[] = $Value;
				}
				unset($arElement);
				$showRow = (count(array_unique($arCompare)) > 1);
			}
			if ($showRow)
				$arShowOfferFileds[$code] = $arProp;
		}
	}
	if($arResult["SHOW_PROPERTIES"])
	{
		foreach($arResult["SHOW_PROPERTIES"] as $code => $arProperty)
		{
			$showRow = true;
			if($arResult['DIFFERENT'])
			{
				$arCompare = array();
				foreach($arResult["ITEMS"] as &$arElement)
				{
					$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
					if(is_array($arPropertyValue))
					{
						sort($arPropertyValue);
						$arPropertyValue = implode(" / ", $arPropertyValue);
					}
					$arCompare[] = $arPropertyValue;
				}
				unset($arElement);
				$showRow = (count(array_unique($arCompare)) > 1);
			}
			if($showRow){
                $arShowProps[$code] = $arProperty;
            }

		}
	}
	if($arResult["SHOW_OFFER_PROPERTIES"])
	{
		foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty)
		{
		    if($code=="URL2"){continue;}
			$showRow = true;
			if($arResult['DIFFERENT'])
			{
				$arCompare = array();
				foreach($arResult["ITEMS"] as &$arElement)
				{
					$arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
					if(is_array($arPropertyValue))
					{
						sort($arPropertyValue);
						$arPropertyValue = implode(" / ", $arPropertyValue);
					}
					$arCompare[] = $arPropertyValue;
				}
				unset($arElement);
				$showRow = (count(array_unique($arCompare)) > 1);
			}
			if($showRow){
                $arProperty['NAME'] = str_replace('Условия.','',$arProperty['NAME']);
                $arProperty['NAME'] = str_replace('Требования.','',$arProperty['NAME']);
                $arProperty['NAME'] = str_replace('Характеристики.','',$arProperty['NAME']);
                $arShowOfferProps[$code] = $arProperty;
            }

		}
	}
	?>

	<?if($arShowFileds || $arShowOfferFileds || $arShowProps || $arShowOfferProps):?>
		<div class="frame props">
			<div class="wraps">
				<table class="data_table_props compare_view">
					<?if($arShowFileds)
					{
						foreach($arShowFileds as $code => $arProp){?>
							<tr class="prop_btn">
								<td>
                                    <div onclick="clickProperty('<?=$code?>')"><?=GetMessage("IBLOCK_FIELD_".$code);?></div>
									<?if($arResult["ALL_FIELDS"][$code]){?>
										<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arResult["ALL_FIELDS"][$code]["ACTION_LINK"])?>')" class="remove"><i></i></span>
									<?}?>
								</td>
								<?foreach($arResult["ITEMS"] as $arElement){?>
                                    <?php
                                    /**
                                     * если есть отбор в сессии - оставляем только эти разделы
                                     */
                                    if(isset($_GET['section_compare'])){
                                        if($_GET['section_compare']!=$arElement['IBLOCK_SECTION_ID']){
                                            continue;
                                        }
                                    }
                                    ?>
									<td valign="top">
										<?=$arElement["FIELDS"][$code];?>
										
									</td>
								<?}
								unset($arElement);?>
							</tr>
						<?}?>
					<?}
					if($arShowOfferFileds){
						foreach ($arShowOfferFileds as $code => $arProp){?>
							<tr class="prop_btn">
								<td>
                                    <div onclick="clickProperty('<?=$code?>')"><?=GetMessage("IBLOCK_OFFER_FIELD_".$code)?></div>
									<?if($arResult["ALL_OFFER_FIELDS"][$code]){?>
										<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arResult["ALL_OFFER_FIELDS"][$code]["ACTION_LINK"])?>')" class="remove" title="<?=GetMessage("CATALOG_REMOVE_PRODUCT")?>"><i></i></span>
									<?}?>
								</td>
								<?foreach($arResult["ITEMS"] as &$arElement){?>
                                    <?php
                                    /**
                                     * если есть отбор в сессии - оставляем только эти разделы
                                     */
                                    if(isset($_GET['section_compare'])){
                                        if($_GET['section_compare']!=$arElement['IBLOCK_SECTION_ID']){
                                            continue;
                                        }
                                    }
                                    ?>
									<td>
										<?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
									</td>
								<?}
								unset($arElement);
								?>
							</tr>
						<?}
					}?>
					<?
					if($arShowProps){
						foreach ($arShowProps as $code => $arProperty){?>
							<tr class="prop_btn">
								<td>
								<div onclick="clickProperty('<?=$code?>')"><?=$arProperty["NAME"]?></div>
								<?if($arResult["ALL_PROPERTIES"][$code]){?>
									<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arResult["ALL_PROPERTIES"][$code]["ACTION_LINK"])?>')" class="remove" title="<?=GetMessage("CATALOG_REMOVE_PRODUCT")?>"><i></i></span>
								<?}?>
								</td>
								<?foreach($arResult["ITEMS"] as &$arElement){?>
                                    <?php
                                    /**
                                     * если есть отбор в сессии - оставляем только эти разделы
                                     */
                                    if(isset($_GET['section_compare'])){
                                        if($_GET['section_compare']!=$arElement['IBLOCK_SECTION_ID']){
                                            continue;
                                        }
                                    }
                                    ?>
									<td>
                                        <?php
                                        $val = $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"];
                                        if(is_array($val))
                                        {
                                            $str_val = "";
                                            foreach ($val as $itemA)
                                            {
                                                if(strlen($str_val)>0)
                                                {
                                                    $str_val = $str_val . ' | ' . $itemA;
                                                }
                                                else
                                                {
                                                    $str_val = $itemA;
                                                }
                                            }
                                            $val = $str_val;
                                        }
                                        echo $val;
                                        ?>
										<?//=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
									</td>
								<?}
								unset($arElement);
								?>
							</tr>
						<?}
					}?>
     
					<?if($arShowOfferProps){
					    //kk-->

                        echo '<tr class="prop_btn">';
                        echo '<td style="background: #e1e1e1;"></td>';
                        foreach($arResult["ITEMS"] as $arElement)
                        {
                            /**
                             * если есть отбор в сессии - оставляем только эти разделы
                             */
                            if(isset($_GET['section_compare'])){
                                if($_GET['section_compare']!=$arElement['IBLOCK_SECTION_ID']){
                                    continue;
                                }
                            }
                            echo '<td style="background: #e1e1e1;"></td>';
                        }
                        echo '</tr>';
                        //вытащим свойство на 1 место - начало
                        if(strlen($compare_sort)>0)
                        {
                            $tempArrOffProp = array();
                            $tempArrSortOffProp = array();
                            foreach($arShowOfferProps as $code=>$arProperty)
                            {
                                if($code==$compare_sort){
                                    $tempArrSortOffProp[$code] = $arProperty;
                                }else{
                                    $tempArrOffProp[$code] = $arProperty;
                                }
                            }
                            $arShowOfferProps = array();
                            foreach($tempArrSortOffProp as $code=>$arProperty)
                            {
                                $arShowOfferProps[$code] = $arProperty;
                            }
                            foreach($tempArrOffProp as $code=>$arProperty)
                            {
                                $arShowOfferProps[$code] = $arProperty;
                            }
                        }
                        //вытащим свойство на 1 место - конец

                        $is_type_cart = false;
                        $typeCardCode = "";
                        $new_array = Array();
                        //<--kk
						foreach($arShowOfferProps as $code=>$arProperty){?>
                            <?
                            //kk-->
                            if(in_array($code, $typeVisa) || in_array($code, $typeMastercard)) {
                                $is_type_cart=true;
                                foreach($arResult["ITEMS"] as &$arElement){
                                    if($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]=="Да"){
                                        $new_array[$arElement['ID']] = $arProperty['NAME'];
                                        $typeCardCode = $code;
                                    }
                                }
                                continue;
                            }
                            //<--kk
                            if(strlen($arProperty["VALUE"])==0){continue;}
                            ?>
							<tr class="prop_btn">
								<td <?if(strlen($compare_sort)>0):?>style="background: #c9ffcd;"<?endif;?>>
                                    <div onclick="clickProperty('<?=$code?>')"><?=$arProperty["NAME"]?><?if($arProperty['PROPERTY_TYPE']=="N"):?><div style="color: red;width: auto;display: inline-block;font-size: 18px;margin-left: 10px;"> &#8595;</div><?endif;?></div>
									<?if($arResult["ALL_OFFER_PROPERTIES"][$code]){?>
										<span onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arResult["ALL_OFFER_PROPERTIES"][$code]["ACTION_LINK"])?>')" class="remove" title="<?=GetMessage("CATALOG_REMOVE_PRODUCT")?>"><i></i></span>
									<?}?>
								</td>
                                <?$counterSort = 0;?>
								<?foreach($arResult["ITEMS"] as $arElement){?>
                                    <?php
                                    /**
                                     * если есть отбор в сессии - оставляем только эти разделы
                                     */
                                    if(isset($_GET['section_compare'])){
                                        if($_GET['section_compare']!=$arElement['IBLOCK_SECTION_ID']){
                                            continue;
                                        }
                                    }
                                    ?>
									<td <?if(strlen($compare_sort)>0):?>style="background: #c9ffcd;"<?endif;?>>
                                        <?
                                        $newValue = getObProp('OFFERS.'.$arProperty["NAME"],$arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]);
                                        if($newValue!=$arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]){
                                            echo $newValue;
                                        }else{
                                        ?>
										    <?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
                                        <?}?>
									</td>
								<?}
								unset($arElement);
								?>
                                <?$compare_sort="";?>
                                <?unset($_SESSION['SORT_COMPARE']);?>
							</tr>
						<?}
                        //kk-->
                        if($is_type_cart):?>
                            <tr class="prop_btn">
                                <td>
                                    <div onclick="clickProperty('<?=$typeCardCode?>')"><?=GetMessage('TYPE_CART')?></div>
                                </td>
                                <?php
                                foreach($arResult["ITEMS"] as &$arElement){
                                    if(isset($new_array[$arElement['ID']])){?>
                                       <td><?=$new_array[$arElement['ID']]?></td>
                                    <?}else{?>
                                       <td></td>
                                    <?}
                                }?>
                            </tr>
                        <?endif;
                        //<--kk
					}?>
				</table>
			</div>
		</div>
	<?endif;?>

</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(window).on('resize', function(){
			initSly();
			createTableCompare($('.data_table_props:not(.clone)'), $('.prop_title_table'), $('.data_table_props.clone'));
		});
		$(window).resize();
		$('.wraps .item_block .title').sliceHeight({'row': '.compare_view', 'item': '.item_block'});
        $(".filter_compare").click(function () {
            var thisSpan = $(this).children('span').html();
            location.href = '<?=$APPLICATION->GetCurPage()?>?section_compare='+thisSpan;
        });
	})
</script>
<?if ($isAjax){
	die();
}?>
</div>
<script type="text/javascript">
	var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block");
</script>
<?$APPLICATION->IncludeComponent(
    "fm:compare.seo",
    ".default",
    array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "N",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "ID_IBLOCK" => "34",
        "COMPONENT_TEMPLATE" => ".default"
    ),
    false
);?>