<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="social-icons">
	<?if($arParams["SOCIAL_TITLE"] && (!empty($arResult["SOCIAL_VK"]) || !empty($arResult["SOCIAL_ODNOKLASSNIKI"]) || !empty($arResult["SOCIAL_FACEBOOK"]) || !empty($arResult["SOCIAL_TWITTER"]) || !empty($arResult["SOCIAL_INSTAGRAM"]) || !empty($arResult["SOCIAL_MAIL"]) || !empty($arResult["SOCIAL_YOUTUBE"]) || !empty($arResult["SOCIAL_GOOGLEPLUS"]))):?>
		<div class="small_title"><?=$arParams["SOCIAL_TITLE"];?></div>
	<?endif;?>
	<!-- noindex -->
	<ul>
        <?if(!empty($arResult['SOCIAL_MAIL'])):?>
            <!--<li class="mail">
                <a href="mailto:<?=$arResult['SOCIAL_MAIL']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_MAILRU')?>">
                    <?=GetMessage('TEMPL_SOCIAL_GOOGLEPLUS')?>
                </a>
            </li>-->
			<li class="mail">
                <a href="mailto:mail@fin.market" target="_blank" rel="nofollow" title="mail">
                     mail@fin.market
                </a>
            </li>
        <?endif;?>
		<?if(!empty($arResult['SOCIAL_VK'])):?>
			<li class="vk">
				<a href="<?=$arResult['SOCIAL_VK']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_VK')?>">
					<?=GetMessage('TEMPL_SOCIAL_VK')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_FACEBOOK'])):?>
			<li class="facebook">
				<a href="<?=$arResult['SOCIAL_FACEBOOK']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_FACEBOOK')?>">
					<?=GetMessage('TEMPL_SOCIAL_FACEBOOK')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_INSTAGRAM'])):?>
			<li class="instagram">
				<a href="<?=$arResult['SOCIAL_INSTAGRAM']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_INSTAGRAM')?>">
					<?=GetMessage('TEMPL_SOCIAL_INSTAGRAM')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_TELEGRAM'])):?>
			<li class="telegram">
				<a href="<?=$arResult['SOCIAL_TELEGRAM']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_TELEGRAM')?>">
					<?=GetMessage('TEMPL_SOCIAL_TELEGRAM')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_ODNOKLASSNIKI'])):?>
			<li class="odn">
				<a href="<?=$arResult['SOCIAL_ODNOKLASSNIKI']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_ODNOKLASSNIKI')?>">
					<?=GetMessage('TEMPL_SOCIAL_ODNOKLASSNIKI')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_GOOGLEPLUS'])):?>
			<li class="gplus">
				<a href="<?=$arResult['SOCIAL_GOOGLEPLUS']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_GOOGLEPLUS')?>">
					<?=GetMessage('TEMPL_SOCIAL_GOOGLEPLUS')?>
				</a>
			</li>
		<?endif;?>
        <?if(!empty($arResult['SOCIAL_TWITTER'])):?>
            <li class="twitter">
                <a href="<?=$arResult['SOCIAL_TWITTER']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_TWITTER')?>">
                    <?=GetMessage('TEMPL_SOCIAL_TWITTER')?>
                </a>
            </li>
        <?endif;?>
        <?if(!empty($arResult['SOCIAL_YOUTUBE'])):?>
            <li class="ytb">
                <a href="<?=$arResult['SOCIAL_YOUTUBE']?>" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_YOUTUBE')?>">
                    <?=GetMessage('TEMPL_SOCIAL_YOUTUBE')?>
                </a>
            </li>
        <?endif;?>
        <li class="twitter2">
            <a href="https://twitter.com/Finmarket24" target="_blank" rel="nofollow" title="Twitter">
                Twitter
            </a>
        </li>
        <li class="whatsapp">
            <a href="https://chat.whatsapp.com/CDe1KYJENgDDdqnhCFELbY" target="_blank" rel="nofollow" title="Whatsapp">
                Whatsapp
            </a>
        </li>
        <li class="viber">
            <a href="https://invite.viber.com/?g2=AQBFRwrWJh3ov0wD67s7mzcGuZY9pCjBJOxFBTftSKTd42GEycBZLv7xjc3HU07j" target="_blank" rel="nofollow" title="Viber">
                Viber
            </a>
        </li>
	</ul>
	<!-- /noindex -->
</div>