<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<? if(!empty( $arResult ))
{
	global $arTheme;
	echo '<div class="menu_top_block catalog_block">';
    $invis_left_menu = "";
    foreach($arResult as $key => $arItem)
    {
        foreach($arItem["CHILD"] as $arChildItem)
        {
            if($arChildItem["SELECTED"]){
                $invis_left_menu = " invisibilite";
                break;
            }
        }
    }
	echo '<ul class="menu dropdown'.$invis_left_menu.'">';
	foreach($arResult as $key => $arItem)//главный каталог
	{
		if(!$arItem["CHILD"])continue;
		$page = $APPLICATION->GetCurPage();
		$pos = strpos($page, $arItem["CODE"]);
		if ($pos === false) continue;

		foreach($arItem["CHILD"] as $arChildItem)
		{
			?>
			<li class="full <?=($arChildItem["SELECTED"] ? "current opened" : "");?> m_<?=strtolower($arTheme["MENU_POSITION"]["VALUE"]);?> v_<?=strtolower($arTheme["MENU_TYPE_VIEW"]["VALUE"]);?>">
				<a style="font-size: 14px;font-weight: 600;" class="icons_fa <?=($arItem["CHILD"] ? "parent" : "");?>" href="<?=$arChildItem["SECTION_PAGE_URL"]?>" >
				<?if($arChildItem["IMAGES"] && $arTheme["LEFT_BLOCK_CATALOG_ICONS"]["VALUE"] == "Y"){?>
				<span class="image"><img src="<?=$arChildItem["IMAGES"]["src"];?>" alt="<?=$arChildItem["NAME"];?>" /></span>
				<?}?>
				<span class="name">
					<?if($arChildItem["UF_SHORT_NAME"]){?>
						<?=$arChildItem["UF_SHORT_NAME"]?>
					<?}else{?>
						<?=$arChildItem["NAME"]?>
					<?}?>
				</span>
				<div class="toggle_block"></div>
				<div class="clearfix"></div>
				</a>
			</li>
		<?}
	} 
	echo '</ul>';
	echo '</div>';
}?>