<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
$resuldIDProduct = "";

$sessionId = session_id();
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM",'PROPERTY_PRODUCT');
$arFilter = Array("IBLOCK_ID"=>40, 'NAME' => session_id(), "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
$productID = array();
while($itemRes = $res->Fetch())
{
    $productID[] = $itemRes['PROPERTY_PRODUCT_VALUE'];
}
if(count($productID)>0)
{
    $arSelectP = Array("ID", "NAME", "DATE_ACTIVE_FROM",'PROPERTY_' . $_POST['code']);
    $arFilterP = Array("IBLOCK_ID"=>35, "ID" => $productID, "ACTIVE"=>"Y");
    $arProducts = CIBlockElement::GetList(Array('PROPERTY_' . $_POST['code'] => $_POST['sort']), $arFilterP, false, Array(), $arSelectP);
    while($elProduct = $arProducts->Fetch())
    {
        if(strlen($resuldIDProduct)==0)
        {
            $resuldIDProduct = $elProduct['ID'];
        }
        else
        {
            $resuldIDProduct = $resuldIDProduct . '|' . $elProduct['ID'];
        }
    }
}
echo $resuldIDProduct;