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
			<a class="<?=isset($style["a"])?$style["a"]:""?> dark-color<?=($bParent ? ' parent' : '')?>" href="<?=$arItem["LINK"]?>">
 				<div class="mob_menu_img"><img src="<?=CFile::ResizeImageGet($arItem['PARAMS']['PICTURE'],array("width" => 50, "height" => 50))['src'];;?>" /></div>
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
						<?$bShowChilds = $arParams['MAX_LEVEL'] > $arSubItem['DEPTH_LEVEL'];?>
						<?$bParent = $arSubItem['CHILD'] && $bShowChilds;?>
						<li<?=($arSubItem['SELECTED'] ? ' class="selected"' : '')?>>
							<a class="dark-color<?=($bParent ? ' parent' : '')?>" href="<?=$arSubItem["LINK"]?>">
                                <div class="mob_menu_img"><img src="<?=CFile::ResizeImageGet($arSubItem['PARAMS']['PICTURE'],array("width" => 50, "height" => 50))['src'];?>" /></div>
                                <?php
                                $name_cat0 = $arSubItem["TEXT"];
                                $uf_arresult0 = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "NAME" => $arSubItem['TEXT']), false, Array("NAME","UF_SHORT_NAME"));
                                if($uf_value0 = $uf_arresult0->GetNext()):
                                    //print_r($uf_value);
                                    if(strlen($uf_value0["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                                        $name_cat0 = $uf_value0["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                                    endif;
                                endif;
                                ?>
                                <span><?=$name_cat0?></span>
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
                                        <?php
                                        $name_cat1 = $arSubSubItem["TEXT"];
                                        $uf_arresult1 = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "NAME" => $arSubSubItem['TEXT']), false, Array("NAME","UF_SHORT_NAME"));
                                        if($uf_value1 = $uf_arresult1->GetNext()):
                                            //print_r($uf_value);
                                            if(strlen($uf_value1["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                                                $name_cat1 = $uf_value1["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                                            endif;
                                        endif;
                                        ?>
										<li<?=($arSubSubItem['SELECTED'] ? ' class="selected"' : '')?>>
											<a class="dark-color<?=($bParent ? ' parent' : '')?>" href="<?=$arSubSubItem["LINK"]?>">
												<span><?=$name_cat1?></span>
												<?if($bParent):?>
													<span class="arrow"><i class="svg svg_triangle_right"></i></span>
												<?endif;?>
											</a>
											<?if($bParent):?>
												<ul class="dropdown">
													<li class="menu_back"><a href="" class="dark-color" rel="nofollow"><i class="svg svg-arrow-right"></i><?=GetMessage('NEXT_T_MENU_BACK')?></a></li>
													<li class="menu_title"><a href="<?=$arSubSubItem['LINK'];?>"><?=$arSubSubItem['TEXT']?></a></li>
													<?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
                                                        <?php
                                                        $name_cat2 = $arSubSubSubItem["TEXT"];
                                                        $uf_arresult2 = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "NAME" => $arSubSubSubItem['TEXT']), false, Array("NAME","UF_SHORT_NAME"));
                                                        if($uf_value2 = $uf_arresult2->GetNext()):
                                                            //print_r($uf_value);
                                                            if(strlen($uf_value2["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                                                                $name_cat2 = $uf_value2["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                                                            endif;
                                                        endif;
                                                        ?>
														<li<?=($arSubSubSubItem['SELECTED'] ? ' class="selected"' : '')?>>
															<a class="dark-color" href="<?=$arSubSubSubItem["LINK"]?>">
																<span><?=$name_cat2?></span>
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