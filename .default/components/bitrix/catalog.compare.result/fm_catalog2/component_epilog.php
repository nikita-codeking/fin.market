<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
global $APPLICATION;

?>

<?if ($_GET['TYPE'] == 'SORT' and isset($_GET['PROP'])):?>

    <?php
        $namePropAtr = "PROPERTIES";
        $pos1 = strripos($_GET['PROP'], "USLOVIYA_");
        $pos2 = strripos($_GET['PROP'], "TREBOVANIYA_");
        $arSort20 = Array();
        $arSort17 = Array();
        if($pos1 === false && $pos2 === false){
            $namePropAtr = "PROPERTIES";
            $arSort17 = Array('PROPERTY_' . $_GET['PROP'] => "ASC");
        }else{
            $namePropAtr = "OFFER_PROPERTIES";
            $arSort20 = Array('PROPERTY_' . $_GET['PROP'] => "ASC");
        }
        $_SESSION['SORT_COMPARE'] = $_GET['PROP'];

        $newArResults = Array();

        if(count($arResult)>0) {
            $idEl = Array();
            foreach ($_SESSION[$arParams["NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"] as $code=>$item) {
                $idEl[] = $code;
            }
            $idArray = Array();
            $sopArray = Array();

            $resSec2 = Array();
            $arFilter = Array("IBLOCK_ID" => 20, "ID" => $idEl, "ACTIVE" => "Y");
            $arSelect = Array("ID", "PROPERTY_CML2_LINK");
            $res = CIBlockElement::GetList($arSort20, $arFilter, false, false, $arSelect);
            while ($ar_fields = $res->GetNext()) {
                //$idArray[] = $ar_fields["ID"];
                $idArray[] = $ar_fields['PROPERTY_CML2_LINK_VALUE'];
                $sopArray[$ar_fields['PROPERTY_CML2_LINK_VALUE']] = $ar_fields["ID"];
                $resSec2[] = $ar_fields;
            }

            if(count($arSort17)>0){
                $resSec = Array();
                $arFilter = Array("IBLOCK_ID" => 17, "ID" => $idArray, "ACTIVE" => "Y");
                $arSelect = Array("ID", "IBLOCK_SECTION_ID",'PROPERTY_' . $_GET['PROP']);
                $res = CIBlockElement::GetList($arSort17, $arFilter, false, false, $arSelect);
                while ($ar_fields = $res->GetNext()) {
                    $resSec[] = $ar_fields;
                }
            }


            if($pos1 === false && $pos2 === false){
                foreach ($resSec as $itemRS1){
                    $newArResults[] = $sopArray[$itemRS1["ID"]];
                }
            }else{
                foreach ($resSec2 as $itemRS2){
                    $newArResults[] = $itemRS2["ID"];
                }
            }
            $_SESSION["ASORT"] = $newArResults;

        }
        $APPLICATION->RestartBuffer();
        echo json_encode($newArResults);
        die();
    ?>
<?endif;?>

<?

$secName = '';
$arResult = $_SESSION["CATALOG_COMPARE_LIST"][17]["ITEMS"];
$id_sec = 0;
if(!isset($_GET['section_id'])){
    if((!isset($_SESSION["CATALOG_COMPARE_LIST"][17]["ITEMS"]) or count($_SESSION["CATALOG_COMPARE_LIST"][17]["ITEMS"] == 0)) and isset($_SESSION["BACKUP_CATALOG_COMPARE_LIST"])){
        $_SESSION["CATALOG_COMPARE_LIST"][17]["ITEMS"] = $_SESSION["BACKUP_CATALOG_COMPARE_LIST"];
    }

    if(count($arResult)>0) {
        $idEl = 0;
        foreach ($arResult as $item) {
            $idEl = $item['ID'];
            break;
        }
        $idArray = Array();
        $arFilter = Array("IBLOCK_ID" => 20, "ID" => $idEl, "ACTIVE" => "Y");
        $arSelect = Array("ID", "PROPERTY_CML2_LINK");

        $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, $arSelect);
        while ($ar_fields = $res->GetNext()) {
            //$idArray[] = $ar_fields["ID"];
            $idArray[] = $ar_fields['PROPERTY_CML2_LINK_VALUE'];
        }

        $idSections = Array();
        $resSec = Array();
        $arFilter = Array("IBLOCK_ID" => 17, "ID" => $idArray, "ACTIVE" => "Y");
        $arSelect = Array("ID", "IBLOCK_SECTION_ID");
        $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, $arSelect);
        while ($ar_fields = $res->GetNext()) {
            $idSections[] = $ar_fields["IBLOCK_SECTION_ID"];
            $resSec = CIBlockSection::GetByID($ar_fields["IBLOCK_SECTION_ID"]);
            $id_sec = (int)$ar_fields["IBLOCK_SECTION_ID"];

            if ($ar_res = $resSec->GetNext())

                $secName = $ar_res['NAME'];

        }

    }
}else{
    $idSectionsOld = 0;
    if(count($arResult)>0) {
        $idEl = 0;
        foreach ($arResult as $item) {
            $idEl = $item['ID'];
            break;
        }
        $idArray = Array();
        $arFilter = Array("IBLOCK_ID" => 20, "ID" => $idEl, "ACTIVE" => "Y");
        $arSelect = Array("ID", "PROPERTY_CML2_LINK");

        $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, $arSelect);
        while ($ar_fields = $res->GetNext()) {
            $idArray[] = $ar_fields["ID"];
            $idArray[] = $ar_fields['PROPERTY_CML2_LINK_VALUE'];
        }

        $resSec = Array();
        $arFilter = Array("IBLOCK_ID" => 17, "ID" => $idArray, "ACTIVE" => "Y");
        $arSelect = Array("ID", "IBLOCK_SECTION_ID");
        $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, $arSelect);
        while ($ar_fields = $res->GetNext()) {
            $idSectionsOld= $ar_fields["IBLOCK_SECTION_ID"];
            break ;
        }
    }
    if($idSectionsOld>0){
        if((int)$idSectionsOld<>(int)$_GET['section_id']){
            $_SESSION["BACKUP_CATALOG_COMPARE_LIST"] = $_SESSION["CATALOG_COMPARE_LIST"][17]["ITEMS"];
            unset($_SESSION["CATALOG_COMPARE_LIST"][17]["ITEMS"]);
            $arResult = Array();
            echo '<script>alert("Товары в сравнении и выбранный раздел не совпадают. Список сравнения будет очищен!"); document.location.reload(true);</script>';
        }
    }
    $resSec = CIBlockSection::GetByID($_GET['section_id']);
    if ($ar_res = $resSec->GetNext())
        $secName = $ar_res['NAME'];

    $id_sec = (int)$_GET['section_id'];
}
if(strlen($secName)>0){ //secname - полное словосочетание
    $responce = file_get_contents('http://morphos.io/api/inflect-geographical-name?name=' . $secName . '&_format=json', false);
    $responce = json_decode($responce, true);
    $secNameDat = $responce['cases']['2'];

    $explodeArr = explode(' ', $secNameDat);
    if(count($explodeArr)>1) {
        $explodeArr[1] = mb_strtolower($explodeArr[1], 'UTF-8');
        $secNameDat = implode(" ", $explodeArr);
    }

    $APPLICATION->SetTitle("Сравнение предложений по " . $secNameDat);
}
?>

<div class="seo_compare">
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "front",
        array(
            "AREA_FILE_SHOW" => "file",
            "AREA_FILE_SUFFIX" => "compr",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "EDIT_TEMPLATE" => "include_area.php",
            "PATH" => "/include/fm/compare/".$id_sec.".php",
            "COMPONENT_TEMPLATE" => "front",
            "AREA_FILE_RECURSIVE" => "Y"
        ),
        false
    );?>
</div>

