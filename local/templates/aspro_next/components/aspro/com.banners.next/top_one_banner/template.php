<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if($arResult['ITEMS']):?>
	<div class="top_big_one_banner <?=($arResult['HAS_CHILD_BANNERS'] ? 'with_childs' : '');?>" style="overflow: hidden;">
		<?include_once('slider.php');?>
	</div>	
	<div class="main_img_wrap_mob">	
		<img class="main_logo_mob" src="<?=SITE_TEMPLATE_PATH?>/images/flogo_wite.svg"  alt="">
		<p class="financial_marketplace">Финансовый маркетплейс</p>
	
		<h1>Подбор и сравнение финансовых продуктов </h1>
		<ul class="sections_wrap">
			<li class="sections_item">
				<p>Карты</p>
				
				<div class="section_item_wrap">
					<ul class="sections_list">
						<li data-href="/catalog/karty/kreditnye_karty/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/karty_kreditye_2.svg" alt="">
							</div>
							<a href="/catalog/karty/kreditnye_karty/">Кредитные</a>					
						</li>
						
						<li data-href="/catalog/karty/karty_rassrochki/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/karty_rassrochki_2.svg" alt="">
							</div>
							<a href="/catalog/karty/karty_rassrochki/">Рассрочка</a>
						</li>
						
						<li data-href="/catalog/karty/debetovye_karty/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/karty_debetovye_2.svg" alt="">
							</div>
							<a href="/catalog/karty/debetovye_karty/">Дебетовые</a>
						</li>
					</ul>
				</div>
			</li>
			<li class="sections_item">
				<p>Кредиты</p>
				<div class="section_item_wrap">
					<ul class="sections_list">
						<li data-href="/catalog/kredity/kredity_nalichnymi/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/kredity_nal_2.svg" alt="">
							</div>
							<a href="/catalog/kredity/kredity_nalichnymi/">Наличными</a>
						</li>
						
						<li data-href="/catalog/kredity/zaymy/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/kredity_zaimy_2.svg" alt="">
							</div>
							<a href="/catalog/kredity/zaymy/">Займы</a>
						</li>
						
						<li data-href="/catalog/kredity/ipoteka/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/kredity_ipoteka_2.svg" alt="">
							</div>
							<a href="/catalog/kredity/ipoteka/">Ипотека</a>
						</li>
						
						<li data-href="/catalog/kredity/avtokredity/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/kredity_avto_2.svg" alt="">
							</div>
							<a href="/catalog/kredity/avtokredity/">Автокредиты</a>
						</li>
						
						<li data-href="/catalog/kredity/refinansirovanie/">
							<div class="sections_img">
								<img src="<?=SITE_TEMPLATE_PATH?>/images/sections/kredity_refinans_2.svg" alt="">
							</div>
							<a href="/catalog/kredity/refinansirovanie/">Рефинансирование</a>
						</li>
					</ul>
				</div>
			</li>
			<li class="sections_item">
				<p>
					<a href="/catalog/dlya_biznesa/raschetnye_scheta/">Расчетные счета</a>
				</p>
				<!--<ul class="sections_list">
					<li><a href="/catalog/dlya_biznesa/raschetnye_scheta/">Расчетные счета</a></li>
					<li><a href="/catalog/dlya_biznesa/servisy/">Сервисы</a></li>
				</ul>-->
			</li>
			<li class="sections_item">
				<p>
					<a href="/catalog/kredity/zaymy/">Займы</a>
				</p>
			</li>
            <li class="sections_item">
                <p>
                    <a href="/catalog/kredity/ipoteka/">Ипотека</a>
                </p>
            </li>
            <li class="sections_item">
                <p>
                    <a href="/catalog/kredity/refinansirovanie/">Рефинансирование</a>
                </p>
            </li>
		</ul>
	</div>
	<script>
	$('.sections_item p').click(function(){
		$(this).toggleClass('active').next('.section_item_wrap').slideToggle();
		
	});
	$('[data-href]').click(function (e) {
        e.preventDefault();
       window.location.href = $(this).attr('data-href');
	});
	</script>
	
<?endif;?>