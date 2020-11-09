<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])){
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency){?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
	<?}
}?>
<?
$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK'], 'ID'=>$arResult['ID']);
$arSelect = Array('ID','PICTURE');
$db_list = CIBlockSection::GetList(Array('ID'=>'DESC'), $arFilter, true, $arSelect);
while($ar_result = $db_list->GetNext())
{
    $APPLICATION->AddHeadString('<meta property="og:image" content="https://'.SITE_SERVER_NAME.CFile::GetPath($ar_result['PICTURE']).'"/>');
}

?>
