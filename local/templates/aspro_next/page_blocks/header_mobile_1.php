<?
global $arTheme, $arRegion;
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
?>
<div class="mobileheader-v1">
	<div class="burger pull-left">
		<?=CNext::showIconSvg("burger dark", SITE_TEMPLATE_PATH."/images/svg/Burger_big_white.svg");?>
		<?=CNext::showIconSvg("close dark", SITE_TEMPLATE_PATH."/images/svg/Close.svg");?>
	</div>
    <div class="comparison-block pull-right" style="padding-left: 36px">
        <?
        $sessionId = session_id();
        $i = 0;
        $element = GetIBlockElementList(40, false, Array(), false, Array('ACTIVE'=>'Y', 'NAME'=>$sessionId));
        while($arelement = $element->GetNext()) { $i++;   }
        if($i == 0){
            ?><a href="/catalog/comparisons/"> &#32; <?
            echo CNext::showIconSvg("comparison big", SITE_TEMPLATE_PATH."/images/svg/Comparison_big_black.svg");
            ?><?' '?><a class = "link_compare_icon" style="margin-left: 10px">0</a><?
            ?>
            </a>
        <?}
        else{
            ?><a href="/catalog/comparisons/"> &#32; <?
            echo CNext::showIconSvg("comparison big", SITE_TEMPLATE_PATH."/images/svg/Comparison_big_black.svg");
            ?><?' '?><a class = "link_compare_icon " style="margin-left: 10px">0</a><?
            ?>
            </a>
        <?}
        ?>
        <!--<a href="/catalog/comparisons/">
            <?=CNext::showIconSvg("comparison big", SITE_TEMPLATE_PATH."/images/svg/Comparison_big_black.svg");?>
        </a>-->
    </div>
	<div class="logo-block pull-left">
		<div class="logo<?=$logoClass?>">
			<?=CNext::ShowLogo();?>
		</div>
	</div>
	<div class="right-icons pull-right">
		<div class="pull-right">
			<div class="wrap_icon">
				<button class="top-btn inline-search-show twosmallfont">
					<?=CNext::showIconSvg("search big", SITE_TEMPLATE_PATH."/images/svg/Search_big_black.svg");?>
				</button>
			</div>
		</div>
		<div class="pull-right">
			<div class="wrap_icon wrap_basket">
				<?=CNext::ShowBasketWithCompareLink('', 'big', false, false, true);?>
			</div>
		</div>
		<div class="pull-right">
			<div class="wrap_icon wrap_cabinet">
				<?=CNext::showCabinetLink(true, false, 'big');?>
			</div>
		</div>
		<div class="pull-right">
			<div class="wrap_icon wrap_phones">
			    <?CNext::ShowHeaderMobilePhones('big');?>			    
			</div>
		</div>
	</div>
</div>