<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<noindex>
	<div class="search-tags-cloud" id="ajax-menu">
		<div class="title-block-middle">Сторис - Тэги</div>
		<div class="tags">
			<?if (!empty($arResult)):?>
				<?foreach($arResult as $arItem):?>
					<a href="<?=$arItem["LINK"]?>" rel="nofollow"><?=$arItem["TEXT"]?></a>
				<?endforeach?>
			<?endif?>
		</div>
	</div>
</noindex>