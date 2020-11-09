<?foreach( $arResult["SECTIONS"] as $code => $arItems ):?>
    <?$APPLICATION->IncludeComponent(
        "fm:admitad.banners",
        ".default",
        array(
            "COMPONENT_TEMPLATE" => ".default",
            "BANNER1" => $banners[$counter][0],
            "BANNER2" => $banners[$counter][1],
            "BANNER3" => $banners[$counter][2],
            "BANNER4" => "",
            "BANNER5" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "PREFICS" => "ref_banner".$ii,
            "HEIGHT_BANNER" => "180",
            "WIDTH_BANNER" => "930",
            "HEIGHT_BANNER_MOBILE" => "300",
            "WIDTH_BANNER_MOBILE" => "300",
            "WIDTH_START_MOBILE" => "767",
            "BANNER_MOBILE1" => $banners[$counter][3],
            "BANNER_MOBILE2" => $banners[$counter][4],
            "BANNER_MOBILE3" => $banners[$counter][5],
            "BANNER_MOBILE4" => "",
            "BANNER_MOBILE5" => "",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO"
        ),
        false,
        array(
            "ACTIVE_COMPONENT" => "N"
        )
    );
    $counter++;?>
    <div class="tab_slider_wrapp specials <?=$class_block;?> best_block clearfix" itemscope itemtype="http://schema.org/WebPage">
        <?$arParams['SET_TITLE'] = 'N';?>
        <span class='request-data' data-value='<?//=$arParamsTmp?>'></span>
        <script>
            $('.wide_N').removeClass('wide_N').addClass('wide_Y');
        </script>
        <style>
            .catalog_page .header_wrap, .catalog_page #mobileheader:not(.fixed) .mobileheader-v1 {
                background-color: white;
            }
        </style>
        <div class="top_blocks">
            <h3 class="title_block"><a href="<?=$arItems["SECTION_PAGE_URL"];?>"><?=$arItems["NAME"];?></a></h3>
            <!--<a href="<?/*=$arItems["SECTION_PAGE_URL"];*/?>"><?/*=GetMessage("VIEW_ALL");*/?></a>-->
        </div>
        <ul class="tabs_content">
            <?$j=1;?>
            <li class="tab <?=$code?>_wrapp <?=($j == 1 ? "cur opacity1" : "");?>" data-code="<?=$code?>" data-col="<?=$col;?>" data-filter="<?//=($arTab["FILTER"] ? urlencode(serialize($arTab["FILTER"])) : '');?>">
                <div class="tabs_slider <?=$code?>_slides wr">
                    <div class="top_wrapper items_wrapper">
                        <div class="catalog_block items row margin0 ajax_load block">
                            <?foreach($arItems["SECTIONS"] as $code => $arItem){?>
                                <?if($arItem["NAME"]=="Сервисы"){continue;}?>
                                <div class="catalog_item_wrapp col-m-12 col-lg-3 col-md-4 col-sm-6 item item_block " data-col="3">
                                    <div class="catalog_item item_wrap main_item_wrapper" id="" >
                                        <div class="inner_wrap">
                                            <div class="image_wrapper_block">
                                                <a href="<?=$arItem["SECTION_PAGE_URL"];?>" class="thumb shine" title="<?=$arItem["ID"]?>">
                                                    <?
                                                    $class_grey = "";
                                                    if($arItem["NAME"]=="Сервисы")
                                                    {
                                                        $class_grey = "no_prop";
                                                    }//if(in_array($arItem['ID'],$arResult['HAVE_PROPERTY']))
                                                    ?>
                                                    <?if(isset($arResult['PICTURES'][$arItem['ID']])):?>
                                                        <img lazyload="" class="noborder lazyloaded <?=$class_grey?> section-comp" src="<?=$arResult['PICTURES'][$arItem['ID']];?>" data-src="<?=$arResult['PICTURES'][$arItem['ID']];?>" alt="<?=$arItem["NAME"];?>" title="<?=$arItem["NAME"];?>">
                                                    <?else:?>
                                                        <img lazyload="" class="noborder lazyloaded <?=$class_grey?> section-comp" src="<?=$arItem["PICTURE"]["SRC"];?>" data-src="<?=$arItem["PICTURE"]["SRC"];?>" alt="<?=$arItem["NAME"];?>" title="<?=$arItem["NAME"];?>">
                                                    <?endif;?>

                                                </a>
                                            </div>
                                            <div class="item_info TYPE_1" style="height: 50px;display: none">
                                                <div class="item-title" style="height: 40px;">
                                                    <a href="<?=$arItem["SECTION_PAGE_URL"];?>" class="dark_link"><span><?=$arItem["NAME"];?></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
<?endforeach;?>
<?$APPLICATION->IncludeComponent(
    "fm:admitad.banners",
    ".default",
    array(
        "COMPONENT_TEMPLATE" => ".default",
        "BANNER1" => "<script type='text/javascript'>(function() {
			  /* Optional settings (these lines can be removed): */ 
			   subID = \"123\";  // - local banner key;
			   injectTo = \"\";  // - #id of html element (ex., \"top-banner\").
			  /* End settings block */ 
			
			if(injectTo==\"\")injectTo=\"admitad_shuffle\"+subID+Math.round(Math.random()*100000000);
			if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
			document.write('<div id=\"'+injectTo+'\"></div>');
			var s = document.createElement('script');
			s.type = 'text/javascript'; s.async = true;
			s.src = 'https://ad.admitad.com/shuffle/a22c8e67dc/'+subid_block+'?inject_to='+injectTo;
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
			})();</script>",
        "BANNER2" => "<script type='text/javascript'>(function() {
			  /* Optional settings (these lines can be removed): */ 
			   subID = \"123\";  // - local banner key;
			   injectTo = \"\";  // - #id of html element (ex., \"top-banner\").
			  /* End settings block */ 
			
			if(injectTo==\"\")injectTo=\"admitad_shuffle\"+subID+Math.round(Math.random()*100000000);
			if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
			document.write('<div id=\"'+injectTo+'\"></div>');
			var s = document.createElement('script');
			s.type = 'text/javascript'; s.async = true;
			s.src = 'https://ad.admitad.com/shuffle/0342faf7ae/'+subid_block+'?inject_to='+injectTo;
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
			})();</script>",
        "BANNER3" => "<script type='text/javascript'>(function() {
			  /* Optional settings (these lines can be removed): */ 
			   subID = \"123\";  // - local banner key;
			   injectTo = \"\";  // - #id of html element (ex., \"top-banner\").
			  /* End settings block */ 
			
			if(injectTo==\"\")injectTo=\"admitad_shuffle\"+subID+Math.round(Math.random()*100000000);
			if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
			document.write('<div id=\"'+injectTo+'\"></div>');
			var s = document.createElement('script');
			s.type = 'text/javascript'; s.async = true;
			s.src = 'https://ad.admitad.com/shuffle/20d134a813/'+subid_block+'?inject_to='+injectTo;
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
			})();</script>",
        "BANNER4" => "",
        "BANNER5" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "PREFICS" => "ref_banner",
        "HEIGHT_BANNER" => "180",
        "WIDTH_BANNER" => "930",
        "HEIGHT_BANNER_MOBILE" => "300",
        "WIDTH_BANNER_MOBILE" => "300",
        "WIDTH_START_MOBILE" => "767",
        "BANNER_MOBILE1" => "<script type='text/javascript'>(function() {
			  /* Optional settings (these lines can be removed): */ 
			   subID = \"123\";  // - local banner key;
			   injectTo = \"\";  // - #id of html element (ex., \"top-banner\").
			  /* End settings block */ 
			
			if(injectTo==\"\")injectTo=\"admitad_shuffle\"+subID+Math.round(Math.random()*100000000);
			if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
			document.write('<div id=\"'+injectTo+'\"></div>');
			var s = document.createElement('script');
			s.type = 'text/javascript'; s.async = true;
			s.src = 'https://ad.admitad.com/shuffle/ff36d77af2/'+subid_block+'?inject_to='+injectTo;
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
			})();</script>",
        "BANNER_MOBILE2" => "<script type='text/javascript'>(function() {
			  /* Optional settings (these lines can be removed): */ 
			   subID = \"123\";  // - local banner key;
			   injectTo = \"\";  // - #id of html element (ex., \"top-banner\").
			  /* End settings block */ 
			
			if(injectTo==\"\")injectTo=\"admitad_shuffle\"+subID+Math.round(Math.random()*100000000);
			if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
			document.write('<div id=\"'+injectTo+'\"></div>');
			var s = document.createElement('script');
			s.type = 'text/javascript'; s.async = true;
			s.src = 'https://ad.admitad.com/shuffle/f0e3cfb88e/'+subid_block+'?inject_to='+injectTo;
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
			})();</script>",
        "BANNER_MOBILE3" => "<script type='text/javascript'>(function() {
			  /* Optional settings (these lines can be removed): */ 
			   subID = \"123\";  // - local banner key;
			   injectTo = \"\";  // - #id of html element (ex., \"top-banner\").
			  /* End settings block */ 
			
			if(injectTo==\"\")injectTo=\"admitad_shuffle\"+subID+Math.round(Math.random()*100000000);
			if(subID=='')subid_block=''; else subid_block='subid/'+subID+'/';
			document.write('<div id=\"'+injectTo+'\"></div>');
			var s = document.createElement('script');
			s.type = 'text/javascript'; s.async = true;
			s.src = 'https://ad.admitad.com/shuffle/38f17aca92/'+subid_block+'?inject_to='+injectTo;
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
			})();</script>",
        "BANNER_MOBILE4" => "",
        "BANNER_MOBILE5" => "",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO"
    ),
    false,
    array(
        "ACTIVE_COMPONENT" => "N"
    )
);?>
