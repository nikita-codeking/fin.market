<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>

<?// shot top banners start?>
<?$bShowTopBanner = (isset($arResult['SECTION_BNR_CONTENT'] ) && $arResult['SECTION_BNR_CONTENT'] == true);?>
<?if($bShowTopBanner):?>
    <?$this->SetViewTarget("section_bnr_content");?>
    <?CNext::ShowTopDetailBanner($arResult, $arParams);?>
    <?$this->EndViewTarget();?>
<?endif;?>
<?// shot top banners end?>

<?// form question?>
<?global $isHideLeftBlock;?>
<?$bShowFormQuestion = ($arResult['DISPLAY_PROPERTIES']['FORM_QUESTION']['VALUE_XML_ID'] == 'YES');?>
<?if($bShowFormQuestion):?>
<?ob_start();?>
<div class="ask_a_question">
    <div class="inner">
        <div class="text-block">
            <?$APPLICATION->IncludeComponent(
                'bitrix:main.include',
                '',
                Array(
                    'AREA_FILE_SHOW' => 'page',
                    'AREA_FILE_SUFFIX' => 'ask',
                    'EDIT_TEMPLATE' => ''
                )
            );?>
        </div>
    </div>
    <div class="outer">
        <span><span class="btn btn-default btn-lg white animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question"><span><?=(strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : Loc::getMessage('S_ASK_QUESTION'))?></span></span></span>
    </div>
</div>
<?$sFormQuestion = ob_get_contents();
ob_end_clean();?>
<?if(!$isHideLeftBlock):?>
    <?$this->SetViewTarget('under_sidebar_content');?>
    <?=$sFormQuestion;?>
    <?$this->EndViewTarget();?>
