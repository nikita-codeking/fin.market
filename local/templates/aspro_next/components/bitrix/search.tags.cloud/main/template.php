<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if(is_array($arResult["SEARCH"]) && !empty($arResult["SEARCH"])):?>
	<noindex>
		<div class="search-tags-cloud" id="ajax-menu">
			<div class="title-block-middle"><?=\Bitrix\Main\Localization\Loc::getMessage('TAG_TITLE');?></div>
			<div class="tags">
				<?//php see($arResult["SEARCH"][0]);?>
				<a href="?" rel="nofollow">Все статьи</a>
				<?foreach ($arResult["SEARCH"] as $key => $res):?>
					<?php $url = str_replace(" ", "%20",$res["NAME"]);?>
					<a href="?tags=<?=$url;?>" rel="nofollow"><?=$res["NAME"]?></a>
				<?endforeach;?>
			</div>
		</div>
	</noindex>
<?endif;?>