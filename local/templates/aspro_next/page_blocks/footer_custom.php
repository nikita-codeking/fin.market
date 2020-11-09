<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<div class="footer_inner <?=($arTheme["SHOW_BG_BLOCK"]["VALUE"] == "Y" ? "fill" : "no_fill");?> footer-grey">
    <div class="bottom_wrapper">
        <div class="maxwidth-theme items">
            <div class="row bottom-middle">
                <div class="col-md-6">
                    <img id="logo" width="200" src="<?=SITE_DIR;?>upload/CNext/fd9/fd9276a41f6df78af744ea73f752a11a.svg" alt="ФинМаркет" title="ФинМаркет">
                </div>
				
                <div class="col-md-6 contact-block">
                    <div class="row" style="text-align: center">

                            <?/*$APPLICATION->IncludeFile(SITE_DIR."include/footer/contacts-title.php", array(), array(
                                    "MODE" => "html",
                                    "NAME" => "Title",
                                    "TEMPLATE" => "include_area.php",
                                )
                            );*/?>
                            <div class="info">
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <?CNext::showEmail('email blocks');?>
                                        <div class="social-block">
                                            <?$APPLICATION->IncludeComponent(
                                                "aspro:social.info.next",
                                                "fm_main",
                                                array(
                                                    "CACHE_TYPE" => "A",
                                                    "CACHE_TIME" => "3600000",
                                                    "CACHE_GROUPS" => "N",
                                                    "COMPONENT_TEMPLATE" => "fm_main",
                                                    "TITLE_BLOCK" => "",
                                                    "COMPOSITE_FRAME_MODE" => "A",
                                                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                                                ),
                                                false
                                            );?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="bottom_flex_box">
                <div class="fin_m metrica">
                    <p><span>ФИН💰МАРКЕТ - ФИНАНСОВЫЙ МАРКЕТПЛЕЙС</span> <br>Подбор и сравнение финансовых продуктов<br></p>
                    <div class="footer_counters">
                        <div style="margin-bottom: 10px;margin-right: 4px;">
                            <?CNext::ShowPageType('bottom_counter');?>
                        </div>
                        <div style="margin-bottom: 10px;margin-right: 4px;">
                            <!-- Rating Mail.ru counter -->
                            <script type="text/javascript">
                                var _tmr = window._tmr || (window._tmr = []);
                                _tmr.push({id: "3162406", type: "pageView", start: (new Date()).getTime()});
                                (function (d, w, id) {
                                    if (d.getElementById(id)) return;
                                    var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
                                    ts.src = "https://top-fwz1.mail.ru/js/code.js";
                                    var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
                                    if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
                                })(document, window, "topmailru-code");
                            </script>
                            <noscript><div>
                                    <img src="https://top-fwz1.mail.ru/counter?id=3162406;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
                                </div>
                            </noscript>
                            <!-- //Rating Mail.ru counter -->
                        </div>
                        <div style="margin-bottom: 10px;margin-right: 4px;">
                            <a style="margin-right: 4px;" href="//www.liveinternet.ru/click" target="_blank"><img src="//counter.yadro.ru/hit?t11.6;rhttps%3A//fin.market/%3Fbitrix_include_areas%3DY%26clear_cache%3DY;s1536*864*24;uhttps%3A//fin.market/%3Fbitrix_include_areas%3DY%26clear_cache%3DY;h%u0424%u0418%u041D%uD83D%uDCB0%u041C%u0410%u0420%u041A%u0415%u0422%20-%20%u0424%u0418%u041D%u0410%u041D%u0421%u041E%u0412%u042B%u0419%20%u041C%u0410%u0420%u041A%u0415%u0422%u041F%u041B%u0415%u0419%u0421%20%u041F%u043E%u0434%u0431%u043E%u0440%20%u0438%20%u0441%u0440%u0430%u0432%u043D%u0435%u043D%u0438%u0435%20%u0444%u0438%u043D%u0430%u043D%u0441%u043E%u0432%u044B%u0445%20%u043F%u0440%u043E%u0434%u0443%u043A%u0442%u043E%u0432;0.22139292690181156" alt="" title="LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня" border="0" width="88" height="31"></a>
                        </div>
                        <div style="margin-bottom: 10px;margin-right: 4px;">
                            <!-- Top100 (Kraken) Widget -->
                            <span id="top100_widget"></span>
                            <!-- END Top100 (Kraken) Widget -->

                            <!-- Top100 (Kraken) Counter -->
                            <?/* Яметрика как была раньше.
                                <div style="margin-bottom: 10px;">
                                    <!--LiveInternet counter--><script type="text/javascript">
                                        document.write('<a href="//www.liveinternet.ru/click" '+
                                            'target="_blank"><img src="//counter.yadro.ru/hit?t11.6;r'+
                                            escape(document.referrer)+((typeof(screen)=='undefined')?'':
                                                ';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
                                                screen.colorDepth:screen.pixelDepth))+';u'+escape(document.URL)+
                                            ';h'+escape(document.title.substring(0,150))+';'+Math.random()+
                                            '" alt="" title="LiveInternet: показано число просмотров за 24'+
                                            ' часа, посетителей за 24 часа и за сегодня" '+
                                            'border="0" width="88" height="31"><\/a>')
                                    </script><!--/LiveInternet-->
                                </div>
                            */?>
                            <script>
                                (function (w, d, c) {
                                    (w[c] = w[c] || []).push(function() {
                                        var options = {
                                            project: 6984558,
                                            element: 'top100_widget',
                                        };
                                        try {
                                            w.top100Counter = new top100(options);
                                        } catch(e) { }
                                    });
                                    var n = d.getElementsByTagName("script")[0],
                                        s = d.createElement("script"),
                                        f = function () { n.parentNode.insertBefore(s, n); };
                                    s.type = "text/javascript";
                                    s.async = true;
                                    s.src =
                                        (d.location.protocol == "https:" ? "https:" : "http:") +
                                        "//st.top100.ru/top100/top100.js";

                                    if (w.opera == "[object Opera]") {
                                        d.addEventListener("DOMContentLoaded", f, false);
                                    } else { f(); }
                                })(window, document, "_top100q");
                            </script>
                            <noscript>
                                <img src="//counter.rambler.ru/top100.cnt?pid=6984558" alt="Топ-100" />
                            </noscript>
                            <!-- END Top100 (Kraken) Counter -->
                        </div>
                        <div style="margin-bottom: 10px;margin-right: 4px;">
                            <a href="https://webmaster.yandex.ru/siteinfo/?site=fin.market"><img width="88" height="31" alt="" border="0" src="https://yandex.ru/cycounter?fin.market&theme=light&lang=ru"/></a>
                        </div>
                        <div style="margin-bottom: 10px;margin-right: 4px;">
                            <!-- Rating Mail.ru logo -->
                            <a href="https://top.mail.ru/jump?from=3162406">
                                <img src="https://top-fwz1.mail.ru/counter?id=3162406;t=617;l=1" style="border:0;" height="31" width="88" alt="Top.Mail.Ru" /></a>
                            <!-- //Rating Mail.ru logo -->
                        </div>
                    </div>
                </div>
                <!-- menu bottom -->
                <?php $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"fm_bottom_cards_and_services", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "bottom_cards_and_services",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "bottom_cards_and_services",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "fm_bottom_cards_and_services",
		"COMPOSITE_FRAME_MODE" => "N",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>



            </div>

            <!-- /menu bottom -->
            <div class="bottom-under">
                <div class="row">
                    <div class="col-md-12 outer-wrapper">
                        <div class="inner-wrapper row">
                            <div class="copy-block">
                                <div class="copy">
                                    <?$APPLICATION->IncludeFile(SITE_DIR."include/fm/footer/copy/copyright.php", Array(), Array(
                                            "MODE" => "php",
                                            "NAME" => "Copyright",
                                            "TEMPLATE" => "include_area.php",
                                        )
                                    );?>
                                </div>
                                <div class="print-block"><?=CNext::ShowPrintLink();?></div>
                                <div id="bx-composite-banner"></div>
                            </div>							
                        </div>
						
						<?$APPLICATION->IncludeFile(SITE_DIR."include/fm/footer/bottom_text.php", Array(), Array(
								"MODE" => "php",
								"NAME" => "bottom_text",
								"TEMPLATE" => "include_area.php",
							)
						);?>
                    </div>
                </div>				
            </div>
        </div>
    </div>
</div>
</div>