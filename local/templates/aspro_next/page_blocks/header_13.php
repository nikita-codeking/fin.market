    <?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme, $arRegion;
$arRegions = CNextRegionality::getRegions();
if($arRegion)
	$bPhone = ($arRegion['PHONES'] ? true : false);
else
	$bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
?>
<div class="header-v2 header-wrapper long">
    <div class="top_inner_block_wrapper maxwidth-theme">
	<!--<div class="maxwidth-theme">-->
		<div class="logo_and_menu-row">
			<div class="logo-row">
				<div class="row">
					<div class="logo-block col-md-2 col-sm-3">
						<div class="logo<?=$logoClass?>">
						<?if($APPLICATION->GetCurPage() == ""){?>
							<img src="/local/templates/aspro_next/images/flogo_wite.svg" alt="">
						<?}?>
						<?if($APPLICATION->GetCurPage() != ""){?>
							<?=CNext::ShowLogo();?>
						<?}?>
                            <span>Финансовый маркетплейс</span>
						</div>
					</div>
					<div class="col-md-10 menu-row">
                        <?if($arRegions):?>
                            <div class="inline-block pull-left">
                                <div class="top-description">
                                    <?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
                                        array(
                                            "COMPONENT_TEMPLATE" => ".default",
                                            "PATH" => SITE_DIR."include/top_page/regionality.list.php",
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "",
                                            "AREA_FILE_RECURSIVE" => "Y",
                                            "EDIT_TEMPLATE" => "include_area.php"
                                        ),
                                        false
                                    );?>
                                </div>
                            </div>
                        <?endif;?>
						<div class="right-icons pull-right">
                            <div class="pull-right show-fixed">
                                <div class="wrap_icon" style="display: none">
                                    <button class="top-btn inline-search-show twosmallfont">
                                        <?=CNext::showIconSvg("search big", SITE_TEMPLATE_PATH."/images/svg/Search_big_black.svg");?>
                                    </button>
                                </div>
                            </div>
                            <div class="pull-right">
                                <!--<div class="wrap_icon wrap_cabinet">
                                    <?/*=CNext::showCabinetLink(true, false, 'big');*/?>
                                </div>-->
                                <div class="wrap_icon wrap_compare">
                                    <a href="/catalog/comparisons/"><?
                                        echo CNext::showIconSvg("comparison big", SITE_TEMPLATE_PATH."/images/svg/Comparison_big_black.svg");
                                           ?> <?' '?><a class = "link_compare_icon">0</a><??>
                                    </a>
                                </div>
                            </div>
						</div>					
						<div class="menu-only">
							<nav class="mega-menu sliced">
								<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
									array(
										"COMPONENT_TEMPLATE" => ".default",
										"PATH" => SITE_DIR."include/menu/menu.top.php",
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "",
										"AREA_FILE_RECURSIVE" => "Y",
										"EDIT_TEMPLATE" => "include_area.php"
									),
									false, array("HIDE_ICONS" => "Y")
								);?>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div><?// class=logo-row?>
    </div>
    <div class="line-row visible-xs"></div>
</div>