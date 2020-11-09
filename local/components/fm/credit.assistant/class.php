<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class CreditAssistantComp extends CBitrixComponent{
    public function onPrepareComponentParams($arParams){
        $arParams['ID_IBLOCK'] = (int) $arParams['ID_IBLOCK'];
        $arParams['ID_IBLOCK_TP'] = (int) $arParams['ID_IBLOCK_TP'];
        $arParams['ID_HL'] = (int) $arParams['ID_HL'];
        if(!$arParams['CACHE_TIME'])
            $arParams['CACHE_TIME'] = 36000000;
        return $arParams;
    }
    private function setarResult(){
        global $USER;
        if($USER->IsAuthorized()){
            /**ПОЛУЧЕНИЕ ТИПОВ - НАЧАЛО**/
            $types = Array();
            $types[] = Array('NAME'=>'Кредитные карты','ID'=>107,'ACTIVE'=>true,'IMG'=>$this->getPictureForSection(107));
            $types[] = Array('NAME'=>'Кредиты','ID'=>108,'ACTIVE'=>false,'IMG'=>$this->getPictureForSection(108));
            $types[] = Array('NAME'=>'Карты рассрочки','ID'=>112,'ACTIVE'=>false,'IMG'=>$this->getPictureForSection(112));
            $types[] = Array('NAME'=>'Займы','ID'=>110,'ACTIVE'=>false,'IMG'=>$this->getPictureForSection(110));
            $types[] = Array('NAME'=>'Автокредиты','ID'=>109,'ACTIVE'=>false,'IMG'=>$this->getPictureForSection(109));
            $types[] = Array('NAME'=>'Ипотека','ID'=>115,'ACTIVE'=>false,'IMG'=>$this->getPictureForSection(115));
            $this->arResult['TYPES'] = $types;
            /**ПОЛУЧЕНИЕ ТИПОВ - КОНЕЦ**/

            /**ПОЛУЧЕНИЕ КАТАЛОГ - НАЧАЛО**/
            $arrSection = Array();
            foreach ($types as $itemType){
                if($itemType['ACTIVE']){
                    $arrSection[] = $itemType['ID'];
                }
            }
            $arFilter = ['IBLOCK_ID' => $this->arParams['ID_IBLOCK'], 'ACTIVE' => 'Y', 'SECTION_ID' => $arrSection];
            $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','IBLOCK_SECTION_ID','PREVIEW_PICTURE'];
            $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRes = $res->Fetch()){
                $products[] = $itemRes;
            }
            $this->arResult['PRODUCTS'] = $products;
            /**ПОЛУЧЕНИЕ КАТАЛОГ - КОНЕЦ**/

            //отсечь по IBLOCK_SECTION_ID
            //вывод анкет
            //сортировка
            //формирование заявок
            //вывод полей СМС
            //выберите еще

            /**ПОЛУЧЕНИЕ АНКЕТЫ - НАЧАЛО**/
            $questionnaire = Array();
            $arFilter = ['IBLOCK_ID' => 25, 'ACTIVE' => 'Y', 'CREATED_BY' => $USER->GetID()];
            $arSelect = [ 'ID', 'NAME','PROPERTY_TYPE'];
            $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRes = $res->Fetch()){
                $questionnaire[] = $itemRes;
            }
            if(count($questionnaire)>0){
                $this->arResult['QUEST'] = $questionnaire;
            }
            /**ПОЛУЧЕНИЕ АНКЕТЫ - КОНЕЦ**/

            /**ПОЛУЧЕНИЕ БРЕНДОВ - НАЧАЛО**/
            /*$products      = Array();
            $brands        = Array();
            $brands_unique = Array();
            $hl_brands     = Array();

            $arFilter = ['IBLOCK_ID' => $this->arParams['ID_IBLOCK'], 'ACTIVE' => 'Y', 'SECTION_ID' => 107];
            $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
            $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRes = $res->Fetch()){
                $products[] = $itemRes['ID'];
            }
            $arFilter = ['IBLOCK_ID' => $this->arParams['ID_IBLOCK_TP'], 'ACTIVE' => 'Y', 'PROPERTY_CML2_LINK' => $products];
            $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM', 'PROPERTY_MAGAZIN'];
            $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRes = $res->Fetch()){
                $brands[] = $itemRes['PROPERTY_MAGAZIN_VALUE'];
            }
            $brands_unique = array_unique($brands);
            if (CModule::IncludeModule('highloadblock')):

                $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->arParams['ID_HL'])->fetch();
                $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
                $entityClass = $entity->getDataClass();

                $res = $entityClass::getList(array(
                    'select' => array('*'),
                    'filter' => array('UF_XML_ID' => $brands_unique)
                ));
                while ($row = $res->fetch()) {
                    $temp = Array();
                    $temp['ID']   = $row['ID'];
                    $temp['NAME'] = $row['UF_NAME'];
                    $temp['IMG']  = CFile::GetPath($row['UF_FILE']);
                    $hl_brands[]  = $temp;
                }
            endif;
            $this->arResult['BRANDS'] = $hl_brands;*/
            /**ПОЛУЧЕНИЕ БРЕНДОВ - КОНЕЦ**/


        }
    }
    public function executeComponent(){
        if($this->StartResultCache()){
            $this->setarResult();
            $this->IncludeComponentTemplate();
        }

    }
    private function getPictureForSection($id_section){
        $res = "";
        $res_query = CIBlockSection::GetByID($id_section);
        if($ar_res = $res_query->GetNext()){
            if($ar_res['PICTURE']>0){
                $res = CFile::GetPath($ar_res['PICTURE']);
            }
        }
        return $res;
    }
}

?>