<?else:?>
<div class="row">
    <div class="col-md-9">
        <?endif;?>
        <?endif;?>

        <?// element name?>
        <?if($arParams['DISPLAY_NAME'] != 'N' && strlen($arResult['NAME'])):?>
            <h2><?=$arResult['NAME']?></h2>
        <?endif;?>

        <?// single detail image?>
        <?if($arResult['FIELDS']['DETAIL_PICTURE']):?>
            <?
            $atrTitle = (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['TITLE']) ? $arResult['DETAIL_PICTURE']['TITLE'] : $arResult['NAME']));
            $atrAlt = (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['ALT']) ? $arResult['DETAIL_PICTURE']['ALT'] : $arResult['NAME']));
            ?>
            <?if($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] == 'LEFT'):?>
                <div class="detailimage image-left col-md-4 col-sm-4 col-xs-12"><a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="fancy" title="<?=$atrTitle?>"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" title="<?=$atrTitle?>" alt="<?=$atrAlt?>" /></a></div>
            <?elseif($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] == 'RIGHT'):?>
                <div class="detailimage image-right col-md-4 col-sm-4 col-xs-12"><a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="fancy" title="<?=$atrTitle?>"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" title="<?=$atrTitle?>" alt="<?=$atrAlt?>" /></a></div>
            <?elseif($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] == 'TOP'):?>
                <?$this->SetViewTarget('top_section_filter_content');?>
                <div class="detailimage image-head"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" title="<?=$atrTitle?>" alt="<?=$atrAlt?>"/></div>
                <?$this->EndViewTarget();?>
            <?else:?>
                <div class="detailimage image-wide"><a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="fancy" title="<?=$atrTitle?>"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" title="<?=$atrTitle?>" alt="<?=$atrAlt?>" /></a></div>
            <?endif;?>
        <?endif;?>

        <?if(!$bShowTopBanner && strlen($arResult['FIELDS']['PREVIEW_TEXT'])):?>
            <div class="introtext_wrapper">
                <div class="introtext">
                    <?if($arResult['PREVIEW_TEXT_TYPE'] == 'text'):?>
                        <p><?=$arResult['FIELDS']['PREVIEW_TEXT'];?></p>
                    <?else:?>
                        <?=$arResult['FIELDS']['PREVIEW_TEXT'];?>
                    <?endif;?>
                </div>
            </div>
        <?endif;?>

        <?if($arResult['COMPANY']):?>
            <div class="wraps barnd-block">
                <div class="item-views list list-type-block image_left">
                    <?if($arResult['COMPANY']['PROPERTY_SLOGAN_VALUE']):?>
                        <div class="slogan"><?=$arResult['COMPANY']['PROPERTY_SLOGAN_VALUE'];?></div>
                    <?endif;?>
                    <div class="items row">
                        <div class="col-md-12">
                            <div class="item noborder clearfix">
                                <?if($arResult['COMPANY']['IMAGE-BIG']):?>
                                    <div class="image">
                                        <a href="<?=$arResult['COMPANY']['DETAIL_PAGE_URL'];?>">
                                            <img src="<?=$arResult['COMPANY']['IMAGE-BIG']['src'];?>" alt="<?=$arResult['COMPANY']['NAME'];?>" title="<?=$arResult['COMPANY']['NAME'];?>" class="img-responsive">
                                        </a>
                                    </div>
                                <?endif;?>
                                <div class="body-info">
                                    <?if($arResult['COMPANY']['DETAIL_TEXT']):?>
                                        <div class="previewtext">
                                            <?=$arResult['COMPANY']['DETAIL_TEXT'];?>
                                        </div>
                                    <?endif;?>
                                    <?if($arResult['COMPANY']['PROPERTY_SITE_VALUE']):?>
                                        <div class="properties">
                                            <div class="inner-wrapper">
                                                <!-- noindex -->
                                                <a class="property icon-block site" href="<?=$arResult['COMPANY']['PROPERTY_SITE_VALUE'];?>" target="_blank" rel="nofollow">
                                                    <?=$arResult['COMPANY']['PROPERTY_SITE_VALUE'];?>
                                                </a>
                                                <!-- /noindex -->
                                            </div>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        <?endif;?>

        <?// date active from or dates period active?>
        <?if(strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']) || ($arResult['DISPLAY_ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', $arParams['FIELD_CODE']))):?>
            <div class="period">
                <?if(strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE'])):?>
                    <span class="date"><?=$arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']?></span>
                <?else:?>
                    <span class="date"><?=$arResult['DISPLAY_ACTIVE_FROM']?></span>
                <?endif;?>
            </div>
        <?endif;?>
        <div class="elementsBannersSravni">
            <?
            //see($_GET['width']);
            if(isset($arResult['PROPERTIES']['SECTIONS_INCLUDE']['VALUE']))
            {

                ?><div class="mobileBnnerSravni"><?
                echo $arResult['BANNER_MOBILE'][0]['DETAIL_TEXT'];
                ?></div><?


                ?><div class="desctopBnnerSravni"><?
                echo $arResult['BANNER_DESK'][0]['DETAIL_TEXT'];
                ?></div><?
                //foreach ($arResult['PROPERTIES']['SECTIONS_INCLUDE']['VALUE'] as $itemV)
            }//if(isset($arResult['PROPERTIES']['SECTIONS_INCLUDE']['VALUE']))

            ?>
        </div>


        <?if(strlen($arResult['FIELDS']['DETAIL_TEXT'])):?>
            <!--<div class="content elastic_block off">-->
            <?// element detail text?>
            <?if(strlen($arResult['FIELDS']['DETAIL_TEXT'])):?>
                <?if($arResult['DETAIL_TEXT_TYPE'] == 'text'):?>
                    <p><?=$arResult['FIELDS']['DETAIL_TEXT'];?></p>
                <?else:?>
                    <?=$arResult['FIELDS']['DETAIL_TEXT'];?>
                <?endif;?>
            <?endif;?>
            <!--<div class="gradient"></div>-->
            <!--
            </div>
            <div>
                <p class="elastic_text">Много букв<br>для самых любознательных ;)</p>
                <button class="elastic_block_button"></button>
            </div>
            -->
        <?endif;?>

        <?$id_product = Array();?>
        <?foreach($arResult['PROPERTIES']['PRODUCTS']['VALUE'] as $item):?>
            <?$id_product[] = $item;?>
        <?endforeach;?>
        <div class="display_list show_un_props">
            <?
            $GLOBALS['arrFilterProp'] = array('ACTIVE' => 'Y', 'ID'=>$id_product);
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "fm_catalog_list_catalog2",
                array(
                    "IBLOCK_TYPE" => "aspro_next_catalog",
                    "IBLOCK_ID" => "35",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => "",
                    "TABS_CODE" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "ELEMENT_SORT_FIELD" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "FILTER_NAME" => "arrFilterProp",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "PAGE_ELEMENT_COUNT" => "5",
                    "LINE_ELEMENT_COUNT" => "2",
                    "PROPERTY_CODE" => array(
                        0 => "OT_DO_GOD_OBSL_MAX",
                        1 => "OT_DO_CREDIT_LIM_MAX",
                        2 => "OT_DO_LGOTNIY_PERIOD_MAX",
                        3 => "OT_DO_PROZ_ST_MAX",
                        4 => "",
                    ),
                    "OFFERS_LIMIT" => "0",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "BASKET_URL" => "/basket/",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "N",
                    "CACHE_FILTER" => "Y",
                    "META_KEYWORDS" => "-",
                    "META_DESCRIPTION" => "-",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "USE_COMPARE" => "Y",
                    "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                    "COMPARE_FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "SORT",
                        2 => "PREVIEW_PICTURE",
                        3 => "",
                    ),
                    "COMPARE_PROPERTY_CODE" => array(
                        0 => "OT_DO_GOD_OBSL_MAX",
                        1 => "OT_DO_CREDIT_LIM_MAX",
                        2 => "OT_DO_LGOTNIY_PERIOD_MAX",
                        3 => "OT_DO_PROZ_ST_MAX",
                        4 => "",
                    ),
                    "COMPARE_OFFERS_FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_PICTURE",
                        2 => "",
                    ),
                    "COMPARE_OFFERS_PROPERTY_CODE" => array(
                        0 => "MAGAZIN",
                        1 => "ID",
                        2 => "TSVET",
                        3 => "PROIZVODITEL",
                        4 => "CML2_ARTICLE",
                        5 => "ARTICLE",
                        6 => "CML2_BASE_UNIT",
                        7 => "VOLUME",
                        8 => "CML2_MANUFACTURER",
                        9 => "SIZES",
                        10 => "CML2_TRAITS",
                        11 => "CML2_TAXES",
                        12 => "CML2_BAR_CODE",
                        13 => "URL2",
                        14 => "USLOVIYA_PROTSENTNAYA_STAVKA",
                        15 => "USLOVIYA_SROK_KREDITA",
                        16 => "USLOVIYA_GODOVOE_OBSLUZHIVANIE",
                        17 => "USLOVIYA_POGASHENIE_KREDITA",
                        18 => "USLOVIYA_SROK_RASSMOTRENIYA_ZAYAVKI",
                        19 => "USLOVIYA_MASTERCARD_STANDARD",
                        20 => "USLOVIYA_MASTERCARD_GOLD",
                        21 => "USLOVIYA_MASTERCARD_PLATINUM",
                        22 => "USLOVIYA_MASTERCARD_WORLD",
                        23 => "USLOVIYA_VISA_CLASSIC",
                        24 => "USLOVIYA_VISA_PLATINUM",
                        25 => "USLOVIYA_VISA_SIGNATURE",
                        26 => "USLOVIYA_VISA_GOLD",
                        27 => "USLOVIYA_VISA_PREPAID",
                        28 => "USLOVIYA_VISA_UNEMBOSSED",
                        29 => "USLOVIYA_VISA_INSTANT_ISSUE",
                        30 => "USLOVIYA_3D_SECURE",
                        31 => "USLOVIYA_CHIP",
                        32 => "USLOVIYA_BESKONTAKTNYE_PLATEZHI_PAYWAVE",
                        33 => "USLOVIYA_GOOGLE_PAY",
                        34 => "USLOVIYA_APPLE_PAY",
                        35 => "USLOVIYA_SAMSUNG_PAY",
                        36 => "USLOVIYA_PROTSENT_NA_OSTATOK_DA_NET",
                        37 => "USLOVIYA_PROTSENT_NA_OSTATOK_",
                        38 => "USLOVIYA_KESH_BEK",
                        39 => "USLOVIYA_KESH_BEK_NA_VSE_POKUPKI_",
                        40 => "USLOVIYA_KESH_BEK_NA_IZBRANNYE_KATEGORII_",
                        41 => "USLOVIYA_BONUSY",
                        42 => "USLOVIYA_ISPOLZOVANIE_SOBSTVENNYKH_SREDSTV",
                        43 => "USLOVIYA_SNYATIE_NALICHNYKH_BEZ_",
                        44 => "USLOVIYA_PROTSENT_ZA_SNYATIE_NALICHNYKH",
                        45 => "USLOVIYA_MINIMALNAYA_KOMISSIYA_ZA_SNYATIE_NALICHNY",
                        46 => "USLOVIYA_LIMIT_NA_SNYATIE_NALICHNYKH_V_MESYATS",
                        47 => "TREBOVANIYA_VOZRAST_ZAYEMSHCHIKA_OT",
                        48 => "TREBOVANIYA_VOZRAST_ZAYEMSHCHIKA_DO",
                        49 => "TREBOVANIYA_STAZH_RABOTY_NA_POSLEDNEM_MESTE_MES",
                        50 => "TREBOVANIYA_PODTVERZHDENIE_DOKHODA",
                        51 => "TREBOVANIYA_GRAZHDANSTVO_RF",
                        52 => "TREBOVANIYA_ZAYAVLENIE_ANKETA",
                        53 => "TREBOVANIYA_PASPORT",
                        54 => "TREBOVANIYA_SPRAVKA_PO_FORME_BANKA",
                        55 => "TREBOVANIYA_SPRAVKA_PO_FORME_2_NDFL",
                        56 => "",
                    ),
                    "COMPARE_ELEMENT_SORT_FIELD" => "shows",
                    "COMPARE_ELEMENT_SORT_ORDER" => "asc",
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                    "PRICE_CODE" => array(
                        0 => "Обмен по рознице",
                    ),
                    "USE_PRICE_COUNT" => "Y",
                    "SHOW_PRICE_COUNT" => "0",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_PROPERTIES" => "",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "CONVERT_CURRENCY" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Товары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "DISCOUNT_PRICE_CODE" => "",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "SHOW_ADD_FAVORITES" => "Y",
                    "SECTION_NAME_FILTER" => "",
                    "SECTION_SLIDER_FILTER" => "21",
                    "COMPONENT_TEMPLATE" => "fm_rait",
                    "OFFERS_FIELD_CODE" => array(
                        0 => "ID",
                        1 => "",
                    ),
                    "OFFERS_PROPERTY_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "SHOW_MEASURE" => "Y",
                    "OFFERS_CART_PROPERTIES" => array(
                        0 => "MAGAZIN",
                    ),
                    "DISPLAY_WISH_BUTTONS" => "Y",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_OLD_PRICE" => "Y",
                    "SHOW_RATING" => "N",
                    "SALE_STIKER" => "SALE_TEXT",
                    "SHOW_DISCOUNT_TIME" => "N",
                    "STORES" => array(
                        0 => "1",
                        1 => "",
                    ),
                    "STIKERS_PROP" => "HIT",
                    "SHOW_DISCOUNT_PERCENT_NUMBER" => "N",
                    "SHOW_MEASURE_WITH_RATIO" => "N",
                    "SHOW_DISCOUNT_TIME_EACH_SKU" => "N",
                    "SHOW_BUY_BTN" => "N",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "NAME_BLOCK" => "Топ лучших дебетовых карт 2020 года с Cash Back",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    "BROWSER_TITLE" => "-",
                    "CUSTOM_FILTER" => "",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "BACKGROUND_IMAGE" => "-",
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_LAST_MODIFIED" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "DISPLAY_COMPARE" => "Y",
                    "COMPARE_PATH" => "",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "COMPATIBLE_MODE" => "Y",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N"
                ),
                false
            );
            ?>
        </div>

        <div class="links choose_extra_links">
            <a class="steck_sravnenia btn btn-default" href="/catalog/comparisons/">Сравнить все</a> или <a class="btn btn-default" href="/request_online/card">Отправить 1 заявку во все банки</a>
        </div>
        <script>
            $(document).ready(function() {
                $('.steck_sravnenia').click(function (e) {
                    e.preventDefault();

                    var idStr = $('.steck_sravnenie_rait');
                    //console.log($(this).parent().parent().children('.col-md-8').children('.top_wrapper').children('.catalog_block').children('.steck_sravnenie_rait').text());

                    //var sravniRating1 = idStr.text().split("|");
                    location.href = "/catalog/comparisons/?products="+idStr.text();
                });
            });

        </script>
</div>