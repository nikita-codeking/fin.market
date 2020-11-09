<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Page\Asset;

class CKChoose extends CBitrixComponent
{
	public function executeComponent() {
		$this->arResult = array();
		//Удаляю пустые ключи.
		$this->arParams["IBLOCK_SECTIONS"] = array_filter($this->arParams["IBLOCK_SECTIONS"]);
		$listsQuery = CIBlockElement::GetList(["SORT"=>"ASC"],["IBLOCK_ID" => 37, "PROPERTY_TYPE" => 2283, "!PROPERTY_RAZDEL"=>[2369, 2366],'PROPERTY_INCLUDE_GROUP2'=>$this->arParams["IBLOCK_SECTIONS"][0]],false,false,["PROPERTY_CODE_PROP", "NAME","IBLOCK_ID", "ID"]);
		$this->arResult["LISTS"];
		while($elList = $listsQuery->GetNextElement()){
			$result = $elList->GetFields();
			$result["prop"] = $elList->GetProperties();
			//see($result["prop"]);break;
			$this->arResult["LISTS"]["ALL"][$result["prop"]["CODE_PROP"]["VALUE"]] = $result["NAME"];
		}
        $arFilterS = array('IBLOCK_ID' => 35,'ID'=>$this->arParams["IBLOCK_SECTIONS"] );
        $rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilterS,false,array('ID','NAME','UF_FAST_PICTURE'));
        while ($arSction = $rsSections->Fetch())
        {
            $this->arResult["SECTIONS"][$arSction["ID"]]['NAME'] = $arSction["NAME"];
            $this->arResult["SECTIONS"][$arSction["ID"]]['PICTURE'] = $arSction["UF_FAST_PICTURE"];
        }
		unset($result);
		$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$this->arParams["IBLOCK_ID"], "CODE"=>"HIT"));
		while($enum_fields = $property_enums->GetNext())
		{
            $tagHit = $enum_fields["ID"];
            $secID  = $this->arParams["IBLOCK_SECTIONS"][0];

            $arrFilter = ["SECTION_ID" => $secID, "IBLOCK_ID" => 35, "PROPERTY_HIT"  => $tagHit, "ACTIVE" => "Y"];
            $queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilter, false, false, Array("NAME", "ID", "PREVIEW_PICTURE", "IBLOCK_ID"));
            $countEl = 0;
            while($resQueryCard = $queryCard->GetNextElement()):
                $countEl++;
            endwhile;
            if($countEl>0):
  			    $this->arResult["LISTS"]["HIT"][$enum_fields["ID"]] = $enum_fields["VALUE"];
            endif;
		}
		$this->includeComponentTemplate();
    }
}