<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="admitad_wrapper <?=$arParams['PREFICS'];?>">
    <div class="admitad_slider">
        <?php
        //получим количество баннеров
        $arBanners = Array();
        for ($i = 1; $i <= 5; $i++) {
            if(!empty($arParams["BANNER".strval($i)])){
                $arBanners[] = $arParams["BANNER".strval($i)];
            }
        }
        ?>
        <div class="count_slides"><?=count($arBanners);?></div>
        <?
        $count = 1;
        foreach ($arBanners as $itemBanner):
        ?>
            <div class="item_m sl_<?=$count;?>" <?if($count>1):?>style="display: none;"<?endif;?>>
                <?=htmlspecialchars_decode($itemBanner);?>
            </div>
            <?$count++;?>
        <?endforeach;?>
    </div>
    <div class="admitad_slider_mobile" style="display: none;">
        <?php
        //получим количество баннеров
        $arBanners = Array();
        for ($i = 1; $i <= 5; $i++) {
            if(!empty($arParams["BANNER_MOBILE".strval($i)])){
                $arBanners[] = $arParams["BANNER_MOBILE".strval($i)];
            }
        }
        ?>
        <div class="count_slides"><?=count($arBanners);?></div>
        <?
        $count = 1;
        foreach ($arBanners as $itemBanner):
            ?>
            <div class="item_m sl_<?=$count;?>" <?if($count>1):?>style="display: none;"<?endif;?>>
                <?=htmlspecialchars_decode($itemBanner);?>
            </div>
            <?$count++;?>
        <?endforeach;?>
    </div>
</div>
<script>
    $(document).ready(function() {
        if($(window).width()<<?=$arParams['WIDTH_START_MOBILE'];?>){
            $('.admitad_slider_mobile').removeAttr("style");
            $('.admitad_slider').attr("style","display:none;");

            heightBanner = ($('#main').width()-30)*<?=$arParams['HEIGHT_BANNER_MOBILE'];?>/<?=$arParams['WIDTH_BANNER_MOBILE'];?>;
            $('.admitad_wrapper.<?= $arParams["PREFICS"];?>').attr("style","height:"+ heightBanner + "px;");

            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider_mobile .item_m>div>div').css({"height":"auto"});
            },500);
            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider_mobile .item_m>div>div').css({"height":"auto"});
            },1000);
            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider_mobile .item_m>div>div').css({"height":"auto"});
            },1500);
            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider_mobile .item_m>div>div').css({"height":"auto"});
                countSlideBanner<?=$arParams["PREFICS"];?> = +$('.admitad_wrapper.<?= $arParams["PREFICS"];?> .admitad_slider_mobile .count_slides').html();

                setInterval(function(){
                    for(i = 1; i <= countSlideBanner<?=$arParams["PREFICS"];?>; i++) {
                        $('.admitad_wrapper.<?=$arParams["PREFICS"];?>  .admitad_slider_mobile .item_m.sl_' + String(i)).fadeOut(300);
                    }
                    countSlideBanner<?=$arParams["PREFICS"];?>++;
                    if(countSlideBanner<?=$arParams["PREFICS"];?>><?=count($arBanners);?>){
                        countSlideBanner<?=$arParams["PREFICS"];?> = 1;
                    }
                    setTimeout(function () {
                        $('.admitad_wrapper.<?=$arParams["PREFICS"];?>  .admitad_slider_mobile .item_m.sl_' + String(countSlideBanner<?=$arParams["PREFICS"];?>)).fadeIn(600);
                    },300);
                },5000);
            },2000);

        }else{
            heightBanner = $('#footer .maxwidth-theme').width()*<?=$arParams['HEIGHT_BANNER'];?>/<?=$arParams['WIDTH_BANNER'];?>;
            $('.admitad_wrapper.<?= $arParams["PREFICS"];?>').attr("style","height:"+ heightBanner + "px;");

            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider .item_m>div>div').css({"height":"auto"});
            },500);
            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider .item_m>div>div').css({"height":"auto"});
            },1000);
            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider .item_m>div>div').css({"height":"auto"});
            },1500);
            setTimeout(function () {
                $('.admitad_wrapper.<?=$arParams["PREFICS"];?> .admitad_slider .item_m>div>div').css({"height":"auto"});
                countSlideBanner<?=$arParams["PREFICS"];?> = +$('.admitad_wrapper.<?= $arParams["PREFICS"];?> .admitad_slider .count_slides').html();

                setInterval(function(){
                    for(i = 1; i <= countSlideBanner<?=$arParams["PREFICS"];?>; i++) {
                        $('.admitad_wrapper.<?=$arParams["PREFICS"];?>  .admitad_slider .item_m.sl_' + String(i)).fadeOut(300);
                    }
                    countSlideBanner<?=$arParams["PREFICS"];?>++;
                    if(countSlideBanner<?=$arParams["PREFICS"];?>><?=count($arBanners);?>){
                        countSlideBanner<?=$arParams["PREFICS"];?> = 1;
                    }
                    setTimeout(function () {
                        $('.admitad_wrapper.<?=$arParams["PREFICS"];?>  .admitad_slider .item_m.sl_' + String(countSlideBanner<?=$arParams["PREFICS"];?>)).fadeIn(600);
                    },300);
                },5000);
            },2000);
        }


    });
</script>