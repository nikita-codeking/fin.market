<?php
function property_mobile_pay_setter(){
	CModule::IncludeModule("iblock");
	$arFilter = array("IBLOCK_ID" => 35, "!PROPERTY_HARAKTERISTIKI_GOOGLE_PAY"=>false);
	//HARAKTERISTIKI_GOOGLE_PAY done
	//HARAKTERISTIKI_APPLE_PAY done
	//HARAKTERISTIKI_SAMSUNG_PAY done
	//получаем все элементы у которых заполнено GOOGLE_PAY
	$queryElementsPays = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementPays = $queryElementsPays->GetNext()) {
		$arrIDs[$resElementPays["ID"]]["GOOGLE_PAY"] = 'Y';
	}
	$arFilter = array("IBLOCK_ID" => 35, "!PROPERTY_HARAKTERISTIKI_APPLE_PAY"=>false);
	$queryElementsPays = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementPays = $queryElementsPays->GetNext()) {
		$arrIDs[$resElementPays["ID"]]["APPLE_PAY"] = 'Y';
	}
	$arFilter = array("IBLOCK_ID" => 35, "!PROPERTY_HARAKTERISTIKI_SAMSUNG_PAY"=>false);
	$queryElementsPays = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementPays = $queryElementsPays->GetNext()) {
		$arrIDs[$resElementPays["ID"]]["SAMSUNG_PAY"] = 'Y';
	}
	//see($arrIDs);
	//die();
	foreach($arrIDs as $elID => $checks){
		$idarrays = array();
		if($checks["GOOGLE_PAY"] == 'Y'){$idarrays[] = 2486;}
		if($checks["APPLE_PAY"] == 'Y'){$idarrays[] = 2485;}
		if($checks["SAMSUNG_PAY"] == 'Y'){$idarrays[] = 2487;}
		//see($idarrays);
		//die();
		//see($elID);
		//die();
		CIBlockElement::SetPropertyValuesEx($elID, 35, array("MOBILE_PAY" => $idarrays));
	}
	echo "Done!";
	//	exit();
}