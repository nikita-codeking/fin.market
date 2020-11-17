<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?//php see($arResult["FIELDS"]["CREATED_BY"]);?>
<?// shot top banners start?>
<?
$bShowTopBanner = (isset($arResult['SECTION_BNR_CONTENT'] ) && $arResult['SECTION_BNR_CONTENT'] == true);
?>
<?if($bShowTopBanner):?>
	<?$this->SetViewTarget("section_bnr_content");?>
		<?CNext::ShowTopDetailBanner($arResult, $arParams);?>
	<?$this->EndViewTarget();?>
<?endif;?>
<?// shot top banners end?>



<?// element name?>
<?if($arParams['DISPLAY_NAME'] != 'N' && strlen($arResult['NAME'])):?>
	<h2><?=$arResult['NAME']?></h2>
<?endif;?>

<?// date active from or dates period active?>
<?if(strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']) || ($arResult['DISPLAY_ACTIVE_FROM'] && in_array('DATE_ACTIVE_FROM', $arParams['FIELD_CODE']))):?>
	<div class="period-wrapper">
		<div class="period">
			<?if(strlen($arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE'])):?>
				<span class="date"><?=$arResult['DISPLAY_PROPERTIES']['PERIOD']['VALUE']?></span>
			<?else:?>
				<span class="date"><?=$arResult['DISPLAY_ACTIVE_FROM']?></span>
			<?endif;?>
		</div>
		<?if($arResult['SECTIONS']):
			$arResult['SECTIONS']= current($arResult['SECTIONS']);?>
			<span class="section_name">
				//&nbsp;<?=$arResult['SECTIONS']['NAME']?>
			</span>
		<?endif;?>
	</div>
<?endif;?>

<?// single detail image?>
<?if($arResult['FIELDS']['DETAIL_PICTURE']):?>
	<?
	$atrTitle = (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['TITLE']) ? $arResult['DETAIL_PICTURE']['TITLE'] : $arResult['NAME']));
	$atrAlt = (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['ALT']) ? $arResult['DETAIL_PICTURE']['ALT'] : $arResult['NAME']));
	?>
	<?if($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] == 'LEFT'):?>
		<div class="detailimage image-left col-md-4 col-sm-4 col-xs-12"><a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="fancybox"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" alt="<?=$atrAlt?>" /></a></div>
	<?elseif($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] == 'RIGHT'):?>
		<div class="detailimage image-right col-md-4 col-sm-4 col-xs-12"><a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="fancybox""><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" alt="<?=$atrAlt?>" /></a></div>
	<?elseif($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] == 'TOP'):?>
		<script type="text/javascript">
		$(document).ready(function() {
			$('section.page-top').remove();
			$('<div class="row"><div class="col-md-12"><div class="detailimage image-head"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" alt="<?=$atrAlt?>"/></div></div></div>').insertBefore('.body > .main > .container > .row');
		});
		</script>
	<?else:?>
		<div class="detailimage image-wide"><a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="fancybox""><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="img-responsive" alt="<?=$atrAlt?>" /></a></div>
	<?endif;?>
<?endif;?>
<?// отобразить пользователя?>
<?if($arResult["USER"]["ID"] != 1):?>
<div class="detail-user-info">
    <?if($arResult["USER"]["PERSONAL_ICQ"]):?>
        <?if($arResult["USER"]["PERSONAL_PHOTO"]):?>
            <a href="<?=$arResult["USER"]["PERSONAL_ICQ"]?>"  class="detail-user-image">
                <img src="<?=$arResult["USER"]["PERSONAL_PHOTO"]?>" alt="">
            </a>
        <?endif;?>
    <div class="detail-user-links">
        <a href="<?=$arResult["USER"]["PERSONAL_ICQ"]?>" class="detail-user-name"><?=$arResult["USER"]["NAME"]?> <?=$arResult["USER"]["LAST_NAME"]?></a>
        <a href="<?=$arResult["USER"]["PERSONAL_ICQ"]?>" class="detail-user-social detail-user-instagram"><?=$arResult["USER"]["XML_ID"]?></a>
    </div>
    <?else:?>
        <?if($arResult["USER"]["PERSONAL_PHOTO"]):?>
            <div class="detail-user-image">
                <img src="<?=$arResult["USER"]["PERSONAL_PHOTO"]?>" alt="">
            </div>
        <?endif;?>
        <div class="detail-user-name"><?=$arResult["USER"]["NAME"]?> <?=$arResult["USER"]["LAST_NAME"]?></div>
    <?endif;?>
