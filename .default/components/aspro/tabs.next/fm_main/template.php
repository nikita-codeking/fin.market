<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

$class_block="s_".$this->randString();
$arTab=array();
$col=4;
if($arParams["LINE_ELEMENT_COUNT"]>=3 && $arParams["LINE_ELEMENT_COUNT"]<4)
    $col=3;
if($arResult["SHOW_SLIDER_PROP"]){?>
<div class="tab_slider_wrapp specials <?=$class_block;?> best_block clearfix" itemscope itemtype="http://schema.org/WebPage">
    <div class="top_blocks">
        <div class="title_wrapper">
            <div class="title_block sm"><?=GetMessage("FAST_TITLE");?></div>
            <!--<a href="/catalog/" class="itsall_href">Все >>></a>-->
        </div>
    </div>
    <?$arParams['SET_TITLE'] = 'N';
    $arTmp = reset($arResult["TABS"]);
    $arParams["FILTER_HIT_PROP"] = $arTmp["CODE"];
    $arParamsTmp = urlencode(serialize($arParams));?>
    <span class='request-data' data-value='<?=$arParamsTmp?>'></span>
    <div class="section_id_slider">325</div>
    <div class="top_blocks_title_cards">
        <div class="top_blocks">
            <?if($arParams["NAME_BLOCK"]):?>
                <div class="title_wrapper">
                    <div class="title_pod_wrapper">
                    <div class="title_block">
                        <a style="display: none" id="325" href="javascript:void(0);" class="sm sec-ajax <?if($_GET['section_main']!=325):?><?if(isset($_GET['section_main'])):?>black_title<?endif?><?endif?>">Кредитные карты</a>
                        <img style="width:300px;border-radius: 8px;" src="/upload/img/credcards.png" <?if($_GET['section_main']!=107):?><?if(isset($_GET['section_main'])):?>class="black_img"<?endif?><?endif?> alt="Кредитные карты" title="Кредитные карты">
						

                    </div>
                    <div class="title_block" style="">
                        <a style="display: none" id="327" href="javascript:void(0);" class="title_block sm sec-ajax <?if($_GET['section_main']!=327):?>black_title<?endif?>">Дебетовые карты</a>
                        <img style="width:300px;border-radius: 8px;" src="/upload/img/debetcards.png" <?if($_GET['section_main']!=105):?>class="black_img"<?endif?> alt="Дебетовые карты" title="Дебетовые карты">
						

                    </div>
                    <!--<div class="title_block">
                        <a id="106" href="javascript:void(0);" class="title_block sm sec-ajax <?if($_GET['section_main']!=106):?>black_title<?endif?>">Карты рассрочки</a>
                        <img src="/upload/img/cart_debet.jpg" <?if($_GET['section_main']!=106):?>class="black_img"<?endif?> alt="Карты рассрочки" title="Карты рассрочки">

                    </div>-->
                    </div>
                </div>
            <?endif;?>
            <div class="tabs_ajax_overflow">
                <ul class="tabs ajax">
                    <?$i=1;
                    foreach($arResult["TABS"] as $code => $arTab):?>
                        <li data-code="<?=$code?>" <?=($i==1 ? "class='cur clicked'" : "")?>><span><?=$arTab["TITLE"];?></span></li>
                        <?$i++;?>
                    <?endforeach;?>
                    <li class="stretch"></li>
                </ul>
            </div>
        </div>
			<ul class="tabs_content">
				<?$j=1;?>
				<?foreach($arResult["TABS"] as $code => $arTab){?>
					<?
					$arTab["FILTER"] = $arTab["FILTER"] ? CNext::makeElementFilterInRegion($arTab["FILTER"]) : array();
					?>
					<li class="tab <?=$code?>_wrapp <?=($j == 1 ? "cur opacity1" : "");?>" data-code="<?=$code?>" data-col="<?=$col;?>" data-filter="<?=($arTab["FILTER"] ? urlencode(serialize($arTab["FILTER"])) : '');?>">
						<div class="tabs_slider <?=$code?>_slides wr">
							<?if($j++ == 1)
							{
								if($arTab["FILTER"])
									$GLOBALS[$arParams["FILTER_NAME"]] = $arTab["FILTER"];

                                include(str_replace("//", "/", $_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/fm/mainpage/comp_catalog_ajax.php"));
							}?>
						</div>
					</li>
				<?}?>
			</ul>
		</div>
	<?}?>
<script>
    $(document).ready(function() {

        /*
        $('.sec-ajax').click(function () {
            location.href = "/?section_main="+$(this).attr("id");
        });
        $('.tab_slider_wrapp .top_blocks .title_block img').click(function () {
            location.href = "/?section_main="+$(this).parent().children('.sec-ajax').attr("id");
        });
        */
    });
</script>
