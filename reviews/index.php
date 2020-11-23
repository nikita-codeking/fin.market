
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Обзоры лучших финансовых продуктов популярных банков");
$APPLICATION->SetPageProperty("description", "Актуальная информация о лучших банковских продуктов на текущий момент. Обзоры популярных предложений банков.");
$APPLICATION->SetTitle("Обзоры");
?><?php 
//echo $APPLICATION->GetProperty("ПОДЗАГОЛОВОК");
$GLOBALS["arRegionLink"] ["?TAGS"] = "Обзоры";?>
<?$APPLICATION->IncludeComponent("bitrix:news", "fm_reviews_list", Array(
	"ADD_ELEMENT_CHAIN" => "Y",	// Включать название элемента в цепочку навигации
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"ALSO_ITEMS_COUNT" => "5",	// Количество выводимых элементов сбоку
		"ALSO_ITEMS_POSITION" => "side",	// Положение блока "Это интересно"
		"BLOG_TITLE" => "Комментарии",
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
		"CACHE_TIME" => "100000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"COLOR_NEW" => "3E74E6",
		"COLOR_OLD" => "C0C0C0",
		"COMMENTS_COUNT" => "10",
		"COMPONENT_TEMPLATE" => "fm_blog_reviews",
		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
		"COUNT_IN_LINE" => "3",
		"DETAIL_ACTIVE_DATE_FORMAT" => "j F Y G:i",	// Формат показа даты
		"DETAIL_BLOG_EMAIL_NOTIFY" => "Y",
		"DETAIL_BLOG_URL" => "catalog_comments",
		"DETAIL_BLOG_USE" => "N",	// Использовать комментарии
		"DETAIL_BRAND_USE" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DETAIL_DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DETAIL_FB_APP_ID" => "",
		"DETAIL_FB_USE" => "N",	// Использовать Facebook
		"DETAIL_FIELD_CODE" => array(	// Поля
			0 => "TAGS",
			1 => "PREVIEW_TEXT",
			2 => "DETAIL_TEXT",
			3 => "DETAIL_PICTURE",
			4 => "DATE_ACTIVE_FROM",
			5 => "CREATED_BY",
			6 => "CREATED_USER_NAME",
			7 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
		"DETAIL_PAGER_TEMPLATE" => "",	// Название шаблона
		"DETAIL_PAGER_TITLE" => "Страница",	// Название категорий
		"DETAIL_PROPERTY_CODE" => array(	// Свойства
			0 => "LINK_GOODS",
			1 => "FORM_QUESTION",
			2 => "FORM_ORDER",
			3 => "LINK_SERVICES",
			4 => "PHOTOS",
			5 => "DOCUMENTS",
			6 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",	// Устанавливать канонический URL
		"DETAIL_STRICT_SECTION_CHECK" => "Y",
		"DETAIL_USE_COMMENTS" => "Y",	// Включить отзывы о товаре
		"DETAIL_VK_API_ID" => "",
		"DETAIL_VK_USE" => "N",	// Использовать Вконтакте
		"DISPLAY_AS_RATING" => "rating",
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "N",	// Выводить название элемента
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"ELEMENT_TYPE_VIEW" => "element_1",	// Шаблон страницы блока детальной страницы
		"FB_TITLE" => "Facebook",
		"FILE_404" => "",	// Страница для показа (по умолчанию /404.php)
		"FILTER_FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arRegionLink",	// Фильтр
		"FILTER_PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "",
		),
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"FORM_ID_ORDER_SERVISE" => "",
		"GALLERY_TYPE" => "small",	// Тип галлереи
		"GOOGLE_API_KEY" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",	// Скрывать ссылку, если нет детального описания
		"HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
		"IBLOCK_ID" => "18",	// Инфоблок
		"IBLOCK_TYPE" => "aspro_next_content",	// Тип инфоблока
		"IMAGE_CATALOG_POSITION" => "left",
		"IMAGE_POSITION" => "left",	// Положение картинки анонса
		"IMAGE_WIDE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"LANDING_IBLOCK_ID" => "",
		"LANDING_SECTION_COUNT" => "10",
		"LANDING_TITLE" => "Популярные категории",
		"LINE_ELEMENT_COUNT" => "2",
		"LINE_ELEMENT_COUNT_LIST" => "3",
		"LINKED_ELEMENST_PAGE_COUNT" => "20",	// Количество связанных товаров на странице
		"LIST_ACTIVE_DATE_FORMAT" => "j F Y G:i",	// Формат показа даты
		"LIST_FIELD_CODE" => array(	// Поля
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_PICTURE",
			4 => "DATE_ACTIVE_FROM",
			5 => "",
		),
		"LIST_PROPERTY_CODE" => array(	// Свойства
			0 => "POSITION_BLOCK",
			1 => "",
		),
		"LIST_USE_SHARE" => "N",
		"LIST_VIEW" => "slider",	// Вид отображения связанных товаров
		"MAP_TYPE" => "0",
		"MEDIA_PROPERTY" => "",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"NEWS_COUNT" => "5",	// Количество новостей на странице
		"NUM_DAYS" => "30",	// Количество дней для экспорта
		"NUM_NEWS" => "20",	// Количество новостей для экспорта
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => "main",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PERIOD_NEW_TAGS" => "",
		"PREVIEW_TRUNCATE_LEN" => "250",	// Максимальная длина анонса для вывода (только для типа текст)
		"PRICE_CODE" => "",	// Тип цены
		"SECTIONS_TYPE_VIEW" => "sections_1",
		"SECTION_ELEMENTS_TYPE_VIEW" => "list_elements_2",	// Шаблон страницы блока списка элементов
		"SECTION_TYPE_VIEW" => "section_1",
		"SEF_FOLDER" => "/reviews/",	// Каталог ЧПУ (относительно корня сайта)
		"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_STATUS_404" => "Y",	// Устанавливать статус 404
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHARE_HANDLERS" => array(
			0 => "delicious",
			1 => "lj",
			2 => "facebook",
			3 => "twitter",
			4 => "mailru",
			5 => "vk",
		),
		"SHARE_HIDE" => "N",
		"SHARE_SHORTEN_URL_KEY" => "",
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_TEMPLATE" => "",
		"SHOW_404" => "Y",	// Показ специальной страницы
		"SHOW_CHILD_SECTIONS" => "Y",
		"SHOW_DETAIL_LINK" => "Y",	// Отображать ссылку на детальную страницу
		"SHOW_DISCOUNT_PERCENT_NUMBER" => "N",	// Отображать процент экономии
		"SHOW_FILTER_DATE" => "Y",
		"SHOW_NEXT_ELEMENT" => "N",
		"SHOW_SECTION_DESCRIPTION" => "Y",
		"SHOW_SECTION_PREVIEW_DESCRIPTION" => "Y",
		"SLIDER_PROPERTY" => "",
		"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
		"SORT_BY2" => "ID",	// Поле для второй сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_ORDER2" => "DESC",	// Направление для второй сортировки новостей
		"STORES" => array(	// Склады
			0 => "",
			1 => "",
		),
		"STRICT_SECTION_CHECK" => "Y",	// Строгая проверка раздела
		"S_ASK_QUESTION" => "",
		"S_ORDER_SERVISE" => "",
		"TAGS_CLOUD_ELEMENTS" => "150",
		"TAGS_CLOUD_WIDTH" => "100%",
		"TEMPLATE_THEME" => "blue",
		"TIZERS_IBLOCK_ID" => "",
		"T_ALSO_ITEMS" => "",	// Заголовок блока "Это интересно"
		"T_CLIENTS" => "",
		"T_DOCS" => "",
		"T_GALLERY" => "",	// Текст подзаголовка "Галерея"
		"T_GOODS" => "",
		"T_NEXT_LINK" => "",
		"T_PREV_LINK" => "",	// Текст ссылки на список элементов
		"T_PROJECTS" => "",
		"T_REVIEWS" => "",
		"T_SERVICES" => "",
		"T_STAFF" => "",
		"T_STUDY" => "",
		"T_VIDEO" => "",
		"USE_CATEGORIES" => "N",	// Выводить материалы по теме
		"USE_FILTER" => "Y",	// Показывать фильтр
		"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
		"USE_RATING" => "N",	// Разрешить голосование
		"USE_REVIEW" => "N",	// Разрешить отзывы
		"USE_RSS" => "Y",	// Разрешить RSS
		"USE_SEARCH" => "N",	// Разрешить поиск
		"USE_SHARE" => "Y",	// Показывать ссылки на соцсети
		"VK_TITLE" => "Вконтакте",
		"YANDEX" => "N",	// Экспортировать в диалект Яндекса
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE#/",
			"detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"rss" => "rss/",
			"rss_section" => "#SECTION_ID#/rss/",
		)
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
<script>
    //#netwiz start раскраска в стиле дзен
    function zenColours() {
        /* var
            ac = new FastAverageColor(),
            items = document.querySelectorAll('.item');

        for (var i = 0; i < items.length; i++) {
            var item = items[i],
                image = item.querySelector('img');
            if (image) {
                var
                    isBottom = item.classList.contains('item_bottom'),
                    gradient = item.querySelector('.item__gradient'),
                    gradientElse = item.querySelector('.item__gradient_horizontal'),
                    height = image.naturalHeight,
                    size = 50,
                    color = ac.getColor(image, isBottom ? {top: height - size, height: size} : {height: size}),
                    colorEnd = [].concat(color.value.slice(0, 3), 0).join(','),
                    colorFive = [].concat(color.value.slice(0, 3), 0.5).join(','),
                    colorSeven = [].concat(color.value.slice(0, 3), 0.7).join(',');

                item.style.background =  color.rgb;
                item.style.color = color.isDark ? 'white' : 'black';

                if (isBottom) {
                    gradient.style.background = 'linear-gradient( to top, ' +
                        color.rgba + ' 0%,' + color.rgba + ' 50%,rgba(' + colorSeven + ') 70%,rgba(' + colorFive + ') 100% )';
                    gradientElse.style.background = 'linear-gradient( to right, ' +
                        color.rgba + ' 0%,' + color.rgba + ' 50%,rgba(' + colorSeven + ') 70%,rgba(' + colorFive + ') 100% )';
                } else {
                    gradient.style.background = 'linear-gradient(to top, ' +
                        'rgba(' + colorEnd + ') 0%, ' + color.rgba + ' 100%)';
                }
            } else {
                item.style.color = 'black';
            }
        } */
    }
    if($('.stories').hasClass('banners-small')) {
        zenColours();
    }
    //#netwiz end раскраска в стиле дзен
    //#netwiz start ленивая загрузка сторис
    function scrollTracking(){
        var windowTop = $(window).scrollTop();
        var windowHeight = $(window).height();
        var footerPosition = $('footer').offset().top + 150;
        var footerHeight = $('footer').outerHeight();
        var documentHeight = $(document).height();
        //проверяем, дошла ли прокрутка до конца блока сторис (показался футер в видимой части экрана)
        if (windowTop + windowHeight >= footerPosition) {
            // показываем кнопку того, что мы загружаем следующую порцию статей
            $('.lazy-hidden .ajax_load_btn').css('visibility', 'visible');
            //крутим ее а-ля прелоадер
            setTimeout(300);
            //инициируем событие клика на кнопку загрузки доп статей
            $('.lazy-hidden .ajax_load_btn').trigger('click');
        }
    }
    //если у нас все еще есть скрытая кнопка "показать еще посты" (то есть они не закончились)
    if($('.lazy-hidden')) {
        $(window).on('scroll', function () {
            //по скроллу проверяем, закончился ли у нас контент
            scrollTracking();
            //раскрашиваем под дзен если загрузили новое
            if($('.stories').hasClass('banners-small')) {
                zenColours();
            }
        });
    }
    //#netwiz end ленивая загрузка сторис
    //#netwiz start автозагрузка баннера на страницах сторис
    //страницы без баннеров закомментированы
    function selectBanner() {
        var tagType = "";
        var tagOneClick = "";
        //выбираем тег
        $('.banner-selection a').each(function (i) {
            if($(this).text() == "Дебетовые карты" || $(this).text() == " Дебетовые карты") {
                tagType = "debet";
                tagOneClick = "";
            }
            if($(this).text() == "Займы" || $(this).text() == " Займы") {
                tagType = "zaymy";
                tagOneClick = "zaymy";
            }
            if($(this).text() == "Ипотека" || $(this).text() == " Ипотека") {
                tagType = "ipoteka";
                tagOneClick = "";
            }
            if($(this).text() == "Карты рассрочки" || $(this).text() == " Карты рассрочки") {
                tagType = "rassrochka";
                tagOneClick = "";
            }
            if ($(this).text() == "Кредитные карты" || $(this).text() == " Кредитные карты") {
                tagType = "credcard";
                tagOneClick = "credcard";
            }
            if ($(this).text() == "Кредиты" || $(this).text() == " Кредиты"){
                tagType = "credit";
                tagOneClick = "credit";
            }
            if ($(this).text() == "Автокредиты" || $(this).text() == " Автокредиты"){
                tagType = "avtokred";
                tagOneClick = "";
            }
            if ($(this).text() == "Осаго" || $(this).text() == " Осаго"){
                // tagType = "osago";
                // tagOneClick = "";
            }
            if ($(this).text() == "Расчетные счета" || $(this).text() == " Расчетные счета") {
                tagType = "rko";
                tagOneClick = "";
            }
            if ($(this).text() == "Рефинансирование" || $(this).text() == " Рефинансирование") {
                tagType = "refinans";
                tagOneClick = "";
            }
            if ($(this).text() == "Страхование" || $(this).text() == " Страхование"){
                // tagType = "strahovanie";
                // tagOneClick = "";
            }
        });
        <?$this_url = $APPLICATION->GetCurPage();?>
        if (tagType !== "") { //если для страницы существует баннер сравни
            if($('.content h2').length > 1) { //если у нас в статье не менее 2 заголовков h2
                //выводим первый баннер перед вторым заголовком
                $('.content h2').eq(1).before("<a href='/catalog/comparisons/'><img class='stories-banner-lg' src='/local/templates/aspro_next/images/banners/svg-lg/" + tagType + "-lg.svg' alt='' /><img class='stories-banner-sm' src='/local/templates/aspro_next/images/banners/stories/" + tagType + "-sm.svg' alt='' /></a>");
                if($('.content h2').length > 3 && tagOneClick !== "") { //если существует баннер заявки в 1 клик и заголовков h2 не менее 4
                    //выведем второй баннер перед ччетвертым заголовком
                    $('.content h2').eq(3).before("<a href='/request_online/<?if(strpos($this_url,'kreditnye_karty')): echo 'kreditnye_karty/'; elseif(strpos($this_url,'kredit')):echo 'kredity_nalichnymi/'; elseif(strpos($this_url,'zaymy')):echo 'zaymy/'; endif;?>'><img class='stories-banner-lg' src='/local/templates/aspro_next/images/banners/svg-lg/1-" + tagType + "-lg.svg' alt='' /><img class='stories-banner-sm' src='/local/templates/aspro_next/images/banners/stories/1-" + tagType + "-sm.svg' alt='' />");
                } else {
                    //или в конце статьи если заголовков меньше 4, но не меньше 2
                    $('.content').append("<img class='stories-banner-lg' src='/local/templates/aspro_next/images/banners/svg-lg/1-" + tagType + "-lg.svg' alt='' /><img class='stories-banner-sm' src='/local/templates/aspro_next/images/banners/stories/1-" + tagType + "-sm.svg' alt='' />");
                }
            } else {
                //выведем баннер сравни в конце статьи, если она имеет менее 2 заголовков, баннера в 1 клик нет
                $('.content').append("<a href='/catalog/comparisons/'><img class='stories-banner-lg' src='/local/templates/aspro_next/images/banners/svg-lg/" + tagType + "-lg.svg' alt='' /><img class='stories-banner-sm' src='/local/templates/aspro_next/images/banners/stories/" + tagType + "-sm.svg' alt='' /></a>");
            }
        }
    }
    selectBanner();
    //#netwiz end автозагрузка баннера на страницах сторис


</script><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>