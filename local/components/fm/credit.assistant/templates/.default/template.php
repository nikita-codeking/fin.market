<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CUtil::JSPostUnescape();?>

<div class="param_credit_assist">
    <div class="type_ca"></div>
    <div class="product_ca"></div>
    <div class="questionnaire_ca"></div>
</div>

<div class="main_credit_assist">
    <div class="step1_credit_assist" id="step_1" <?if(isset($_GET['CODE']) || isset($_GET['strIMessage'])):?>style="display: none;"<?endif;?>>
        <div class="personal_wrapper">
            <?if($arResult['TYPES']):?>
                <h2><?=GetMessage("TITLE_H2_STEP1")?></h2>
                <div class="row sale-personal-section-row-flex">
                    <?foreach ($arResult['TYPES'] as $itemType):?>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 typeid <?if(!$itemType['ACTIVE']):?>block_step<?else:?>work_step<?endif;?>" id="<?=$itemType['ID'];?>">
                            <div class="sale-personal-section-index-block bx-theme-">
                                <a class="sale-personal-section-index-block-link" href="javascript:void(0);">
                                    <div class="img"><img src="<?=$itemType['IMG'];?>" alt="<?=$itemType['NAME'];?>" /></div>
                                    <h2 class="sale-personal-section-index-block-name"><?=$itemType['NAME'];?></h2>
                                </a>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            <?else:?>
                <h2><?=GetMessage("TITLE_H2_STEP1_ERROR")?></h2>
            <?endif;?>
        </div>
    </div>
    <div class="step2_credit_assist" id="step_2" style="display: none;">
        <div class="personal_wrapper">
            <?if($arResult['PRODUCTS']):?>
                <h2><?=GetMessage("TITLE_H2_STEP2")?></h2>
                <div class="assist_buttons_group">
                    <div class="assist_button" id="1">Назад</div>
                    <div class="assist_button" id="2">Вперед</div>
                    <div class="assist_button" id="3">Выбрать все</div>
                </div>
                <?foreach ($arResult['PRODUCTS'] as $itemProduct):?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productid" id="<?=$itemProduct['ID'];?>">
                        <div class="sale-personal-section-index-block bx-theme-">
                            <a class="sale-personal-section-index-block-link d-flex" href="javascript:void(0);">
                                <div class="check">
                                    <input type="checkbox" name="check" alt="<?=$itemProduct["ID"]?>"/>
                                </div>
                                <div class="img">
                                    <img id="img_<?=$itemProduct['ID'];?>" class="img-header h-center" src="<?=CFile::GetPath($itemProduct['PREVIEW_PICTURE'])?>" alt="<?=$itemProduct['NAME']?>" />
                                    <div class="description_wrapp"><div class="like_icons">
                                            <span id="compare_add_<?=$itemProduct['ID'];?>" class="compare_item to TYPE_1" data-iblock="17" data-item="<?=$itemProduct['ID'];?>"><i></i><span class="s-text">Сравнить</span></span>
                                            <span id="compare_in_<?=$itemProduct['ID'];?>" class="compare_item in added TYPE_1" style="display: none;" data-iblock="17" data-item="<?=$itemProduct['ID'];?>"><i></i><span class="s-text">В сравнении</span></span>
                                        </div></div>
                                </div>

                                <?
                                $val = "";
                                $res = CIBlockElement::GetProperty(17, $itemProduct['ID'], array("sort" => "asc"), array("CODE"=>"OT_DO_PROZ_ST_MAX"));
                                if ($arProp = $res->GetNext())
                                {
                                    if( !empty($arProp["VALUE"] && $arProp["VALUE"]>0) )
                                    {
                                        $val .= $arProp["VALUE"].'%/';
                                    }
                                }
                                //
                                $res = CIBlockElement::GetProperty(17, $itemProduct['ID'], array("sort" => "asc"), array("CODE"=>"OT_DO_CREDIT_LIM_MAX"));
                                if ($arProp_limit = $res->GetNext())
                                {
                                    if( !empty($arProp_limit["VALUE"] && $arProp_limit["VALUE"]>0) )
                                    {
                                        $ar_limit = str_split($arProp_limit["VALUE"],3);


                                        if(count($ar_limit)>2){
                                            $val1 = (ceil($arProp_limit["VALUE"]/1000000))*1000000;
                                            $val1 = strval($val1);
                                            $val1 = substr($val1, 0,strlen($val1)-6) . ' млн';
                                        }elseif(count($ar_limit)>1){
                                            $val1 = (ceil($arProp_limit["VALUE"]/1000))*1000;
                                            $val1 = strval($val1);
                                            $val1 = substr($val1, 0,strlen($val1)-3) . ' тыс';
                                        }
                                        $val .=$val1.' руб./';
                                    }
                                }
                                $res = CIBlockElement::GetProperty(17, $itemProduct['ID'], array("sort" => "asc"), array("CODE"=>"OT_DO_LGOTNIY_PERIOD_MAX"));
                                if ($arProp_period = $res->GetNext())
                                {
                                    if( !empty($arProp_period["VALUE"] && $arProp_period["VALUE"]>0) )
                                    {
                                        $val .= $arProp_period["VALUE"].' ' . tpl_tpluralForm((int)$arProp_period["VALUE"], "день", "дня", "дней");
                                    }
                                }
                                ?>
                                <h2 id="header_<?=$itemProduct['ID'];?>" class="sale-personal-section-index-block-name mt-30"><?=$itemProduct['NAME']?> <br/><span class="sm-text"><?=$val?></span></h2>

                            </a>
                        </div>
                    </div>
                <?endforeach;?>
            <?else:?>
                <h2><?=GetMessage("TITLE_H2_STEP2_ERROR")?></h2>
            <?endif;?>
        </div>
        <div class="assist_buttons_group">
            <div class="assist_button" id="1">Назад</div>
            <div class="assist_button" id="2">Вперед</div>
            <div class="assist_button" id="3">Выбрать все</div>
        </div>
    </div>
    <div class="step3_credit_assist" id="step_3" <?if( !isset($_GET['CODE']) || isset($_GET['strIMessage']) ):?>style="display: none;"<?endif;?>>
        <div class="personal_wrapper">
            <h2><?=GetMessage("TITLE_H2_STEP3")?></h2>
            <div class="assist_buttons_group">
                <div class="assist_button" id="1">Назад</div>
            </div>
            <?if($arResult['QUEST']):?>
                <select name="quest" class="quest_select_ca">
                    <option value="">Использовать сохранённые анкеты</option>
                    <?foreach ($arResult['QUEST'] as $itemQuest):?>
                        <?if($arResult['TYPES'][0]['ACTIVE']):?>
                            <?if($itemQuest['PROPERTY_TYPE_ENUM_ID']==2125):?>
                                <option value="https://<?=$_SERVER['SERVER_NAME']?>/personal/kreditnyy-assistent/?edit=Y&CODE=<?=$itemQuest['ID']?>"><?=$itemQuest['NAME']?></option>
                            <?endif;?>
                        <?else:?>
                            <option value="https://<?=$_SERVER['SERVER_NAME']?>/personal/kreditnyy-assistent/?edit=Y&CODE=<?=$itemQuest['ID']?>"><?=$itemQuest['NAME']?></option>
                        <?endif;?>
                    <?endforeach;?>
                </select>
            <?endif;?>
        </div>
        <div style="font-size:14px; color:red;" id="error_pr"></div>
        <?//if(isset($_GET['CODE']) && !empty($_GET['CODE'])):?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:iblock.element.add.form",
            "fm_questionnaire2",
            array(
                "OSN" => "Кредитные карты",
                "COMPONENT_TEMPLATE" => "fm_questionnaire2",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
                "CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
                "CUSTOM_TITLE_DETAIL_PICTURE" => "",
                "CUSTOM_TITLE_DETAIL_TEXT" => "",
                "CUSTOM_TITLE_IBLOCK_SECTION" => "",
                "CUSTOM_TITLE_NAME" => "",
                "CUSTOM_TITLE_PREVIEW_PICTURE" => "",
                "CUSTOM_TITLE_PREVIEW_TEXT" => "",
                "CUSTOM_TITLE_TAGS" => "",
                "DEFAULT_INPUT_SIZE" => "30",
                "DETAIL_TEXT_USE_HTML_EDITOR" => "Y",
                "ELEMENT_ASSOC" => "CREATED_BY",
                "GROUPS" => array(
                    0 => "2",
                ),
                "IBLOCK_ID" => "25",
                "IBLOCK_TYPE" => "aspro_next_content",
                "LEVEL_LAST" => "Y",
                "LIST_URL" => "",
                "MAX_FILE_SIZE" => "0",
                "MAX_LEVELS" => "100",
                "MAX_USER_ENTRIES" => "100",
                "PREVIEW_TEXT_USE_HTML_EDITOR" => "Y",
                "PROPERTY_CODES" => array(
                    0 => "334",
                    1 => "335",
                    2 => "336",
                    3 => "337",
                    4 => "345",
                    5 => "353",
                    6 => "351",
                    8 => "352",
                    9 => "349",
                    10 => "346",
                    11 => "561",
                    12 => "562",
                    13 => "347",
                    14 => "344",
                    15 => "566",
                    16 => "567",
                    17 => "568",
                    18 => "569",
                    19 => "570",
                    20 => "571",
                    21 => "572",
                    22 => "573",
                    23 => "574",
                    24 => "575",
                    25 => "368",
                    26 => "340",
                ),
                "PROPERTY_CODES_REQUIRED" => array(
                    0 => "334",
                    1 => "335",
                    2 => "336",
                    3 => "337",
                    4 => "345",
                    5 => "353",
                    6 => "351",
                    8 => "352",
                    9 => "349",
                    10 => "346",
                    11 => "561",
                    12 => "562",
                    13 => "347",
                    14 => "344",
                    15 => "566",
                    16 => "567",
                    17 => "568",
                    18 => "569",
                    19 => "570",
                    20 => "571",
                    21 => "572",
                    22 => "573",
                    23 => "574",
                    24 => "575",
                    25 => "368",
                    26 => "340",
                ),
                "RESIZE_IMAGES" => "N",
                "SEF_MODE" => "N",
                "STATUS" => "ANY",
                "STATUS_NEW" => "N",
                "USER_MESSAGE_ADD" => "Спасибо за заполнение анкеты!",
                "USER_MESSAGE_EDIT" => "Спасибо за заполнение анкеты!",
                "USE_CAPTCHA" => "N"
            ),
            false
        );?>
        <?//endif;?>
        <div class="assist_buttons_group">
            <div class="assist_button" id="1">Назад</div>
        </div>
    </div>

    <div class="step4_credit_assist" id="step_4" style="display: none;">
        <div class="personal_wrapper">
            <h2>ШАГ 4 - Отправка анкет</h2>
            <div class="assist_buttons_group">
                <a href="/personal/kreditnyy-assistent/" class="assist_button_1">Новая заявка</a>
            </div>
            <div id="preloader">
                <h3>Отправлется запрос в банк, пожалуйста, подождите</h3>
                <div class="container_preloader">
                    <div class="bubbles">
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                        <div class="bubble">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="personal_wrapper" id="resultTable"></div>
        </div>

        <div class="assist_buttons_group">
            <a href="/personal/kreditnyy-assistent/" class="assist_button_1">Новая заявка</a>
            <a href="/personal/" class="assist_button_1">Личный кабинет</a>
        </div>
    </div>
