<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

foreach($arResult["ITEMS"] as $key => $arItem)
{
	if($arItem["CODE"]=="IN_STOCK"){
		sort($arResult["ITEMS"][$key]["VALUES"]);
		if($arResult["ITEMS"][$key]["VALUES"])
			$arResult["ITEMS"][$key]["VALUES"][0]["VALUE"]=$arItem["NAME"];
	}
}


/**
 * переберем свойства
 */
$brand = Array();
$osn   = Array();
$usl   = Array();
$treb  = Array();
$har   = Array();
$doc   = Array();
$ser   = Array();
foreach($arResult["ITEMS"] as $key => $arItem){
    $pos_point_in_name = strpos($arItem["NAME"], ".");

    //Вызов стикеров
    if($arItem['CODE']=="HIT") {
        $this->setFrameMode( true );
        $this->SetViewTarget("header_sections_wrapper");
        ?>
        <div class="stickers 46">
            <?
            foreach($arItem['VALUES'] as $keys => $arItem1){
                echo '<div class="1"><div class="sticker_ 1"><a href="' . $APPLICATION->GetCurPage . '?tags=' . $keys . '" class="btn_filter">' . $arItem1['VALUE'] . ' </a></div></div>';
            };
            ?>
        </div>
        <?
        $this->EndViewTarget();
    }
    //Вызов стикеров - Конец

    if($arItem['CODE']=="MAGAZIN"){
        $brand[] = $arItem;
    }elseif ($pos_point_in_name>0){
        $group_filters  = substr($arItem["NAME"],0,$pos_point_in_name);
        if($group_filters=='Основные'){
            $osn[] = $arItem;
        }
        if($group_filters=='Условия'){
            $usl[] = $arItem;
        }
        if($group_filters=='Требования'){
            $treb[] = $arItem;
        }
        if($group_filters=='Характеристики'){
            $har[] = $arItem;
        }
        if($group_filters=='Документы'){
            $doc[] = $arItem;
        }
        if($group_filters=='Сервисы'){
            $ser[] = $arItem;
        }
    }
}
$res = Array();
foreach($brand as $arItem){
    $res['BRAND'][] = $arItem;
}
foreach($osn as $arItem){
    $res['OSN'][] = $arItem;
}
foreach($usl as $arItem){
    $res['USL'][] = $arItem;
}
foreach($treb as $arItem){
    $res['TREB'][] = $arItem;
}
foreach($har as $arItem){
    $res['HAR'][] = $arItem;
}
foreach($doc as $arItem){
    $res['DOC'][] = $arItem;
}
foreach($ser as $arItem){
    $res['SER'][] = $arItem;
}

$new_usl_group   = Array();
$new_usl_other   = Array();
foreach ($res['USL'] as $item)
{
    $arr = getGroupProperty($item["NAME"]);
    if(count($arr)>0)
    {
        $new_usl_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_usl_other[] = $item;
    }
}
$new_treb_group  = Array();
$new_treb_other  = Array();
foreach ($res['TREB'] as $item)
{
    $arr = getGroupProperty($item["NAME"]);
    if(count($arr)>0)
    {
        $new_treb_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_treb_other[] = $item;
    }
}
$new_har_group   = Array();
$new_har_other   = Array();
foreach ($res['HAR'] as $item)
{
    $arr = getGroupProperty($item["NAME"]);
    if(count($arr)>0)
    {
        $new_har_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_har_other[] = $item;
    }
}
$new_doc_group   = Array();
$new_doc_other   = Array();
foreach ($res['DOC'] as $item)
{
    $arr = getGroupProperty($item["NAME"]);
    if(count($arr)>0)
    {
        $new_doc_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_doc_other[] = $item;
    }
}
$new_ser_group   = Array();
$new_ser_other   = Array();
foreach ($res['SER'] as $item)
{
    $arr = getGroupProperty($item["NAME"]);
    if(count($arr)>0)
    {
        $new_ser_group['GROUPS'][$arr['NAME']][] = $item;
    }
    else
    {
        $new_ser_other[] = $item;
    }
}
//окончательная сборка - НАЧАЛО
$new_res = array();
foreach ($res['BRAND'] as $item)
{
    $new_res[] = $item;
}
foreach ($res['OSN'] as $item)
{
    $new_res[] = $item;
}
foreach ($new_usl_other as $item)
{
    $new_res[] = $item;
}
$new_res[] = $new_usl_group;
foreach ($new_treb_other as $item)
{
    $new_res[] = $item;
}
$new_res[] = $new_treb_group;
foreach ($new_har_other as $item)
{
    $new_res[] = $item;
}
$new_res[] = $new_har_group;
foreach ($new_doc_other as $item)
{
    $new_res[] = $item;
}
$new_res[] = $new_doc_group;
foreach ($new_ser_other as $item)
{
    $new_res[] = $item;
}
$new_res[] = $new_ser_group;

//окончательная сборка - КОНЕЦ
$arResult["ITEMS"] = $new_res;

\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

// sort
include 'sort.php';

global $sotbitFilterResult;
$sotbitFilterResult = $arResult;