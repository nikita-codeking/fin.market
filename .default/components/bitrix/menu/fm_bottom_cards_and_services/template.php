<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if($arResult){?>

	<div class="submenu_top row bottom_menu">
        <div class="column_bottom_menu column_menu_1">
            <?$open_div = false;?>
            <?$count_child=0;?>
			<?foreach( $arResult as $arItem ){?>
                <?if($arItem['IS_PARENT']>0):?>
                    <?if($open_div):?></div><?endif;?>
                    <div class="colum_menu_footer   ">
                    <?
                    $open_div    = true;
                    $count_child = 0;
                    ?>
                <?else:?>
                    <?$count_child++;?>
                <?endif;?>
				<div class="item_block bottom_menu <?if($arItem['IS_PARENT']>0):?>is_parent<?else:?>is_child<?endif;?>">
                    <?php
                    $name_cat = $arItem["TEXT"];
                    $uf_arresult = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "NAME" => $arItem["TEXT"]), false, Array("NAME","UF_SHORT_NAME"));
                    if($uf_value = $uf_arresult->GetNext()):
                        if(strlen($uf_value["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                            $name_cat = $uf_value["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                        endif;
                    endif;
                    ?>
                    /*временный костыль для переименования "все займы" в "займы", уберем когда будут другие названия подразделов в НОВОМ каталоге*/
                    <div class="menu_item"><a href="<?if($arItem['IS_PARENT']>0 && $name_cat!="Рейтинги" && $name_cat!="Сторис" && $name_cat!="Обзоры" && $name_cat!="Все займы"):?>javascript:void(0);<?else:?><?if($arItem["LINK"] == '/catalog/zaymy/'): $name_cat = ''; else: echo $arItem["LINK"]; endif;?><?endif;?>" class="dark_link"><?if($name_cat == 'Все займы'): echo 'Займы'; else: echo $name_cat; endif;?></a></div>
                </div>
			<?}?>
            <?if($open_div):?></div><?endif;?>
        </div>
	</div>
<?}?>