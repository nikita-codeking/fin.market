<?	
	if($arParams["TOP_DEPTH"]>1){
		$arSections = array();
		$arSectionsDepth3 = array();
		foreach( $arResult["SECTIONS"] as $arItem ) {
			if( $arItem["DEPTH_LEVEL"] == 1 ) { $arSections[$arItem["ID"]] = $arItem;}
			elseif( $arItem["DEPTH_LEVEL"] == 2 ) {$arSections[$arItem["IBLOCK_SECTION_ID"]]["SECTIONS"][$arItem["ID"]] = $arItem;}
			elseif( $arItem["DEPTH_LEVEL"] == 3 ) {$arSectionsDepth3[] = $arItem;}
		}
		if($arSectionsDepth3){
			foreach( $arSectionsDepth3 as $arItem) {
				foreach( $arSections as $key => $arSection) {
					if (is_array($arSection["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]) && !empty($arSection["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]])) {
						$arSections[$key]["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["SECTIONS"][$arItem["ID"]] = $arItem;
					}
				}
			}
		}
		$arResult["SECTIONS"] = $arSections;
	}
/**
 * картинки разделов
 */
$arResult['PICTURES']      = array();
$idSections = array();
foreach ($arResult["SECTIONS"] as $arItem2)
{
    foreach ($arItem2["SECTIONS"] as $arItem)
    {
        $idSections[] = $arItem['ID'];
    }//foreach ($arItem2["SECTIONS"] as $arItem)
}//foreach ($arResult["SECTIONS"] as $arItem)
$arFilter = array('IBLOCK_ID' => 35, 'ID'=>$idSections,'ACTIVE'=>'Y');
$arSelect = array('ID','NAME','UF_FAST_PICTURE');
$rsSections = CIBlockSection::GetList(array('SORT' => 'ASC'), $arFilter,false,$arSelect);
while ($arSection = $rsSections->Fetch())
{
    $arResult['PICTURES'][$arSection['ID']] = CFile::GetPath($arSection['UF_FAST_PICTURE']);
}//while ($arSection = $rsSections->Fetch())

//$arResult['ID_ELEM_COMPR'] = array();

/*
$strId = "";
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
$arFilter = Array("IBLOCK_ID" => 35, "ACTIVE_DATE"=>"Y", 'SECTION_ID' => $arItem["ID"], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
$arrID = Array();
while($ob = $res->Fetch())
{
	$arElementsId = $ob['ID'];
	if(strlen($strId)>0)
	{
		$strId = "|" .$arElementsId;
		$arResult['ID_ELEM_COMPR'] = $strId;
	}
	else
	{
		$strId = $arElementsId;
		$arResult['ID_ELEM_COMPR'] = $strId;
	}
}

*/
?>
