<?
$arDisplays = array("block", "list", "table");
if(array_key_exists("display", $_REQUEST) || (array_key_exists("display", $_SESSION)) || $arParams["DEFAULT_LIST_TEMPLATE"]){
    if($_REQUEST["display"] && (in_array(trim($_REQUEST["display"]), $arDisplays))){
        $display = trim($_REQUEST["display"]);
        $_SESSION["display"]=trim($_REQUEST["display"]);
    }
    elseif($_SESSION["display"] && (in_array(trim($_SESSION["display"]), $arDisplays))){
        $display = $_SESSION["display"];
    }
    elseif($arSection["DISPLAY"]){
        $display = $arSection["DISPLAY"];
    }
    else{
        $display = $arParams["DEFAULT_LIST_TEMPLATE"];
    }
}
else{
    $display = "block";
}
$template = "catalog_".$display;
?>
<div class="sort_header view_<?=$display?>">

    <?php
    /**
     * получим свойства для сортировки
     */
    if(isset($arSection['ID'])):?>

        <div class="sort_filter mobile_filter_compact">
            <!--noindex-->
            <?
            $arFilter = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y', 'PROPERTY_INCLUDE_MAIN' => $arSection['ID']];
            $arSelect = [ 'ID', 'NAME', 'PROPERTY_CODE_PROP' ,'DATE_ACTIVE_FROM'];
            $resSort = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            $arSort = array();
            while($itemSort = $resSort->Fetch())
            {
                $arSort[] = $itemSort;
            }
            //see($arSort, true);
            if(count($arSort)==0)
            {
                $resSP = CIBlockSection::GetByID($arSection['ID']);
                if($arSP = $resSP->GetNext())
                {
                    $arFilter = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y', 'PROPERTY_INCLUDE_MAIN' => $arSP['IBLOCK_SECTION_ID']];
                    $arSelect = [ 'ID', 'NAME', 'PROPERTY_CODE_PROP' ,'DATE_ACTIVE_FROM'];
                    $resSort = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                    while($itemSort = $resSort->Fetch())
                    {
                        $arSort[] = $itemSort;
                    }
                }
            }
            $sortResult = "";
            if (isset($_GET["sort"])) {
                $sortResult = str_replace('property_','',$_GET["sort"]);
            }//if (isset($_GET["sort"]))

            if(strlen($sortResult)==0 && count($arSort)>0)
            {
                foreach($arSort as $itemSort)
                {
                    if($itemSort['PROPERTY_CODE_PROP_VALUE']=='USLOVIYA_KREDIT_LIMIT')
                    {
                        $_GET["sort"]   = 'property_' . $itemSort['PROPERTY_CODE_PROP_VALUE'];
                        $_GET["method"] = 'desc';

                        $sortResult = str_replace('property_','',$_GET["sort"]);
                    }
                    elseif($itemSort['PROPERTY_CODE_PROP_VALUE'] == 'STAVKA_V_DEN')
                    {
                        $_GET["sort"]   = 'property_' . $itemSort['PROPERTY_CODE_PROP_VALUE'];
                        $_GET["method"] = 'desc';

                        $sortResult = str_replace('property_','',$_GET["sort"]);
                    }
                    elseif($itemSort['PROPERTY_CODE_PROP_VALUE'] == 'USLOVIYA_PERIOD_RASSROCHKI_DLYA_KART_RASSROCHKI')
                    {
                        $_GET["sort"]   = 'property_' . $itemSort['PROPERTY_CODE_PROP_VALUE'];
                        $_GET["method"] = 'desc';

                        $sortResult = str_replace('property_','',$_GET["sort"]);
                    }
                    elseif($itemSort['PROPERTY_CODE_PROP_VALUE'] == 'USLOVIYA_VNESHNIE_PEREVODY_ZA_PLATEZH_')
                    {
                        $_GET["sort"]   = 'property_' . $itemSort['PROPERTY_CODE_PROP_VALUE'];
                        $_GET["method"] = 'desc';

                        $sortResult = str_replace('property_','',$_GET["sort"]);
                    }
                    elseif($itemSort['PROPERTY_CODE_PROP_VALUE'] == 'USLOVIYA_GOD_OBSL')
                    {
                        $_GET["sort"]   = 'property_' . $itemSort['PROPERTY_CODE_PROP_VALUE'];
                        $_GET["method"] = 'desc';

                        $sortResult = str_replace('property_','',$_GET["sort"]);
                    }

                    //if($itemSort['PROPERTY_CODE_PROP_VALUE']=='USLOVIYA_KREDIT_LIMIT')
                }//foreach($arSort as $itemSort)
            }//if(count($arraySortPrintFirst)==0)

            $arraySortPrintFirst = array();
            $arraySortPrintLast  = array();

            foreach($arSort as $itemSort)
            {
                $nameProp = $itemSort['NAME'];
                if ($itemSort["PROPERTY_CODE_PROP_VALUE"] == $sortResult) {
                    if ($_GET["method"] == 'desc') {
                        $arraySortPrintFirst[] = '<a href="' . $arResult["SECTION_PAGE_URL"] . '?sort=property_' . $itemSort["PROPERTY_CODE_PROP_VALUE"] . '&method=asc" class="sort_btn current ' . $_GET["method"] . '" rel="nofollow"><i class="icon" title="' . $nameProp . '"></i><span>' . $nameProp . '</span><i class="arr icons_fa"></i></a>';
                    } else {
                        $arraySortPrintFirst[] = '<a href="' . $arResult["SECTION_PAGE_URL"] . '?sort=property_' . $itemSort["PROPERTY_CODE_PROP_VALUE"] . '&method=desc" class="sort_btn current ' . $_GET["method"] . '" rel="nofollow"><i class="icon" title="' . $nameProp . '"></i><span>' . $nameProp . '</span><i class="arr icons_fa"></i></a>';
                    }
                } else {
                    if ($_GET["method"] == 'desc') {
                        $arraySortPrintLast[] = '<a href="' . $arResult["SECTION_PAGE_URL"] . '?sort=property_' . $itemSort["PROPERTY_CODE_PROP_VALUE"] . '&method=asc" class="sort_btn desc" rel="nofollow"><i class="icon" title="' . $nameProp . '"></i><span>' . $nameProp . '</span><i class="arr icons_fa"></i></a>';
                    } else {
                        $arraySortPrintLast[] = '<a href="' . $arResult["SECTION_PAGE_URL"] . '?sort=property_' . $itemSort["PROPERTY_CODE_PROP_VALUE"] . '&method=desc" class="sort_btn desc" rel="nofollow"><i class="icon" title="' . $nameProp . '"></i><span>' . $nameProp . '</span><i class="arr icons_fa"></i></a>';
                    }
                }
            }//foreach($arSort as $itemSort)

            foreach ($arraySortPrintFirst as $item)
            {
                echo $item;
            }//foreach ($arraySortPrintFirst as $item)

            foreach ($arraySortPrintLast as $item)
            {
                echo $item;
            }//foreach ($arraySortPrintFirst as $item)


            ?>
            <!--/noindex-->
        </div>
    <?
    endif;
    ?>
    <div class="sort_display">

        <?foreach($arDisplays as $displayType):?>
            <?
            $current_url = '';
            $current_url = $APPLICATION->GetCurPageParam('display='.$displayType, 	array('display'));
            $url = str_replace('+', '%2B', $current_url);
            ?>
            <a rel="nofollow" href="<?=$url;?>" class="sort_btn <?=$displayType?> <?=($display == $displayType ? 'current' : '')?>"><i title="<?=GetMessage("SECT_DISPLAY_".strtoupper($displayType))?>"></i></a>
        <?endforeach;?>
    </div>
    <div class="clearfix"></div>
    <!--/noindex-->
</div>