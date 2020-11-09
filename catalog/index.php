<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "N");
$APPLICATION->SetTitle("Каталог | ФинМаркет");?>
<?php if(isset($_GET['param']))
{
    if($_GET['param']=='add')
    {
        $APPLICATION->SetTitle("Выбор продуктов для сравнения");
    }
}
//$name_filter = "arRegionLink";
$name_filter = "arFilter";
if (!empty($_GET["tags"])){
    GLOBAL $arFilter;
    $arFilter = array("PROPERTY" => Array("HIT"=> $_GET["tags"]));
    $name_filter = 'arFilter';
}
if (!empty($_GET["newtags"])){
    GLOBAL $arFilter;
    $arFilter = array("PROPERTY_".$_GET["newtags"]."_VALUE" => "Да");
    $name_filter = 'arFilter';
}
if (!empty($_GET["othertagcode"]) && !empty($_GET["otherid"])){
	GLOBAL $arFilter;
	$arFilter = array("PROPERTY_".$_GET["othertagcode"] => $_GET["otherid"]);
	$name_filter = 'arFilter';
}
if(isset($_GET["ajaxLazy"]) && !empty($_GET["ajaxLazy"])){
   $GLOBALS[$name_filter]["ID"] = $_GET["ajaxLazy"];
}
?>
<div class="stepAjax" style="display: none;">1</div>
<div class="lastScrollToElem" style="display: none;">no</div>
<?
$APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	"fm_catalog2", 
	array(
		"DISPLAY_COMPARE" => "Y",
		"RECOMENDATION_TITLE" => "Вас заинтересует",
		"IBLOCK_TYPE" => "aspro_next_catalog",
		"IBLOCK_ID" => "35",
		"HIDE_NOT_AVAILABLE" => "N",
		"BASKET_URL" => "/basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/catalog/",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "Y",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "Y",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => $name_filter,
		"FILTER_FIELD_CODE" => array(
			0 => "SORT",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "USLOVIYA_M_PROTSENTNAYA_STAVKA_PROTSENT",
			1 => "SROK_ZAIMA",
			2 => "STAVKA_V_DEN",
			3 => "CML2_ARTICLE",
			4 => "IN_STOCK",
			5 => "",
		),
		"FILTER_PRICE_CODE" => array(
		),
		"FILTER_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "COLOR",
			2 => "CML2_LINK",
			3 => "",
		),
		"USE_REVIEW" => "Y",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "Y",
		"POST_FIRST_MESSAGE" => "N",
		"USE_COMPARE" => "Y",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPARE_FIELD_CODE" => array(
			0 => "NAME",
			1 => "SORT",
			2 => "PREVIEW_PICTURE",
			3 => "",
		),
		"COMPARE_PROPERTY_CODE" => array(
			0 => "HIT",
			1 => "MAGAZIN",
			2 => "URL",
			3 => "MAIN_LGOTNIY_PERIOD",
			4 => "MAIN_PROZ_STAVKA",
			5 => "MAIN_SROK_KREDITA",
			6 => "USLOVIYA_VNESENIE_NALICHNYKH",
			7 => "USLOVIYA_BESPLATNYE_PLATEZHI_PEREVODY",
			8 => "USLOVIYA_BONUSY",
			9 => "USLOVIYA_VALYUTA",
			10 => "USLOVIYA_VEDENIE_SCHETA_PRI_ISPOLZOVANII_SISTEMY_D",
			11 => "USLOVIYA_VNESHNIE_PEREVODY_ZA_PLATEZH_PRIMECHANIE",
			12 => "USLOVIYA_VYPUSK_KARTY",
			13 => "USLOVIYA_GODOVOE_OBSLUZHIVANIE",
			14 => "USLOVIYA_DLYA_PUTESHESTVIY",
			15 => "USLOVIYA_ZAKRYTIE_SCHETA",
			16 => "USLOVIYA_OTKRYTIE_RASCHETNYKH_SCHETOV_V_RUBLYAKH_R",
			17 => "USLOVIYA_NALOGOVYE_PLATEZHI_RUB_MES",
			18 => "USLOVIYA_SVYSHE_BESPLATNOGO_LIMITA_VNESENIYA_NALIC",
			19 => "USLOVIYA_KREDITNYY_LIMIT",
			20 => "USLOVIYA_LGOTNYY_PERIOD",
			21 => "USLOVIYA_LGOTNYY_PERIOD_NA_NALICHNYE_DNEY",
			22 => "USLOVIYA_MESTO_VYDACHI_OFORMLENIYA_KREDITA",
			23 => "USLOVIYA_MINIMALNAYA_KOMISSIYA_ZA_SNYATIE_NALICHNY",
			24 => "USLOVIYA_MINIMALNYY_PLATEZH_V_MESYATS_OT_SUMMY",
			25 => "USLOVIYA_MINIMALNYY_PLATEZH_PO_KARTE_V_MESYATS_RUB",
			26 => "USLOVIYA_NALOGOVYE_PLATEZHI",
			27 => "USLOVIYA_NEUSTOYKA_OT_SUMMY_PROSROCHENNOGO_PLATEZH",
			28 => "USLOVIYA_OBSLUZHIVANIE_PAKETA_EZHEMESYACHNO_RUB_",
			29 => "USLOVIYA_PROTSENT_PO_ONLAYN_DEPOZITU",
			30 => "USLOVIYA_PEREVOD_NA_SVOYU_KARTU_FIZLITSA_DLYA_IP_",
			31 => "USLOVIYA_PEREVOD_NA_SVOYU_KARTU_FIZLITSA_DLYA_IP",
			32 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_IP",
			33 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_OOO",
			34 => "USLOVIYA_PLATA_ZA_PROPUSK_PLATEZHA_",
			35 => "USLOVIYA_PLATA_ZA_PROPUSK_PLATEZHA_RUB",
			36 => "USLOVIYA_PLATEZHI_V_INOSTRANNOY_VALYUTE_OT_STOIMOS",
			37 => "USLOVIYA_PLATEZHI_V_INOSTRANNOY_VALYUTE",
			38 => "USLOVIYA_PLATEZHI_SVERKH_BESPLATNOGO_LIMITA_RUB_",
			39 => "USLOVIYA_PORYADOK_POGASHENIYA",
			40 => "USLOVIYA_PRODAVETS",
			41 => "USLOVIYA_SNYATIE_NALICHNYKH_BEZ_",
			42 => "USLOVIYA_PROTSENT_NA_OSTATOK_DA_NET",
			43 => "USLOVIYA_PROTSENTNAYA_STAVKA",
			44 => "USLOVIYA_M_PROTSENTNAYA_STAVKA_PROTSENT",
			45 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_NALICHNYE",
			46 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_POKUPKI",
			47 => "USLOVIYA_PROTSENTY_NA_OSTATOK",
			48 => "USLOVIYA_REZHIM_VYDACHI",
			49 => "USLOVIYA_SKIDKA_PRI_PREDOPLATE_ZA_12_MESYATSEV_",
			50 => "USLOVIYA_OBSLUZHIVANIE_PAKETA_PRI_PREDOPLATE_ZA_12",
			51 => "USLOVIYA_SKIDKA_PRI_PREDOPLATE_ZA_3_MESYATSA_",
			52 => "USLOVIYA_OBSLUZHIVANIE_PAKETA_PRI_PREDOPLATE_ZA_3_",
			53 => "USLOVIYA_SKIDKA_PRI_PREDOPLATE_ZA_6_MESYATSEV_",
			54 => "USLOVIYA_OBSLUZHIVANIE_PAKETA_PRI_PREDOPLATE_ZA_6_",
			55 => "USLOVIYA_SMENA_TARIFA",
			56 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_IP",
			57 => "USLOVIYA_SNYATIE_NALICHNYKH_V_BANKOMATAKH_DRUGIKH_",
			58 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_IP_KOMISSIYA_RUB",
			59 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_OOO",
			60 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_OOO_KOMISSIYA_RUB",
			61 => "USLOVIYA_SPOSOB_OPLATY",
			62 => "USLOVIYA_SREDNEMESYACHNYE_RASKHODY",
			63 => "USLOVIYA_SROK_KREDITA",
			64 => "USLOVIYA_SROK_RASSMOTRENIYA_ZAYAVKI",
			65 => "USLOVIYA_EKSTRENNYE_USLUGI_ZA_RUBEZHOM_VYDACHA_NAL",
			66 => "TREBOVANIYA_VOZRAST_ZAYEMSHCHIKA",
			67 => "TREBOVANIYA_PODTVERZHDENIE_DOKHODA",
			68 => "TREBOVANIYA_REGISTRATSIYA_V_REGIONE_POLUCHENIYA_KA",
			69 => "TREBOVANIYA_REGISTRATSIYA_V_REGIONE_PRISUTSTVIYA_B",
			70 => "TREBOVANIYA_SEMEYNOE_POLOZHENIE",
			71 => "HARAKTERISTIKI_3D_SECURE",
			72 => "HARAKTERISTIKI_BESKONTAKTNYE_PLATEZHI_PAYWAVE",
			73 => "USLOVIYA_OBESPECHENIE_DA_NET",
			74 => "HARAKTERISTIKI_PLATEZHNAYA_SISTEMA",
			75 => "HARAKTERISTIKI_TEKHNOLOGIYA_3D_SECURE",
			76 => "HARAKTERISTIKI_TIP_KARTY",
			77 => "HARAKTERISTIKI_CHIP",
			78 => "DOKUMENTY_SECOND_DOCUMENT",
			79 => "DOKUMENTY_DOGOVOR_S_OBRAZOVATELNYM_UCHREZHDENIEM",
			80 => "DOKUMENTY_DOKUMENT_O_VREMENNOY_REGISTRATSII",
			81 => "DOKUMENTY_PROCHIE_DOKUMENTY",
			82 => "SERVISY_INTERNET_BANK_I_MOBILNOE_PRILOZHENIE_DLYA_",
			83 => "SERVISY_ABONENTSKAYA_PLATA_ZA_MOBILNOE_PRILOZHENIE",
			84 => "SERVISY_SMS_1MES",
			85 => "SERVISY_SMS_DALEE",
			86 => "SERVISY_SMS_STOIMOST_PRI_PREDOPLATE_ZA_6_MES_RUB",
			87 => "USLOVIYA_ANNUITETNYE_PLATEZHI",
			88 => "USLOVIYA_STRAKHOVANIE_KASKO",
			89 => "USLOVIYA_VNESHNIE_PEREVODY_RUB_MES",
			90 => "USLOVIYA_VOZMOZHNOST_OBRATNOGO_VYKUPA",
			91 => "USLOVIYA_DIFFERENTSIROVANNYE_PLATEZHI",
			92 => "ALL_DOCUMENTS",
			93 => "USLOVIYA_DOSROCHNOE_POGASHENIE_DA_NET",
			94 => "SERVISY_KREDITY_DLYA_BIZNESA",
			95 => "USLOVIYA_KESH_BEK_NA_VSE_POKUPKI_",
			96 => "USLOVIYA_KESH_BEK_NA_IZBRANNYE_KATEGORII_",
			97 => "USLOVIYA_LIMIT_NA_SNYATIE_NALICHNYKH_DEN",
			98 => "USLOVIYA_LIMIT_NA_SNYATIE_NALICHNYKH_V_MESYATS",
			99 => "USLOVIYA_MINIMALNYY_PERVONACHALNYY_VZNOS",
			100 => "SERVISY_MOBILNOE_PRILOZHENIE",
			101 => "MOBILE_PAY",
			102 => "USLOVIYA_BONUSY_YES_NO",
			103 => "USLOVIYA_PROTSENT_NA_OSTATOK_",
			104 => "USLOVIYA_KESH_BEK",
			105 => "USLOVIYA_PERIOD_RASSROCHKI_DLYA_KART_RASSROCHKI",
			106 => "USLOVIYA_VNESHNIE_PEREVODY_ZA_PLATEZH_",
			107 => "USLOVIYA_POGASHENIE_KREDITA",
			108 => "USLOVIYA_POLUCHENIE_NA_KARTU",
			109 => "USLOVIYA_POLUCHENIE_NA_SCHET",
			110 => "USLOVIYA_POLUCHENIE_NA_SCHET_V_STORONNEM_BANKE",
			111 => "USLOVIYA_POLUCHENIE_NALICHNYMI",
			112 => "USLOVIYA_POLUCHENIE_NALICHNYMI_V_OFISE",
			113 => "USLOVIYA_PROTSENT_ZA_SNYATIE_NALICHNYKH",
			114 => "USLOVIYA_REZERVIROVANIE_SCHETA",
			115 => "USLOVIYA_SEYFOVAYA_YACHEYKA",
			116 => "USLOVIYA_SISTEMA_DENEZHNYKH_PEREVODOV",
			117 => "USLOVIYA_SMS_INFORMIROVANIE",
			118 => "USLOVIYA_ISPOLZOVANIE_SOBSTVENNYKH_SREDSTV",
			119 => "SROK_ZAIMA",
			120 => "USLOVIYA_SROK_KREDITA_LET",
			121 => "STAVKA_V_DEN",
			122 => "USLOVIYA_STRAKHOVANIE_DA_NET",
			123 => "USLOVIYA_EKSPRESS_KREDIT",
			124 => "USLOVIYA_ELEKTRONNYY_KOSHELEK",
			125 => "USLOVIYA_VYPLATA_ZARPLATY_SOTRUDNIKAM",
			126 => "HARAKTERISTIKI_APPLE_PAY",
			127 => "HARAKTERISTIKI_GOOGLE_PAY",
			128 => "HARAKTERISTIKI_SAMSUNG_PAY",
			129 => "DOKUMENTY_VODITELSKOE_UDOSTOVERENIE",
			130 => "DOKUMENTY_VOENNYY_BILET",
			131 => "DOKUMENTY_DOKUMENTY_NA_IMUSHCHESTVO",
			132 => "DOKUMENTY_ZARPLATNAYA_KARTA_BANKA",
			133 => "DOKUMENTY_ZAYVLENIE_ANKETA",
			134 => "DOKUMENTY_INN",
			135 => "DOKUMENTY_KOPIYA_TRUDOVOY_KNIZHKI",
			136 => "DOKUMENTY_PASPORT",
			137 => "DOKUMENTY_PENSIONNOE_UDOST",
			138 => "DOKUMENTY_SNILS",
			139 => "DOKUMENTY_IP",
			140 => "DOKUMENTY_OOO",
			141 => "DOKUMENTY_SPRAVKA_PO_FORME_2_NDFL",
			142 => "DOKUMENTY_SPRAVKA_BANKA",
			143 => "USLOVIYA_VID_TRANSPORTNOGO_SREDSTVA",
			144 => "USLOVIYA_VOZRAST_TRANSPORTNOGO_SREDSTVA",
			145 => "USLOVIYA_TIP_TRANSPORTNOGO_SREDSTVA",
			146 => "HARAKTERISTIKI_BESC_OPLATA",
			147 => "USLOVIYA_BESPLATNOE_VNESENIE_NALICHNYKH_LIMIT_PRIM",
			148 => "USLOVIYA_VYPLATA_ZARPLATY_SOTRUDNIKAM_PRIMECHANIE",
			149 => "USLOVIYA_DOSROCHNOE_POGASHENIE_PRIMECHANIE",
			150 => "USLOVIYA_OBESPECHENIE_PRIMECHANIE",
			151 => "USLOVIYA_ONLAYN_DEPOZIT_PRIMECHANIE",
			152 => "USLOVIYA_PEREVOD_NA_SVOYU_KARTU_FIZLITSA_DLYA_IP_P",
			153 => "USLOVIYA_PLATEZHI_V_INOSTRANNOY_VALYUTE_PRIMECHANI",
			154 => "USLOVIYA_PROTSENTY_NA_OSTATOK_DO_PRIMECHANIE",
			155 => "USLOVIYA_STRAKHOVANIE_PRIMECHANIE",
			156 => "TREBOVANIYA_PRIMECHANIE",
			157 => "SERVISY_GODOVOE_OBSLUZHIVANIE_BIZNES_KARTY_OT_RUB",
			158 => "SERVISY_GODOVOE_OBSLUZHIVANIE_BIZNES_KARTY_PRIMECH",
			159 => "SERVISY_TORGOVYY_EKVAYRING_PRIMECHANIE",
			160 => "MAIN_GOD_OBSL",
			161 => "MAIN_KREDIT_LIMIT",
			162 => "USLOVIYA_VYPLATA_ZARPLATY_SOTRUDNIKAM_DO_",
			163 => "USLOVIYA_SNYATIE_NALICHNYKH_NA_ZARPLATU",
			164 => "USLOVIYA_GODOVOE_OBSLUZHIVANIE_PRIMECHANIE",
			165 => "USLOVIYA_GODOVOE_OBSLUZHIVANIE_RUB_DO",
			166 => "USLOVIYA_KREDITNYY_LIMIT_RUB_OT",
			167 => "USLOVIYA_MINIMALNYY_PLATEZH_V_MESYATS_OT_SUMMY_DO",
			168 => "USLOVIYA_MINIMALNYY_PLATEZH_V_MESYATS_OT_SUMMY_OT",
			169 => "USLOVIYA_ONLAYN_DEPOZIT_DO_",
			170 => "USLOVIYA_ONLAYN_DEPOZIT_OT_",
			171 => "USLOVIYA_ONLAYN_DEPOZIT_DO_RUB",
			172 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_IP_DO_",
			173 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_IP_OT_",
			174 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_IP_LIMIT",
			175 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_OOO_DO_",
			176 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_OOO_OT_",
			177 => "USLOVIYA_PEREVODY_FIZICHESKIM_LITSAM_DLYA_OOO_LIMI",
			178 => "USLOVIYA_PLATEZHI_PEREDANNYE_V_BANK_NA_BUMAZHNOM_N",
			179 => "USLOVIYA_PODKLYUCHENIE_RUB_GOD",
			180 => "USLOVIYA_PROTSENTNAYA_STAVKA_DO",
			181 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_NALICHNYE_DO",
			182 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_NALICHNYE_OT",
			183 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_POKUPKI_DO",
			184 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_POKUPKI_OT",
			185 => "USLOVIYA_PROTSENTY_NA_OSTATOK_DO_",
			186 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_IP_DO_",
			187 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_IP_OT_",
			188 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_OOO_DO_",
			189 => "USLOVIYA_SNYATIE_NALICHNYKH_DLYA_OOO_OT_",
			190 => "USLOVIYA_OTKRYTIE_RKO_V_RUBLYAKH_RF_I_INOSTRANNOY_",
			191 => "SERVISY_VALYUTNYY_KONTROL_SUMMA_DO_IN_VALYUTA",
			192 => "SERVISY_VALYUTNYY_KONTROL_SUMMA_OT_IN_VALYUTA",
			193 => "SERVISY_VALYUTNYY_KONTROL_SUMMA_DO_RUB",
			194 => "SERVISY_INTERNET_EKVAYRING_DO_",
			195 => "SERVISY_TORGOVYY_EKVAYRING_DO_",
			196 => "SERVISY_TORGOVYY_EKVAYRING_OT_",
			197 => "USLOVIYA_PREIMUSHCHESTVA_SCHETA",
			198 => "",
		),
		"COMPARE_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "",
		),
		"COMPARE_OFFERS_PROPERTY_CODE" => array(
			0 => "MAGAZIN",
			1 => "USLOVIYA_SMS_INFORMIROVANIE",
			2 => "USLOVIYA_BONUSY",
			3 => "USLOVIYA_VYPUSK_KARTY",
			4 => "USLOVIYA_GODOVOE_OBSLUZHIVANIE",
			5 => "USLOVIYA_DLYA_PUTESHESTVIY",
			6 => "USLOVIYA_ISPOLZOVANIE_SOBSTVENNYKH_SREDSTV",
			7 => "USLOVIYA_KREDITNYY_LIMIT",
			8 => "USLOVIYA_KESH_BEK_NA_VSE_POKUPKI_",
			9 => "USLOVIYA_KESH_BEK_NA_IZBRANNYE_KATEGORII_",
			10 => "USLOVIYA_LIMIT_NA_SNYATIE_NALICHNYKH_V_MESYATS",
			11 => "USLOVIYA_LGOTNYY_PERIOD",
			12 => "USLOVIYA_LGOTNYY_PERIOD_NA_NALICHNYE_DNEY",
			13 => "USLOVIYA_MINIMALNAYA_KOMISSIYA_ZA_SNYATIE_NALICHNY",
			14 => "USLOVIYA_MINIMALNYY_PLATEZH_V_MESYATS_OT_SUMMY",
			15 => "USLOVIYA_MINIMALNYY_PLATEZH_PO_KARTE_V_MESYATS_RUB",
			16 => "USLOVIYA_BONUSY_YES_NO",
			17 => "USLOVIYA_KESH_BEK",
			18 => "USLOVIYA_PERIOD_RASSROCHKI_DLYA_KART_RASSROCHKI",
			19 => "USLOVIYA_POGASHENIE_KREDITA",
			20 => "USLOVIYA_PROTSENT_ZA_SNYATIE_NALICHNYKH",
			21 => "USLOVIYA_PROTSENT_NA_OSTATOK_",
			22 => "USLOVIYA_PROTSENT_NA_OSTATOK_DA_NET",
			23 => "USLOVIYA_PROTSENTNAYA_STAVKA",
			24 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_NALICHNYE",
			25 => "USLOVIYA_PROTSENTNAYA_STAVKA_NA_POKUPKI",
			26 => "USLOVIYA_SNYATIE_NALICHNYKH_BEZ_",
			27 => "USLOVIYA_SROK_KREDITA",
			28 => "USLOVIYA_SROK_RASSMOTRENIYA_ZAYAVKI",
			29 => "TREBOVANIYA_VOZRAST_ZAYEMSHCHIKA",
			30 => "TREBOVANIYA_PODTVERZHDENIE_DOKHODA",
			31 => "TREBOVANIYA_PRIMECHANIE",
			32 => "TREBOVANIYA_SEMEYNOE_POLOZHENIE",
			33 => "TREBOVANIYA_SPRAVKA_PO_FORME_2_NDFL",
			34 => "HARAKTERISTIKI_3D_SECURE",
			35 => "HARAKTERISTIKI_APPLE_PAY",
			36 => "HARAKTERISTIKI_GOOGLE_PAY",
			37 => "HARAKTERISTIKI_SAMSUNG_PAY",
			38 => "HARAKTERISTIKI_BESKONTAKTNYE_PLATEZHI_PAYWAVE",
			39 => "KHARAKTERISTIKI_PLATEZHNAYA_SISTEMA",
			40 => "KHARAKTERISTIKI_TEKHNOLOGIYA_3D_SECURE",
			41 => "KHARAKTERISTIKI_TIP_KARTY",
			42 => "HARAKTERISTIKI_CHIP",
			43 => "TREBOVANIYA_VTOROY_DOKUMENT_NA_VYBOR",
			44 => "TREBOVANIYA_ZAYAVLENIE_ANKETA",
			45 => "TREBOVANIYA_PASPORT",
			46 => "TREBOVANIYA_PENSIONNOE_UDOSTOVERENIE",
			47 => "TREBOVANIYA_SPRAVKA_PO_FORME_BANKA",
			48 => "TREBOVANIYA_DOKHOD_RUB_SOVOKUPNYY_DOKHOD_KLIENTA_P",
			49 => "TREBOVANIYA_POSTOYANNAYA_REGISTRATSIYA_NA_TERRITOR",
			50 => "TREBOVANIYA_RABOTA_V_REGIONE_PRISUTSTVIYA_BANKA",
			51 => "TREBOVANIYA_STAZH_RABOTY_NA_POSLEDNEM_MESTE_MES",
			52 => "TREBOVANIYA_GRAZHDANSTVO_RF",
			53 => "TREBOVANIYA_NALICHIE_KONTAKTNOGO_TELEFONA",
			54 => "",
		),
		"COMPARE_ELEMENT_SORT_FIELD" => "shows",
		"COMPARE_ELEMENT_SORT_ORDER" => "asc",
		"DISPLAY_ELEMENT_SELECT_BOX" => "Y",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "Y",
		"SHOW_PRICE_COUNT" => "0",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_PROPERTIES" => "",
		"USE_PRODUCT_QUANTITY" => "Y",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"OFFERS_CART_PROPERTIES" => "",
		"SHOW_TOP_ELEMENTS" => "Y",
		"SECTION_COUNT_ELEMENTS" => "Y",
		"SECTION_TOP_DEPTH" => "2",
		"SECTIONS_LIST_PREVIEW_PROPERTY" => "DESCRIPTION",
		"SHOW_SECTION_LIST_PICTURES" => "Y",
		"PAGE_ELEMENT_COUNT" => "5",
		"LINE_ELEMENT_COUNT" => "4",
		"ELEMENT_SORT_FIELD" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "shows",
		"ELEMENT_SORT_ORDER2" => "asc",
		"LIST_PROPERTY_CODE" => array(
			0 => "BRAND",
			1 => "CML2_ARTICLE",
			2 => "PROP_2033",
			3 => "COLOR_REF2",
			4 => "PROP_159",
			5 => "PROP_2052",
			6 => "PROP_2027",
			7 => "PROP_2053",
			8 => "PROP_2083",
			9 => "PROP_2049",
			10 => "PROP_2026",
			11 => "PROP_2044",
			12 => "PROP_162",
			13 => "PROP_2065",
			14 => "PROP_2054",
			15 => "PROP_2017",
			16 => "PROP_2055",
			17 => "PROP_2069",
			18 => "PROP_2062",
			19 => "PROP_2061",
			20 => "CML2_LINK",
			21 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "CML2_LINK",
			2 => "DETAIL_PAGE_URL",
			3 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "ARTICLE",
			1 => "VOLUME",
			2 => "SIZES",
			3 => "COLOR_REF",
			4 => "",
		),
		"LIST_OFFERS_LIMIT" => "10",
		"SORT_BUTTONS" => array(
			0 => "POPULARITY",
			1 => "NAME",
			2 => "PRICE",
		),
		"SORT_PRICES" => "REGION_PRICE",
		"DEFAULT_LIST_TEMPLATE" => "list",
		"SECTION_DISPLAY_PROPERTY" => "",
		"LIST_DISPLAY_POPUP_IMAGE" => "Y",
		"SECTION_PREVIEW_PROPERTY" => "DESCRIPTION",
		"SHOW_SECTION_PICTURES" => "Y",
		"SHOW_SECTION_SIBLINGS" => "Y",
		"USE_DETAIL_PREDICTION" => "N",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "BRAND",
			1 => "CML2_ARTICLE",
			2 => "VIDEO_YOUTUBE",
			3 => "PROP_2033",
			4 => "CML2_ATTRIBUTES",
			5 => "COLOR_REF2",
			6 => "PROP_159",
			7 => "PROP_2052",
			8 => "PROP_2027",
			9 => "PROP_2053",
			10 => "PROP_2083",
			11 => "PROP_2049",
			12 => "PROP_2026",
			13 => "PROP_2044",
			14 => "PROP_162",
			15 => "PROP_2065",
			16 => "PROP_2054",
			17 => "PROP_2017",
			18 => "PROP_2055",
			19 => "PROP_2069",
			20 => "PROP_2062",
			21 => "PROP_2061",
			22 => "RECOMMEND",
			23 => "NEW",
			24 => "STOCK",
			25 => "VIDEO",
			26 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "DETAIL_TEXT",
			3 => "DETAIL_PICTURE",
			4 => "DETAIL_PAGE_URL",
			5 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "FRAROMA",
			1 => "ARTICLE",
			2 => "SPORT",
			3 => "VLAGOOTVOD",
			4 => "AGE",
			5 => "RUKAV",
			6 => "KAPUSHON",
			7 => "FRCOLLECTION",
			8 => "FRLINE",
			9 => "FRFITIL",
			10 => "VOLUME",
			11 => "FRMADEIN",
			12 => "FRELITE",
			13 => "SIZES",
			14 => "TALL",
			15 => "FRFAMILY",
			16 => "FRSOSTAVCANDLE",
			17 => "FRTYPE",
			18 => "FRFORM",
			19 => "COLOR_REF",
			20 => "",
		),
		"PROPERTIES_DISPLAY_LOCATION" => "TAB",
		"SHOW_BRAND_PICTURE" => "Y",
		"SHOW_ASK_BLOCK" => "N",
		"ASK_FORM_ID" => "2",
		"SHOW_ADDITIONAL_TAB" => "N",
		"PROPERTIES_DISPLAY_TYPE" => "TABLE",
		"SHOW_KIT_PARTS" => "Y",
		"SHOW_KIT_PARTS_PRICES" => "Y",
		"LINK_IBLOCK_TYPE" => "aspro_next_content",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "Y",
		"ALSO_BUY_ELEMENT_COUNT" => "5",
		"ALSO_BUY_MIN_BUYES" => "2",
		"USE_STORE" => "N",
		"USE_STORE_PHONE" => "Y",
		"USE_STORE_SCHEDULE" => "Y",
		"USE_MIN_AMOUNT" => "N",
		"MIN_AMOUNT" => "10",
		"STORE_PATH" => "/contacts/stores/#store_id#/",
		"MAIN_TITLE" => "Наличие на складах",
		"MAX_AMOUNT" => "20",
		"USE_ONLY_MAX_AMOUNT" => "Y",
		"OFFERS_SORT_FIELD" => "shows",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "shows",
		"OFFERS_SORT_ORDER2" => "asc",
		"PAGER_TEMPLATE" => "main",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"IBLOCK_STOCK_ID" => "19",
		"SHOW_QUANTITY" => "Y",
		"SHOW_MEASURE" => "Y",
		"SHOW_QUANTITY_COUNT" => "Y",
		"USE_RATING" => "Y",
		"DISPLAY_WISH_BUTTONS" => "Y",
		"DEFAULT_COUNT" => "1",
		"SHOW_HINTS" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"STORES" => array(
			0 => "1",
			1 => "",
		),
		"USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_EMPTY_STORE" => "Y",
		"SHOW_GENERAL_STORE_INFORMATION" => "N",
		"TOP_ELEMENT_COUNT" => "8",
		"TOP_LINE_ELEMENT_COUNT" => "4",
		"TOP_ELEMENT_SORT_FIELD" => "shows",
		"TOP_ELEMENT_SORT_ORDER" => "asc",
		"TOP_ELEMENT_SORT_FIELD2" => "shows",
		"TOP_ELEMENT_SORT_ORDER2" => "asc",
		"TOP_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"COMPONENT_TEMPLATE" => "fm_catalog2",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"SHOW_DEACTIVATED" => "N",
		"TOP_OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "",
		),
		"TOP_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"TOP_OFFERS_LIMIT" => "10",
		"SECTION_TOP_BLOCK_TITLE" => "Лучшие предложения",
		"OFFER_TREE_PROPS" => array(
			0 => "MAGAZIN",
		),
		"USE_BIG_DATA" => "Y",
		"BIG_DATA_RCM_TYPE" => "similar",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"VIEWED_ELEMENT_COUNT" => "20",
		"VIEWED_BLOCK_TITLE" => "Ранее вы смотрели",
		"ELEMENT_SORT_FIELD_BOX" => "name",
		"ELEMENT_SORT_ORDER_BOX" => "asc",
		"ELEMENT_SORT_FIELD_BOX2" => "id",
		"ELEMENT_SORT_ORDER_BOX2" => "desc",
		"ADD_PICT_PROP" => "-",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "Y",
		"SKU_DETAIL_ID" => "oid",
		"USE_MAIN_ELEMENT_SECTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"AJAX_FILTER_CATALOG" => "Y",
		"SECTION_BACKGROUND_IMAGE" => "-",
		"DETAIL_BACKGROUND_IMAGE" => "-",
		"DISPLAY_ELEMENT_SLIDER" => "10",
		"SHOW_ONE_CLICK_BUY" => "Y",
		"USE_GIFTS_DETAIL" => "Y",
		"USE_GIFTS_SECTION" => "Y",
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
		"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "8",
		"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "8",
		"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
		"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "8",
		"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
		"OFFER_HIDE_NAME_PROPS" => "N",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
		"SECTION_PREVIEW_DESCRIPTION" => "Y",
		"SECTIONS_LIST_PREVIEW_DESCRIPTION" => "Y",
		"SALE_STIKER" => "SALE_TEXT",
		"SHOW_DISCOUNT_TIME" => "Y",
		"SHOW_RATING" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_OFFERS_LIMIT" => "0",
		"DETAIL_EXPANDABLES_TITLE" => "Аксессуары",
		"DETAIL_ASSOCIATED_TITLE" => "Похожие товары",
		"DETAIL_PICTURE_MODE" => "MAGNIFIER",
		"SHOW_UNABLE_SKU_PROPS" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"DETAIL_STRICT_SECTION_CHECK" => "Y",
		"COMPATIBLE_MODE" => "Y",
		"TEMPLATE_THEME" => "blue",
		"LABEL_PROP" => "",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"COMMON_SHOW_CLOSE_POPUP" => "N",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"SHOW_MAX_QUANTITY" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнение",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"SIDEBAR_SECTION_SHOW" => "Y",
		"SIDEBAR_DETAIL_SHOW" => "N",
		"SIDEBAR_PATH" => "",
		"USE_SALE_BESTSELLERS" => "Y",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"FILTER_HIDE_ON_MOBILE" => "N",
		"INSTANT_RELOAD" => "N",
		"COMPARE_POSITION_FIXED" => "Y",
		"COMPARE_POSITION" => "top left",
		"USE_RATIO_IN_RANGES" => "Y",
		"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
		"COMMON_ADD_TO_BASKET_ACTION" => "ADD",
		"TOP_ADD_TO_BASKET_ACTION" => "ADD",
		"SECTION_ADD_TO_BASKET_ACTION" => "ADD",
		"DETAIL_ADD_TO_BASKET_ACTION" => array(
			0 => "BUY",
		),
		"DETAIL_ADD_TO_BASKET_ACTION_PRIMARY" => array(
			0 => "BUY",
		),
		"TOP_PROPERTY_CODE_MOBILE" => "",
		"TOP_VIEW_MODE" => "SECTION",
		"TOP_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"TOP_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
		"TOP_ENLARGE_PRODUCT" => "STRICT",
		"TOP_SHOW_SLIDER" => "Y",
		"TOP_SLIDER_INTERVAL" => "3000",
		"TOP_SLIDER_PROGRESS" => "N",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"LIST_PROPERTY_CODE_MOBILE" => "",
		"LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"LIST_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
		"LIST_ENLARGE_PRODUCT" => "STRICT",
		"LIST_SHOW_SLIDER" => "Y",
		"LIST_SLIDER_INTERVAL" => "3000",
		"LIST_SLIDER_PROGRESS" => "N",
		"DETAIL_MAIN_BLOCK_PROPERTY_CODE" => "",
		"DETAIL_MAIN_BLOCK_OFFERS_PROPERTY_CODE" => "",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DETAIL_USE_COMMENTS" => "N",
		"DETAIL_BRAND_USE" => "N",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_IMAGE_RESOLUTION" => "16by9",
		"DETAIL_PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
		"DETAIL_PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
		"DETAIL_SHOW_SLIDER" => "N",
		"DETAIL_DETAIL_PICTURE_MODE" => array(
			0 => "POPUP",
			1 => "MAGNIFIER",
		),
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"MESS_PRICE_RANGES_TITLE" => "Цены",
		"MESS_DESCRIPTION_TAB" => "Описание",
		"MESS_PROPERTIES_TAB" => "Характеристики",
		"MESS_COMMENTS_TAB" => "Комментарии",
		"LAZY_LOAD" => "N",
		"LOAD_ON_SCROLL" => "N",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"DETAIL_DOCS_PROP" => "-",
		"STIKERS_PROP" => "HIT",
		"USE_SHARE" => "Y",
		"TAB_OFFERS_NAME" => "",
		"TAB_DESCR_NAME" => "",
		"TAB_CHAR_NAME" => "",
		"TAB_VIDEO_NAME" => "",
		"TAB_REVIEW_NAME" => "",
		"TAB_FAQ_NAME" => "",
		"TAB_STOCK_NAME" => "",
		"TAB_DOPS_NAME" => "",
		"BLOCK_SERVICES_NAME" => "",
		"BLOCK_DOCS_NAME" => "",
		"CHEAPER_FORM_NAME" => "",
		"DIR_PARAMS" => CNext::GetDirMenuParametrs(__DIR__),
		"SHOW_CHEAPER_FORM" => "Y",
		"SHOW_LANDINGS" => "N",
		"LANDING_TITLE" => "Популярные категории",
		"LANDING_SECTION_COUNT" => "7",
		"SHOW_LANDINGS_SEARCH" => "Y",
		"LANDING_SEARCH_TITLE" => "Похожие запросы",
		"LANDING_SEARCH_COUNT" => "7",
		"SECTIONS_TYPE_VIEW" => "sections_1",
		"SECTION_ELEMENTS_TYPE_VIEW" => "list_elements_1",
		"ELEMENT_TYPE_VIEW" => "element_1",
		"SHOW_ARTICLE_SKU" => "Y",
		"SORT_REGION_PRICE" => "Обмен по рознице",
		"LANDING_TYPE_VIEW" => "landing_1",
		"BIGDATA_NORMAL" => "bigdata_1",
		"BIGDATA_EXT" => "bigdata_2",
		"SHOW_MEASURE_WITH_RATIO" => "N",
		"SHOW_DISCOUNT_PERCENT_NUMBER" => "N",
		"ALT_TITLE_GET" => "NORMAL",
		"SHOW_COUNTER_LIST" => "Y",
		"SHOW_DISCOUNT_TIME_EACH_SKU" => "N",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"SHOW_HOW_BUY" => "Y",
		"TITLE_HOW_BUY" => "Как купить",
		"SHOW_DELIVERY" => "Y",
		"TITLE_DELIVERY" => "Доставка",
		"SHOW_PAYMENT" => "Y",
		"TITLE_PAYMENT" => "Оплата",
		"SHOW_GARANTY" => "Y",
		"TITLE_GARANTY" => "Условия гарантии",
		"USE_FILTER_PRICE" => "N",
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"RESTART" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"NO_WORD_LOGIC" => "Y",
		"SECTIONS_SEARCH_COUNT" => "10",
		"SHOW_SECTION_DESC" => "Y",
		"LANDING_POSITION" => "AFTER_PRODUCTS",
		"TITLE_SLIDER" => "Рекомендуем",
		"VIEW_BLOCK_TYPE" => "N",
		"SHOW_SEND_GIFT" => "Y",
		"SEND_GIFT_FORM_NAME" => "",
		"USE_ADDITIONAL_GALLERY" => "N",
		"BLOCK_LANDINGS_NAME" => "",
		"BLOG_IBLOCK_ID" => "",
		"BLOCK_BLOG_NAME" => "",
		"RECOMEND_COUNT" => "5",
		"VISIBLE_PROP_COUNT" => "4",
		"BUNDLE_ITEMS_COUNT" => "3",
		"STORES_FILTER" => "TITLE",
		"STORES_FILTER_ORDER" => "SORT_ASC",
		"OFFER_SHOW_PREVIEW_PICTURE_PROPS" => "",
		"FILE_404" => "",
		"CACHE_NOTES" => "",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
			"smart_filter" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);?>
<?php /*global $USER;
if ($USER->IsAdmin()): ?>
<div id="otladka">
0
</div>
<?php endif;*/ ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>