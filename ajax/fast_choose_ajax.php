<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
CModule::IncludeModule('iblock');
$codeProp = array();
$codeEdIzmProp = array();
if(isset($_GET["section_id"]) && $_GET["section_id"] != "") {
    /**
     * список товаров
     */
    $arrFilter = array("IBLOCK_ID" => 35);
	if(isset($_GET["all_lists_id"]) && $_GET["all_lists_id"]!="") {
		$arrFilter = ["SECTION_ID" => $_GET["section_id"], "IBLOCK_ID" => 35, "PROPERTY_" . $_GET["all_lists_id"] ."_VALUE" => "Да", "ACTIVE" => "Y"];
	} else if(isset($_GET["hit_lists_id"]) && $_GET["hit_lists_id"]!=""){
		$arrFilter = ["SECTION_ID" => $_GET["section_id"], "IBLOCK_ID" => 35, "PROPERTY_HIT"  => $_GET["hit_lists_id"], "ACTIVE" => "Y"];
	} else if(isset($_GET["other_code"]) &&  $_GET["other_code"]!=""){
		$arrFilter = ["SECTION_ID" => $_GET["section_id"], "IBLOCK_ID" => 35, "PROPERTY_" . $_GET["other_code"] => $_GET["other_id"], "ACTIVE" => "Y"]; 
	}
	if((isset($_GET["section_id"]) && $_GET["section_id"] != 0) || count($arrFilter)>0){
		//see($arrFilter);die();
		$queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilter, false, false, Array("NAME", "ID", "PREVIEW_PICTURE", "IBLOCK_ID","DETAIL_PAGE_URL", "PROPERTY_*"));
		while($resQueryCard = $queryCard->GetNextElement()) {
			$arrRes = $resQueryCard->GetFields();
			$arrRes["PREVIEW_PICTURE"] = CFile::GetPath($arrRes["PREVIEW_PICTURE"]);
			$arrRes["PROPERTIES"] = $resQueryCard->GetProperties();
			$arResult["ITEMS"][] = $arrRes;
		}
	}
	/**
     * список доступных свойств
     */
    $arrFilterProp = ["IBLOCK_ID" => 37, "PROPERTY_INCLUDE_MAIN"  => $_GET["section_id"], "ACTIVE" => "Y"];
    $queryProp = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilterProp, false, false, Array("NAME", "ID", "PROPERTY_CODE_PROP","PROPERTY_ED_IZM"));
    while ($rowProp = $queryProp->fetch())
    {
        $codeProp[] = $rowProp['PROPERTY_CODE_PROP_VALUE'];
        $codeEdIzmProp[$rowProp['PROPERTY_CODE_PROP_VALUE']] = $rowProp['PROPERTY_ED_IZM_VALUE'];
    }
}

?>
<?php if($arResult["ITEMS"]): ?>
	<?php foreach($arResult["ITEMS"] as $arItem):?>
		<div data-el_id="<?=$arItem["ID"]?>" class="card-item">
			<div class="card-item-name">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img width="200" src="<?=$arItem["PREVIEW_PICTURE"]?>"></a>
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><p class="fast_title"><?=$arItem["NAME"]?></p></a>
			</div>
            <div class="fast_view_block <?=$arItem["ID"]?>" data-event="jqm" data-param-form_id="fast_view" data-param-iblock_id="<?=$arItem["ID"]?>" data-param-id="666" data-param-item_href="<?=$arItem["DETAIL_PAGE_URL"]?>" data-name="fast_view">Быстрый просмотр</div>
            <a class="btn btn-default basket read_more" rel="nofollow" href="<?=$arItem["DETAIL_PAGE_URL"]?>" data-item="<?=$arItem["ID"]?>">Оформить</a>
            <div class="props_list_wrapp">
                <table class="props_list prod">
                    <tbody>
                        <?foreach ($arItem["PROPERTIES"] as $key=>$item):?>
                            <?//echo $key . '</br>';?>
                            <?if(in_array($key,$codeProp)):?>
                                <tr>
                                    <td><span class="sm-text"><?=$item["NAME"];?></span></td>
                                    <?$valueProp = "";?>
                                    <?if(is_array($item["VALUE"])):?>
                                        <?foreach ($item["VALUE"] as $val):?>
                                            <?if(strlen($valueProp)>0):?>
                                                <?$valueProp .= '-' . $val?>
                                            <?else:?>
                                                <?$valueProp = $val?>
                                            <?endif;?>
                                        <?endforeach;?>
                                    <?else:?>
                                        <?$valueProp = $item["VALUE"];?>
                                    <?endif;?>
                                    <td><span class="sm-text"><?=formatToHuman($valueProp);?> <?=$codeEdIzmProp[$key]?></span></td>
                                </tr>
                            <?endif;?>
                        <?endforeach;?>
                    </tbody>
                </table>
            </div>
		</div>
	<?php endforeach;?>
<?php endif;?>
<script>
    $(document).ready(function() {
        $('.choose-result-wrap .card-item').hover(function() {
                $(this).children('.fast_view_block').attr("style","visibility: visible;opacity: 1;margin-top: -100px;");
            },
            function() {
                $(this).children('.fast_view_block').removeAttr('style');
            }
        );
    });
</script>