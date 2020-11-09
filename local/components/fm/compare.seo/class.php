<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class CreditAssistantComp extends CBitrixComponent{
    public function onPrepareComponentParams($arParams){
        $arParams['ID_IBLOCK'] = (int) $arParams['ID_IBLOCK'];
        if(!$arParams['CACHE_TIME'])
            $arParams['CACHE_TIME'] = 36000000;
        return $arParams;
    }
    private function setarResult(){
        $arrTemp = array();
        if(isset($_GET['section_compare'])):
            $arFilter = ['IBLOCK_ID' => $this->arParams['ID_IBLOCK'], 'ACTIVE' => 'Y', 'NAME' => $_GET['section_compare']];
            $arSelect = [ 'ID', 'NAME','DETAIL_TEXT'];
            $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRes = $res->Fetch()){
                $arrTemp = $itemRes;
            }
        endif;
        $this->arResult['ELEMENT'] = $arrTemp;
    }
    public function executeComponent(){
        if($this->StartResultCache()){
            $this->setarResult();
            $this->IncludeComponentTemplate();
        }

    }
}

?>