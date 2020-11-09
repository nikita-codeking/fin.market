<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
$sess = trim($_POST['session']);
$prod = trim($_POST['id']);

CModule::IncludeModule("iblock");

$rsItems = CIBlockElement::GetList(array(),array('IBLOCK_ID' => 40, 'NAME' => $sess,"PROPERTY_PRODUCT"=>$prod)
,false,false,array('ID'));
if(!$rsItems->GetNext()){
	$el = new CIBlockElement;
	$PROP = array();
	$PROP[1937] = $prod;
	$arLoadProductArray = Array(
		"IBLOCK_SECTION_ID" => false,
		"IBLOCK_ID"      => 40,
		"PROPERTY_VALUES"=> $PROP,
		"NAME"           => $sess,
		"GROUPS" => Array("1", "2", "3", "4", "5", "6", "7", "8"),
		"ACTIVE"         => "Y"
	);
	$el->Add($arLoadProductArray);
}?>

