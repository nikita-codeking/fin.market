<?php
function property_documents_setter()
{
	CModule::IncludeModule("iblock");
	//Справка по форме 2-НДФЛ
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_SPRAVKA_PO_FORME_2_NDFL_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_SPRAVKA_PO_FORME_2_NDFL"] = 'Y';
	}
	//Заявление-анкета
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_ZAYVLENIE_ANKETA_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_ZAYVLENIE_ANKETA"] = 'Y';
	}
	//Паспорт
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_PASPORT_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_PASPORT"] = 'Y';
	}
	//Справка по форме банка
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_SPRAVKA_BANKA_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_SPRAVKA_BANKA"] = 'Y';
	}
	//Пенсионное удостоверение
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_PENSIONNOE_UDOST_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_PENSIONNOE_UDOST"] = 'Y';
	}
	//Копия трудовой книжки
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_KOPIYA_TRUDOVOY_KNIZHKI_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_KOPIYA_TRUDOVOY_KNIZHKI"] = 'Y';
	}
	//СНИЛС
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_SNILS_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_SNILS"] = 'Y';
	}
	//ИНН
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_INN_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_INN"] = 'Y';
	}
	//Военный билет
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_VOENNYY_BILET_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_VOENNYY_BILET"] = 'Y';
	}
	//Договор с образовательным учреждением
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_DOGOVOR_S_OBRAZOVATELNYM_UCHREZHDENIEM_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_DOGOVOR_S_OBRAZOVATELNYM_UCHREZHDENIEM"] = 'Y';
	}
	//Водительское удостоверение
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_VODITELSKOE_UDOSTOVERENIE_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_VODITELSKOE_UDOSTOVERENIE"] = 'Y';
	}
	//Документы на имущество
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_DOKUMENTY_NA_IMUSHCHESTVO_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_DOKUMENTY_NA_IMUSHCHESTVO"] = 'Y';
	}
	//Зарплатная карта Банка
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_ZARPLATNAYA_KARTA_BANKA_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_ZARPLATNAYA_KARTA_BANKA"] = 'Y';
	}
	//Сведения о детях
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_SVEDENIYA_O_DETYAH_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_SVEDENIYA_O_DETYAH"] = 'Y';
	}
	//Диплом об образовании
	$arFilter = Array("IBLOCK_ID" => 35, "PROPERTY_DOKUMENTY_DIPLOM_OB_0BRAZOVANII_VALUE" => 'Да');
	$queryElementsDocs = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array("ID"));
	while($resElementDocs = $queryElementsDocs->GetNext()) {
		$arrIDs[$resElementDocs["ID"]]["DOKUMENTY_DIPLOM_OB_0BRAZOVANII"] = 'Y';
	}
	foreach($arrIDs as $elID => $checks){
		$idarrays = array();
		//Справка по форме 2-НДФЛ
		if($checks["DOKUMENTY_SPRAVKA_PO_FORME_2_NDFL"] == 'Y'){$idarrays[] = 2495;}
		//Заявление-анкета
		if($checks["DOKUMENTY_ZAYVLENIE_ANKETA"] == 'Y'){$idarrays[] = 2496;}
		//Паспорт
		if($checks["DOKUMENTY_PASPORT"] == 'Y'){$idarrays[] = 2497;}
		//Справка по форме банка
		if($checks["DOKUMENTY_SPRAVKA_BANKA"] == 'Y'){$idarrays[] = 2498;}
		//Пенсионное удостоверение
		if($checks["DOKUMENTY_PENSIONNOE_UDOST"] == 'Y'){$idarrays[] = 2500;}
		//Копия трудовой книжки
		if($checks["DOKUMENTY_KOPIYA_TRUDOVOY_KNIZHKI"] == 'Y'){$idarrays[] = 2501;}
		//СНИЛС
		if($checks["DOKUMENTY_SNILS"] == 'Y'){$idarrays[] = 2502;}
		//ИНН
		if($checks["DOKUMENTY_INN"] == 'Y'){$idarrays[] = 2503;}
		//Военный билет
		if($checks["DOKUMENTY_VOENNYY_BILET"] == 'Y'){$idarrays[] = 2504;}
		//Договор с образовательным учреждением
		if($checks["DOKUMENTY_DOGOVOR_S_OBRAZOVATELNYM_UCHREZHDENIEM"] == 'Y'){$idarrays[] = 2505;}
		//Водительское удостоверение
		if($checks["DOKUMENTY_VODITELSKOE_UDOSTOVERENIE"] == 'Y'){$idarrays[] = 2506;}
		//Документы на имущество
		if($checks["DOKUMENTY_DOKUMENTY_NA_IMUSHCHESTVO"] == 'Y'){$idarrays[] = 2507;}
		//Зарплатная карта Банка
		if($checks["DOKUMENTY_ZARPLATNAYA_KARTA_BANKA"] == 'Y'){$idarrays[] = 2508;}
		//Сведения о детях
		if($checks["DOKUMENTY_SVEDENIYA_O_DETYAH"] == 'Y'){$idarrays[] = 2509;}
		//Диплом об образовании
		if($checks["DOKUMENTY_DIPLOM_OB_0BRAZOVANII"] == 'Y'){$idarrays[] = 2510;}
		/*see($arrIDs);
		die();*/
		CIBlockElement::SetPropertyValuesEx($elID, 35, array("ALL_DOCUMENTS" => $idarrays));
	}
	echo "Done!";
}