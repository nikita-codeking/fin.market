<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Page\Asset;

class FastFilterSection extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['ID_IBLOCK']  = (int) $arParams['ID_IBLOCK'];
        $arParams['ID_SECTION'] = (int) $arParams['ID_SECTION'];
        if(!$arParams['CACHE_TIME'])
            $arParams['CACHE_TIME'] = 36000000;
        return $arParams;
    }
    private function setarResult()
    {
        $this->arResult = array();
        $arFilter = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y', 'PROPERTY_INCLUDE_GROUP2' => $this->arParams["ID_SECTION"]];
        $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM', 'PROPERTY_CODE_PROP', 'PROPERTY_RAZDEL'];
        $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
        while($itemRes = $res->Fetch())
        {
            $this->arResult['PROPERTIES'][$itemRes['PROPERTY_RAZDEL_VALUE']][] = $itemRes;
        }
    }
    public function executeComponent()
    {
        if($this->StartResultCache()){
            $this->setarResult();
            $this->IncludeComponentTemplate();
        }
    }
}
?>