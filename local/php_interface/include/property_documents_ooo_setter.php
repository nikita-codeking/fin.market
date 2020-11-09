<?php
function property_documents_ooo_setter()
{
	CModule::IncludeModule("iblock");
	$arFilter = Array("IBLOCK_ID" => 35, "!PROPERTY_DOKUMENTY_OOO" => false);
	$fieldsProp = Array();
	$queryElementsDocsIp = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, Array());
	while ($queryElementsDocsIpRes = $queryElementsDocsIp->GetNextElement()) {
		$docsFields = $queryElementsDocsIpRes->GetFields();
		$prop = $queryElementsDocsIpRes->GetProperties();
		//see($prop);
		//die()$docsFields["NAME"];
		$fieldsProp[$docsFields["NAME"]] = $prop['DOKUMENTY_OOO']["VALUE"];
	}
	//$fieldsProp = array_unique($fieldsProp);
	echo "COUNT: " . count($fieldsProp);
	see($fieldsProp);
	/*$allprops = array();
	foreach($fieldsProp as $pfields){
		$arrfileds = explode(PHP_EOL, $pfields);
		foreach($arrfileds as $field){
			if(!empty($field)){
				$allprops[] = trim($field);
			}
		}
	}
	$allprops = array_unique($allprops);
	see($allprops);*/
}
