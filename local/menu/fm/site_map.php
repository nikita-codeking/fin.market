<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');
IncludeModuleLangFile(__FILE__);
$root = $_SERVER['DOCUMENT_ROOT'];

?><div class="siteMapMainBlock" style="font-size: 16px; line-height: 31px;"><?php
$dir = opendir($root); // Открываем дирректорию.
while($file = readdir($dir)) { // Считываем содержимое дирректории и записываем в массив
    //условия на вывод только публичных разделов
    if (is_dir($root.'/'.$file) && $file != '.' && $file != '..') {
        if ($file != 'bitrix' && $file != 'local' && $file != 'ajax' && $file != 'aspro_regions' && $file != 'cgi-bin' && $file != 'images' && $file != 'old_questionnaire' && $file != 'upload' && $file != '1111_files' && $file != 'include') {
            //echo $file."\n";
            $innerFile = $root.'/'.$file.'/index.php'; // помещаем пути в массив
            $lines = file($innerFile);
            ?>
            <details>
                <summary>
                    <?
                    foreach ($lines as $line_num => $line) { // код открытх файлов разбиваем и записываем в $line

                        $re = '/(?<=SetTitle\(").*(?="\))/su'; // регулярное выражение, извлекаем содержимое функции SetTitle каждого файла
                        $str = $line;
                        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
                        echo($matches[0][0]); // выводим значение SetTitle
                    }
                    ?> -- <a href="/<?=$file?>/"><?=$file?></a>
                    <?php // визуальная составляющая
                    $outSEO = "";
                    foreach ($lines as $line_num => $line) {
                        $setPagePropertyRe = '/(?<=SetPageProperty\(").*(?="\))/su'; //регулярное выражение, извлекаем содержимое функции SetPageProperty каждого файла
                        $setPagePropertyStr = $line;
                        preg_match_all($setPagePropertyRe, $setPagePropertyStr, $setPagePropertyMatches, PREG_SET_ORDER, 0);
                        if(strlen($setPagePropertyMatches[0][0])>1)
                        {
                            if(strlen($outSEO)>0)
                            {
                                $outSEO = $outSEO . "|" . $setPagePropertyMatches[0][0]; //// выводим значение SetPageProperty
                            }
                            else
                            {
                                $outSEO = $setPagePropertyMatches[0][0]; //// выводим значение SetPageProperty
                            }
                        }

                    }
                    if(strlen($outSEO)>0)
                    {
                        $outSEO = str_replace('"','',$outSEO);
                        $outSEO = str_replace(",","=",$outSEO);
                        $outSEO = str_replace(" ","",$outSEO);
                        echo 'SEO: ' . $outSEO;
                    }
                    ?>
                </summary>
                <?php

                if($file == 'catalog'){
                    $arrTreeCatalog = array();
                    $IBLOCK_ID = 35;
                    $arFilter = Array(
                        'IBLOCK_ID' => $IBLOCK_ID,
                        'ACTIVE' => 'Y');
                    $obSection = CIBlockSection::GetTreeList($arFilter);
                    $parent_section = 0;
                    while ($arResult = $obSection->GetNext()) {
                        if($arResult['DEPTH_LEVEL']==1)
                        {
                            $arrTreeCatalog[$arResult['ID']] = array('NAME'=>$arResult['NAME'],'URL'=>$arResult['SECTION_PAGE_URL']);
                            $parent_section = $arResult['ID'];
                        }
                        elseif($arResult['DEPTH_LEVEL']==2)
                        {
                            $arrTreeCatalog[$arResult['IBLOCK_SECTION_ID']]['ITEMS'][$arResult['ID']] = array('NAME'=>$arResult['NAME'],'URL'=>$arResult['SECTION_PAGE_URL']);
                        }elseif($arResult['DEPTH_LEVEL']==3)
                        {
                            $arrTreeCatalog[$parent_section]['ITEMS'][$arResult['IBLOCK_SECTION_ID']]['ITEMS'][$arResult['ID']] = array('NAME'=>$arResult['NAME'],'URL'=>$arResult['SECTION_PAGE_URL']);
                        }
                    }
                    if(count($arrTreeCatalog)>0)
                    {
                        foreach ($arrTreeCatalog as $sectionItem)
                        {
                            ?>
                            <details>
                                <summary style="margin-left: 20px;">
                                    <p class="siteMapSecondLevelDir" style="padding-left:20px;padding-bottom: 10px;margin-top: -30px;">
                                        <?=$sectionItem['NAME']?> -- <a style="color: red;" href="<?=$sectionItem['URL']?>"><?=$sectionItem['URL']?></a></p>
                                </summary>
                                <?
                                //2 уровени
                                if($sectionItem['ITEMS']):
                                    foreach ($sectionItem['ITEMS'] as $keyS=>$elItem)
                                    {
                                        ?>
                                        <p class="siteMapThirdLevelDir" style="margin-left:60px;padding-top: 10px;margin-top: -30px;"> --section-- <?=$elItem['NAME']?> -- <a style="color: green;" href="<?=$elItem['URL']?>"><?=$elItem['URL']?></a></p>
                                        <?
                                        $arFilter = ['IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y','IBLOCK_SECTION_ID'=>$keyS];
                                        $arSelect = [ 'ID', 'NAME', 'CODE'];
                                        $resProduct = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                                        while($itemResProduct = $resProduct->Fetch())
                                        {
                                            ?>
                                            <p class="siteMapThirdLevelDir" style="margin-left:60px;padding-top: 10px;margin-top: -30px;"> ----element-- <?=$itemResProduct['NAME']?> -- <a style="color: green;" href="<?=$elItem['URL']?><?=$itemResProduct['CODE']?>"><?=$elItem['URL']?><?=$itemResProduct['CODE']?></a></p>
                                            <?
                                        }

                                        //3 уровень
                                        if($elItem['ITEMS']):
                                            foreach ($elItem['ITEMS'] as $keyS2=>$thirdItem)
                                            {
                                                ?>
                                                <p class="siteMapThirdLevelDir" style="margin-left:60px;padding-top: 10px;margin-top: -30px;"> ----section-- <?=$thirdItem['NAME']?> -- <a style="color: green;" href="<?=$thirdItem['URL']?>"><?=$thirdItem['URL']?></a></p>
                                                <?
                                                $arFilter = ['IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y','IBLOCK_SECTION_ID'=>$keyS];
                                                $arSelect = [ 'ID', 'NAME', 'CODE'];
                                                $resProduct = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                                                while($itemResProduct = $resProduct->Fetch())
                                                {
                                                    ?>
                                                    <p class="siteMapThirdLevelDir" style="margin-left:60px;padding-top: 10px;margin-top: -30px;"> ------element-- <?=$itemResProduct['NAME']?> -- <a style="color: green;" href="<?=$elItem['URL']?><?=$itemResProduct['CODE']?>"><?=$elItem['URL']?><?=$itemResProduct['CODE']?></a></p>
                                                    <?
                                                }
                                            }
                                        endif;
                                    }
                                endif;
                                ?>
                            </details>
                            <?
                        }
                    }

                }
                if($file == 'articles')
                {
                    $arrTreeCatalog = array();
                    $IBLOCK_ID = 18;
                    $arFilter = Array(
                        'IBLOCK_ID' => $IBLOCK_ID,
                        'ACTIVE' => 'Y');
                    $obSection = CIBlockSection::GetTreeList($arFilter);
                    $parent_section = 0;
                    while ($arResult = $obSection->GetNext()) {
                        if($arResult['DEPTH_LEVEL']==1)
                        {
                            $arrTreeCatalog[$arResult['ID']] = array('NAME'=>$arResult['NAME'],'URL'=>$arResult['SECTION_PAGE_URL']);
                            $parent_section = $arResult['ID'];
                        }
                        elseif($arResult['DEPTH_LEVEL']==2)
                        {
                            $arrTreeCatalog[$arResult['IBLOCK_SECTION_ID']]['ITEMS'][$arResult['ID']] = array('NAME'=>$arResult['NAME'],'URL'=>$arResult['SECTION_PAGE_URL']);
                        }elseif($arResult['DEPTH_LEVEL']==3)
                        {
                            $arrTreeCatalog[$parent_section]['ITEMS'][$arResult['IBLOCK_SECTION_ID']]['ITEMS'][$arResult['ID']] = array('NAME'=>$arResult['NAME'],'URL'=>$arResult['SECTION_PAGE_URL']);
                        }
                    }
                    if(count($arrTreeCatalog)>0)
                    {
                        foreach ($arrTreeCatalog as $keyS=>$sectionItem)
                        {
                            ?>
                            <details>
                                <summary style="margin-left: 20px;">
                                    <p class="siteMapSecondLevelDir" style="padding-left:20px;padding-bottom: 10px;margin-top: -30px;">
                                        <?=$sectionItem['NAME']?> -- <a style="color: red;" href="<?=$sectionItem['URL']?>"><?=$sectionItem['URL']?></a></p>
                                </summary>
                                <?
                                $arFilter = ['IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y','IBLOCK_SECTION_ID'=>$keyS];
                                $arSelect = [ 'ID', 'NAME', 'CODE'];
                                $resProduct = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                                while($itemResProduct = $resProduct->Fetch())
                                {
                                    ?>
                                    <p class="siteMapThirdLevelDir" style="margin-left:60px;padding-top: 10px;margin-top: -30px;"> --element-- <?=$itemResProduct['NAME']?> -- <a style="color: green;" href="<?=$sectionItem['URL']?><?=$itemResProduct['CODE']?>"><?=$sectionItem['URL']?><?=$itemResProduct['CODE']?></a></p>
                                    <?
                                }
                                ?>
                            </details>
                            <?
                        }
                    }
                }

                $childInnerDir = opendir($root.'/'.$file.'/');
                while($childFile= readdir($childInnerDir)){
                    if (is_dir($root.'/'.$file.'/'.$childFile)&& $childFile != '.' && $childFile != '..'){
                        $innerChildFile = $root.'/'.$file.'/'.$childFile.'/index.php';
                        $innerLines = file($innerChildFile);
                        ?>
                        <details>
                            <summary style="margin-left: 20px;">
                                <p class="siteMapSecondLevelDir" style="padding-left:20px;padding-bottom: 10px;margin-top: -30px;">
                                    <?
                                    foreach ($innerLines as $innerLine_num => $innerLine) { // разбиваем код открытых файлов
                                        $innerRe = '/(?<=SetTitle\(").*(?="\))/su'; // регулярное выражение, извлекаем содержимое функции SetTitle каждого файла
                                        $innerStr = $innerLine;
                                        preg_match_all($innerRe, $innerStr, $innerMatches, PREG_SET_ORDER, 0);
                                        $innerMatches = $innerMatches[0][0];

                                        ?><?echo($innerMatches);
                                        // выводим значение SetTitle
                                    }
                                    ?> -- <a  style="color: red;" href="/<?=$file.'/'.$childFile?>/"><?=$childFile?></a></p>
                            </summary>
                            <?php

                            if($childFile == 'offers'){
                                $arrTreeCatalog = array();
                                $arFilter = ['IBLOCK_ID' => 32, 'ACTIVE' => 'Y'];
                                $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
                                $resProduct = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
                                while($itemResProduct = $resProduct->Fetch())
                                {
                                    $arrTreeCatalog[$itemResProduct['ID']] = array('NAME'=>$itemResProduct['NAME'],'URL'=>'/catalog/offers/?page='.$itemResProduct['ID']);
                                }
                                if(count($arrTreeCatalog)>0)
                                {
                                    foreach ($arrTreeCatalog as $sectionItem)
                                    {
                                        ?>
                                        <p class="siteMapThirdLevelDir" style="margin-left:60px;padding-top: 10px;margin-top: -30px;"> --element-- <?=$sectionItem['NAME']?> -- <a style="color: green;" href="<?=$sectionItem['URL']?>"><?=$sectionItem['URL']?></a></p>
                                        <?
                                    }
                                }

                            }

                            $childInnerSecondDir = opendir($root.'/'.$file.'/'.$childFile.'/');
                            while($childSecondFile= readdir($childInnerSecondDir)){
                                if (is_dir($root.'/'.$file.'/'.$childFile.'/'.$childSecondFile)&& $childSecondFile != '.' && $childSecondFile != '..'){

                                    $innerSecondChildFile = $root.'/'.$file.'/'.$childFile.'/'.$childSecondFile.'/index.php';
                                    $innerSecondLines = file($innerSecondChildFile);
                                    echo '<p  class="siteMapThirdLevelDir" style="margin-left:60px;padding-top: 10px;margin-top: -30px;">';
                                    foreach ($innerSecondLines as $innerSecondLine_num => $innerSecondLine) { // разбиваем код открытых файлов
                                        $innerSecondRe = '/(?<=SetTitle\(").*(?="\))/su'; // регулярное выражение, извлекаем содержимое функции SetTitle каждого файла
                                        $innersecondStr = $innerSecondLine;
                                        preg_match_all($innerSecondRe, $innersecondStr, $innerSecondMatches, PREG_SET_ORDER, 0);
                                        $innerSecondMatches = $innerSecondMatches[0][0];
                                        ?>
                                        <?echo($innerSecondMatches);
                                        // выводим значение SetTitle
                                    }
                                }
                            }
                            ?>
                        </details>
                        <?
                    }
                }
                ?>
            </details>
            <?php
        }
    }
}
?></div><?
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");
?>