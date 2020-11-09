<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
$sess = trim($_GET['session']);
$prod = trim($_GET['id']);

CModule::IncludeModule("iblock");

$arFilter = ['IBLOCK_ID' => 40, 'ACTIVE' => 'Y','NAME'=>$sess,'PROPERTY_PRODUCT'=>$prod];
$arSelect = [ 'ID', 'NAME'];
$res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
while($itemRes = $res->Fetch())
{
    CIBlockElement::Delete($itemRes['ID']);
}//while($itemRes = $res->Fetch())
?>
<script>
    document.location.href='/catalog/comparisons/';
</script>

