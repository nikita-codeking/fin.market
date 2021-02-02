<?if('Y' == $arParams['USE_FILTER']):?>
	<?
	if($arTheme["FILTER_VIEW"]["VALUE"] == 'COMPACT'){
		if($arParams["AJAX_FILTER_CATALOG"]=="Y"){
			$template = 'main_compact_ajax';
		}
		else{
			$template = 'main_compact';
		}
	}
	elseif($arParams["AJAX_FILTER_CATALOG"]=="Y"){
		$template = 'main_ajax';
	}
	else{
		$template = 'main';
	}
	?>
	<?php
	/*$GLOBALS['SMART_FILTER_AJAX']['PARAMS'] = Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "AJAX_FILTER_FLAG" => $isAjaxFilter,
        "SECTION_ID" => (isset($arSection["ID"]) ? $arSection["ID"] : ''),
        "FILTER_NAME" => $arParams["FILTER_NAME"],
        "PRICE_CODE" => ($arParams["USE_FILTER_PRICE"] == 'Y' ? $arParams["FILTER_PRICE_CODE"] : $arParams["PRICE_CODE"]),
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_NOTES" => "",
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SAVE_IN_SESSION" => "N",
        "XML_EXPORT" => "Y",
        "SECTION_TITLE" => "NAME",
        "SECTION_DESCRIPTION" => "DESCRIPTION",
        "SHOW_HINTS" => $arParams["SHOW_HINTS"],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        'DISPLAY_ELEMENT_COUNT' => $arParams['DISPLAY_ELEMENT_COUNT'],
        "INSTANT_RELOAD" => "Y",
        "VIEW_MODE" => strtolower($arTheme["FILTER_VIEW"]["VALUE"]),
        "SEF_MODE" => (strlen($arResult["URL_TEMPLATES"]["smart_filter"]) ? "Y" : "N"),
        "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
        "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
        "SORT_BUTTONS" => $arParams["SORT_BUTTONS"],
        "SORT_PRICES" => $arParams["SORT_PRICES"],
        "AVAILABLE_SORT" => $arAvailableSort,
        "SORT" => $sort,
        "SORT_ORDER" => $sort_order,
    );
    $GLOBALS['SMART_FILTER_AJAX']['COMPONENT'] = $component;*/
    ?>
    <?//$APPLICATION->ShowViewContent('SMART_FILTER_AJAX');?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter",
		'fm_'.$template . '_catalog2',
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"AJAX_FILTER_FLAG" => $isAjaxFilter,
			"SECTION_ID" => (isset($arSection["ID"]) ? $arSection["ID"] : ''),
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"PRICE_CODE" => ($arParams["USE_FILTER_PRICE"] == 'Y' ? $arParams["FILTER_PRICE_CODE"] : $arParams["PRICE_CODE"]),
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_NOTES" => "",
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SAVE_IN_SESSION" => "N",
			"XML_EXPORT" => "Y",
			"SECTION_TITLE" => "NAME",
			"SECTION_DESCRIPTION" => "DESCRIPTION",
			"SHOW_HINTS" => $arParams["SHOW_HINTS"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'DISPLAY_ELEMENT_COUNT' => $arParams['DISPLAY_ELEMENT_COUNT'],
			"INSTANT_RELOAD" => "Y",
			"VIEW_MODE" => strtolower($arTheme["FILTER_VIEW"]["VALUE"]),
			"SEF_MODE" => (strlen($arResult["URL_TEMPLATES"]["smart_filter"]) ? "Y" : "N"),
			"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
			"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"SORT_BUTTONS" => $arParams["SORT_BUTTONS"],
			"SORT_PRICES" => $arParams["SORT_PRICES"],
			"AVAILABLE_SORT" => $arAvailableSort,
			"SORT" =>  $_GET["sort"],
			"SORT_ORDER" =>  $_GET["method"],
		),
		$component);
	?>
<?endif;?>