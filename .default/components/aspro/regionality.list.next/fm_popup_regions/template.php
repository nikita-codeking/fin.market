<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);
echo \Bitrix\Main\Service\GeoIp\Manager::getCityName('ru');
use \Bitrix\Main\Localization\Loc;?>
<?//see($arResult['CURRENT_REGION']);?>
<?if(!$arResult['POPUP']):?>
	<?if($arResult['CURRENT_REGION']):?>
		<?global $arTheme;?>
		<div class="region_wrapper">
			<div class="js_city_chooser colored" data-event="jqm" data-name="city_chooser" data-param-url="<?=urlencode($APPLICATION->GetCurUri());?>" data-param-form_id="city_chooser">
				<span class="name-region-in-banner">в <?=$arResult['CURRENT_REGION']['PROPERTY_REGION_NAME_DECLINE_PP_VALUE'];?></span><span class="arrow"><i></i></span>
			</div>
		</div>
	<?endif;?>
<?endif;?>
