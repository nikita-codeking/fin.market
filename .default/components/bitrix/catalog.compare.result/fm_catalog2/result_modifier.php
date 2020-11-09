<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Type\Collection;

if($arResult["ITEMS"])
{
	$strBaseCurrency = $arParams['CURRENCY_ID'];
	if(!$arParams['CURRENCY_ID'])
		$strBaseCurrency = CCurrency::GetBaseCurrency();

	foreach($arResult["ITEMS"] as $key => $arItem)
	{
		// print_r($arItem);
		if($arItem['CATALOG_TYPE'] == 3 && !$arItem['OFFER_FIELDS'])
		{
			$arResult["ITEMS"][$key]['MIN_PRICE'] = array(
				'DISCOUNT_VALUE' => $arItem['PROPERTIES']['MINIMUM_PRICE']['VALUE'],
				'SUFFIX' => GetMessage('PRICE_FROM'),
				'PRINT_DISCOUNT_VALUE' => CCurrencyLang::CurrencyFormat($arItem['PROPERTIES']['MINIMUM_PRICE']['VALUE'], $strBaseCurrency, true)
			);
		}
	}
}

$arResult['ALL_FIELDS'] = array();
$existShow = !empty($arResult['SHOW_FIELDS']);
$existDelete = !empty($arResult['DELETED_FIELDS']);
if ($existShow || $existDelete)
{
	if ($existShow)
	{
		foreach ($arResult['SHOW_FIELDS'] as $propCode)
		{
			$arResult['SHOW_FIELDS'][$propCode] = array(
				'CODE' => $propCode,
				'IS_DELETED' => 'N',
				'ACTION_LINK' => str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode);
		$arResult['ALL_FIELDS'] = $arResult['SHOW_FIELDS'];
		if($arResult['ALL_FIELDS']["PREVIEW_PICTURE"] || $arResult['ALL_FIELDS']["DETAIL_PICTURE"])
			unset($arResult['ALL_FIELDS']["PREVIEW_PICTURE"],$arResult['ALL_FIELDS']["DETAIL_PICTURE"]);
	}
	if ($existDelete)
	{
		foreach ($arResult['DELETED_FIELDS'] as $propCode)
		{
			$arResult['ALL_FIELDS'][$propCode] = array(
				'CODE' => $propCode,
				'IS_DELETED' => 'Y',
				'ACTION_LINK' => str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode, $arResult['DELETED_FIELDS']);
	}
	Collection::sortByColumn($arResult['ALL_FIELDS'], array('SORT' => SORT_ASC));
}

$arResult['ALL_PROPERTIES'] = array();
$existShow = !empty($arResult['SHOW_PROPERTIES']);
$existDelete = !empty($arResult['DELETED_PROPERTIES']);
if ($existShow || $existDelete)
{
	if ($existShow)
	{
		foreach ($arResult['SHOW_PROPERTIES'] as $propCode => $arProp)
		{
			$arResult['SHOW_PROPERTIES'][$propCode]['IS_DELETED'] = 'N';
			$arResult['SHOW_PROPERTIES'][$propCode]['ACTION_LINK'] = str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_PROPERTY_TEMPLATE']);
		}
		$arResult['ALL_PROPERTIES'] = $arResult['SHOW_PROPERTIES'];
	}
	unset($arProp, $propCode);
	if ($existDelete)
	{
		foreach ($arResult['DELETED_PROPERTIES'] as $propCode => $arProp)
		{
			$arResult['DELETED_PROPERTIES'][$propCode]['IS_DELETED'] = 'Y';
			$arResult['DELETED_PROPERTIES'][$propCode]['ACTION_LINK'] = str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_PROPERTY_TEMPLATE']);
			$arResult['ALL_PROPERTIES'][$propCode] = $arResult['DELETED_PROPERTIES'][$propCode];
		}
		unset($arProp, $propCode, $arResult['DELETED_PROPERTIES']);
	}
	Collection::sortByColumn($arResult["ALL_PROPERTIES"], array('SORT' => SORT_ASC, 'ID' => SORT_ASC));
}

$arResult["ALL_OFFER_FIELDS"] = array();
$existShow = !empty($arResult["SHOW_OFFER_FIELDS"]);
$existDelete = !empty($arResult["DELETED_OFFER_FIELDS"]);
if ($existShow || $existDelete)
{
	if ($existShow)
	{
		foreach ($arResult["SHOW_OFFER_FIELDS"] as $propCode)
		{
			if($propCode=="PREVIEW_PICTURE" || $propCode=="DETAIL_PICTURE" || $propCode=="NAME" || $propCode=="ID"){
				unset($arResult["SHOW_OFFER_FIELDS"][$propCode]);
			}else{
				$arResult["SHOW_OFFER_FIELDS"][$propCode] = array(
					"CODE" => $propCode,
					"IS_DELETED" => "N",
					"ACTION_LINK" => str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_OF_FIELD_TEMPLATE']),
					'SORT' => $arResult['FIELDS_SORT'][$propCode]
				);
			}
		}
		unset($propCode);
		$arResult['ALL_OFFER_FIELDS'] = $arResult['SHOW_OFFER_FIELDS'];
	}
	if ($existDelete)
	{
		foreach ($arResult['DELETED_OFFER_FIELDS'] as $propCode)
		{
			$arResult['ALL_OFFER_FIELDS'][$propCode] = array(
				"CODE" => $propCode,
				"IS_DELETED" => "Y",
				"ACTION_LINK" => str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_OF_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode, $arResult['DELETED_OFFER_FIELDS']);
	}
	Collection::sortByColumn($arResult['ALL_OFFER_FIELDS'], array('SORT' => SORT_ASC));
}

$arResult['ALL_OFFER_PROPERTIES'] = array();
$existShow = !empty($arResult["SHOW_OFFER_PROPERTIES"]);
$existDelete = !empty($arResult["DELETED_OFFER_PROPERTIES"]);
if ($existShow || $existDelete)
{
	if ($existShow)
	{
		foreach ($arResult['SHOW_OFFER_PROPERTIES'] as $propCode => $arProp)
		{
			$arResult["SHOW_OFFER_PROPERTIES"][$propCode]["IS_DELETED"] = "N";
			$arResult["SHOW_OFFER_PROPERTIES"][$propCode]["ACTION_LINK"] = str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_OF_PROPERTY_TEMPLATE']);
		}
		unset($arProp, $propCode);
		$arResult['ALL_OFFER_PROPERTIES'] = $arResult['SHOW_OFFER_PROPERTIES'];
	}
	if ($existDelete)
	{
		foreach ($arResult['DELETED_OFFER_PROPERTIES'] as $propCode => $arProp)
		{
			$arResult["DELETED_OFFER_PROPERTIES"][$propCode]["IS_DELETED"] = "Y";
			$arResult["DELETED_OFFER_PROPERTIES"][$propCode]["ACTION_LINK"] = str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_OF_PROPERTY_TEMPLATE']);
			$arResult['ALL_OFFER_PROPERTIES'][$propCode] = $arResult["DELETED_OFFER_PROPERTIES"][$propCode];
		}
		unset($arProp, $propCode, $arResult['DELETED_OFFER_PROPERTIES']);
	}
	Collection::sortByColumn($arResult['ALL_OFFER_PROPERTIES'], array('SORT' => SORT_ASC, 'ID' => SORT_ASC));
}
?>

<?php
if(isset($_SESSION["ASORT"])){
    if(count($_SESSION["ASORT"])>0){
        $newArr = Array();
        foreach ($_SESSION["ASORT"] as $item1){
            foreach ($arResult['ITEMS'] as $item2){
                if($item1==$item2['ID']){
                    $newArr[] = $item2;
                    break;
                }
            }
        }
        $arResult['ITEMS'] = $newArr;
        unset($_SESSION["ASORT"]);
    }
}
?>
<?php
/*
if(isset($_GET['add_section']) && isset($_GET['tag'])){
    $arResult['ITEMS'] = Array();
    $arFilter = ['IBLOCK_ID' => 17, 'ACTIVE' => 'Y', 'PROPERTY_HIT' => getIDforXMLId($_GET['tag']),'SECTION_ID' => $_GET['add_section']];
    $arSelect = Array();
    $resProduct = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
    try {
        while($itemResProduct = $resProduct->Fetch()) {
        	$newArr = $itemResProduct;
        	$arrOffers = getPropertyByIdProduct($itemResProduct['ID'],$arResult["SHOW_FIELDS"]);
            $newArr['OFFER_DISPLAY_PROPERTIES']           = $arrOffers['PROPERTY'];
            $newArr["OFFER_FIELDS"]["PREVIEW_PICTURE"]    = $arrOffers['PREVIEW_PICTURE'];
            $newArr["DETAIL_PAGE_URL"]                    = "javascript:void(0);";
            $arResult['ITEMS'][] = $newArr;
        }
    } catch (Throwable $e) {
        echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
    }

}
function getPropertyByIdProduct($id_product,$show_fields){
	$ret_property = Array();
    $arFilter = ['IBLOCK_ID' => 20, 'ACTIVE' => 'Y', 'PROPERTY_CML2_LINK' => $id_product];

    $arSelect = Array("PREVIEW_PICTURE","PROPERTY_MAGAZIN","PROPERTY_USLOVIYA_PROTSENTNAYA_STAVKA","DETAIL_PAGE_URL");
    $resProductP = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
    try {
        while($itemResProductP = $resProductP->Fetch()) {
            $newArr = Array();
            $newArr['PREVIEW_PICTURE'] = $itemResProductP['PREVIEW_PICTURE'];
            $newArr['PROPERTY']        = [$itemResProductP['PROPERTY_MAGAZIN'],$itemResProductP['PROPERTY_USLOVIYA_PROTSENTNAYA_STAVKA']];
            //print_r($itemResProductP);
            $ret_property = $newArr;
        }
    } catch (Throwable $e) {
        echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
    }
    return $ret_property;
}
function getIDforXMLId($xml_id){
	$id_list_property = 0;
    switch ($xml_id) {
        case 'HIT':
            $id_list_property = 65;
            break;
        case 'RECOMMEND':
            $id_list_property = 66;
            break;
        case 'NEW':
            $id_list_property = 67;
            break;
        case 'STOCK':
            $id_list_property = 68;
            break;
        case 'e16ed0099295f0fe5e3083beba2d0410':
            $id_list_property = 2132;
            break;
        case '9733d7b20b00a9451b84c3f3476a0f9c':
            $id_list_property = 2129;
            break;
        case '85d9a67546db028be6e1b42524aba8c6':
            $id_list_property = 2130;
            break;
        case '6fdb585f1576c1db8523d2a1dc0c926c':
            $id_list_property = 2131;
            break;
        case '0fb4146a8c2fb737356c4b3e949f4dec':
            $id_list_property = 2133;
            break;
        case '3c57ec78a2bcd724f6d67ec506a06464':
            $id_list_property = 2134;
            break;
        case 'ed2b43c46fb1df2b4db5bc62ff119746':
            $id_list_property = 2135;
            break;
    }
    return $id_list_property;
}*/
?>
