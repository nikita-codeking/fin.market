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
$usl   = Array();
$treb  = Array();
$har   = Array();
foreach($arResult["ITEMS"] as $key => $arItem){
    $pos_point_in_name = strpos($arItem["NAME"], ".");

    //Вызов стикеров
    if($arItem['CODE']=="HIT") {
        $this->setFrameMode( true );
        $this->SetViewTarget("header_sections_wrapper");
        ?>
        <div class="stickers 51" style="right: 0px !important;left: inherit !important;text-align: right !important;position: absolute !important;bottom: 10px !important;width: 400px;padding-right: 0px !important;">
            <?
            foreach($arItem['VALUES'] as $keys => $arItem1){
		//see($arItem);break;
                echo '<div><div class="sticker_ 2"><a href="' . $APPLICATION->GetCurPage . '?tags=' . $keys . '" class="btn_filter">' . $arItem1['VALUE'] . ' </a></div></div>';
            };
            ?>
        </div>
        <?
        $this->EndViewTarget();
    }
    //Вызов стикеров - Конец

    if($arItem['CODE']=="MAGAZIN"){
        $brand[] = $arItem;
    }elseif ($arItem['CODE']=="OT_DO_PROZ_ST" || $arItem['CODE']=="OT_DO_CREDIT_LIM" || $arItem['CODE']=="OT_DO_AGE_ZAEM" || $arItem['CODE']=="OT_DO_YYEAR_OBSL" ||
        $arItem['CODE']=="OT_DO_PROZ_ST_MAX" || $arItem['CODE']=="OT_DO_CREDIT_LIM_MAX" || $arItem['CODE']=="OT_DO_LGOTNIY_PERIOD_MAX"){
        $temp = Array();
        $temp = $arItem;
        $temp['NAME'] = 'Условия.' . $temp['NAME'];
        $usl[] = $temp;
    }elseif ($pos_point_in_name>0){
        $group_filters  = substr($arItem["NAME"],0,$pos_point_in_name);
        if($group_filters=='Условия'){
            $usl[] = $arItem;
        }
        if($group_filters=='Требования'){
            $treb[] = $arItem;
        }
        if($group_filters=='Характеристики'){
            $har[] = $arItem;
        }
    }
}
$res = Array();
foreach($brand as $arItem){
    $res[] = $arItem;
}
foreach($usl as $arItem){
    $res[] = $arItem;
}
foreach($treb as $arItem){
    $res[] = $arItem;
}
foreach($har as $arItem){
    $res[] = $arItem;
}
$arResult["ITEMS"] = $res;

\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

// sort
include 'sort.php';

global $sotbitFilterResult;
$sotbitFilterResult = $arResult;