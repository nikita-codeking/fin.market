<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?use \Bitrix\Conversion\Internals\MobileDetect;?>

<?$detect = new MobileDetect;
if($detect->isMobile()):?>
    <?$visSec = false;?>
    <?if($visSec):?>
    <?if($arResult['SECTIONS']):?>
        <div class="sections_wrapper">
            <?if($arParams["TITLE_BLOCK"] || $arParams["TITLE_BLOCK_ALL"]):?>
                <div class="top_block">
                    <h3 class="title_block"><?=$arParams["TITLE_BLOCK"];?></h3>
                    <a href="<?=SITE_DIR.$arParams["ALL_URL"];?>"><?=$arParams["TITLE_BLOCK_ALL"] ;?></a>
                </div>
            <?endif;?>
            <div class="list items">
                <div class="row margin0 flexbox">
                    <?foreach($arResult['SECTIONS'] as $arSection):
                        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));?>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="item" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                                <?if ($arParams["SHOW_SECTION_LIST_PICTURES"]!="N"):?>
                                    <div class="img shine">
                                        <?if($arSection["PICTURE"]["SRC"]):?>
                                            <?$img = CFile::ResizeImageGet($arSection["PICTURE"]["ID"], array( "width" => 300), BX_RESIZE_IMAGE_PROPORTIONAL, true );?>
                                            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=$img["src"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arSection["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arSection["NAME"])?>" /></a>
                                        <?elseif($arSection["~PICTURE"]):?>
                                            <?$img = CFile::ResizeImageGet($arSection["~PICTURE"], array( "width" => 300), BX_RESIZE_IMAGE_PROPORTIONAL, true );?>
                                            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=$img["src"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arSection["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arSection["NAME"])?>" /></a>
                                        <?else:?>
                                            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/catalog_category_noimage.svg" alt="<?=$arSection["NAME"]?>" title="<?=$arSection["NAME"]?>" /></a>
                                        <?endif;?>
                                    </div>
                                <?endif;?>

                                <div class="name">
                                    <?php
                                    $name_cat = $arSection['NAME'];
                                    $uf_arresult = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "ID" => $arSection["ID"]), false, Array("NAME","UF_SHORT_NAME"));
                                    if($uf_value = $uf_arresult->GetNext()):
                                        //print_r($uf_value);
                                        if(strlen($uf_value["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                                            $name_cat = $uf_value["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                                        endif;
                                    endif;
                                    ?>
                                    <a href="<?=$arSection['SECTION_PAGE_URL'];?>" class="dark_link"><?=$name_cat;?></a>
                                </div>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    <?endif;?>
    <?endif;?>
<?else:?>

    <?$this->setFrameMode( true );?>
    <?$this->SetViewTarget("header_sections_wrapper");?>
    <?//php see($arResult['SECTIONS']);?>
    <?$visSec = false;?>
    <?if($visSec):?>
    <?if($arResult['SECTIONS']):?>
        <div class="sections_wrapper">
            <?if($arParams["TITLE_BLOCK"] || $arParams["TITLE_BLOCK_ALL"]):?>
                <div class="top_block">
                    <h3 class="title_block"><?=$arParams["TITLE_BLOCK"];?> - 1</h3>
                    <a href="<?=SITE_DIR.$arParams["ALL_URL"];?>"><?=$arParams["TITLE_BLOCK_ALL"] ;?></a>
                </div>
            <?endif;?>
            <div class="list items">
                <div class="row margin flexbox">
                    <?foreach($arResult['SECTIONS'] as $arSection):
                        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));?>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="item" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                                <?if ($arParams["SHOW_SECTION_LIST_PICTURES"]!="N"):?>
                                    <div class="img shine">
                                        <?if($arSection["PICTURE"]["SRC"]):?>
                                            <?$img = CFile::ResizeImageGet($arSection["PICTURE"]["ID"], array( "width" => 300), BX_RESIZE_IMAGE_PROPORTIONAL, true );?>
                                            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=$img["src"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arSection["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arSection["NAME"])?>" /></a>
                                        <?elseif($arSection["~PICTURE"]):?>
                                            <?$img = CFile::ResizeImageGet($arSection["~PICTURE"], array( "width" => 300), BX_RESIZE_IMAGE_PROPORTIONAL, true );?>
                                            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=$img["src"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arSection["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arSection["NAME"])?>" /></a>
                                        <?else:?>
                                            <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="thumb"><img src="<?=SITE_TEMPLATE_PATH?>/images/svg/catalog_category_noimage.svg" alt="<?=$arSection["NAME"]?>" title="<?=$arSection["NAME"]?>" /></a>
                                        <?endif;?>
                                    </div>
                                <?endif;?>
                                <div class="name">
                                    <?php
                                    $name_cat = $arSection['NAME'];
                                    $uf_arresult = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID" => 17, "ID" => $arSection["ID"]), false, Array("NAME","UF_SHORT_NAME"));
                                    if($uf_value = $uf_arresult->GetNext()):
                                        //print_r($uf_value);
                                        if(strlen($uf_value["UF_SHORT_NAME"]) > 0): //проверяем что поле заполнено
                                            $name_cat = $uf_value["UF_SHORT_NAME"]; //подменяем ссылку и используем её в дальнейшем
                                        endif;
                                    endif;
                                    ?>
                                    <a href="<?=$arSection['SECTION_PAGE_URL'];?>" class="dark_link"><?=$name_cat;?></a>
                                </div>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    <?endif;?>
    <?endif;?>
    <?$this->EndViewTarget();?>

<?endif;?>

