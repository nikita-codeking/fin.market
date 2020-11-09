<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Page\Asset;

class VueCatalogSection extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['VUECATALOG.SECTION.ID_IBLOCK']  = (int) $arParams['VUECATALOG.SECTION.ID_IBLOCK'];
        $arParams['VUECATALOG.SECTION.ID_SECTION'] = (int) $arParams['VUECATALOG.SECTION.ID_SECTION'];
        if(!$arParams['CACHE_TIME'])
            $arParams['CACHE_TIME'] = 36000000;
        return $arParams;
    }
    private function setarResult()
    {

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