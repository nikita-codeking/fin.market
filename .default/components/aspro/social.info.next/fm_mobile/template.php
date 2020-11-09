<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="social-icons">
	<!-- noindex -->
	<ul>
        <li class="mail">
            <a href="mailto:mail@fin.market" class="dark-color" target="_blank" rel="nofollow" title="mail">
                <?=CNext::showIconSvg("ml", SITE_TEMPLATE_PATH."/images/svg/social/Mailru.svg");?>
                mail@fin.market
            </a>
        </li>
		<?if(!empty($arResult['SOCIAL_FACEBOOK'])):?>
			<li class="facebook">
				<a href="<?=$arResult['SOCIAL_FACEBOOK']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_FACEBOOK')?>">
					<?=CNext::showIconSvg("fb", SITE_TEMPLATE_PATH."/images/svg/social/Facebook.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_FACEBOOK')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_VK'])):?>
			<li class="vk">
				<a href="<?=$arResult['SOCIAL_VK']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_VK')?>">
					<?=CNext::showIconSvg("vk", SITE_TEMPLATE_PATH."/images/svg/social/Vk.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_VK')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_TWITTER'])):?>
			<li class="twitter">
				<a href="<?=$arResult['SOCIAL_TWITTER']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_TWITTER')?>">
					<?=CNext::showIconSvg("tw", SITE_TEMPLATE_PATH."/images/svg/social/pinterest.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_TWITTER')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_INSTAGRAM'])):?>
			<li class="instagram">
				<a href="<?=$arResult['SOCIAL_INSTAGRAM']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_INSTAGRAM')?>">
					<?=CNext::showIconSvg("inst", SITE_TEMPLATE_PATH."/images/svg/social/Instagram.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_INSTAGRAM')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_TELEGRAM'])):?>
			<li class="telegram">
				<a href="<?=$arResult['SOCIAL_TELEGRAM']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_TELEGRAM')?>">
					<?=CNext::showIconSvg("tel", SITE_TEMPLATE_PATH."/images/svg/social/Telegram.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_TELEGRAM')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_YOUTUBE'])):?>
			<li class="ytb">
				<a href="<?=$arResult['SOCIAL_YOUTUBE']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_YOUTUBE')?>">
					<?=CNext::showIconSvg("yt", SITE_TEMPLATE_PATH."/images/svg/social/ya-chats.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_YOUTUBE')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_ODNOKLASSNIKI'])):?>
			<li class="odn">
				<a href="<?=$arResult['SOCIAL_ODNOKLASSNIKI']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_ODNOKLASSNIKI')?>">
					<?=CNext::showIconSvg("ok", SITE_TEMPLATE_PATH."/images/svg/social/Odnoklassniki.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_ODNOKLASSNIKI')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_GOOGLEPLUS'])):?>
			<li class="gplus">
				<a href="<?=$arResult['SOCIAL_GOOGLEPLUS']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_GOOGLEPLUS')?>">
					<?=CNext::showIconSvg("gp", SITE_TEMPLATE_PATH."/images/svg/social/zen-black.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_GOOGLEPLUS')?>
				</a>
			</li>
		<?endif;?>
        <li class="twitter2">
            <a href="https://twitter.com/Finmarket24" class="dark-color" target="_blank" rel="nofollow" title="Twitter>">
                <?=CNext::showIconSvg("gp", SITE_TEMPLATE_PATH."/images/svg/social/Twitter.svg");?>
                Twitter
            </a>
        </li>
        <li class="whatsapp">
            <a href="https://chat.whatsapp.com/CDe1KYJENgDDdqnhCFELbY" class="dark-color" target="_blank" rel="nofollow" title="Whatsapp">
                <?=CNext::showIconSvg("gp", SITE_TEMPLATE_PATH."/images/svg/social/whatsapp.svg");?>
                Whatsapp
            </a>
        </li>
        <li class="viber">
            <a href="https://invite.viber.com/?g2=AQBFRwrWJh3ov0wD67s7mzcGuZY9pCjBJOxFBTftSKTd42GEycBZLv7xjc3HU07j" class="dark-color" target="_blank" rel="nofollow" title="Viber">
                <?=CNext::showIconSvg("gp", SITE_TEMPLATE_PATH."/images/svg/social/viber.svg");?>
                Viber
            </a>
        </li>
	</ul>
	<!-- /noindex -->
</div>