</div>
<script>
    $('html, body').animate({
        scrollTop: $('.error:visible')
    }, 500);
    function get_field_id(elem_name)
    {
        elem_name = elem_name.replace('PROPERTY','');
        elem_name = elem_name.replace('[0]','');
        elem_name = elem_name.replace('[VALUE]','');
        elem_name = elem_name.split('[').pop().split(']')[0];
        return elem_name;
    }
    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
    var intRegex = /^\d+$/
    $("#input_form").submit(function(e){
        e.preventDefault();
        if( (getUrlVars()['product_ca']==null || getUrlVars()['product_ca']=='') && $(document).find('.param_credit_assist .product_ca').text()=='')
        {
            $('html, body').animate({
                scrollTop: 0
            }, 500);
            $("#error_pr").text("На шаге 2 не выбран продукт. Пожалуйста вернитесь на предыдущий шаг и выберите товар.");
            return;
        }
        $("#input_form").validate();
        var post = {};
        //получаем данные из div c товаром
        if (getUrlVars()['CODE']!=null)
        {
            post['code'] =  getUrlVars()['CODE'];
        }
        //if (getUrlVars()['type_ca']!=null && getUrlVars()['product_ca']!=null)
        if ($(document).find('.param_credit_assist .product_ca').text()=='')
        {
            post['type_ca'] =  getUrlVars()['type_ca'];
            post['product_ca'] = getUrlVars()['product_ca'];
        }
        else
        {
            post['type_ca'] =  $(document).find('.param_credit_assist .type_ca').text();
            post['product_ca'] = $(document).find('.param_credit_assist .product_ca').text();
        }

        //получаем заполненную анкету
        var answers = {};
        $('input[name^="PROPERTY["]').each(function() {
            var id = get_field_id(this.name);
            if(!isNaN(get_field_id(this.name)))
            {
                answers[id]=this.value;
            }
        });
        $('textarea[name^="PROPERTY["]').each(function() {
            var id = get_field_id(this.name);
            if(!isNaN(id))
            {
                answers[id]=this.value;
            }
        });
        $('select[name^="PROPERTY["]').each(function() {
            var id = get_field_id(this.name);
            if(!isNaN(get_field_id(this.name)))
            {
                answers[id]=$(this).find('option:selected').text();
            }
        });
        post['anketa'] = answers;
        console.log(JSON.stringify(post));
        //отправляем запрос на сервер
        for (var index=1;index<=3;index++)
        {
            $("#step_"+index.toString()).removeAttr("style");
            $("#step_"+index.toString()).attr("style","display:none");
        }
        $("#step_4").removeAttr("style");

        /**
         * прогресс-бар - для каждого товара - так круче
         */
        textPreloader = '';
        arrSplit = $('.product_ca').html().split('|');
        for (i = 1; i <= arrSplit.length; ++i) {
            textPreloader+='<div class="bubbles">\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div>Отправка анкеты по - '+i+' продукту</div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an1"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an2"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an3"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an4"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an5"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an6"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an7"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an8"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an9"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t    <div class="bubble">\n' +
                '\t\t      <div class="circle an10"></div>\n' +
                '\t\t    </div>\n' +
                '\t\t  </div>';
        }
        $('#preloader .container_preloader').html(textPreloader);
        $("#preloader").removeAttr("style");
        $('html, body').animate({
            scrollTop: 0
        }, 500);
        BX.ajax.post(
            '/personal/kreditnyy-assistent/send_data.php',
            post,
            function (data) {
                if (data.toString()=='no data')
                {
                    return;
                }
                var array = $.parseJSON(data);
                var markup="";
                var node = document.getElementById('resultTable');
                $.each(array,function(index, value){
                    var answ="";
                    if (value.toLowerCase()=="заявка одобрена") answ='<div class="answ-res"><a href="/personal/orders/" class="btn btn-default btn-success ofo-href mobile mt-30 answ-res">Отправлено</a></div>';
                    else answ='<div class="answ-res"><a href="/personal/orders/" class="btn btn-default btn-danger ofo-href mobile mt-30 answ-res">Отклонено</a></div>';
                    var elem = $("#img_"+index).attr('src');
                    var ahtml = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productid">';
                    ahtml+='<div class="sale-personal-section-index-block">';
                    ahtml+='<div class="sale-personal-section-index-block-link d-flex">';
                    ahtml+='<div class="img">';
                    ahtml+='<img class="img-header h-center img-mobile" src="'+$("#img_"+index).attr('src')+'" alt="'+$("#img_"+index).attr('alt')+'">';
                    ahtml+='</div>';
                    ahtml+='<h2 class="sale-personal-section-index-block-name mt-30">'+$("#img_"+index).attr('alt')+'</h2>';
                    ahtml+=answ;
                    ahtml+='</div>';
                    if (value.toLowerCase()=="заявка одобрена"){
                        ahtml+='<span>Ваша анкета отправлена в банк. Ожидайте ответа менеджера банка по указанному номеру телефона или электронной почте</span>';
                    }
                    ahtml+='</div>';
                    ahtml+='</div>';
                    $('#resultTable').append(ahtml);
                });
                $("#preloader").attr("style","display:none");
            }
        );

    });
    //
    $('[id^="compare_in_"]').click(function(e) {
        e.preventDefault();
        $(this).hide();
        $("#"+$(this).attr('id').replace("_in_","_add_")).show();
    });
    $('[id^="compare_add_"]').click(function(e) {
        e.preventDefault();
        $("#"+$(this).attr('id').replace("_add_","_in_")).show();
        $(this).hide();
    });
    $( document ).ready(function() {
        if (getUrlVars()['type_ca']!=null) $('.param_credit_assist .type_ca').html(getUrlVars()['type_ca']);
        if (getUrlVars()['product_ca']!=null) $('.param_credit_assist .product_ca').html(getUrlVars()['product_ca']);
        if (window.location.pathname.toString().indexOf("kreditnyy-assistent")!==-1 || window.location.pathname.toString().indexOf("compare")!==-1)
        {
            $("#basket_line").show();
        }
        else $("#basket_line").hide();

    });
</script>