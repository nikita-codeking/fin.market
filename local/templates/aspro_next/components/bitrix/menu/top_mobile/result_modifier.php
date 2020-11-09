<?$arResult = CNext::getChilds($arResult);
global $arRegion, $arTheme;

if(isset($arTheme['HEADER_MOBILE_MENU_CATALOG_EXPANDED']['VALUE']) && $arTheme['HEADER_MOBILE_MENU_CATALOG_EXPANDED']['VALUE'] === 'Y') {
    $arParams["CATALOG_MENU_EXPANDED"] = "Y";
}

if($arResult){
	foreach($arResult as $key=>$arItem)
	{
		if(isset($arItem['CHILD']))
		{
			foreach($arItem['CHILD'] as $key2=>$arItemChild)
			{
				if(isset($arItemChild['PARAMS']) && $arRegion && $arTheme['USE_REGIONALITY']['VALUE'] === 'Y' && $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_FILTER_ITEM']['VALUE'] === 'Y')
				{
					// filter items by region
					if(isset($arItemChild['PARAMS']['LINK_REGION']))
					{
						if($arItemChild['PARAMS']['LINK_REGION'])
						{
							if(!in_array($arRegion['ID'], $arItemChild['PARAMS']['LINK_REGION']))
								unset($arResult[$key]['CHILD'][$key2]);
						}
						else
							unset($arResult[$key]['CHILD'][$key2]);
					}
				}
			}
		}
	}
}
?>
<?
if(!function_exists('show_top_mobile_li')){
    function show_top_mobile_li($arItem, $arParams, $bParent, $style = array()){
    ?>
		<li<?=($arItem['SELECTED'] ? ' class="selected"' : '')?>>
			<a class="<?=isset($style["a"])?$style["a"]:""?> dark-color<?=($bParent ? ' parent' : '')?>" href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>">
				<span><?=$arItem['TEXT']?></span>
				<?if($bParent):?>
					<span class="arrow"><i class="svg svg_triangle_right"></i></span>
				<?endif;?>
			</a>
			<?if($bParent):?>
				<ul class="dropdown">
					<li class="menu_back"><a href="" class="dark-color" rel="nofollow"><i class="svg svg-arrow-right"></i><?=GetMessage('NEXT_T_MENU_BACK')?></a></li>
					<li class="menu_title"><a href="<?=$arItem['LINK'];?>"><?=$arItem['TEXT']?></a></li>
					<?foreach($arItem['CHILD'] as $arSubItem):?>
						<?
						/*if (strpos($arSubItem["LINK"], 'ipotechnoe_strakhovanie') !== false)
						{
							$arSubItem["LINK"]=$arSubItem["LINK"].'sravnenie_tsen_polisov_ipotechnogo_strakhovaniya/';
						}
						if (strpos($arSubItem["LINK"], 'osago') !== false)
						{
							$arSubItem["LINK"]=$arSubItem["LINK"].'sravni_ru_strakhovanie_osago/';
						}
						if (strpos($arSubItem["LINK"], 'kasko') !== false)
						{
							$arSubItem["LINK"]=$arSubItem["LINK"].'strakhovanie_kasko/';
						}
						if (strpos($arSubItem["LINK"], 'strakhovanie_puteshestvennikov') !== false)
						{
							$arSubItem["LINK"]=$arSubItem["LINK"].'strakhovanie_turistov/';
						}
						if (strpos($arSubItem["LINK"], 'sportivnoe_strakhovanie') !== false)
						{
							$arSubItem["LINK"]=$arSubItem["LINK"].'sportivnoe_strakhovanie_sravnenie/';
						}*/
						?>
						<?$bShowChilds = $arParams['MAX_LEVEL'] > $arSubItem['DEPTH_LEVEL'];?>
						<?$bParent = $arSubItem['CHILD'] && $bShowChilds;?>
						<li<?=($arSubItem['SELECTED'] ? ' class="selected"' : '')?>>
							<a class="dark-color<?=($bParent ? ' parent' : '')?>" href="<?=$arSubItem["LINK"]?>" title="<?=$arSubItem["TEXT"]?>">
                                <?php
                                $name_cat = $arSubItem["TEXT"];
                                $uf_arresult = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "NAME" => $arSubItem["TEXT"]), false, Array("NAME","UF_SHORT_NAME"));
                                if($uf_value = $uf_arresult->GetNext()):
                                    //print_r($uf_value);
                                    if(strlen($uf_value["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                                        $name_cat = $uf_value["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                                    endif;
                                endif;
                                ?>
                                <?
                                //echo "<pre>";
                                //print_r($arSubItem);
                                //echo "</pre>";
                                ?>
								<span><?=$name_cat?></span>
								<?if($bParent):?>
									<span class="arrow"><i class="svg svg_triangle_right"></i></span>
								<?endif;?>
							</a>
							<?if($bParent):?>
								<ul class="dropdown">
									<li class="menu_back"><a href="" class="dark-color" rel="nofollow"><i class="svg svg-arrow-right"></i><?=GetMessage('NEXT_T_MENU_BACK')?></a></li>
									<li class="menu_title"><a href="<?=$arSubItem['LINK'];?>"><?=$arSubItem['TEXT']?></a></li>
									<?foreach($arSubItem["CHILD"] as $arSubSubItem):?>
										<?$bShowChilds = $arParams['MAX_LEVEL'] > $arSubSubItem['DEPTH_LEVEL'];?>
										<?$bParent = $arSubSubItem['CHILD'] && $bShowChilds;?>
										<li<?=($arSubSubItem['SELECTED'] ? ' class="selected"' : '')?>>
											<a class="dark-color<?=($bParent ? ' parent' : '')?>" href="<?=$arSubSubItem["LINK"]?>" title="<?=$arSubSubItem["TEXT"]?>">
												<span><?=$arSubSubItem['TEXT']?></span>
												<?if($bParent):?>
													<span class="arrow"><i class="svg svg_triangle_right"></i></span>
												<?endif;?>
											</a>
											<?if($bParent):?>
												<ul class="dropdown">
													<li class="menu_back"><a href="" class="dark-color" rel="nofollow"><i class="svg svg-arrow-right"></i><?=GetMessage('NEXT_T_MENU_BACK')?></a></li>
													<li class="menu_title"><a href="<?=$arSubSubItem['LINK'];?>"><?=$arSubSubItem['TEXT']?></a></li>
													<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
														<li<?=($arSubSubSubItem['SELECTED'] ? ' class="selected"' : '')?>>
															<a class="dark-color" href="<?=$arSubSubSubItem["LINK"]?>" title="<?=$arSubSubSubItem["TEXT"]?>">
																<span><?=$arSubSubSubItem['TEXT']?></span>
															</a>
														</li>
													<?endforeach;?>
												</ul>
											<?endif;?>
										</li>
									<?endforeach;?>
								</ul>
							<?endif;?>
						</li>
					<?endforeach;?>
				</ul>
			<?endif;?>
		</li>
    <?
	}
}
?>