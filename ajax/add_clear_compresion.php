<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
$sess = trim($_POST['session']);
$prod = trim($_POST['id']);

CModule::IncludeModule("iblock");
//echo 'section - ' .  $prod . '</br>';

$arSelect1 = Array('ID', 'NAME');
$arFilter1 = Array("IBLOCK_ID" => 35, "ACTIVE" => "Y", "IBLOCK_SECTION_ID" => $prod);
$res1 = CIBlockElement::GetList(Array(), $arFilter1, false, Array(), $arSelect1);
while ($ob1 = $res1->Fetch()) {
    //echo $ob1['ID'] . '</br>';
    $rsItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 40, 'NAME' => $sess, "PROPERTY_PRODUCT" => $ob1['ID'])
        , false, false, array('ID'));
    if (!$rsItems->GetNext()) {
        $el = new CIBlockElement;
        $PROP = array();
        $PROP[1937] = $ob1['ID'];
        $arLoadProductArray = Array(
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => 40,
            "PROPERTY_VALUES" => $PROP,
            "GROUPS" => Array("1", "2", "3", "4", "5", "6", "7", "8"),
            "NAME" => $sess,
            "ACTIVE" => "Y"
        );
        $el->Add($arLoadProductArray);
    }
}

