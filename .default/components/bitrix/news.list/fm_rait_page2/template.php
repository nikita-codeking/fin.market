<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<div id="ajax-cont">
<div class="catalog item-views list big-img <?=($arParams["IMAGE_POSITION"] ? "image_".$arParams["IMAGE_POSITION"] : "")?> <?=$templateName;?>">
    <?// top pagination?>
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>

    <?if($arResult["SECTIONS"]):?>

        <div class="items row">
            <?foreach($arResult["SECTIONS"] as $i => $arSection):?>
                <div class="col-md-12">
                    <?if(isset($arSection["NAME"]) && $arSection["NAME"]):?>
                        <!--<h2><a href="<?=$arSection["SECTION_PAGE_URL"];?>" class="dark-color"><?=$arSection["NAME"];?></a></h2>-->
                    <?endif;?>
                    <div class="row">
                        <?// show section items?>
                        <?foreach($arSection["ITEMS"] as $i => $arItem):?>
                            <?
                            // edit/add/delete buttons for edit mode
                            $this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));
                            // use detail link?
                            $bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);
                            // preview picture
                            $bImage = isset($arItem['FIELDS']['DETAIL_PICTURE']) && strlen($arItem['DETAIL_PICTURE']['SRC']);
                            $imageSrc = ($bImage ? $arItem['DETAIL_PICTURE']['SRC'] : false);
                            $imageDetailSrc = ($bImage ? $arItem['DETAIL_PICTURE']['SRC'] : false);
                            // show active date period
                            $bActiveDate = strlen($arItem["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]) || ($arItem["DISPLAY_ACTIVE_FROM"] && in_array("DATE_ACTIVE_FROM", $arParams["FIELD_CODE"]));
                            ?>

                            <?ob_start();?>
                            <?// element name?>
                            <?if(strlen($arItem["FIELDS"]["NAME"])):?>
                                <div class="title">
                                    <?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" <?=(strpos($arItem['DETAIL_PAGE_URL'], 'http') !== false ? 'target="_blank"' : "")?>><?endif;?>
                                        <?=$arItem['NAME']?>
                                        <?if($bDetailLink):?></a><?endif;?>
                                </div>
                            <?endif;?>

                            <?// date active period?>
                            <?if($bActiveDate):?>
                                <div class="period">
                                    <?if(strlen($arItem["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"])):?>
                                        <span class="date"><?=$arItem["DISPLAY_PROPERTIES"]["PERIOD"]["VALUE"]?></span>
                                    <?else:?>
                                        <span class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></span>
                                    <?endif;?>
                                </div>
                            <?endif;?>

                            <?// element preview text?>
                            <?if(strlen($arItem["FIELDS"]["PREVIEW_TEXT"])):?>
                                <div class="previewtext">
                                    <?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?>
                                        <p><?=$arItem["FIELDS"]["PREVIEW_TEXT"]?></p>
                                    <?else:?>
                                        <?=$arItem["FIELDS"]["PREVIEW_TEXT"]?>
                                    <?endif;?>
                                </div>
                            <?endif;?>
                            <?/*if($bDetailLink):?>
                                <div class="link-block-more">
                                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" <?=(strpos($arItem['DETAIL_PAGE_URL'], 'http') !== false ? 'target="_blank"' : "")?> class="btn-inline sm rounded black"><?=GetMessage('TO_ALL')?><i class="fa fa-angle-right"></i></a>
                                </div>
                            <?endif;*/?>

                            <?$textPart = ob_get_clean();?>

                            <?ob_start();?>
                            <?if($bImage):?>
                                <div class="image shine <?=($bImage ? ' w-picture' : ' wo-picture')?>">
                                    <?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>" <?=(strpos($arItem['DETAIL_PAGE_URL'], 'http') !== false ? 'target="_blank"' : "")?>><?endif;?>
                                        <img src="<?=$imageSrc?>" alt="<?=($bImage ? $arItem['DETAIL_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['DETAIL_PICTURE']['TITLE'] : $arItem['NAME'])?>" class="img-responsive" />
                                        <?if($bDetailLink):?></a><?endif;?>
                                </div>
                            <?endif;?>
                            <?
                            $arrIdSravniAll = Array();
                            foreach($arItem['PROPERTIES']['PRODUCTS']['VALUE'] as $valID){
                                $arrIdSravniAll[] = $valID;
                            }
                            $trimStrSravni = implode('|', $arrIdSravniAll);
                            ?>
                            <a class="steck_sravnenia srv_all btn btn-default" href="/catalog/comparisons/?products=<?=$trimStrSravni;?>"><?=GetMessage('SRV_ALL_PAGE');?></a>
                            <?$imagePart = ob_get_clean();?>
                            <div class="col-md-12 rate__list-item">
                                <?/*if($i):?>
							<hr />
						<?endif;*/?>
                                <div id="<?=$this->GetEditAreaId($arItem['ID'])?>" class="item noborder1<?=($bImage ? '' : ' wti')?><?=($bActiveDate ? ' wdate' : '')?>">
                                    <div class="row">
                                        <?if(!$bImage):?>
                                            <div class="col-md-12"><div class="text"><?=$textPart?></div></div>
                                        <?elseif($arParams["IMAGE_POSITION"] == "right"):?>
                                            <div class="col-md-5 col-sm-7 col-xs-12"><div class="text"><?=$textPart?></div></div>
                                            <div class="col-md-7 col-sm-5 col-xs-12"><?=$imagePart?></div>
                                        <?else:?>
                                            <div class="col-md-4 col-sm-5 col-xs-12"><?=$imagePart?></div>
                                            <?$id_product = "";?>
                                            <?foreach($arItem['PROPERTIES']['PRODUCTS']['VALUE'] as $item):?>
                                                <?
                                                    if(strlen($id_product)==0)
                                                    {
                                                        $id_product = $item;
                                                    }
                                                    else
                                                    {
                                                        $id_product = $id_product . '|' . $item;
                                                    }//if(strlen($id_product)==0)
                                                ?>
                                            <?endforeach;?>
                                            <div class="col-md-8 col-sm-7 col-xs-12 product-list" id="<?=$id_product?>"><div class="text"><?=$textPart?></div>

                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>
                            </div>

                        <?endforeach;?>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    <?endif;?>

    <?// bottom pagination?>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>
</div>
<script>
    function ratingSlider() {
        $('.catalog_block.swiper-container').each(function (index) {
            var newSwiper = new Swiper($(this)[0], {
                direction: 'horizontal',
                slidesPerView: 3,
                freeMode: true,
                mousewheel: true,
                navigation: {
                    nextEl: $(this).siblings('.swiper-button-next'),
                    prevEl: $(this).siblings('.swiper-button-prev'),
                },
                watchOverflow: true,
                breakpoints: {
                    550: {
                        slidesPerView: 'auto',
                        freeMode: false,
                        },
                }
            });
        });
    }

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
        /*$('.steck_sravnenia').click(function (e) {
            e.preventDefault();
            var idStr = $(this).parent().parent().children('.col-md-8').children('.top_wrapper').children('.catalog_block').children('.steck_sravnenie_rait');
            //console.log($(this).parent().parent().children('.col-md-8').children('.top_wrapper').children('.catalog_block').children('.steck_sravnenie_rait').text());
            //var sravniRating1 = idStr.text().split("|");
            location.href = "/catalog/comparisons/?products="+idStr.text();
        });*/
        /**
         * после загрузки страницы - грузим области с картами
         */
        setTimeout(function () {
            $('.product-list').each(function () {
                var thisEl = $(this);
                var idPr = $(this).attr('id');
                $.ajax({
                    type: 'post',//тип запроса: get,post либо head
                    url: '/ajax/after_load_ratings.php',//url адрес файла обработчика
                    data: "id=" + idPr,//параметры запроса
                    response: 'html',//тип возвращаемого ответа text либо xml
                    success: function (data) {//возвращаемый результат от сервера
                        thisEl.children().after(data);
                    }
                });
            });
        }, 1000);
        $('.tags a').click(function() {
            setTimeout(function () {
                $('.product-list').each(function () {
                    var thisEl = $(this);
                    var idPr = $(this).attr('id');
                    $.ajax({
                        type: 'post',//тип запроса: get,post либо head
                        url: '/ajax/after_load_ratings.php',//url адрес файла обработчика
                        data: "id=" + idPr,//параметры запроса
                        response: 'html',//тип возвращаемого ответа text либо xml
                        success: function (data) {//возвращаемый результат от сервера
                            thisEl.children().after(data);
                        }
                    });
                });
            }, 1000);
        });
    });

</script>
</div>