						<?CNext::checkRestartBuffer();?>

						<?IncludeTemplateLangFile(__FILE__);?>

							<?if(!$isIndex):?>
								<?if($isBlog):?>
                                    <?if(strpos($APPLICATION->GetCurPage(false),'/ratings/')!==false && $APPLICATION->GetCurDir() !== '/ratings/'):?>
                                    <?else:?>
                                        </div> <?// class=col-md-9 col-sm-9 col-xs-8 content-md?>
                                    <?endif;?>
									<div class="col-md-3 col-sm-3 right-menu-md blog-sidebar">
										<div class="sidearea">
											<?$APPLICATION->ShowViewContent('under_sidebar_content');?>
											<?CNext::get_banners_position('SIDE', 'Y');?>
                                            <?php if($APPLICATION->GetCurDir() == '/reviews/'):?>
                                                <noindex>
                                                    <div class="search-tags-cloud" id="ajax-menu">
                                                        <div class="title-block-middle">Обзоры</div>
                                                        <div class="tags">
                                                            <a href="/reviews/" rel="nofollow">Все обзоры</a>
                                                            <a href="/reviews/?section=325" rel="nofollow">Кредитные карты</a>
                                                            <a href="/reviews/?section=329" rel="nofollow">Кредиты</a>
                                                            <a href="/reviews/?section=326" rel="nofollow">Карты рассрочки</a>
                                                            <a href="/reviews/?section=327" rel="nofollow">Дебетовые карты</a>
                                                            <a href="/reviews/?section=331" rel="nofollow">Ипотека</a>
                                                            <a href="/reviews/?section=335" rel="nofollow">Расчетные счета</a>
                                                        </div>
                                                    </div>
                                                </noindex>
                                            <?php endif; ?>
											<?php if($APPLICATION->GetCurDir() == '/ratings/'):?>
                                                <noindex>
                                                    <div class="search-tags-cloud" id="ajax-menu">
                                                        <div class="title-block-middle">Рейтинги</div>
                                                        <div class="tags">
                                                            <a href="/ratings/" rel="nofollow">Все рейтинги</a>
                                                            <a href="/ratings/?section=325" rel="nofollow">Кредитные карты</a>
                                                            <a href="/ratings/?section=329" rel="nofollow">Кредиты</a>
                                                            <a href="/ratings/?section=326" rel="nofollow">Карты рассрочки</a>
                                                            <a href="/ratings/?section=327" rel="nofollow">Дебетовые карты</a>
                                                            <a href="/ratings/?section=331" rel="nofollow">Ипотека</a>
                                                            <a href="/ratings/?section=335" rel="nofollow">Расчетные счета</a>
                                                            <a href="/ratings/?section=332" rel="nofollow"> <img src="/upload/resize_cache/iblock/cb4/150_150_1/cb4118f18033e0994ff0bb8af731d05c.png" class="leftSaidbar"> Автокредиты</a>
                                                        </div>
                                                    </div>
                                                </noindex>
                                            <?elseif(strpos($APPLICATION->GetCurPage(false),'/ratings/')!==false):?>
                                                <?$APPLICATION->IncludeComponent("bitrix:news.list", "fm_sidebar", array(
                                                    "IBLOCK_TYPE" => "aspro_next_content",
                                                    "IBLOCK_ID" => 32,
                                                    "NEWS_COUNT" => 5,
                                                    "TITLE_BLOCK" => "Это интересно",
                                                    "SORT_BY1" => "ACTIVE_FROM",
                                                    "SORT_ORDER1" => "DESC",
                                                    "SORT_BY2" => "SORT",
                                                    "SORT_ORDER2" => "ASC",
                                                    "FILTER_NAME" => "arAlsoFilter",
                                                    "FIELD_CODE" => array(
                                                        0 => "NAME",
                                                        1 => "PREVIEW_TEXT",
                                                        2 => "DETAIL_PICTURE",
                                                        3 => "DATE_ACTIVE_FROM",
                                                    ),
                                                    "PROPERTY_CODE" => array(
                                                        0 => "DOCUMENTS",
                                                        1 => "POST",
                                                    ),
                                                    "CHECK_DATES" => "Y",
                                                    "DETAIL_URL" => "",
                                                    "AJAX_MODE" => "N",
                                                    "AJAX_OPTION_JUMP" => "N",
                                                    "AJAX_OPTION_STYLE" => "Y",
                                                    "AJAX_OPTION_HISTORY" => "N",
                                                    "CACHE_TYPE" => "A",
                                                    "CACHE_TIME" => "36000000",
                                                    "CACHE_FILTER" => "Y",
                                                    "CACHE_GROUPS" => "N",
                                                    "PREVIEW_TRUNCATE_LEN" => "",
                                                    "ACTIVE_DATE_FORMAT" => "j F Y",
                                                    "SET_TITLE" => "N",
                                                    "SET_STATUS_404" => "N",
                                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                                    "ADD_SECTIONS_CHAIN" => "N",
                                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                                    "PARENT_SECTION" => "",
                                                    "PARENT_SECTION_CODE" => "",
                                                    "INCLUDE_SUBSECTIONS" => "Y",
                                                    "PAGER_TEMPLATE" => ".default",
                                                    "DISPLAY_TOP_PAGER" => "N",
                                                    "DISPLAY_BOTTOM_PAGER" => "Y",
                                                    "PAGER_TITLE" => "�������",
                                                    "PAGER_SHOW_ALWAYS" => "N",
                                                    "PAGER_DESC_NUMBERING" => "N",
                                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                                    "PAGER_SHOW_ALL" => "N",
                                                    "VIEW_TYPE" => "list",
                                                    "SHOW_TABS" => "N",
                                                    "SHOW_IMAGE" => "Y",
                                                    "SHOW_NAME" => "Y",
                                                    "SHOW_DETAIL" => "Y",
                                                    "IMAGE_POSITION" => "left",
                                                    "COUNT_IN_LINE" => "3",
                                                    "AJAX_OPTION_ADDITIONAL" => ""
                                                ),
                                                    false, array("HIDE_ICONS" => "Y")
                                                );?>
											<?php endif; ?>

											<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "sect", "AREA_FILE_SUFFIX" => "sidebar", "AREA_FILE_RECURSIVE" => "Y"), false);?>
										</div>
									</div>
								</div><?endif;?>
								<?if($isHideLeftBlock && !$isWidePage):?>
									</div> <?// .maxwidth-theme?>
								<?endif;?>
								</div> <?// .container?>
							<?else:?>
								<?CNext::ShowPageType('indexblocks');?>
							<?endif;?>
							<?CNext::get_banners_position('CONTENT_BOTTOM');?>
						</div> <?// .middle?>
					<?//if(!$isHideLeftBlock && !$isBlog):?>
					<?if(($isIndex && $isShowIndexLeftBlock) || (!$isIndex && !$isHideLeftBlock) && !$isBlog):?>
						</div> <?// .right_block?>				
						<?if($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") != "Y" && !defined("ERROR_404")):?>
							<div class="left_block">
								<?CNext::ShowPageType('left_block');?>
							</div>

						<?endif;?>
					<?endif;?>
				<?if($isIndex):?>
					</div>
				<?elseif(!$isWidePage):?>
					</div> <?// .wrapper_inner?>				
				<?endif;?>
			</div> <?// #content?>
			<?CNext::get_banners_position('FOOTER');?>
		</div><?// .wrapper?>
		<div class="maxwidth-theme">
		<?$APPLICATION->ShowViewContent('catblocks');?>
		</div>
		<footer id="footer">
			<?if($APPLICATION->GetProperty("viewed_show") == "Y" || $is404):?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include", 
					"basket", 
					array(
						"COMPONENT_TEMPLATE" => "basket",
						"PATH" => SITE_DIR."include/footer/comp_viewed.php",
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"AREA_FILE_RECURSIVE" => "Y",
						"EDIT_TEMPLATE" => "standard.php",
						"PRICE_CODE" => array(
							0 => "BASE",
						),
						"STORES" => array(
							0 => "",
							1 => "",
						),
						"BIG_DATA_RCM_TYPE" => "bestsell"
					),
					false
				);?>					
			<?endif;?>
            
			<?CNext::ShowPageType('footer');?>
		</footer>

		<?CNext::ShowPageType('search_title_component');?>
		<?CNext::setFooterTitle();
		CNext::showFooterBasket();?>

        <?
        $frame = new \Bitrix\Main\Page\FrameBuffered("cookie_fixed_area");
        $frame->begin();
        if(ERROR_404!='Y') {
            /**добавить реферерер в инфоблок - старт**/
            $referer_href = $_SERVER['HTTP_REFERER'];
            if (isset($referer_href)) {
                if (strlen($referer_href) > 5) {
                    $pos = strpos($referer_href, "myfinmarket.ru");
                    if ($pos == false) {
                        $el = new CIBlockElement;
                        $arLoadProductArray = Array(
                            "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                            "IBLOCK_ID" => 26,
                            "NAME" => $referer_href,
                            "ACTIVE" => "Y",            // активен
                        );
                        $PRODUCT_ID = $el->Add($arLoadProductArray);
                    }
                }
            }
            /**добавить реферерер в инфоблок - конец**/

            $referer = 'organic';
            if (isset($_GET['utm_source'])) {
                if (!empty($_GET['utm_source'])) {
                    if ($_GET['utm_source'] != 'null') {
                        $referer = $_GET['utm_source'];
                    }
                }
            }
            if ($referer == 'organic') {
                $referer_href = $_SERVER['HTTP_REFERER'];
                if (isset($referer_href)) {
                    $arr_search_referer = array();
                    $arr_search_referer[] = "yabs.yandex";
                    $arr_search_referer[] = "ad.yandex";
                    $arr_search_referer[] = "google";
                    $arr_search_referer[] = "direct";
                    $arr_search_referer[] = "adwords";
                    $arr_search_referer[] = "vk";
                    $arr_search_referer[] = "facebook";
                    $arr_search_referer[] = "ok";
                    $arr_search_referer[] = "mail";
                    $arr_search_referer[] = "instagram";

                    foreach ($arr_search_referer as $item) {
                        $pos = strpos($referer_href, $item);
                        if ($pos !== false) {
                            if ($item == "vk") {
                                $referer = "vkontakte";
                            } elseif ($item == "ok") {
                                $referer = "odnoklassniki";
                            } elseif ($item == "yabs.yandex") {
                                $referer = "direct";
                            } elseif ($item == "ad.yandex") {
                                $referer = "direct";
                            } else {
                                $referer = $item;
                            }
                            break;
                        }//if($pos > 0)
                    }//foreach ($arr_search_referer as $item)
                }
            } else {
                $pos = strpos($referer, "vk");
                if ($pos !== false) {
                    $referer = "vk-ads";
                }
                $pos = strpos($referer, "fb");
                if ($pos !== false) {
                    $referer = "fb-ads";
                }
                $pos = strpos($referer, "ig");
                if ($pos !== false) {
                    $referer = "ig-ads";
                }
                $pos = strpos($referer, "ok");
                if ($pos !== false) {
                    $referer = "ok-ads";
                }
            }


            $old_referer = 'null';
            if (isset($_COOKIE['utm_source'])) {
                if (!empty($_COOKIE['utm_source'])) {
                    $old_referer = $_COOKIE['utm_source'];
                }
            }
            $set_referer = false;
            if ($old_referer != 'null') {
                if ($referer != 'organic') {
                    $set_referer = true;
                }
            } else {
                $set_referer = true;
            }

            if ($set_referer) {
                setcookie('utm_source', '', time() - 3600, '/');
                unset($_COOKIE['utm_source']);
                setcookie('utm_source', $referer, strtotime("+6 month"), '/');
            }
        }else {
            /**добавить реферерер по 404 - старт**/
            $refererHref = $APPLICATION->GetCurPageParam();

            $startRedirect = true;

            $arFilter = ['IBLOCK_ID' => 47, 'ACTIVE' => 'Y'];
            $arSelect = [ 'ID', 'NAME'];
            $resException = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
            while($arException=$resException->Fetch())
            {
                $posException = strpos($refererHref, $arException['NAME']);
                if($posException!==false)
                {
                    $startRedirect = false;
                    break;
                }//if($posException!==false)
            }// while($arException=$resException->Fetch())

            if($startRedirect==true)
            {
                $el = new CIBlockElement;
                $arLoadProductArray = Array(
                    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                    "IBLOCK_ID" => 30,
                    "NAME" => $refererHref,
                    "ACTIVE" => "Y",            // активен
                );
                $PRODUCT_ID = $el->Add($arLoadProductArray);

                if(CModule::IncludeModule("form"))
                {
                    $FORM_ID = 10;
                    // массив значений ответов
                    $arValues = array(
                        "form_text_47" => $refererHref
                    );
                    // создадим новый результат
                    if ($RESULT_ID = CFormResult::Add($FORM_ID, $arValues))
                    {
                        // если успех - отправим на почту - почтовый шаблон
                        CFormResult::Mail($RESULT_ID);
                        // относительный путь к файлу в текущем каталоге текущего сайта
                        //LocalRedirect("/");
                    }//if ($RESULT_ID = CFormResult::Add($FORM_ID, $arValues))
                }//if(CModule::IncludeModule("form"))
            }
            else
            {
                //LocalRedirect("/");
            }
            /**добавить реферерер по 404 - конец**/
        }
        $frame->beginStub();
        //заглушка
        $frame->end();
         ?>
        <div class="popap_ofo" style="display: none;">
            <label class="popap_ofo-closer" id="popap_ofo-closer">&#215;</label>
            <div></div>
        </div>
        <div style="position: absolute;" class="basket_animation" >
            <img style="width:119px; height:75px;" src="/local/templates/aspro_next/images/basket_fly.png">
        </div>
        <?$is_main = $APPLICATION->GetCurPage(false)==SITE_DIR;?>
        <script>
            //отображать шапку, когда в нее летит сравнение.

            //Полет сравнить
            $(document).ready(function(){
                //console.log(11111111111);
                $('.like_icons').click(function () {
                    var imgProduct = $(this).parent().children('.thumb').children().attr("src");
                    if(document.location.href.search("/?oid") > 0){
                        imgProduct = $(this).parent().parent().children('.item_slider').children('.slides').children('.offers_img').children('.popup_link').children('img').attr("src");
                    }else if(document.location.href.search("/offers/") > 0) {
                        imgProduct = $(this).parent().children('.thumb').children().attr("src");
                    }else if(document.location.href.search("/catalog/") > 0) {
                        imgProduct = $(this).parent().parent().parent().children('.image_block').children('.image_wrapper_block').children('.thumb').children().attr("src");
                    }
                    flyBacket($(this).offset()['top'],$(this).offset()['left'],imgProduct);
                });

            });
            function flyBacket(cTop,cLeft,src) {
                <?if(!$is_main):?>
                    if(document.location.href.search("/offers/") > 0) {
                    }else{
                        if (document.documentElement.clientWidth > 991) {
                            if(!$('#headerfixed').hasClass('fixed')){
                                $('#headerfixed').addClass('fixed');
                            }
                            $('.basket_animation>img').attr("src", src);
                            $('.basket_animation').css({'top': cTop - 50 + "px", 'left': cLeft - 50 + "px"});
                            $('.basket_animation').clone()
                                .css({
                                    'position': 'absolute',
                                    'display': 'block',
                                    'z-index': '11100',
                                    'top': cTop - 50,
                                    'left': cLeft - 50
                                })
                                .appendTo("body")
                                .animate({
                                    opacity: 0.2,
                                    left: $("#headerfixed .svg-inline-comparison").offset()['left'],
                                    top: $("#headerfixed .svg-inline-comparison").offset()['top'],
                                    width: 100
                                }, 1000, function () {
                                    $(this).remove();

                                });
                        }
                        else{
                            if(!$('#headerfixed').hasClass('fixed')){
                                $('#headerfixed').addClass('fixed');
                            }
                            $('.basket_animation>img').attr("src", src);
                            $('.basket_animation').css({'top': cTop - 50 + "px", 'left': cLeft - 50 + "px"});
                            $('.basket_animation').clone()
                                .css({
                                    'position': 'absolute',
                                    'display': 'block',
                                    'z-index': '11100',
                                    'top': cTop - 50,
                                    'left': cLeft - 50
                                })
                                .appendTo("body")
                                .animate({
                                    opacity: 0.2,
                                    left: $("#mobileheader .svg-inline-comparison").offset()['left'],
                                    top: $("#mobileheader .svg-inline-comparison").offset()['top'],
                                    width: 100
                                }, 1000, function () {
                                    $(this).remove();

                                });
                        }
                    }
                 <?endif;?>
            }
            
        </script>

        <?if(!isset($_COOKIE["COOKIE_AGREE"])):?>
            <?setcookie("COOKIE_AGREE", "agree");?>
            <div class="cookieConsentContainer" id="cookieConsentContainer" style="opacity: 1;display: block;-webkit-box-shadow: 0px 0px 19px 4px rgba(54, 54, 54, 0.2);-moz-box-shadow: 0px 0px 19px 4px rgba(54, 54, 54, 0.2);box-shadow: 0px 0px 19px 4px rgba(54, 54, 54, 0.2);">
                <div class="cookieTitle"><b>Мы используем файлы куки</b></div>
                <div class="cookieDesc"><p>Это помогает сделать пользование сайтом более удобным и продуктивным.</p>
                </div><div class="cookieButton"><a onclick="purecookieDismiss();" style="width: 70%;" class="btn btn-default">Согласен</a>
                </div>
            </div>
            <script>
                function purecookieDismiss(){
                    $('#cookieConsentContainer').remove();
                }
            </script>
        <?endif;?>
        <div id="tooltip"></div>
        <div id="srv_click"></div>

        <script>
            $(document).ready(function() {
                var session = '<?=session_id();?>';
                $.ajax({
                    type: "POST",
                    url: "/ajax/addIconComprCheck.php",
                    data:"session="+session,
                    success: function (data) {//возвращаемый результат от сервера
                        $('.link_compare_icon').html(data);
                    }
                });
                $(".btn-default").click(function () {
                    setTimeout(function () {
                        $.ajax({
                            type: "POST",
                            url: "/ajax/addIconComprCheck.php",
                            data:"session="+session,
                            success: function (data) {//возвращаемый результат от сервера
                                $('.link_compare_icon').html(data);
                            }
                        });
                    },1000);
                });
            });

        </script>

        <!-- Pinterest Tag -->
        <script>
            !function(e){if(!window.pintrk){window.pintrk = function () {
                window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var
                n=window.pintrk;n.queue=[],n.version="3.0";var
                t=document.createElement("script");t.async=!0,t.src=e;var
                r=document.getElementsByTagName("script")[0];
                r.parentNode.insertBefore(t,r)}}("https://s.pinimg.com/ct/core.js");
            pintrk('load', '2613378663678', {em: '<user_email_address>'});
            pintrk('page');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none;" alt="" src="https://ct.pinterest.com/v3/?event=init&tid=2613378663678&pd[em]=<hashed_email_address>&noscript=1" />
        </noscript>
        <!-- end Pinterest Tag -->
        <script>
            window.onload = function () {
                document.body.classList.add('loaded_hiding');
                window.setTimeout(function () {
                    document.body.classList.add('loaded');
                    document.body.classList.remove('loaded_hiding');
                }, 500);
            }
        </script>
	</body>
</html>