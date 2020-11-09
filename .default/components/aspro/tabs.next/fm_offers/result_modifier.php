<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;
use Bitrix\Iblock;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();


$res = CIBlockSection::GetByID($arParams["SECTION_ID"]);
if($ar_res = $res->GetNext())
    $arResult["SECTION_URL"] = $ar_res['SECTION_PAGE_URL'];


?>