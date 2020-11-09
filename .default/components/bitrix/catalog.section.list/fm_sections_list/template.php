<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?
$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
require('banners.php');
?>
<?$pageContentType = 2;?>
<?if($arResult["SECTIONS"]){?>
    <?if($pageContentType == 1):?>
        <div class="catalog_section_list row items flexbox">
        <?foreach( $arResult["SECTIONS"] as $arItems ){
            $this->AddEditAction($arItems['ID'], $arItems['EDIT_LINK'], CIBlock::GetArrayByID($arItems["IBLOCK_ID"], "SECTION_EDIT"));
            $this->AddDeleteAction($arItems['ID'], $arItems['DELETE_LINK'], CIBlock::GetArrayByID($arItems["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));
        ?>
            <div class="item_block col-md-6 col-sm-6">
                <div class="section_item item" id="<?=$this->GetEditAreaId($arItems['ID']);?>">

                    <table class="section_item_inner">
                        <tr>
                            <?if ($arParams["SHOW_SECTION_LIST_PICTURES"]=="Y"):?>
                                <?$collspan = 2;?>

                                <td class="image">
                                    <?if($arItems["PICTURE"]["SRC"]):?>
                                        <?$img = CFile::ResizeImageGet($arItems["PICTURE"]["ID"], array( "width" => 300, "height" => 300 ), BX_RESIZE_IMAGE_EXACT, true );?>
                                        <a href="<?=$arItems["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=$img["src"]?>" alt="<?=($arItems["PICTURE"]["ALT"] ? $arItems["PICTURE"]["ALT"] : $arItems["NAME"])?>" title="<?=($arItems["PICTURE"]["TITLE"] ? $arItems["PICTURE"]["TITLE"] : $arItems["NAME"])?>" /></a>
                                    <?elseif($arItems["~PICTURE"]):?>
                                        <?$img = CFile::ResizeImageGet($arItems["~PICTURE"], array( "width" => 300, "height" => 300 ), BX_RESIZE_IMAGE_EXACT, true );?>
                                        <a href="<?=$arItems["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=$img["src"]?>" alt="<?=($arItems["PICTURE"]["ALT"] ? $arItems["PICTURE"]["ALT"] : $arItems["NAME"])?>" title="<?=($arItems["PICTURE"]["TITLE"] ? $arItems["PICTURE"]["TITLE"] : $arItems["NAME"])?>" /></a>
                                    <?else:?>
                                        <a href="<?=$arItems["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/catalog_category_noimage.svg" alt="<?=$arItems["NAME"]?>" title="<?=$arItems["NAME"]?>" /></a>
                                    <?endif;?>
                                </td>
                            <?endif;?>
                            <td class="section_info">
                                <ul>
                                    <li class="name">
                                        <a href="<?=$arItems["SECTION_PAGE_URL"]?>" class="dark_link">
                                            <span>
                                                <?=$arItems["NAME"]?>
                                            </span>
                                        </a>
                                    </li>
                                    <?if($arItems["SECTIONS"]){
                                        foreach( $arItems["SECTIONS"] as $arItem ){?>
                                            <li class="sect"><a href="<?=$arItem["SECTION_PAGE_URL"]?>" class="dark_link">
                                                    <?php
                                                    $name_cat = $arItem["NAME"];
                                                    $uf_arresult = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "NAME" => $arItem["NAME"]), false, Array("NAME","UF_SHORT_NAME"));
                                                    if($uf_value = $uf_arresult->GetNext()):
                                                        //print_r($uf_value);
                                                        if(strlen($uf_value["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                                                            $name_cat = $uf_value["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                                                        endif;
                                                    endif;
                                                    ?>
                                                    <?=$name_cat?><? echo $arItem["ELEMENT_CNT"]?'&nbsp;<span>'.$arItem["ELEMENT_CNT"].'</span>':'';?>
                                                </a>
                                            </li>
                                        <?}
                                    }?>
                                </ul>
                            </td>
                        </tr>
                        <?if($arParams["SECTIONS_LIST_PREVIEW_DESCRIPTION"]!="N"):?>
                            <?$arSection = $section=CNextCache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CNextCache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $arItems["ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"]));?>
                            <?if ($arSection[$arParams["SECTIONS_LIST_PREVIEW_PROPERTY"]]):?>
                                <tr><td class="desc" <?=($collspan? 'colspan="'.$collspan.'"':"");?>><span class="desc_wrapp"><?=$arSection[$arParams["SECTIONS_LIST_PREVIEW_PROPERTY"]]?></span></td></tr>
                            <?else:?>
                                <tr><td class="desc" <?=($collspan? 'colspan="'.$collspan.'"':"");?>><span class="desc_wrapp"><?=$arItems["DESCRIPTION"]?></span></td></tr>
                            <?endif;?>
                        <?endif;?>
                    </table>
                </div>
            </div>
        <?}?>
    </div>
    <?elseif ($pageContentType == 2):?>
        <?
        $class_block="s_".$this->randString();
        $arTab=array();
        $col=4;
        if($arParams["LINE_ELEMENT_COUNT"]>=3 && $arParams["LINE_ELEMENT_COUNT"]<4)
            $col=3;
        ?>
        <?$counter = 1;?>
            <?foreach( $arResult["SECTIONS"] as $arItems ):?>
                <div class="tab_slider_wrapp specials <?=$class_block;?> best_block clearfix" itemscope itemtype="http://schema.org/WebPage">
                    <div class="top_blocks">
                        <h3 class="title_block"><a href="<?=$arItems["SECTION_PAGE_URL"];?>"><?=$arItems["NAME"];?></a></h3>
                    </div>
                    <div class="section_slider<?=$counter?> swiper-container tabs_content">
                        <ul id="" class="section_slider<?=$counter?>_list swiper-wrapper">
                            <?foreach($arItems["SECTIONS"] as $arItem):?>
                            <li class="slider_team_item swiper-slide">
                                <div class="slider_team_img">
                                    <a href="javascript:void(0);" class="thumb shine" title="<?=$arItem["ID"]?>">
                                        <?if(isset($arResult['PICTURES'][$arItem['ID']])):?>
                                            <img class="" height="160" src="<?=$arResult['PICTURES'][$arItem['ID']];?>" data-src="<?=$arResult['PICTURES'][$arItem['ID']];?>" alt="<?=$arItem["NAME"];?>">
                                        <?else:?>
                                            <img class="" height="160" src="<?=$arItem["PICTURE"]["SRC"];?>" data-src="<?=$arItem["PICTURE"]["SRC"];?>" alt="<?=$arItem["NAME"];?>">
                                        <?endif;?>
                                    </a>
                                </div>
                            </li>
                            <?endforeach;?>
                        </ul>
                    </div>
                </div>
                <?$counter++;?>
            <?endforeach;?>
    <?endif;?>

<?}?>

<script>
    $('.section_slider1 .thumb.shine').click(function(e){
        e.preventDefault();
        //console.log($(this).attr("title"));
        $.ajax({
            type:'post',//тип запроса: get,post либо head
            url:'/ajax/add_clear_compresion.php',//url адрес файла обработчика
            data:"session="+'<?=session_id();?>'+"&id=" + $(this).attr("title"),//параметры запроса
            response:'text',//тип возвращаемого ответа text либо xml
            success:function (data) {//возвращаемый результат от сервера
                location.href = "/catalog/comparisons/";
            }
        });
    });
    $('.section_slider2 .thumb.shine').click(function(e){
        e.preventDefault();
        //console.log($(this).attr("title"));
        $.ajax({
            type:'post',//тип запроса: get,post либо head
            url:'/ajax/add_clear_compresion.php',//url адрес файла обработчика
            data:"session="+'<?=session_id();?>'+"&id=" + $(this).attr("title"),//параметры запроса
            response:'text',//тип возвращаемого ответа text либо xml
            success:function (data) {//возвращаемый результат от сервера
                location.href = "/catalog/comparisons/";
            }
        });
    });
    $('.section_slider3 .thumb.shine').click(function(e){
        e.preventDefault();
        //console.log($(this).attr("title"));
        $.ajax({
            type:'post',//тип запроса: get,post либо head
            url:'/ajax/add_clear_compresion.php',//url адрес файла обработчика
            data:"session="+'<?=session_id();?>'+"&id=" + $(this).attr("title"),//параметры запроса
            response:'text',//тип возвращаемого ответа text либо xml
            success:function (data) {//возвращаемый результат от сервера
                location.href = "/catalog/comparisons/";
            }
        });
    });
</script>
