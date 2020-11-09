<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');
IncludeModuleLangFile(__FILE__);
?>

<?if(isset($_POST['load_geo'])):?>
    <?php
    $idProduct               = $_POST['product'];
    $cityString              = array();
    $cityStringExcept        = array();
    $cityStringSection       = array();
    $cityStringSectionExcept = array();
    /**
     * читаем города/регионы загрузки
     */
    $cityTemp = explode(PHP_EOL, $_POST['citys']);
    foreach ($cityTemp as $item)
    {
        $cityString[] = trim($item);
    }
    /**
     * читаем города/регионы исключения
     */
    $cityTempExcept = explode(PHP_EOL, $_POST['citysExcept']);
    foreach ($cityTempExcept as $item)
    {
        $cityStringExcept[] = trim($item);
    }
    /**
     * приставки исключения
     */
    $loadRegion = false;
    if(isset($_POST['region']))
    {
        if($_POST['region']=='true')
        {
            $loadRegion = true;
        }//if($_POST['region']=='true')
    }//if(isset($_POST['region']))
    /**
     * обработчик получения регионов
     */
    if($loadRegion==true)
    {
        $exceptionRegionPR = array();
        $exceptionRegionPR[] = "республика";
        $exceptionRegionPR[] = "область";
        $exceptionRegionPR[] = "край";
        $exceptionRegionPR[] = "автономный округ";

        if(count($cityString)>0)
        {
            //обычный список
            foreach ($cityString as &$item)
            {
                foreach ($exceptionRegionPR as $pr)
                {
                    $newRegion = str_replace($pr, '', strtolower($item));
                    if(strlen($newRegion)!=strlen(strtolower($item)))
                    {
                        $cityStringSection[] = array('NAME_LOAD'=>trim($newRegion));
                    }//if(strlen($newRegion)!=strlen(strtolower($item)))
                }//foreach ($exceptionRegionPR as $pr)
            }//foreach ($cityString as &$item)
            if(count($cityStringSection)>0)
            {
                /**
                 * получим все регионы
                 */
                $arFilterSections = array('IBLOCK_ID' => 2, 'ACTIVE'=>'Y','>DEPTH_LEVEL'=>2);
                $rsSections = CIBlockSection::GetList(array('ID' => 'ASC'), $arFilter,false,array('ID','NAME'));
                while ($arSection = $rsSections->Fetch())
                {
                    foreach ($cityStringSection as &$item)
                    {
                        $pos = strpos(strtolower($arSection['NAME']), $item['NAME_LOAD']);
                        if($pos>0)
                        {
                            $item['NAME_SECTION'] = $arSection['NAME'];
                            $item['ID_SECTION']   = $arSection['ID'];
                            break;
                        }//if($pos>0)
                    }//foreach ($cityStringSection as &$item)
                }
            }//if(count($cityStringSection)>0)
        }//if(count($cityString)>0)
        if(count($cityStringExcept)>0)
        {
            //исключения
            foreach ($cityStringExcept as &$item)
            {
                foreach ($exceptionRegionPR as $pr)
                {
                    $newRegion = str_replace($pr, '', strtolower($item));
                    if(strlen($newRegion)!=strlen(strtolower($item)))
                    {
                        $cityStringSectionExcept[] = array('NAME_LOAD'=>trim($newRegion));
                    }//if(strlen($newRegion)!=strlen(strtolower($item)))
                }//foreach ($exceptionRegionPR as $pr)
            }//foreach ($cityStringExcept as &$item)
            if(count($cityStringSectionExcept)>0)
            {
                /**
                 * получим все регионы
                 */
                $arFilterSections = array('IBLOCK_ID' => 2, 'ACTIVE'=>'Y','>DEPTH_LEVEL'=>2);
                $rsSections = CIBlockSection::GetList(array('ID' => 'ASC'), $arFilter,false,array('ID','NAME'));
                while ($arSection = $rsSections->Fetch())
                {
                    foreach ($cityStringSectionExcept as &$item)
                    {
                        $pos = strpos(strtolower($arSection['NAME']), $item['NAME_LOAD']);
                        if($pos>0)
                        {
                            $item['NAME_SECTION'] = $arSection['NAME'];
                            $item['ID_SECTION']   = $arSection['ID'];
                            break;
                        }//if($pos>0)
                    }//foreach ($cityStringSectionExcept as &$item)
                }//while ($arSection = $rsSections->Fetch())
            }//if(count($cityStringSectionExcept)>0)
        }//if(count($cityStringExcept)>0)
    }//if($loadRegion==true)
    /**
     * загружаем в свойство
     */
    if($loadRegion==true)
    {
        $cityStringSectionCity = array();
        if(count($cityStringSection)>0 || count($cityString)==1 && $cityString[0]=="РФ")
        {
            /**
             * соберем массив исключений
             */
            $excepSec = array();
            foreach ($cityStringSectionExcept as $item)
            {
                if(isset($item['ID_SECTION']))
                {
                    $excepSec[] = $item['ID_SECTION'];
                }//if(isset($item['ID_SECTION']))
            }//foreach ($cityStringSectionExcept as $item)
            /**
             * присвоим значения
             */
            $mainSec = array();
            foreach ($cityStringSection as $item)
            {
                if(isset($item['ID_SECTION']))
                {
                    $mainSec[] = $item['ID_SECTION'];
                }//if(isset($item['ID_SECTION']))
            }//foreach ($cityStringSectionExcept as $item)
            if(count($cityString)==1 && $cityString[0]=="РФ")
            {
                $arFilter = ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y','!IBLOCK_SECTION_ID'=>$excepSec];
            }
            else
            {
                $arFilter = ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y', 'IBLOCK_SECTION_ID' => $mainSec, '!IBLOCK_SECTION_ID'=>$excepSec];
            }
            $arSelect = [ 'ID', 'NAME'];
            $resRegions = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRegion = $resRegions->Fetch())
            {
                $cityStringSectionCity[] = $itemRegion["ID"];
            }// while($itemRegion = $resRegions->Fetch())
        }//if(count($cityStringSection)>0)
        if(count($cityStringSectionCity)>0)
        {
            foreach ($idProduct as $prod)
            {
                if($prod>0)
                {
                    CIBlockElement::SetPropertyValueCode($prod, "LINK_REGION", $cityStringSectionCity);
                }//if($prod>0)
            }//foreach ($idProduct as $prod)

        }//if(count($cityStringSectionCity)>0)
    }
    else
    {
        if(count($cityString)>0)
        {
            $citySpr = array();
            if (count($cityString)==1 && $cityString[0]=="РФ")
            {
                $arFilter = ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y', '!NAME' => $cityStringExcept];
            }
            else
            {
                $arFilter = ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y', 'NAME' => $cityString, '!NAME' => $cityStringExcept];
            }
            $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
            $resRegions = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($itemRegion = $resRegions->Fetch()) {
                $citySpr[] = $itemRegion["ID"];
            }

            if(count($citySpr)>0)
            {
                foreach ($idProduct as $prod)
                {
                    if ($prod > 0)
                    {
                        CIBlockElement::SetPropertyValueCode($prod, "LINK_REGION", $citySpr);
                    }//if ($prod > 0)
                }//foreach ($idProduct as $prod)
            }
        }//if(count($cityString)>0)
    }//if($loadRegion==true)

    ?>
    <h2>Данные обновлены</h2>