</div>
<?endif;?>
<?// ask question?>
<?if($arResult['DISPLAY_PROPERTIES']['FORM_QUESTION']['VALUE_XML_ID'] == 'YES'):?>
	<?$this->SetViewTarget('under_sidebar_content');?>
		
	<?$this->EndViewTarget();?>
<?endif;?>

<?if(!$bShowTopBanner && strlen($arResult['FIELDS']['PREVIEW_TEXT'])):?>
	<div class="preview-text-detail">
		<?if($arResult['PREVIEW_TEXT_TYPE'] == 'text'):?>
			<p><?=$arResult['FIELDS']['PREVIEW_TEXT'];?></p>
		<?else:?>
			<?=$arResult['FIELDS']['PREVIEW_TEXT'];?>
		<?endif;?>
		<hr class="colored_line">
	</div>
<?endif;?>

<?//#netwiz start - вывод детальной статьи сторис?>
<?if(strlen($arResult['FIELDS']['DETAIL_TEXT'])):?>
	<div class="content">
        <div class="elementsBannersSravni">
            <?
            //see($_GET['width']);
            if(isset($arResult['PROPERTIES']['SECTIONS_INCLUDE']['VALUE']))
            {

                $trimStrBannerSravni = implode('|', $arResult['ELEMENT_BANNER_ID']);
                ?><a class="mobileBnnerSravni" href="/catalog/comparisons/?products=<?=$trimStrBannerSravni;?>"><?
                echo $arResult['BANNER_MOBILE'][0]['DETAIL_TEXT'];
                ?></a><?


                ?><a class="desctopBnnerSravni" href="/catalog/comparisons/?products=<?=$trimStrBannerSravni;?>"><?
                echo $arResult['BANNER_DESK'][0]['DETAIL_TEXT'];
                ?></a><?
                //foreach ($arResult['PROPERTIES']['SECTIONS_INCLUDE']['VALUE'] as $itemV)
            }//if(isset($arResult['PROPERTIES']['SECTIONS_INCLUDE']['VALUE']))

            ?>
        </div>
		<?if(strlen($arResult['FIELDS']['DETAIL_TEXT'])):?>
			<?if($arResult['DETAIL_TEXT_TYPE'] == 'text'):?>
				<p><?=$arResult['FIELDS']['DETAIL_TEXT'];?></p>
			<?else:?>
				<?=$arResult['FIELDS']['DETAIL_TEXT'];?>
			<?endif;?>
		<?endif;?>
	</div>
<?endif;?>
<?//#netwiz end - вывод детальной статьи сторис?>

<?// gallery?>
<?if($arResult['GALLERY']):?>
	<div class="wraps galerys-block with-padding">
		<hr/>		
		<h5><?=(strlen($arParams['T_GALLERY']) ? $arParams['T_GALLERY'] : Loc::getMessage('T_GALLERY'))?></h5>
		<?if($arParams['GALLERY_TYPE'] == 'small'):?>
			<div class="small-gallery-block">
				<div class="flexslider unstyled front border small_slider custom_flex top_right color-controls" data-plugin-options='{"animation": "slide", "useCSS": true, "directionNav": true, "controlNav" :true, "animationLoop": true, "slideshow": false, "counts": [4, 3, 2, 1]}'>
					<ul class="slides items">
						<?foreach($arResult['GALLERY'] as $i => $arPhoto):?>
							<li class="col-md-3 item visible">
								<div>
									<img src="<?=$arPhoto['PREVIEW']['src']?>" class="img-responsive inline" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
								</div>
								<a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy dark_block_animate" rel="gallery" target="_blank" title="<?=$arPhoto['TITLE']?>"></a>
							</li>
						<?endforeach;?>
					</ul>
				</div>
			</div>
		<?else:?>
			<div class="gallery-block">
				<div class="gallery-wrapper">
					<div class="inner">
						<?if(count($arResult["GALLERY"]) > 1):?>
							<div class="small-gallery-wrapper">
								<div class="flexslider unstyled small-gallery center-nav" data-plugin-options='{"slideshow": false, "useCSS": true, "animation": "slide", "animationLoop": true, "itemWidth": 60, "itemMargin": 20, "minItems": 1, "maxItems": 9, "slide_counts": 1, "asNavFor": ".gallery-wrapper .bigs"}' id="carousel1">
									<ul class="slides items">	
										<?foreach($arResult["GALLERY"] as $arPhoto):?>
											<li class="item">
												<img class="img-responsive inline" border="0" src="<?=$arPhoto["THUMB"]["src"]?>" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
											</li>
										<?endforeach;?>
									</ul>
								</div>
							</div>
						<?endif;?>
						<div class="flexslider big_slider dark bigs color-controls" id="slider" data-plugin-options='{"animation": "slide", "useCSS": true, "directionNav": true, "controlNav" :true, "animationLoop": true, "slideshow": false, "sync": ".gallery-wrapper .small-gallery", "counts": [1, 1, 1]}'>
							<ul class="slides items">
								<?foreach($arResult['GALLERY'] as $i => $arPhoto):?>
									<li class="col-md-12 item">
										<a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy" rel="gallery" target="_blank" title="<?=$arPhoto['TITLE']?>">
											<img src="<?=$arPhoto['PREVIEW']['src']?>" class="img-responsive inline" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
											<span class="zoom"></span>
										</a>
									</li>
								<?endforeach;?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		<?endif;?>
	</div>
