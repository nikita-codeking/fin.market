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
    <!--noindex-->
    <?php
    $this_url = $APPLICATION->GetCurPage();
    $pos_credit_cart = strpos($this_url, 'kreditnye_karty');
    $pos_debit_cart = strpos($this_url, 'debetovye_karty');
    $pos_credit_nal  = strpos($this_url, 'kredity_nalichnymi');
    $pos_zaymi  = strpos($this_url, 'zaymy');
    $pos_autocredity  = strpos($this_url, 'avtokredity');
    $pos_ipoteka  = strpos($this_url, 'ipoteka');
    $pos_refinansirovanie  = strpos($this_url, 'refinansirovanie');
    $pos_rko  = strpos($this_url, 'raschetnye_scheta');
    if($pos_credit_cart>0 || $pos_credit_nal>0 || $pos_zaymi>0 || $pos_autocredity>0 || $pos_ipoteka>0 || $pos_refinansirovanie>0 || $pos_debit_cart>0):
    ?>
    <div class="sort_filter mobile_filter_compact">
        <?if($pos_debit_cart>0):?>
            <?if($_GET["sort"] == "property_OT_DO_GOD_OBSL_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_GOD_OBSL_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_GOD_OBSL_MAX" || is_null($_GET["sort"])):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="годовое обслуживание"></i><span>Годовое обслуживание</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
        <?else:?>
            <?if($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_CREDIT_LIM_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX" || is_null($_GET["sort"])):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="кредитный лимит"></i><span>Кредитный лимит</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
            <?if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_PROZ_ST_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX"):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="процентная ставка"></i><span>Процентная ставка</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
        <?endif;?>

        <?if($pos_credit_nal>0 || $pos_zaymi>0 || $pos_ipoteka>0 || $pos_autocredity || $pos_debit_cart>0):?>
        <?else:?>
            <?if($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_LGOTNIY_PERIOD_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX"):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="льготный период"></i><span>Льготный период</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
        <?endif;?>



        <?if($pos_debit_cart>0):?>
            <?if($_GET["sort"] != "property_OT_DO_GOD_OBSL_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_GOD_OBSL_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_GOD_OBSL_MAX" || is_null($_GET["sort"])):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="годовое обслуживание"></i><span>Годовое обслуживание</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
        <?else:?>
            <?if($_GET["sort"] != "property_OT_DO_CREDIT_LIM_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_CREDIT_LIM_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_CREDIT_LIM_MAX" || is_null($_GET["sort"])):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="кредитный лимит"></i><span>Кредитный лимит</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
            <?if($_GET["sort"] != "property_OT_DO_PROZ_ST_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_PROZ_ST_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_PROZ_ST_MAX"):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="процентная ставка"></i><span>Процентная ставка</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
        <?endif;?>

        <?if($pos_credit_nal>0 || $pos_zaymi>0 || $pos_ipoteka>0 || $pos_autocredity || $pos_debit_cart>0):?>
        <?else:?>
            <?if($_GET["sort"] != "property_OT_DO_LGOTNIY_PERIOD_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_LGOTNIY_PERIOD_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_LGOTNIY_PERIOD_MAX"):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="льготный период"></i><span>Льготный период</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
        <?endif;?>

    </div>
    <?endif;?>
    <?if($pos_rko>0):?>
        <div class="sort_filter mobile_filter_compact">
            <?if($_GET["sort"] == "property_OT_DO_OBSLUGIVANIE_MAX"):?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_OBSLUGIVANIE_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_OBSLUGIVANIE_MAX" || is_null($_GET["sort"])):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="обслуживание в месяц"></i><span>Обслуживание в месяц</span><i class="arr icons_fa"></i>
                </a>
            <?else:?>
                <a href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=property_OT_DO_OBSLUGIVANIE_MAX&method=<?if($_GET["method"]=='desc'):?>asc<?else:?>desc<?endif;?>" class="sort_btn <?if($_GET["sort"] == "property_OT_DO_OBSLUGIVANIE_MAX" || is_null($_GET["sort"])):?>current <?=$_GET["method"]?><?else:?>desc<?endif;?>" rel="nofollow">
                    <i class="icon" title="обслуживание в месяц"></i><span>Обслуживание в месяц</span><i class="arr icons_fa"></i>
                </a>
            <?endif;?>
        </div>
    <?endif;?>
    <!--/noindex-->
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