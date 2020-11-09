<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
if(isset($_POST['session'])):
    $sess = trim($_POST['session']);
    $arSelect = Array("ID");
    $arFilter = Array('IBLOCK_ID'=>40,'NAME' => $sess);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    $i = 0;
    while($itemResR = $res->Fetch()){
        $i++;
    }
    echo $i;
endif;