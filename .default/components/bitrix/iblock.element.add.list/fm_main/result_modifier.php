<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

/**
 * получим свойство TYPE
 */

$arr_id = array();
$arr_result = array();
foreach ($arResult["ELEMENTS"] as $arElement){
    $arr_id[] = $arElement['ID'];
    $arr_result[$arElement['ID']][] = $arElement['ID'];
}
$arSort = array('SORT' => 'ASC', 'ID' => 'DESC');
$arFilter = array('ACTIVE' => 'Y', 'IBLOCK_ID' => $arParams['IBLOCK_ID'],'ID' => $arr_id);
$arSelect = array('ID', 'NAME', 'PROPERTY_TYPE');

$res = CIBlockElement::getList($arSort, $arFilter, false, false, $arSelect);
while ($row = $res->fetch()) {
    $arr_result[$row['ID']][] = $row['PROPERTY_TYPE_VALUE'];
}

foreach ($arResult["ELEMENTS"] as &$arElement){
    if(count($arr_result[$arElement['ID']])>1){
        $arElement['TYPE'] = $arr_result[$arElement['ID']][1];
    }
}
