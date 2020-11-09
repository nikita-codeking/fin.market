<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/iblock/lib/template/functions/fabric.php');
use \Bitrix\Main\Localization\Loc;
Loc::LoadMessages(__FILE__);
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("MFEvents", "OnBeforeIBlockElementUpdateHandler"));
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("MFEvents", "OnBeforeIBlockElementAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockSectionAdd", Array("MFEvents", "OnAfterIBlockSectionAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockSectionUpdate", Array("MFEvents", "OnAfterIBlockSectionUpdateHandler"));
use Bitrix\Main;
$eventManager = Main\EventManager::getInstance();
$eventManager->addEventHandler("iblock", "OnTemplateGetFunctionClass", array("MFEvents", "OnTemplateGetFunctionClass") );

class MFEvents
{
    function OnTemplateGetFunctionClass(Bitrix\Main\Event $event) {
        $arParam = $event->getParameters();
        $functionClass = $arParam[0];
        if (is_string($functionClass) && class_exists($functionClass) && $functionClass=='regionseo_ip'){
            $result = new Bitrix\Main\EventResult(1,$functionClass);
            return $result;
        }
        if (is_string($functionClass) && class_exists($functionClass) && $functionClass=='regionseo_pp'){
            $result = new Bitrix\Main\EventResult(1,$functionClass);
            return $result;
        }
    }
    function OnBeforeIBlockElementAddHandler(&$arFields)
    {
        /**
         * создадим болванку свойства
         */
        if($arFields["IBLOCK_ID"] == PROPERTY_IBLOCK)
        {
            $codeProp = "";
            foreach ($arFields["PROPERTY_VALUES"][1250] as $itemCode)
            {
                $codeProp = $itemCode['VALUE'];
            }
            if(strlen($codeProp)>3)
            {
                self::AddNewProperty($arFields['NAME'],$codeProp);
                self::UpdSettingsProperty($arFields);
            }
        }
    }
    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
		global $APPLICATION;
		// #netwiz-> Если выбран чекбокс и ползунок.
		$typeP = $arFields["PROPERTY_VALUES"][1256][0]['VALUE'];
		$typeFilter = $arFields["PROPERTY_VALUES"][1972][0]['VALUE'];
		if($typeP == 2283 && $typeFilter == 2370) {
			$APPLICATION->ThrowException("У чекбокса не может быть вид в умном фильтре ползунок");
			return false;	
		}
		// #netwiz-> Если выбрана строка и ползунок
		if($typeP == 2281 && $typeFilter == 2370) {
			$APPLICATION->ThrowException("У строки не может быть вид в умном фильтре ползунок");
			return false;
		}
		// #netwiz-> Если выбрано число и список
		if($typeP == 2282 && $typeFilter == 2372) {
			$APPLICATION->ThrowException("У числа не может быть вид в умном фильтре список");
		}
		// #netwiz-> Если выбрано число и чекбокс
		if($typeP == 2282 && $typeFilter == 2371) {
			$APPLICATION->ThrowException("У числа не может быть вид в умном фильтре флажок");
		}
        self::UpdSettingsProperty($arFields);
    }
    function AddNewProperty($name,$code)
    {
        $arFields = Array(
            "NAME" => $name,
            "ACTIVE" => "Y",
            "SORT" => "999",
            "CODE" => $code,
            "PROPERTY_TYPE" => "S",
            'SMART_FILTER' => 'Y',
            "IBLOCK_ID" => CATALOG_IBLOCK
        );
        $ibp = new CIBlockProperty;
        if($ibp->Add($arFields))
        {
            CEventLog::Add(array(
                    "SEVERITY" => "SECURITY",
                    "MODULE_ID" => "main",
                    "DESCRIPTION" => $name . " - свойство добавлено!"
                )
            );
        }
        else
        {
            CEventLog::Add(array(
                    "SEVERITY" => "SECURITY",
                    "MODULE_ID" => "main",
                    "DESCRIPTION" => $name . " - свойство не добавлено. Ошибка! " . $ibp->LAST_ERROR
                )
            );
        }
    }
    function UpdSettingsProperty($arFields)
    {
        if($arFields["IBLOCK_ID"] == PROPERTY_IBLOCK) {
            if ($arFields["PROPERTY_VALUES"][1256][0]['VALUE']) {
                $typeP = $arFields["PROPERTY_VALUES"][1256][0]['VALUE'];
                // #netwiz-> Получаем ID варианта отображения в умном фильтре
                $typeFilter = $arFields["PROPERTY_VALUES"][1972][0]['VALUE'];
				
                /**
                 *#netwiz-> получим ID свойства по CODE
                 */
                $idProp = 0;
                $codeProp = "";
                $thisType = "";
                $nameNewProperty = $arFields['NAME'];
                $nameOldProperty = "";
                foreach ($arFields["PROPERTY_VALUES"][1250] as $itemCode)
                {
                    $codeProp = $itemCode['VALUE'];
                }
                $properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>CATALOG_IBLOCK, "CODE"=>$codeProp));
                while ($prop_fields = $properties->GetNext())
                {
                    $idProp = $prop_fields["ID"];
                    $thisType = $prop_fields['PROPERTY_TYPE'];
                    $nameOldProperty = $prop_fields['NAME'];
					//see($arFields["PROPERTY_VALUES"][1973]);
					//exit();
                    //see($typeFilter);
                    //exit();
					//see($arFields["PROPERTY_VALUES"][1976][0]["VALUE"]);
					//exit();
                }
                if($idProp>0)
                {
					if ($typeP == 2283 || $typeP == 2385) // #netwiz-> чекбокс или список
                    {
                        if($thisType != "L" || $typeP == 2385)
                        {
                            $arFieldsP = array(
                                "NAME" => $arFields["NAME"],
                                "CODE" => $codeProp,
                                "PROPERTY_TYPE" => "L",
                                "SMART_FILTER" => "Y",
                                "IBLOCK_ID" => CATALOG_IBLOCK,
							);
							//see($arFieldsP);
							//die();
							// #netwiz-> Если установлен вид в умном фильтре флажок - устанавливаем
							if($typeFilter == 2371) {
								$arFieldsP["DISPLAY_TYPE"] = "C";
								//$arFieldsP["LIST_TYPE"] = "C";
							} else if($typeFilter == 2372) {
								// #netwiz-> Если усьановлен вид в умном фильтре список - устанавливаем
								$arFieldsP["DISPLAY_TYPE"] = "P";
								//$arFieldsP["LIST_TYPE"] = "P";
							}
                            $ibp = new CIBlockProperty();
                            if($ibp->Update($idProp, $arFieldsP))
                            {
								if($arFields["PROPERTY_VALUES"][1976][0]["VALUE"] == 2459){
									$valuesEnum = array();
									if($typeP == 2283) {
                                		$valuesEnum[] = array('SORT'=>1, 'VALUE'=>"Да");
                                		$valuesEnum[] = array('SORT'=>2, 'VALUE'=>"Нет");
									} else {
										$sort = 1;
										foreach($arFields["PROPERTY_VALUES"][1973] as $key => $value) {
											$valuesEnum[] = array('SORT'=> $sort, 'VALUE'=>$value["VALUE"]);
											$sort++;
										}
									}
									$CIBlockProp = new CIBlockProperty;
									$CIBlockProp->UpdateEnum($idProp, $valuesEnum);
								}
								CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $arFields["NAME"] . " - меняем тип на список"
                                    )
                                );
                            }
                            else
                            {
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $arFields["NAME"] . " - меняем тип на список." . $ibp->LAST_ERROR
                                    )
                                );
                            }
                        }
                        elseif($thisType == "L")
                        {
							$arFieldsP = array(
	                                "CODE" => $codeProp,
	                                "IBLOCK_ID" => CATALOG_IBLOCK,
	                                "SMART_FILTER" => "Y"           
	                        );
							//see($arFieldsP);
							//die();
							if($nameNewProperty != $nameOldProperty){
								// #netwiz-> Если имя изменилось - обновляем
								$arFieldsP["NAME"] = $nameNewProperty;
							}
							// #netwiz-> Если установлен вид в умном фильтре флажок - устанавливаем
							if($typeFilter == 2371) {
								$arFieldsP["DISPLAY_TYPE"] = "C";
								//$arFieldsP["LIST_TYPE"] = "C";
							} else if($typeFilter == 2372) {
								// #netwiz-> Если установлен вид в умном фильтре список - устанавливаем
								$arFieldsP["DISPLAY_TYPE"] = "P";
								//$arFieldsP["LIST_TYPE"] = "P";
							}
                            $ibp = new CIBlockProperty();
                            if($ibp->Update($idProp, $arFieldsP))
                            {
								if($arFields["PROPERTY_VALUES"][1976][0]["VALUE"] == 2459){
									$valuesEnum = array();
									if($typeP == 2283) {
                                		$valuesEnum[] = array('SORT'=>1, 'VALUE'=>"Да");
                                		$valuesEnum[] = array('SORT'=>2, 'VALUE'=>"Нет");
									}
									$CIBlockProp = new CIBlockProperty;
									$CIBlockProp->UpdateEnum($idProp, $valuesEnum);
								}
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $nameNewProperty . " - изменяем наименование свойства - было - " . $nameOldProperty
                                    )
                                );
                            }
                        }//if($thisType!="L")

                    }//if ($typeP == 2283)
                    elseif ($typeP == 2281) //#netwiz-> строка
                    {
                        if($thisType != "S")
                        {
                            $arFieldsP = array(
                                "NAME" => $arFields["NAME"],
                                "CODE" => $codeProp,
                                "PROPERTY_TYPE" => "S",
                                "SMART_FILTER" => "Y",
                                "IBLOCK_ID" => CATALOG_IBLOCK
                            );
                            // #netwiz-> Если установлен вид в умном фильтре флажок - устанавливаем
							if($typeFilter == 2371) {
								$arFieldsP["DISPLAY_TYPE"] = "C";
								// #netwiz-> $arFieldsP["LIST_TYPE"] = "C";
							} else if($typeFilter == 2372) {
								// #netwiz-> Если усьановлен вид в умном фильтре список - устанавливаем
								$arFieldsP["DISPLAY_TYPE"] = "P";
								//$arFieldsP["LIST_TYPE"] = "P";
							}
                            $ibp = new CIBlockProperty();
                            if($ibp->Update($idProp, $arFieldsP))
                            {
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $arFields["NAME"] . " - меняем тип на строка"
                                    )
                                );
                            }
                            else
                            {
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $arFields["NAME"] . " - меняем тип на строка." . $ibp->LAST_ERROR
                                    )
                                );
                            }
                        }
                        elseif($thisType=="S")
                        {
                            $arFieldsP = array(
                                "CODE" => $codeProp,
                                "IBLOCK_ID" => CATALOG_IBLOCK,
                                "SMART_FILTER" => "Y",
                            );
                            if($nameNewProperty!=$nameOldProperty) {
								// #netwiz-> Если имя изменилось - обновляем
								$arFieldsP["NAME"] = $nameNewProperty;
							}
							// #netwiz-> Если установлен вид в умном фильтре флажок - устанавливаем
							if($typeFilter == 2371) {
								$arFieldsP["DISPLAY_TYPE"] = "C";
								//$arFieldsP["LIST_TYPE"] = "C";
							} else if($typeFilter == 2372) {
								// #netwiz-> Если усьановлен вид в умном фильтре список - устанавливаем
								$arFieldsP["DISPLAY_TYPE"] = "P";
								//$arFieldsP["LIST_TYPE"] = "P";
							}
                            $ibp = new CIBlockProperty();
                            if ($ibp->Update($idProp, $arFieldsP)) {
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $nameNewProperty . " - изменяем наименование свойства - было - " . $nameOldProperty
                                    )
                                );
                            }
                        }//if($thisType!="S")
                    }//elseif ($typeP == 2281)
                    elseif ($typeP == 2282) // #netwiz-> число
                    {
                        if($thisType != "N")
                        {
                            $arFieldsP = array(
                                "NAME" => $arFields["NAME"],
                                "CODE" => $codeProp,
                                "PROPERTY_TYPE" => "N",
                                "SMART_FILTER" => "Y",
                                "IBLOCK_ID" => CATALOG_IBLOCK
                            );
                            // #netwiz-> Если установлен вид в умном фильтре флажок - устанавливаем
							if($typeFilter == 2370) {
								// #netwiz-> Если усьановлен вид в умном фильтре ползунком - устанавливаем
								$arFieldsP["DISPLAY_TYPE"] = "A";
								//$arFieldsP["LIST_TYPE"] = "A";
							}
                            $ibp = new CIBlockProperty();
                            if($ibp->Update($idProp, $arFieldsP))
                            {
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $arFields["NAME"] . " - меняем тип на число."
                                    )
                                );
                            }
                            else
                            {
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $arFields["NAME"] . " - меняем тип на число." . $ibp->LAST_ERROR
                                    )
                                );
                            }
                        }
                        elseif($thisType == "N")
                        {
                            $arFieldsP = array(
                                "CODE" => $codeProp,
                                "SMART_FILTER" => "Y",
                                "IBLOCK_ID" => CATALOG_IBLOCK
                            );
                            if($nameNewProperty != $nameOldProperty) {
								// #netwiz-> Если имя изменилось - обновляем
								$arFieldsP["NAME"] = $nameNewProperty;
							}
							// #netwiz-> Если установлен вид в умном фильтре флажок - устанавливаем
							if($typeFilter == 2371) {
								$arFieldsP["DISPLAY_TYPE"] = "C";
								// #netwiz-> $arFieldsP["LIST_TYPE"] = "C";
							} else if($typeFilter == 2370) {
								// #netwiz-> Если усьановлен вид в умном фильтре ползунком - устанавливаем
								$arFieldsP["DISPLAY_TYPE"] = "A";
								//$arFieldsP["LIST_TYPE"] = "A";
							} else if($typeFilter == 2372) {
								// #netwiz-> Если усьановлен вид в умном фильтре список - устанавливаем
								$arFieldsP["DISPLAY_TYPE"] = "P";
								//$arFieldsP["LIST_TYPE"] = "P";
							}
                            $ibp = new CIBlockProperty();
                            if ($ibp->Update($idProp, $arFieldsP)) {
                                CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "MODULE_ID" => "main",
                                        "DESCRIPTION" => $nameNewProperty . " - изменяем наименование свойства - было - " . $nameOldProperty
                                    )
                                );
                            }
                        }//if($thisType!="N")
                    }//elseif ($typeP == 2282)
				} else { /*see($idProp); die();*/ }//if($idProp>0)

            }
        }
    }
    function OnAfterIBlockSectionAddHandler(&$arFields)
    {
        if($arFields['IBLOCK_ID']==35)
        {
            if(isset($arFields['IBLOCK_SECTION_ID']))
            {
                if(!empty($arFields['IBLOCK_SECTION_ID']))
                {
                    /**
                     * получим город
                     */
                    $idCity = 0;
                    if($arFields['UF_REGION_RAZDEL_SEO'])
                    {
                        $idCity = $arFields['UF_REGION_RAZDEL_SEO'];
                    }
                    if($idCity>0)
                    {
                        $arFilter = ['IBLOCK_ID' => $arFields['IBLOCK_ID'], 'ACTIVE' => 'Y', 'IBLOCK_SECTION_ID' => $arFields['IBLOCK_SECTION_ID'],'PROPERTY_LINK_REGION'=>$idCity];
                        $arSelect = array('ID', 'NAME');
                        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
                        while ($itemRes = $res->Fetch()) {


                            /**
                             * получим в каких группах он уже состоит
                             */
                            $arrResultGroups = array();
                            $getGroups = CIBlockElement::GetElementGroups($itemRes['ID'], true);
                            //$ar_new_groups = Array($NEW_GROUP_ID);
                            while ($arGroups = $getGroups->Fetch())
                                $arrResultGroups[] = $arGroups["ID"];
                            //CIBlockElement::SetElementSection($ELEMENT_ID, $ar_new_groups);
                            /**
                             * проверяем есть ли наша группа там
                             */
                            if (!in_array($arFields['ID'], $arrResultGroups)) {
                                $arrResultGroups[] = $arFields['ID'];
                            }//if(!in_array($arFields['ID'],$arrResultGroups))
                            /**
                             * устанавливаем привязки групп
                             */
                            CIBlockElement::SetElementSection($itemRes['ID'], $arrResultGroups);
                        }//while($itemRes = $res->Fetch())
                    }//if($idCity>0)
                    //exit();
                }//if(!empty($arFields['IBLOCK_SECTION_ID']))
            }//if(isset($arFields['IBLOCK_SECTION_ID']))
        }//if($arFields['IBLOCK_ID']==35)
    }
    function OnAfterIBlockSectionUpdateHandler(&$arFields)
    {
        if($arFields['IBLOCK_ID']==35)
        {
            if(isset($arFields['IBLOCK_SECTION_ID']))
            {
                if(!empty($arFields['IBLOCK_SECTION_ID']))
                {
                    /**
                     * получим город
                     */
                    $idCity = 0;
                    if($arFields['UF_REGION_RAZDEL_SEO'])
                    {
                        $idCity = $arFields['UF_REGION_RAZDEL_SEO'];
                    }
                    //echo 'city - ' . $city . ' id city - ' . $idCity;
                    if($idCity>0)
                    {
                        $arFilter = ['IBLOCK_ID' => $arFields['IBLOCK_ID'], 'ACTIVE' => 'Y', 'IBLOCK_SECTION_ID' => $arFields['IBLOCK_SECTION_ID'],'PROPERTY_LINK_REGION'=>$idCity];
                        $arSelect = array('ID','NAME');
                        $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                        while($itemRes = $res->Fetch())
                        {

                            /**
                             * получим в каких группах он уже состоит
                             */
                            $arrResultGroups = array();
                            $getGroups = CIBlockElement::GetElementGroups($itemRes['ID'], true);
                            //$ar_new_groups = Array($NEW_GROUP_ID);
                            while($arGroups = $getGroups->Fetch())
                                $arrResultGroups[] = $arGroups["ID"];
                            //CIBlockElement::SetElementSection($ELEMENT_ID, $ar_new_groups);
                            /**
                             * проверяем есть ли наша группа там
                             */
                            if(!in_array($arFields['ID'],$arrResultGroups))
                            {
                                $arrResultGroups[] = $arFields['ID'];
                            }//if(!in_array($arFields['ID'],$arrResultGroups))
                            /**
                             * устанавливаем привязки групп
                             */
                            CIBlockElement::SetElementSection($itemRes['ID'], $arrResultGroups);
                            \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex(35, $itemRes['ID']);
                        }//while($itemRes = $res->Fetch())
                    }//if($idCity>0)

                    //exit();
                }//if(!empty($arFields['IBLOCK_SECTION_ID']))
            }//if(isset($arFields['IBLOCK_SECTION_ID']))
        }//if($arFields['IBLOCK_ID']==35)
    }
}
class regionseo_ip extends Bitrix\Iblock\Template\Functions\FunctionBase
{
    public function calculate(array $parameters)
    {

        $arParams = $this->parametersToArray($parameters);
        $text = strip_tags(trim(implode(" ", $arParams)));
        $words = explode(" ", $text);
        $str_res = "";
        foreach ($words as $word){
            if(strlen($word)>0)
            {
                $str_res = $word;
                $arFilter = ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y', 'ID' => (int)$word];
                $arSelect = [ 'ID', 'NAME'];
                $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                while($itemRes = $res->Fetch())
                {
                    $str_res = $itemRes['NAME'];
                }
            }
        }
        return $str_res;
    }
}
class regionseo_pp extends Bitrix\Iblock\Template\Functions\FunctionBase
{
    public function calculate(array $parameters)
    {

        $arParams = $this->parametersToArray($parameters);
        $text = strip_tags(trim(implode(" ", $arParams)));
        $words = explode(" ", $text);
        $str_res = "";
        foreach ($words as $word){
            if(strlen($word)>0)
            {
                $arFilter = ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y', 'ID' => (int)$word];
                $arSelect = [ 'ID', 'NAME','PROPERTY_REGION_NAME_DECLINE_PP'];
                $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                while($itemRes = $res->Fetch())
                {
                    $str_res = $itemRes['PROPERTY_REGION_NAME_DECLINE_PP_VALUE'];
                }
            }
        }
        return $str_res;
    }
}
?>
