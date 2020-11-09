<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');
IncludeModuleLangFile(__FILE__);
?>
<form id="upload_seo" name="upload_seo" method="post">
    </br>
    </br>
    <label>Что копируем:</label></br>
    <input name="product[n0]" id="product[n0]" type="number" placeholder="Выберите раздел">
    <input type="button" value="..." onclick="jsUtils.OpenWindow('/bitrix/admin/iblock_element_search.php?lang=ru&amp;IBLOCK_ID=35&amp;n=product&amp;k=n0&amp;iblockfix=y&amp;tableId=iblockprop-E-1255-38', 900, 700);">
    </br>
    </br>
    <label>Куда копируем:</label></br>
    <input name="product[n0]" id="product[n0]" type="number" placeholder="Выберите раздел">
    <input type="button" value="..." onclick="jsUtils.OpenWindow('/bitrix/admin/iblock_element_search.php?lang=ru&amp;IBLOCK_ID=35&amp;n=product&amp;k=n0&amp;iblockfix=y&amp;tableId=iblockprop-E-1255-38', 900, 700);">
    </br>
    </br>
    <input type="submit" name="load_geo" value="Копировать">
    </br>
    </br>
</form>
<?
require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");
?>