<?endif;?>
    <form id="upload_geo" name="upload_geo" method="post">
        </br>
        </br>
        <input name="product[n0]" id="product[n0]" type="number" placeholder="ID товара 1">
        <input type="button" value="..." onclick="jsUtils.OpenWindow('/bitrix/admin/iblock_element_search.php?lang=ru&amp;IBLOCK_ID=35&amp;n=product&amp;k=n0&amp;iblockfix=y&amp;tableId=iblockprop-E-1255-38', 900, 700);">
        </br>
        </br>
        <input name="product[n1]" id="product[n1]" type="number" placeholder="ID товара 2">
        <input type="button" value="..." onclick="jsUtils.OpenWindow('/bitrix/admin/iblock_element_search.php?lang=ru&amp;IBLOCK_ID=35&amp;n=product&amp;k=n1&amp;iblockfix=y&amp;tableId=iblockprop-E-1255-38', 900, 700);">
        </br>
        </br>
        <input name="product[n2]" id="product[n2]" type="number" placeholder="ID товара 3">
        <input type="button" value="..." onclick="jsUtils.OpenWindow('/bitrix/admin/iblock_element_search.php?lang=ru&amp;IBLOCK_ID=35&amp;n=product&amp;k=n2&amp;iblockfix=y&amp;tableId=iblockprop-E-1255-38', 900, 700);">
        </br>
        </br>
        <input name="product[n3]" id="product[n3]" type="number" placeholder="ID товара 4">
        <input type="button" value="..." onclick="jsUtils.OpenWindow('/bitrix/admin/iblock_element_search.php?lang=ru&amp;IBLOCK_ID=35&amp;n=product&amp;k=n3&amp;iblockfix=y&amp;tableId=iblockprop-E-1255-38', 900, 700);">
        </br>
        </br>
        <input name="product[n4]" id="product[n4]" type="number" placeholder="ID товара 5">
        <input type="button" value="..." onclick="jsUtils.OpenWindow('/bitrix/admin/iblock_element_search.php?lang=ru&amp;IBLOCK_ID=35&amp;n=product&amp;k=n4&amp;iblockfix=y&amp;tableId=iblockprop-E-1255-38', 900, 700);">
        </br>
        </br>
        <input type="checkbox" name="region" value="true">Это регионы</p>
        </br>
        <textarea name="citys" placeholder="Города - по 1 в строке(Либо РФ)" rows="50" cols="50"></textarea>
        <textarea name="citysExcept" placeholder="Города - Исключения" rows="50" cols="50"></textarea>
        </br>
        </br>
        <input type="submit" name="load_geo" value="Обновить данные">
        </br>
        </br>
    </form>

<?
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");
?>