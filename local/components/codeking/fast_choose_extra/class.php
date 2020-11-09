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
		$secID  = $this->arParams["IBLOCK_SECTIONS"][0];
		while($elList = $listsQuery->GetNextElement()){
			$result = $elList->GetFields();
			$result["prop"] = $elList->GetProperties();
			$arrFilter = ["SECTION_ID" => $secID, "IBLOCK_ID" => 35, "!PROPERTY_".$result["prop"]["CODE_PROP"]["VALUE"]  => false, "ACTIVE" => "Y"];
			$queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilter, false, false, Array("NAME", "ID", "IBLOCK_ID"));
			while($resQueryCard = $queryCard->GetNextElement()):
                $countEl++;
            endwhile;
			if($countEl>0):
				$this->arResult["LISTS"]["ALL"][$result["prop"]["CODE_PROP"]["VALUE"]] = $result["NAME"];
			endif;
		}
		$countEl = 0;
		$secArrayForFutureFilter = array();
        $arFilterS = array('IBLOCK_ID' => 35,'ID'=>$this->arParams["IBLOCK_SECTIONS"] );
        $rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilterS,false,array('ID','NAME','UF_FAST_PICTURE'));
        while ($arSction = $rsSections->Fetch())
        {
            $this->arResult["SECTIONS"][$arSction["ID"]]['NAME']    = $arSction["NAME"];
            $this->arResult["SECTIONS"][$arSction["ID"]]['PICTURE'] = $arSction["UF_FAST_PICTURE"];
            $this->arResult["SECTIONS"][$arSction["ID"]]['BANNER']  = 0;
            $secArrayForFutureFilter[] = $arSction["ID"];
        }
		unset($result);
        /**
         * получим где надо показать отправить в банки 1 заявку
         */
        $arFilterB   = array('IBLOCK_ID' => 46, 'ACTIVE'=>'Y');
        $rsSectionsB = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilterB,false,false,array('ID','NAME','PROPERTY_BANNERS_SECTION'));
        while($arSectionB = $rsSectionsB->Fetch())
        {
            if(in_array($arSectionB['PROPERTY_BANNERS_SECTION_VALUE'],$secArrayForFutureFilter))
            {
                $this->arResult["SECTIONS"][$arSectionB['PROPERTY_BANNERS_SECTION_VALUE']]['BANNER'] = 1;
            }
        }//while($arSectionB = $rsSectionsB->Fetch())


		$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$this->arParams["IBLOCK_ID"], "CODE"=>"HIT"));
		while($enum_fields = $property_enums->GetNext())
		{
            $tagHit = $enum_fields["ID"];
			//$secID  = $this->arParams["IBLOCK_SECTIONS"][0];

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

		$listsOtherQuery = CIBlockElement::GetList(["SORT"=>"ASC"],["IBLOCK_ID" => 37, "PROPERTY_TYPE" => 2385, "!PROPERTY_RAZDEL"=>[2369, 2366],'PROPERTY_INCLUDE_GROUP2'=>$this->arParams["IBLOCK_SECTIONS"][0]],false,false,["PROPERTY_CODE_PROP", "NAME","IBLOCK_ID", "ID"]);
		while($elList = $listsOtherQuery->GetNextElement()){
			$result = $elList->GetFields();
			$result["prop"] = $elList->GetProperties();
			$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$this->arParams["IBLOCK_ID"], "CODE"=>$result["prop"]["CODE_PROP"]["VALUE"]));
            $countEl = 0;
			while($enum_fields = $property_enums->Fetch()){
				$arrFilter = ["IBLOCK_SECTION_ID" => $secID, "IBLOCK_ID" => 35, "PROPERTY_".$enum_fields["PROPERTY_CODE"]  => $enum_fields["ID"], "ACTIVE" => "Y"];
				$queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilter, false, false, Array("NAME", "ID", "IBLOCK_ID","PROPERTY_".$enum_fields["PROPERTY_CODE"]));
				while($resQueryCard = $queryCard->Fetch()):
                   $countEl++;
            	endwhile;
				if($countEl>0):
					$this->arResult["LISTS"]["OTHER"][$result["prop"]["CODE_PROP"]["VALUE"]][]=  $enum_fields;
				endif;
                $countEl = 0;
			}
		}
		$this->includeComponentTemplate();
    }
}