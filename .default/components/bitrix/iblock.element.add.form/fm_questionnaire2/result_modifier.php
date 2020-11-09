<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

$arr_code = array();
$arr_result = array();
foreach ($arResult["PROPERTY_LIST"] as $propertyID){
    $arr_code[] = $arResult["PROPERTY_LIST_FULL"][$propertyID]['CODE'];
    $arr_result[$arResult["PROPERTY_LIST_FULL"][$propertyID]['CODE']][] = $arResult["PROPERTY_LIST_FULL"][$propertyID]['CODE'];
}

$arSort = array('SORT' => 'ASC', 'ID' => 'DESC');
$arFilter = array('ACTIVE' => 'Y', 'IBLOCK_ID' => 31,'CODE' => $arr_code);
$arSelect = array('CODE', 'NAME', 'PREVIEW_TEXT');

$res = CIBlockElement::getList($arSort, $arFilter, false, false, $arSelect);
while ($row = $res->fetch()) {
    //echo strtoupper($row['CODE']) . '</br>';
    $arr_result[str_replace('-','_',strtoupper($row['CODE']))][] = $row['PREVIEW_TEXT'];
}

$arResult["VISIBLE"] = $arr_result;

