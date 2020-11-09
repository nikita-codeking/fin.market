<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class AdmidatBannersComp extends CBitrixComponent{
    public function onPrepareComponentParams($arParams){
        if(!$arParams['CACHE_TIME'])
            $arParams['CACHE_TIME'] = 36000000;
        return $arParams;
    }
    private function setarResult(){

    }
    public function executeComponent(){
        if($this->StartResultCache()){
            $this->setarResult();
            $this->IncludeComponentTemplate();
        }

    }
}
?>