<?endif;?>

<?
$frame = $this->createFrame('video')->begin('');
$frame->setAnimation(true);
?>
<?// video?>
<?if($arResult['VIDEO']):?>
	<div class="wraps">
		<hr />
		<h5><?=(strlen($arParams['T_VIDEO']) ? $arParams['T_VIDEO'] : Loc::getMessage('T_VIDEO'))?></h5>
		<div class="row video">
			<?foreach($arResult['VIDEO'] as $i => $arVideo):?>
				<div class="col-md-6 item">
					<div class="video_body">
						<video id="js-video_<?=$i?>" width="350" height="217"  class="video-js" controls="controls" preload="metadata" data-setup="{}">
							<source src="<?=$arVideo["path"]?>" type='video/mp4' />
							<p class="vjs-no-js">
								To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
							</p>
						</video>
					</div>
					<div class="title"><?=(strlen($arVideo["title"]) ? $arVideo["title"] : $i)?></div>
				</div>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>
<?$frame->end();?>
<?if($arResult['TAGS']):?>
	<?$this->SetViewTarget('tags_content');?>
		<div class="search-tags-cloud">
			<div class="title-block-middle"><?=Loc::getMessage('TAGS');?></div>
			<div class="tags banner-selection">
				<?$arTags = explode(",", $arResult['TAGS']);?>
				<?foreach($arTags as $text):?>
					<a href="<?=SITE_DIR;?>search/index.php?tags=<?=htmlspecialcharsex($text);?>" rel="nofollow"><?=$text;?></a>
				<?endforeach;?>
			</div>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>
<script>
    function kk_add_to_comparisons(id,session){
        $.ajax({
            type:'post',//тип запроса: get,post либо head
            url:'/ajax/add_item_copmparison.php',//url адрес файла обработчика
            data:"session="+session+"&id=" + id,//параметры запроса
            response:'text',//тип возвращаемого ответа text либо xml
            success:function (data) {//возвращаемый результат от сервера
                //location.href = '/basket/';
                console.log(data);
            }
        });
        setTimeout(function () {
            $.ajax({
                type: "POST",
                url: "/ajax/addIconComprCheck.php",
                success: function (data) {//возвращаемый результат от сервера
                    $('.link_compare_icon').html(data);
                }
            });
        },1000);

    }

    $(document).ready(function() {
        $('.desctopBnnerSravni').click(function (e) {
            e.preventDefault();

            var arrayOfStrings1 = $('.elementsBannersSravni').text().split("|");
            $.each(arrayOfStrings1,function(index,value){
                kk_add_to_comparisons(value,'<?=session_id();?>')
            });
            location.href = "/catalog/comparisons/";
        });
    });


    viewBanner();
    $(window).resize(function(){
        viewBanner();
    });
    function viewBanner()
    {
        if ($(window).width() <= '500'){
            $('.mobileBnnerSravni').show();
            $('.desctopBnnerSravni').hide();
        }
        else{
            $('.desctopBnnerSravni').show();
            $('.mobileBnnerSravni').hide();
        }
    }
</script>