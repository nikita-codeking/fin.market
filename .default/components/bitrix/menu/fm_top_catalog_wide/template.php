<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?
global $arTheme;
$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
?>
<?if($arResult):?>
    <div class="table-menu">
        <table>
            <tr>
                <?$first=true;?>
                <?foreach($arResult as $arItem):?>
                    <?$bShowChilds = $arParams["MAX_LEVEL"] > 1;
                    $bWideMenu = $arItem["PARAMS"]['FROM_IBLOCK'];?>
                    <td class="menu-item unvisible <?=($arItem["CHILD"] ? "dropdown" : "")?> <?=($bWideMenu ? 'wide_menu' : '');?> <?=(isset($arItem["PARAMS"]["CLASS"]) ? $arItem["PARAMS"]["CLASS"] : "");?>  <?=($arItem["SELECTED"] ? "active" : "")?>">
                        <div class="wrap">
                            <?php
                            $href = 'javascript:void(0);';
                            if($arItem["LINK"]=='/ratings/' || $arItem["LINK"]=='/articles/' || $arItem["LINK"]=='/reviews/'){
                                $href = $arItem["LINK"];
                            }
                            ?>
                            <?if($arItem["TEXT"]=='Главная'):?>
                                <?$href = $arItem["LINK"];?>
                            <?endif;?>
                            <a class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown-toggle" : "")?>" href="<?=$href?>">
                                <div>
                                    <?if(isset($arItem["PARAMS"]["CLASS"]) && strpos($arItem["PARAMS"]["CLASS"], "sale_icon") !== false):?>
                                        <?=CNext::showIconSvg('sale', SITE_TEMPLATE_PATH.'/images/svg/Sale.svg', '', '');?>
                                    <?endif;?>
                                    <?if($arItem["TEXT"]=='Главная'):?>
                                        <img height="30" src="<?=SITE_TEMPLATE_PATH?>/images/icon_main_menu.png" />
                                    <?else:?>
                                        <?=$arItem["TEXT"]?>
                                    <?endif;?>
                                    <?if($first!=true):?><div class="line-wrapper"><span class="line"></span></div><?endif;?>
                                </div>
                            </a>
                            <?$first=false;?>
                            <?if($arItem["CHILD"] && $bShowChilds):?>
                                <span class="tail"></span>
                                <ul class="dropdown-menu">
                                    <?foreach($arItem["CHILD"] as $arSubItem):?>
                                        <?$bShowChilds = $arParams["MAX_LEVEL"] > 2;?>
                                        <?$bHasPicture = (isset($arSubItem['PARAMS']['PICTURE']) && $arSubItem['PARAMS']['PICTURE'] && $arTheme['SHOW_CATALOG_SECTIONS_ICONS']['VALUE'] == 'Y');?>
                                        <li class="<?=($arSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu" : "")?> <?=($arSubItem["SELECTED"] ? "active" : "")?> <?=($bHasPicture ? "has_img" : "")?>">
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
                                            <a href="<?=$arSubItem["LINK"]?>">
                                                <?$set_img = false;?>
                                                <?if($bHasPicture && $bWideMenu):
                                                    $arImg = CFile::ResizeImageGet($arSubItem['PARAMS']['PICTURE'], array('width' => 150, 'height' => 150), BX_RESIZE_PROPORTIONAL_ALT);
                                                    if(is_array($arImg)):?>
                                                        <div class="menu_img"><img src="<?=$arImg["src"]?>" class="123" /></div>
                                                        <?$set_img = true;?>
                                                    <?endif;?>
                                                <?endif;?>
                                                <?if(!$set_img):?>
                                                    <?
                                                    $imgLink = "/local/templates/aspro_next/images/svg/catalog_category_noimage.svg";
                                                    if($arSubItem["TEXT"] == "Все рейтинги") {
                                                        $imgLink = "/local/templates/aspro_next/images/sections/mob_menu/reitingi_mob.png";
                                                    } elseif ($arSubItem["TEXT"] == "Все обзоры") {
                                                        $imgLink = "/local/templates/aspro_next/images/sections/mob_menu/obzor.svg";
                                                    } elseif ($arSubItem["TEXT"] == "Все сторисы") {
                                                        $imgLink = "/local/templates/aspro_next/images/sections/mob_menu/stories_mob.png";
                                                    }
                                                    ?>
                                                    <div class="menu_img"><img src="<?=$imgLink?>"  width="150" height="150" /></div>
                                                <?endif;?>
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
                                                /*временный костыль для переименования "все займы" в "займы", уберем когда будут другие названия подразделов в НОВОМ каталоге*/
                                                <span class="name subsection_name"><?if($name_cat == 'Все займы'): echo 'Займы'; else: echo $name_cat; endif;?></span><?=($arSubItem["CHILD"] && $bShowChilds ? '<span class="arrow"><i></i></span>' : '')?>
                                            </a>
                                            <?if($arSubItem["CHILD"] && $bShowChilds):?>
                                                <?$iCountChilds = count($arSubItem["CHILD"]);?>
                                                <ul class="dropdown-menu toggle_menu">
                                                    <?foreach($arSubItem["CHILD"] as $key => $arSubSubItem):?>
                                                        <?$bShowChilds = $arParams["MAX_LEVEL"] > 3;?>
                                                        <li class="<?=(++$key > $iVisibleItemsMenu ? 'collapsed' : '');?> <?=($arSubSubItem["CHILD"] && $bShowChilds ? "dropdown-submenu" : "")?> <?=($arSubSubItem["SELECTED"] ? "active" : "")?>">
                                                            <a href="<?=$arSubSubItem["LINK"]?>" ><span class="name"><?=$arSubSubItem["TEXT"]?></span></a>
                                                            <?if($arSubSubItem["CHILD"] && $bShowChilds):?>
                                                                <ul class="dropdown-menu">
                                                                    <?foreach($arSubSubItem["CHILD"] as $arSubSubSubItem):?>
                                                                        <li class="<?=($arSubSubSubItem["SELECTED"] ? "active" : "")?>">
                                                                            <a href="<?=$arSubSubSubItem["LINK"]?>" ><span class="name"><?=$arSubSubSubItem["TEXT"]?></span></a>
                                                                        </li>
                                                                    <?endforeach;?>
                                                                </ul>

                                                            <?endif;?>
                                                        </li>
                                                    <?endforeach;?>
                                                    <?if($iCountChilds > $iVisibleItemsMenu && $bWideMenu):?>
                                                        <li><span class="colored more_items with_dropdown"><?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS");?></span></li>
                                                    <?endif;?>
                                                </ul>
                                            <?endif;?>
                                        </li>
                                    <?endforeach;?>
                                </ul>
                            <?endif;?>
                        </div>
                    </td>
                <?endforeach;?>

                <td class="menu-item dropdown js-dropdown nosave unvisible">
                    <div class="wrap">
                        <a class="dropdown-toggle more-items" href="#">
                            <span><?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS");?></span>
                        </a>
                        <span class="tail"></span>
                        <ul class="dropdown-menu"></ul>
                    </div>
                </td>

            </tr>
        </table>
    </div>
<?endif;?>