<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class ComparisonsListComp extends CBitrixComponent{
    public function onPrepareComponentParams($arParams){
        $arParams['ID_IBLOCK'] = (int) $arParams['ID_IBLOCK'];
        if(!$arParams['CACHE_TIME'])
            $arParams['CACHE_TIME'] = 36000000;
        return $arParams;
    }

    private function setarResult(){
        $sessionId = session_id();
        if(isset($_GET['products']))
        {

            /**
             * удаляем все из сравнения
             */
            $arFilter = ['IBLOCK_ID' => $this->arParams['ID_IBLOCK'], 'ACTIVE' => 'Y','NAME'=>$sessionId];
            $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_PRODUCT','PROPERTY_PRODUCT.NAME'];
            $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRes = $res->Fetch())
            {
                CIBlockElement::Delete($itemRes['ID']);
            }//while($itemRes = $res->Fetch())
            /**
             * добавляем в сравнение
             */
            $arrProductComparisons = explode("|",$_GET['products']);
            foreach ($arrProductComparisons as $itemP)
            {
                $el = new CIBlockElement;
                $PROP = array();
                $PROP[1937] = $itemP;
                $arLoadProductArray = Array(
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID"      => 40,
                    "PROPERTY_VALUES"=> $PROP,
                    "NAME"           => $sessionId,
                    "ACTIVE"         => "Y"
                );
                $el->Add($arLoadProductArray);
            }//foreach ($arrProductComparisons as $itemP)
        }//if(isset($_GET['products']))

        if(isset($_GET['section_code'])){

            $arFilter = ['IBLOCK_ID' => $this->arParams['ID_IBLOCK'], 'ACTIVE' => 'Y','NAME'=>$sessionId];
            $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_PRODUCT','PROPERTY_PRODUCT.NAME'];
            $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRes = $res->Fetch())
            {
                CIBlockElement::Delete($itemRes['ID']);
            }
            $arSelect1 = ['ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_PRODUCT','PROPERTY_PRODUCT.NAME'];
            $arFilter1 = ['IBLOCK_ID' => 35, 'ACTIVE' => 'Y', 'SECTION_CODE' => $_GET['section_code']];
            $res1 = CIBlockElement::GetList(Array(), $arFilter1, false, Array(), $arSelect1);
            while ($ob1 = $res1->Fetch()) {
                //echo $ob1['ID'] . '</br>';

                $el = new CIBlockElement;
                $PROP = array();
                $PROP[1937] = $ob1['ID'];
                $arLoadProductArray = Array(
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID" => 40,
                    "PROPERTY_VALUES" => $PROP,
                    "NAME" => $sessionId,
                    "ACTIVE" => "Y"
                );
                $el->Add($arLoadProductArray);

            }


        }

        $this->arResult['ITEMS'] = array();
        $arrResultItems = array();
        $arrResultProperties = array();
        $sectionId = 0;
        if(isset($sessionId))
        {
            if(!empty($sessionId))
            {

                $arFilter = ['IBLOCK_ID' => $this->arParams['ID_IBLOCK'], 'ACTIVE' => 'Y','NAME'=>$sessionId];
                $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_PRODUCT','PROPERTY_PRODUCT.NAME', 'PROPERTY_PRODUCT.DETAIL_PICTURE', 'PROPERTY_PRODUCT.IBLOCK_SECTION_ID'];
                $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                while($itemRes = $res->Fetch()) {

                    $res1 = CIBlockElement::GetByID($itemRes['PROPERTY_PRODUCT_VALUE']);
                    if ($ar_res1 = $res1->GetNext()) {
                        //print_r($ar_res1);
                        $elementPage = $ar_res1['DETAIL_PAGE_URL'];

                        $res2 = CIBlockSection::GetByID($itemRes['PROPERTY_PRODUCT_IBLOCK_SECTION_ID']);
                        if ($ar_res = $res2->GetNext()) {
                            $arPage = $ar_res['SECTION_PAGE_URL'];

                            $urlA = "";
                            $iteratorQuery = CIBlockElement::GetPropertyValues(35, array('ACTIVE' => 'Y', 'ID' => $itemRes['PROPERTY_PRODUCT_VALUE']), true, array('ID' => 954));
                            while ($iteratorRes = $iteratorQuery->Fetch()) {
                                $urlA = $iteratorRes['954'];
                            }

                            $arrResultItems[] = array('ID' => $itemRes['PROPERTY_PRODUCT_VALUE'], 'DETAIL_PAGE_URL' => $elementPage, 'URL' => $urlA, 'NAME' => $itemRes['PROPERTY_PRODUCT_NAME'], 'LIST_PRODUCT' => $arPage, 'PROPERTIES' => array(), 'PICTURE' => CFile::GetPath($itemRes['PROPERTY_PRODUCT_DETAIL_PICTURE']));
                        }
                    }
                }//while($itemRes = $res->Fetch())

                if(count($arrResultItems)>0)
                {
                    /**
                     * получим раздел
                     */
                    $resS = CIBlockElement::GetByID($arrResultItems[count($arrResultItems)-1]['ID']);
                    if($arS= $resS->GetNext())
                    {
                        $sectionId = $arS['IBLOCK_SECTION_ID'];
                    }//if($ar_res = $res->GetNext())
                    /**
                     * отсечем лишние
                     */
                    //see($arrResultItems);
                    $newArrResultItems = array();
                    foreach ($arrResultItems as &$item)
                    {
                        $sectionThis = 0;
                        $resS = CIBlockElement::GetByID($item['ID']);
                        if($arS= $resS->GetNext()) {
                            $sectionThis = $arS['IBLOCK_SECTION_ID'];
                        }
                        if($sectionThis!=$sectionId)
                        {
                            unset($item);
                        }
                        else
                        {
                            $newArrResultItems[] = $item;
                        }
                    }
                    //see($newArrResultItems);
                    $arrResultItems = $newArrResultItems;

                    /**
                     * получим свойства раздела
                     */
                    if($sectionId>0)
                    {
                        $arrOsn = array();
                        $arrUsl = array();
                        $arrTre = array();
                        $arrHar = array();
                        $arrDoc = array();
                        $arrSer = array();
                        $arFilterP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y','PROPERTY_INCLUDE_GROUP'=>$sectionId];
                        $arSelectP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_CODE_PROP','PROPERTY_ED_IZM','PROPERTY_RAZDEL'];
                        $resP = CIBlockElement::GetList(array(),$arFilterP,false,false,$arSelectP);
                        while($itemResP = $resP->Fetch())
                        {
                            if(isset($itemResP["PROPERTY_RAZDEL_VALUE"])){
                                $group_filters  = $itemResP["PROPERTY_RAZDEL_VALUE"];
                                //echo $group_filters . '</br>';
                                if($group_filters == 'Условия')//Условия
                                {
                                    $arrUsl[] = array('NAME'=>$itemResP['NAME'],'CODE'=>$itemResP['PROPERTY_CODE_PROP_VALUE'],'ED_IZM'=>$itemResP['PROPERTY_ED_IZM_VALUE']);
                                }
                                if($group_filters == 'Требования')//Требования
                                {
                                    $arrTre[] = array('NAME'=>$itemResP['NAME'],'CODE'=>$itemResP['PROPERTY_CODE_PROP_VALUE'],'ED_IZM'=>$itemResP['PROPERTY_ED_IZM_VALUE']);
                                }
                                if($group_filters == 'Характеристики')//Характеристики
                                {
                                    $arrHar[] = array('NAME'=>$itemResP['NAME'],'CODE'=>$itemResP['PROPERTY_CODE_PROP_VALUE'],'ED_IZM'=>$itemResP['PROPERTY_ED_IZM_VALUE']);
                                }
                                if($group_filters == 'Документы')//Документы
                                {
                                    $arrDoc[] = array('NAME'=>$itemResP['NAME'],'CODE'=>$itemResP['PROPERTY_CODE_PROP_VALUE'],'ED_IZM'=>$itemResP['PROPERTY_ED_IZM_VALUE']);
                                }
                                if($group_filters == 'Сервисы')//Сервисы
                                {
                                    $arrSer[] = array('NAME'=>$itemResP['NAME'],'CODE'=>$itemResP['PROPERTY_CODE_PROP_VALUE'],'ED_IZM'=>$itemResP['PROPERTY_ED_IZM_VALUE']);
                                }
                            }//if($pos_point_in_name === false)
                        }//while($itemRes = $res->Fetch())
                        foreach ($arrOsn as $temV)
                        {
                            $arrResultProperties[] = $temV;
                        }//foreach ($arrOsn as $temV)
                        foreach ($arrUsl as $temV)
                        {
                            $arrResultProperties[] = $temV;
                        }//foreach ($arrUsl as $temV)
                        foreach ($arrTre as $temV)
                        {
                            $arrResultProperties[] = $temV;
                        }//foreach ($arrTre as $temV)
                        foreach ($arrHar as $temV)
                        {
                            $arrResultProperties[] = $temV;
                        }//foreach ($arrHar as $temV)
                        foreach ($arrDoc as $temV)
                        {
                            $arrResultProperties[] = $temV;
                        }//foreach ($arrDoc as $temV)
                        foreach ($arrSer as $temV)
                        {
                            $arrResultProperties[] = $temV;
                        }//foreach ($arrSer as $temV)


                    }//if($sectionId>0)
                    /**
                     * получим значения свойств элементов
                     */


                    if(count($arrResultProperties)>0)
                    {
                        foreach ($arrResultItems as &$itemC)
                        {
                            foreach ($arrResultProperties as $itemP)
                            {
                                $idProduct  = $itemC['ID'];
                                $codeProperty = $itemP['CODE'];
                                $arFilterVP = ['IBLOCK_ID' => 35, 'ACTIVE' => 'Y','ID'=>$idProduct];
                                $arSelectVP = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_'.$codeProperty];
                                $resVP = CIBlockElement::GetList(array(),$arFilterVP,false,false,$arSelectVP);
                                while($itemResVP = $resVP->Fetch())
                                {
                                    
                                    $realIdProperty  = 0;
                                    $realDescription = "";
                                    $propertiesGet = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>35,'CODE'=>$codeProperty));
                                    while ($prop_fields_get = $propertiesGet->GetNext())
                                    {

                                        $realIdProperty = $prop_fields_get['ID'];
                                        $propertyType = $prop_fields_get['PROPERTY_TYPE']; // netwiz-> получаем из гетЛиста значения тип данных у свойств, символьный код и айдишник.
                                        $propertyCode = $prop_fields_get['CODE']; // #netwiz-> получаем символьный код.
                                        $propertyMultiple = $prop_fields_get['MULTIPLE']; // #netwiz-> получаем значение множественности свойства.

                                    }

                                    if($realIdProperty>0)
                                    {
                                        $iteratorVP = CIBlockElement::GetPropertyValues(35, array('ACTIVE' => 'Y','ID'=>$itemResVP['ID']), true, array('ID' => $realIdProperty));
                                        while ($rowPVR = $iteratorVP->Fetch())
                                        {
                                            foreach ($rowPVR['DESCRIPTION'] as $itemDescription)
                                            {
                                                $realDescription = $itemDescription;

                                            }//foreach ($rowPVR['DESCRIPTION'] as $itemDescription)
                                        }//while ($rowPVR = $iteratorVP->Fetch())
                                    }//if($realIdProperty>0)

                                    #netwiz->start получение двух значений множественных свойств и запись их в $arResult, для дальнейшего вывода в формате "от" и "до".
                                    if(isset($itemC['PROPERTIES'][$codeProperty]))
                                     {
                                        if(is_array($itemC['PROPERTIES'][$codeProperty]['VALUE']))
                                        {
                                            $itemC['PROPERTIES'][$codeProperty]['VALUE'][] = $itemResVP['PROPERTY_'.$codeProperty.'_VALUE'];
                                        }
                                        else
                                        {
                                            $old_val = $itemC['PROPERTIES'][$codeProperty]['VALUE'];
                                            $itemC['PROPERTIES'][$codeProperty]['VALUE'] = array();
                                            $itemC['PROPERTIES'][$codeProperty]['VALUE'][] = $old_val;
                                            $itemC['PROPERTIES'][$codeProperty]['VALUE'][] = $itemResVP['PROPERTY_'.$codeProperty.'_VALUE'];

                                        }//if(is_array($itemC['PROPERTIES'][$codeProperty]['VALUE']))
                                    }
                                    else
                                    {
                                        $itemC['PROPERTIES'][$codeProperty] = array('VALUE'=>$itemResVP['PROPERTY_'.$codeProperty.'_VALUE'], 'ID' => $realIdProperty,'CODE' => $propertyCode,'PROPERTY_TYPE' => $propertyType, 'VALUE_DESCRIPTION' =>$itemP['ED_IZM'],'DESCRIPTION'=>$realDescription, 'TYPE_MULTIPLE' => $propertyMultiple);
                                    }
                                    #netwiz->end получение двух значений множественных свойств.

                                }
                            }//foreach ($arrResultProperties as $itemP)
                        }//foreach ($arrResultItems as $itemC)

                    }//if(count($arrResultProperties)>0)
                }//if(count($arrResultItems)>0)
            }//if(!empty($session_id))
        }//if(isset($session_id))




        $this->arResult['SECTION_ID'] = $sectionId;
        $this->arResult['SESSION']    = $sessionId;
        $this->arResult['ITEMS']      = $arrResultItems;
        $this->arResult['PROPERTIES'] = $arrResultProperties;


    }

    public function executeComponent(){
        if($this->StartResultCache()){
            $this->setarResult();
            $this->IncludeComponentTemplate();
        }

    }
}

?>