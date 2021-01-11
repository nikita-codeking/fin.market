<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$rsResult = CIBlockSection::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => 35, 'CODE' => $_GET['section_code']), false, $arSelect = array("UF_*"));
if($arResSection = $rsResult -> Fetch()){
    $titleComprSection = $arResSection['UF_NAME_IN_COMPR'];
    $seoComprSection = $arResSection['UF_SEO_TEXT_COMPR'];
}
?>
<?
$APPLICATION->SetTitle($titleComprSection);
?>
<div class="comparisons">

    <div class="comparisons_nav">

        <?if(count($arResult['ITEMS'])>0):?>
        <div class="item-group-c">
            <span></span>
            <!--<div>-->
            <div class="item-c head-comparison">
                <div class="scroll_wrap">
                    <button class="scroll" data-factor="-1">&lt;</button>
                    <button class="scroll" data-factor="1">&gt;</button>
                </div>
                <div class="item-prop-c main">
                    <p>Свойство</p>

                </div>
                <?foreach ($arResult['ITEMS'] as $item):?>
                    <div class="item-prod-c" id="<?=$item['ID']?>">
                        <div class="prod_name">

                            <div class="prod_img">
                                <a href="<?=$item['DETAIL_PAGE_URL']?>"><img src="<?=$item['PICTURE']?>" alt=""></a>
                            </div>
                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                <div class="prod_desc">
                                    <?=$item['NAME']?>
                                </div>
                            </a>
                        </div>
                        <a class="del" href="/ajax/delete_item_comparison.php?id=<?=$item['ID']?>&session=<?=$arResult['SESSION']?>"></a>


                        <?if(strlen(trim($item['URL']))>0):?>
                            <?
                            if(strpos(trim($item['URL']) ,'admitad') >-1){
                                $referer=trim($item['URL']) . "subid/" .$_COOKIE['utm_source'] ;

                            }else{
                                $referer=trim($item['URL']) ."&sa=".$_COOKIE['utm_source'] ;
                            }
                            ?>
                            <div class="helperBlock_button">
                                <a class="btn btn-default ofo-href desc" onClick="ym('56316898','reachGoal', 'oformit');" target="_blank" href="<?=$referer?>">Оформить</a>
                            </div>
                        <?endif;?>
                    </div>
                <?endforeach;?>
            </div>
            <!--</div>-->
        </div>

        <?//see($arResult['ITEMS'][0]['LIST_PRODUCT'], true);?>
        <div class="btn_wrap">
            <?if(count($arResult['ITEMS'])>0){
                ?><a class="btn btn-default" href="<?=$arResult['ITEMS'][0]['LIST_PRODUCT']?>">Добавить продукты к сравнению</a><?
            }else{
                ?><a class="btn btn-default" href="/catalog/">Добавить продукты к сравнению</a><?
            }?>
            <a class="btn btn-default" href="/ajax/delete_item_comparison.php?&session=<?=$arResult['SESSION']?>">Очистить</a>
            <button class="transform" data-info="Изменить ориентацию таблицы">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
    <div class="wrapper-c">
        <?$group="";?>
        <?foreach ($arResult['PROPERTIES'] as $itemP):?>
            <?
            $pos_point_in_name = strpos($itemP['NAME'], ".");
			//$property_name = substr($itemP["NAME"],$pos_point_in_name);
			$property_name = $itemP["NAME"];
            if($pos_point_in_name>0)
            {
                $group_filters  = substr($itemP["NAME"],0,$pos_point_in_name);
                if($group!=$group_filters)
                {
                    if(strlen($group)!="")
                    {
                        echo '</div></div>';
                    }//if(strlen($group)=="")
                    echo '<div class="item-group-c"><!--<div style="display:block;">--><div class="item_group_c_head">
				<span>'.$group_filters.'</span></div><div class="z">';
                    $group = $group_filters;
                }//if($group!=$group_filters)
            }//if($pos_point_in_name>0)
            ?>

            <div class="item-c prop-comparison <?if($arResult['ITEMS'][0]['PROPERTIES'][$itemP['CODE']]['PROPERTY_TYPE'] == 'L' && $arResult['ITEMS'][0]['PROPERTIES'][$itemP['CODE']]['TYPE_MULTIPLE'] == 'Y' && !is_array($arResult['ITEMS'][0]['PROPERTIES'][$itemP['CODE']]['VALUE'])): echo 'repeat'; elseif($property_name == 'Документы' && strpos($arResult['ITEMS'][0]['LIST_PRODUCT'], 'kreditnye_karty') || strpos($arResult['ITEMS'][0]['LIST_PRODUCT'], 'ipoteka') || strpos($arResult['ITEMS'][0]['LIST_PRODUCT'], 'karty_rassrochki') || strpos($arResult['ITEMS'][0]['LIST_PRODUCT'], 'avtokredity') || strpos($arResult['ITEMS'][0]['LIST_PRODUCT'], 'refinansirovanie') || strpos($arResult['ITEMS'][0]['LIST_PRODUCT'], 'zaymy')): echo 'repeat'; endif;?>">
                <div class="item-prop-c main <?if($arResult['ITEMS'][0]['PROPERTIES'][$itemP['CODE']]['PROPERTY_TYPE'] == 'N'):?>sort <?endif;?>" id="<?=$itemP['CODE'];?>">
                    <div class="arrow-4" data-info="Сортировать по свойству '<?=$property_name;?>'">
                        <!--<span class="arrow-4-left"></span>
                        <span class="arrow-4-right"></span>-->
                        <!--<?=CNext::showIconSvg("comparison big", SITE_TEMPLATE_PATH."/images/svg/Comparison_big_black.svg");?>-->
                        <div class="sort_icon">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                    </div>
                    <span>
                        <?if($arResult['ITEMS'][0]['PROPERTIES'][$itemP['CODE']]['PROPERTY_TYPE'] == 'L' && $arResult['ITEMS'][0]['PROPERTIES'][$itemP['CODE']]['TYPE_MULTIPLE'] == 'Y'):?>
                            <!-- #netwiz->start выведения значений множествееного списка в выпадающий список по клику на название свойства.-->
                                <div class="elementListProperty">
                                <details>
                                <summary><? echo $property_name ?></summary>
                                    <? $property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => 35, "CODE" => $arResult['ITEMS'][0]['PROPERTIES'][$itemP['CODE']]));
                                    while ($enum_fields = $property_enums->Fetch()):?>
                                        <div class="item-c prop-comparison">
                                            <?//see($enum_fields["VALUE"], true);?>
                                            <div class="item-prop-c main" style="margin-left: -49px;"><?=$enum_fields["VALUE"]; ?></div>
                                            <?foreach ($arResult['ITEMS'] as $itemC):?>
                                                <?if(in_array($enum_fields["VALUE"], $itemC['PROPERTIES'][$itemP['CODE']]['VALUE'])):?>
                                                    <div class="item-prod-c kk-tooltip yes"></div>
                                                <?else:?>
                                                    <div class="item-prod-c" style="color: red; font-size: 27px; font-weight: 500">X</div>
                                                <?endif;?>
                                            <?endforeach;?>
                                        </div>
                                    <?endwhile;?>
                                </details>
                            </div>
                        <?else:?>
                            <?echo $property_name;?>
                        <?endif;?>
                        <!-- #netwiz->end список занченй -->
                    </span>
                </div>


                <?foreach ($arResult['ITEMS'] as $itemC):?>
                    <div class="item-prod-c kk-tooltip" id="<?=$itemC['ID']?>">
                        <?//see($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'], true);?>
                        <?php if(intval($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']) > 999):?>
                            <?//php $price = CCurrencyLang::CurrencyFormat(intval($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']),'RUB',true);?>
                            <?/*php $price = explode(" ", $price);?>
							<?php $count = count($price) - 2;?>
							<?php
								if($price[$count] = "000") {
									$price[$count] = 'тыс.';
								}?>
							<?php $price = implode(" ", $price);*/?>
						<?php
								$itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = preg_replace("/[^0-9]+/","",$itemC['PROPERTIES'][$itemP['CODE']]['VALUE']);
								//$itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = trim($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'], " ");
								//$itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = explode("&emsp;",$itemC['PROPERTIES'][$itemP['CODE']]['VALUE']);
								//$itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = implode("",$itemC['PROPERTIES'][$itemP['CODE']]['VALUE']);?>
						<?$price = formatToHuman($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'])?>
						<?=$price . ' ' . $itemC['PROPERTIES'][$itemP['CODE']]['VALUE_DESCRIPTION'];?>
                        <?/*
                            выведение занчения для свойства сроков кредита.
                         */?>
                        <?elseif($itemC['PROPERTIES'][$itemP['CODE']]['CODE'] == 'USLOVIYA_SROK_KREDITA_LET'):?>
						<?echo $itemC['PROPERTIES'][$itemP['CODE']]['VALUE'], ' ', declension($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'], array('год', 'года', 'лет'));?>

                        <?elseif($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] == 'Да'):?>
                            <?echo 'Да';?>
                        <?elseif($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] == 'Нет'):?>
                            <?echo 'Нет';?>

                        <?php else: ?>
                            <!-- #netwiz->start Вывод значений свойств для каждого продкута, проверка есть в ли два значение для свойства что бы вывоить "от " и "до".-->
                            <?if(isset($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'])) {
                                if(is_array ($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'])){
                                    if($itemC['PROPERTIES'][$itemP['CODE']]['VALUE_DESCRIPTION'] == '%'){
                                        $a  = $itemC['PROPERTIES'][$itemP['CODE']]['VALUE']['0'];
                                        $itemC['PROPERTIES'][$itemP['CODE']]['VALUE']['0'] = $itemC['PROPERTIES'][$itemP['CODE']]['VALUE']['1'];
                                        $itemC['PROPERTIES'][$itemP['CODE']]['VALUE']['1'] = $a;
										echo  ' ' . round($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']['1']) . ' ' .  '-' . ' '. round($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']['0']) . ' ' . $itemC['PROPERTIES'][$itemP['CODE']]['VALUE_DESCRIPTION'];
                                    }
                                    else{
                                        echo ' ';
                                    }

                                }else{

                                    if(trim($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']) =="Любой"){
                                        echo "Да";
                                    }else{
                                        if($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']==0)
                                        {
                                            echo $itemC['PROPERTIES'][$itemP['CODE']]['VALUE']. '  ' . $itemC['PROPERTIES'][$itemP['CODE']]['VALUE_DESCRIPTION'];
                                        }
                                        else
                                        {

                                            if(is_int($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'])){

                                                $itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = preg_replace("/[^0-9]+/","",$itemC['PROPERTIES'][$itemP['CODE']]['VALUE']);
                                                //$itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = trim($itemC['PROPERTIES'][$itemP['CODE']]['VALUE'], " ");
                                                //$itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = explode("&emsp;",$itemC['PROPERTIES'][$itemP['CODE']]['VALUE']);
                                                //$itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] = implode("",$itemC['PROPERTIES'][$itemP['CODE']]['VALUE']);

                                                echo formatToHuman($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']) . '  ' . $itemC['PROPERTIES'][$itemP['CODE']]['VALUE_DESCRIPTION'];
                                            }
                                            else{

                                                if($itemC['PROPERTIES'][$itemP['CODE']]['CODE'] == 'TREBOVANIYA_OBSHCHIY_STAZH_RABOTY_LET' && $itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] == 1){
                                                    echo '12' . ' ' . 'мес.';
                                                }
                                                elseif ($itemC['PROPERTIES'][$itemP['CODE']]['CODE'] == 'TREBOVANIYA_OBSHCHIY_STAZH_RABOTY_LET' && $itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] != 1){
                                                    echo $itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] . ' '. 'мес.';
                                                }
                                                else {
                                                    echo $itemC['PROPERTIES'][$itemP['CODE']]['VALUE'] . '  ' . $itemC['PROPERTIES'][$itemP['CODE']]['VALUE_DESCRIPTION'];
                                                }
                                            }

                                        }//if($itemC['PROPERTIES'][$itemP['CODE']]['VALUE']==0)

                                    }
                                }

                            }
                            else{?>
                                <div class="null_valueCompr"><?echo 'X';?></div>
                            <?}

                            ?>
                            <!-- #netwiz->end Вывод значений свойств для каждого продкута-->
                        <?php endif; ?>
                        <?if(strlen($itemC['PROPERTIES'][$itemP['CODE']]['DESCRIPTION']) > 0):?>
                            <span data-info="<?=$itemC['PROPERTIES'][$itemP['CODE']]['DESCRIPTION']?>">?</span>
                        <?endif;?>
                    </div>

                <?endforeach;?>

            </div>
        <?endforeach;?>
        <?
        if(strlen($group)!="")
        {
            echo '</div></div><!--</div>-->';
        }//if(strlen($group)=="")
        ?>
        <?else:?>
            <script>
                location.href = "/catalog/?param=add";
            </script>
            <h2>Нет товаров для сравнения</h2>
        <?endif;?>
    </div>
</div>

<h2><?echo $seoComprSection;?></h2>

<script>

    var box = $('.comparisons .wrapper-c');
    /*  var boxx = $('.comparisons_nav .head-comparison'); */
    var boxx = $('.comparisons_nav .item-group-c');

    $('.scroll').on('click', function(){
        if( $('.comparisons').hasClass('tab_transform')){
            var distance = $(".tab_transform .prop-comparison").innerWidth();
        }else{
            var distance = $(".item-prod-c").innerWidth();
        }
        box.stop().animate({
            scrollLeft: '+=' + (distance * $(this).data('factor'))
        });

        boxx.stop().animate({
            scrollLeft: '+=' + (distance * $(this).data('factor'))
        });
    });

    box.scroll(function () {
        boxx.scrollLeft(box.scrollLeft());
    });
    boxx.scroll(function () {
        box.scrollLeft(boxx.scrollLeft());
    });
</script>
<script>	
		$('.comparisons:not(.tab_transform) .item_group_c_head').click(function(){
			$(this).toggleClass('active').next('div').slideToggle();		
		});		
</script>
<script>
    var marks = document.querySelectorAll('.item-prod-c');

    for (let mark of marks) {
        if(mark.textContent.includes('Да')|| mark.textContent.includes(' да ')){
            mark.classList.add('yes');
            //mark.style.paddingLeft = '22px'
            mark.textContent = " ";
        }
        if(mark.textContent.includes('Нет') || mark.textContent.includes(' нет ')){
            mark.classList.add('no');
            //mark.style.paddingLeft = '22px'
            mark.textContent = " ";
        }
    };

    $(window).on('scroll',function(){
        var scrollPosition = window.scrollY;
        var tableHeaderPosition =  $('.wrapper-c').offset().top;
        var tableHeader = $('.comparisons:not(.tab_transform) .wrapper-c .item-group-c:nth-child(1) .head-comparison');
        /* var tableFirstRow = $('.comparisons .wrapper-c .prop-comparison:nth-of-type(2)'); */
        var tableHeaderImg = $('.comparisons:not(.tab_transform) .item-group-c:nth-child(1) .prod_img');

        if(scrollPosition>=tableHeaderPosition - 200){
            /* tableHeader.attr("style","position: fixed; top:0px;min-width: 565px; max-width: 1110px;overflow: hidden;");
            tableFirstRow.attr("style","margin-top: 140px;"); */
            //tableHeaderImg.attr("style","display: none;");
            tableHeaderImg.slideUp(600);
        }else{
            /* tableHeader.removeAttr("style");
            tableFirstRow.removeAttr("style"); */
            //tableHeaderImg.removeAttr("style");
            tableHeaderImg.slideDown(600);
        }
    });

    $(".item-prop-c").click(function(){
        var thisProperty = $(this);
        var thisPropertyCod = $(this).attr('id');

        var distance = 10000;
        var box = $('.comparisons:not(.tab_transform) .wrapper-c');
        var boxx = $('.comparisons:not(.tab_transform) .comparisons_nav .item-group-c .head-comparison');

        if(thisProperty.hasClass('sort')){
            if(thisProperty.hasClass('increase')){
                sort = "desc";
                thisProperty.removeClass('increase');
            }else {
                sort = "asc";
                thisProperty.addClass('increase');
            }
            $.ajax({
                type: "POST",
                url: "/ajax/sortCompression.php",
                data: "code="+thisPropertyCod + "&sort=" + sort,
                success:function (data) {//возвращаемый результат от сервера
                    arr = data.split('|');
                    $.each(arr, function( key, value ) {
                        //движение шапки
                        $('.head-comparison .main').after($('.head-comparison #' + value));
                        //движение свойств
                        $('.prop-comparison').each(function () {
                            $(this).children('.main').after($(this).children('#' + value));
                        });
                    });
                    /* if(thisProperty.hasClass('row_up')){					thisProperty.removeClass('row_up').addClass('row_down');
                    } */
                }
            });
            thisProperty.parent().siblings().children(".item-prop-c").removeClass('increase');
            $(".item-prop-c").removeClass('active');
            $(".item-prop-c").parent().removeClass('active_row');
            thisProperty.addClass('active');
            thisProperty.parent().addClass('active_row');

            box.scrollLeft(-distance);
            boxx.scrollLeft(-distance);
        }
    });

	var beda = $('.item-group-c');
	var block_width = $(".item-c.prop-comparison").innerWidth();						
	beda.attr("style","width:" + block_width + "px;");
    $(".comparisons_nav .transform").click(function(){
        $('.comparisons').toggleClass('tab_transform');		
		/* if( $('.comparisons').hasClass('tab_transform')){
			var block_width = $(".item-c.prop-comparison").innerWidth();						
			beda.attr("style","width:" + block_width + "px;");
        }else{
            beda.attr("style","width:220px;");
        } */
    });
</script>
