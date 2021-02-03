<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$theme = COption::GetOptionString("main", "wizard_eshop_adapt_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";
foreach($arResult["ITEMS"] as $key => $arItem)
{
	if($arItem["CODE"]=="IN_STOCK"){
		sort($arResult["ITEMS"][$key]["VALUES"]);
		if($arResult["ITEMS"][$key]["VALUES"])
			$arResult["ITEMS"][$key]["VALUES"][0]["VALUE"]=$arItem["NAME"];
	}
}

/**
 * получим принадлежность свойства
 */
$brand = Array();
$osn   = Array();
$usl   = Array();
$treb  = Array();
$har   = Array();
$doc   = Array();
$ser   = Array();
foreach($arResult["ITEMS"] as $key => $arItem) {
    $razdel_name = "";
    $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y', 'PROPERTY_CODE_PROP' => $arItem['CODE']];
    $arSelectP = ['ID', 'NAME', 'DATE_ACTIVE_FROM', 'PROPERTY_RAZDEL'];
    $resP = CIBlockElement::GetList(array(), $arFilterP, false, false, $arSelectP);
    while ($itemResP = $resP->Fetch()) {
        $razdel_name = $itemResP['PROPERTY_RAZDEL_VALUE'];
    }//while($itemResP = $resP->Fetch())

    if ($arItem['CODE'] == "MAGAZIN") {
        $brand[] = $arItem;
    } else {
        if ($razdel_name == 'Основные') {
            $osn[] = $arItem;
        }
        if ($razdel_name == 'Условия') {
            $usl[] = $arItem;
        }
        if ($razdel_name == 'Требования') {
            $treb[] = $arItem;
        }
        if ($razdel_name == 'Характеристики') {
            $har[] = $arItem;
        }
        if ($razdel_name == 'Документы') {
            $doc[] = $arItem;
        }
        if ($razdel_name == 'Сервисы') {
            $ser[] = $arItem;
        }
    }
}
$uslKey = array();
foreach ($usl as $key => $row)
{
    $uslKey[$key] = $row['DISPLAY_TYPE'];
}
array_multisort($uslKey, SORT_ASC, $usl);

$trebKey = array();
foreach ($treb as $key => $row)
{
    $treblKey[$key] = $row['DISPLAY_TYPE'];
}
array_multisort($treblKey, SORT_ASC, $treb);

$harKey = array();
foreach ($har as $key => $row)
{
    $harlKey[$key] = $row['DISPLAY_TYPE'];
}
array_multisort($harlKey, SORT_ASC, $har);

$serKey = array();
foreach ($ser as $key => $row)
{
    $serlKey[$key] = $row['DISPLAY_TYPE'];
}
array_multisort($serlKey, SORT_ASC, $ser);

$res = Array();
foreach($brand as $arItem){
    $res['BRAND'][] = $arItem;
}
foreach($osn as $arItem){
    $res['OSN'][] = $arItem;
}
foreach($usl as $arItem){
    $res['USL'][] = $arItem;
}
foreach($treb as $arItem){
    $res['TREB'][] = $arItem;
}
foreach($har as $arItem){
    $res['HAR'][] = $arItem;
}
foreach($doc as $arItem){
    $res['DOC'][] = $arItem;
}
foreach($ser as $arItem){
    $res['SER'][] = $arItem;
}


$new_brand_group   = Array();
$new_brand_other   = Array();
foreach ($res['BRAND'] as &$item)
{
    $arr = getGroupProperty($item["CODE"]);
    $item['MAIN_GROUP'] = 'Партнеры';
    if(count($arr)>0)
    {
        $new_brand_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_brand_other[] = $item;
    }
}

$new_usl_group   = Array();
$new_usl_other   = Array();
foreach ($res['USL'] as &$item)
{
    $arr = getGroupProperty($item["CODE"]);
    $item['MAIN_GROUP'] = 'Условия';
    if(count($arr)>0)
    {
        $new_usl_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_usl_other[] = $item;
    }
}
$new_treb_group  = Array();
$new_treb_other  = Array();
foreach ($res['TREB'] as &$item)
{
    $arr = getGroupProperty($item["CODE"]);
    $item['MAIN_GROUP'] = 'Требования';
    if(count($arr)>0)
    {
        $new_treb_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_treb_other[] = $item;
    }
}
$new_har_group   = Array();
$new_har_other   = Array();
foreach ($res['HAR'] as &$item)
{
    $arr = getGroupProperty($item["CODE"]);
    $item['MAIN_GROUP'] = 'Характеристики';
    if(count($arr)>0)
    {
        $new_har_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_har_other[] = $item;
    }
}
$new_doc_group   = Array();
$new_doc_other   = Array();
foreach ($res['DOC'] as &$item)
{
    $arr = getGroupProperty($item["CODE"]);
    $item['MAIN_GROUP'] = 'Документы';
    if(count($arr)>0)
    {
        $new_doc_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_doc_other[] = $item;
    }
}
$new_ser_group   = Array();
$new_ser_other   = Array();
foreach ($res['SER'] as &$item)
{

    $arr = getGroupProperty($item["CODE"]);
    $item['MAIN_GROUP'] = 'Сервисы';
    if(count($arr)>0)
    {
        $new_ser_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_ser_other[] = $item;
    }
}

//окончательная сборка - НАЧАЛО
$new_res = array();
foreach ($res['BRAND'] as $item)
{
    $new_res[] = $item;
}
foreach ($new_usl_other as $item)
{
    $new_res[] = $item;
}
foreach ($new_usl_group['GROUPS'] as $nameGroup=>$itemGroup)
{
    if(count($itemGroup)>0)
    {
        $count = 0;
        foreach ($itemGroup as $item)
        {
            if(
                empty($item["VALUES"])
                || isset($item["PRICE"])
            )
                continue;
            if (
                $item["DISPLAY_TYPE"] == "A"
                && (
                    $item["VALUES"]["MAX"]["VALUE"] - $item["VALUES"]["MIN"]["VALUE"] <= 0
                )
            )
                continue;
            $count++;
        }//foreach ($itemGroup as $item)
        if($count>0)
        {
            $new_res[] = array("PODGR"=>$nameGroup);
            foreach ($itemGroup as $item)
            {
                $new_res[] = $item;
            }//foreach ($itemGroup as $item)
        }//if($count>0)
    }//if(count($itemGroup)>0)
}//foreach ($new_usl_group['GROUPS'] as $itemGroup)
foreach ($new_treb_other as $item)
{
    $new_res[] = $item;
}
foreach ($new_treb_group['GROUPS'] as $nameGroup=>$itemGroup)
{
    if(count($itemGroup)>0)
    {
        $count = 0;
        foreach ($itemGroup as $item)
        {
            if(
                empty($item["VALUES"])
                || isset($item["PRICE"])
            )
                continue;
            if (
                $item["DISPLAY_TYPE"] == "A"
                && (
                    $item["VALUES"]["MAX"]["VALUE"] - $item["VALUES"]["MIN"]["VALUE"] <= 0
                )
            )
                continue;
            $count++;
        }//foreach ($itemGroup as $item)
        if($count>0)
        {
            $new_res[] = array("PODGR"=>$nameGroup);
            foreach ($itemGroup as $item)
            {
                $new_res[] = $item;
            }//foreach ($itemGroup as $item)
        }//if($count>0)
    }//if(count($itemGroup)>0)
}//foreach ($new_treb_group['GROUPS'] as $itemGroup)
foreach ($new_har_other as $item)
{
    $new_res[] = $item;
}
foreach ($new_har_group['GROUPS'] as $nameGroup=>$itemGroup)
{
    if(count($itemGroup)>0)
    {
        $count = 0;
        foreach ($itemGroup as $item)
        {
            if(
                empty($item["VALUES"])
                || isset($item["PRICE"])
            )
                continue;
            if (
                $item["DISPLAY_TYPE"] == "A"
                && (
                    $item["VALUES"]["MAX"]["VALUE"] - $item["VALUES"]["MIN"]["VALUE"] <= 0
                )
            )
                continue;
            $count++;
        }//foreach ($itemGroup as $item)
        if($count>0)
        {
            $new_res[] = array("PODGR"=>$nameGroup);
            foreach ($itemGroup as $item)
            {
                $new_res[] = $item;
            }//foreach ($itemGroup as $item)
        }//if($count>0)
    }//if(count($itemGroup)>0)
}//foreach ($new_har_group['GROUPS'] as $itemGroup)
foreach ($new_doc_other as $item)
{
    $new_res[] = $item;
}
foreach ($new_doc_group['GROUPS'] as $nameGroup=>$itemGroup)
{
    if(count($itemGroup)>0)
    {
        $count = 0;
        foreach ($itemGroup as $item)
        {
            if(
                empty($item["VALUES"])
                || isset($item["PRICE"])
            )
                continue;
            if (
                $item["DISPLAY_TYPE"] == "A"
                && (
                    $item["VALUES"]["MAX"]["VALUE"] - $item["VALUES"]["MIN"]["VALUE"] <= 0
                )
            )
                continue;
            $count++;
        }//foreach ($itemGroup as $item)
        if($count>0)
        {
            $new_res[] = array("PODGR"=>$nameGroup);
            foreach ($itemGroup as $item)
            {
                $new_res[] = $item;
            }//foreach ($itemGroup as $item)
        }//if($count>0)
    }//if(count($itemGroup)>0)
}//foreach ($new_doc_group['GROUPS'] as $itemGroup)
/*foreach ($new_ser_other as $item)
{
    $new_res[] = $item;
}
$new_res[] = $new_ser_group;*/

//окончательная сборка - КОНЕЦ

$arResult["ITEMS"] = $new_res;

\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

// sort
include 'sort.php';

global $sotbitFilterResult;
$sotbitFilterResult = $arResult;
// netwiz start - выводим теги под тайтлом
$queryAllCheckbox = CIBlockElement::GetList(Array("SORT"=>"ASC"),Array("IBLOCK_ID" => 37, "PROPERTY_TYPE" => 2283, "!PROPERTY_RAZDEL"=>[2369, 2366]),false,false,Array("ID","IBLOCK_ID","NAME","PROPERTY_CODE_PROP"));
while($obj = $queryAllCheckbox->GetNextElement())
{
	foreach($arResult["ITEMS"] as &$arItem){
		$arFields = $obj->GetProperties();
		if($arItem['CODE'] == $arFields["CODE_PROP"]["VALUE"]){
			$arItem["FILTER_THIS"] = true;
		}
	}
}
$queryAllList = CIBlockElement::GetList(Array("SORT"=>"ASC"),Array("IBLOCK_ID" => 37, "PROPERTY_TYPE" => 2385, "!PROPERTY_RAZDEL"=>[2369, 2366]),false,false,Array("ID","IBLOCK_ID","NAME","PROPERTY_CODE_PROP"));
while($obj = $queryAllList->GetNextElement())
{
	foreach($arResult["ITEMS"] as &$arItem){
		$arFields = $obj->GetProperties();
		if($arItem['CODE'] == $arFields["CODE_PROP"]["VALUE"]){
			if($arItem['CODE'] != "HIT"){
				$arItem["ALL_FILTER_THIS"] = true;
			}
		}
	}
}
$this->setFrameMode( true );
$this->SetViewTarget("header_sections_wrapper");
foreach($arResult["ITEMS"] as $key => $arItem){
    $pos_point_in_name = strpos($arItem["NAME"], ".");
    //Вызов стикеров
        if($arItem['CODE']=="HIT" || $arItem["FILTER_THIS"] == true || $arItem["ALL_FILTER_THIS"] == true) {
	    if($arItem["FILTER_THIS"] != true && $arItem["ALL_FILTER_THIS"] != true){
	            foreach($arItem['VALUES'] as $keys => $arItem1){
	                echo '<div class="swiper-slide"><div class="sticker_"><a href="' . $APPLICATION->GetCurPage . '?tags=' . $keys . '" class="btn_filter">' . $arItem1['VALUE'] . ' </a></div></div>';
	            }
		}else{
			if($arItem["FILTER_THIS"] == true){
				$queryTestEl = CIBlockElement::GetList(Array("SORT"=>"ASC"),Array("IBLOCK_SECTION_ID" => $arParams["SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"], "PROPERTY_".$arItem["CODE"]."_VALUE" => "Да"),false,false,Array("ID","IBLOCK_ID","NAME"));
				$cnt = 0;
				while($obj = $queryTestEl->GetNextElement()){
					$cnt++;
				}
				if($cnt > 0){
                    $dop_class = '';
					if($arItem["CODE"]==$_GET['newtags'] && isset($_GET['newtags']))
					{
                        $dop_class = 'active_element_sidebar';
					}
					echo '<div class="swiper-slide"><div class="sticker_"><a class="'.$dop_class.'" href="' . $APPLICATION->GetCurPage . '?newtags=' . $arItem["CODE"] . '" class="btn_filter">' . $arItem['NAME'] . ' </a></div></div>';
				}
			}else{
				$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$arItem["CODE"]));
				while($enum_fields = $property_enums->Fetch()){
					$arrFilterOther = ["IBLOCK_SECTION_ID" => $arParams["SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"], "PROPERTY_".$enum_fields["PROPERTY_CODE"]  => $enum_fields["ID"], "ACTIVE" => "Y"];
					$queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilterOther, false, false, Array("NAME", "ID", "IBLOCK_ID","PROPERTY_".$enum_fields["PROPERTY_CODE"]));
					$countEl = 0;
					while($resQueryCard = $queryCard->Fetch()):
                   		$countEl++;
            		endwhile;
					if($countEl > 0){
						echo '<div class="swiper-slide"><div class="sticker_"><a href="' . $APPLICATION->GetCurPage . '?othertagcode=' . $enum_fields["PROPERTY_CODE"] . '&otherid='.$enum_fields["ID"].'" class="btn_filter">' . $enum_fields['VALUE'] . ' </a></div></div>';
					}
				}
			}
	    }
	}
}
$this->EndViewTarget();
//  netwiz end
$APPLICATION->IncludeComponent('intec.seo:filter.loader', '', [
    'FILTER_RESULT' => $arResult
], $component);
?>