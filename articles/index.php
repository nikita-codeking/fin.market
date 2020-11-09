<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Актуальные статьи про банковские продукты, а также много полезной информации для физических и юридических лиц.");
$APPLICATION->SetPageProperty("title", "Полезные статьи про банковские услуги - самая свежая информация ");
$APPLICATION->SetTitle("Сторис");
?><?php
$GLOBALS["arRegionLink"]["!%TAGS"] = "Обзоры";
//Фильтр по тегам
if(isset($_GET["tags"]) && !empty($_GET["tags"])){
$GLOBALS["arRegionLink"] ["?TAGS"] = $_GET["tags"];
}
?>
<?$APPLICATION->IncludeComponent("bitrix:news", "fm_storis_list", Array(
	"IBLOCK_TYPE" => "aspro_next_content",	// Тип инфоблока
		"IBLOCK_ID" => "18",	// Инфоблок
		"NEWS_COUNT" => "5",	// Количество новостей на странице
		"USE_SEARCH" => "N",	// Разрешить поиск
		"USE_RSS" => "Y",	// Разрешить RSS
		"USE_RATING" => "N",	// Разрешить голосование
		"USE_CATEGORIES" => "N",	// Выводить материалы по теме
		"USE_FILTER" => "Y",	// Показывать фильтр
		"FILTER_NAME" => "arSectionLink",	// Фильтр
		"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_BY2" => "ID",	// Поле для второй сортировки новостей
		"SORT_ORDER2" => "DESC",	// Направление для второй сортировки новостей
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"SEF_FOLDER" => "/articles/",	// Каталог ЧПУ (относительно корня сайта)
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "100000",	// Время кеширования (сек.)
		"CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SET_STATUS_404" => "Y",	// Устанавливать статус 404
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
		"PREVIEW_TRUNCATE_LEN" => "250",	// Максимальная длина анонса для вывода (только для типа текст)
		"LIST_ACTIVE_DATE_FORMAT" => "j F Y G:i",	// Формат показа даты
		"LIST_FIELD_CODE" => array(	// Поля
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_PICTURE",
			4 => "DATE_ACTIVE_FROM",
			5 => "CREATED_BY",
			6 => "CREATED_USER_NAME",
			7 => "TIMESTAMP_X",
			8 => "",
		),
		"LIST_PROPERTY_CODE" => array(	// Свойства
			0 => "POSITION_BLOCK",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",	// Скрывать ссылку, если нет детального описания
		"DISPLAY_NAME" => "N",	// Выводить название элемента
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"DETAIL_ACTIVE_DATE_FORMAT" => "j F Y G:i",	// Формат показа даты
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
		"DETAIL_PROPERTY_CODE" => array(	// Свойства
			0 => "LINK_GOODS",
			1 => "FORM_QUESTION",
			2 => "FORM_ORDER",
			3 => "LINK_SERVICES",
			4 => "PHOTOS",
			5 => "DOCUMENTS",
			6 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DETAIL_PAGER_TITLE" => "Страница",	// Название категорий
		"DETAIL_PAGER_TEMPLATE" => "",	// Название шаблона
		"DETAIL_PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
		"PAGER_TEMPLATE" => "main",	// Шаблон постраничной навигации
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"IMAGE_POSITION" => "left",	// Положение картинки анонса
		"USE_SHARE" => "Y",	// Показывать ссылки на соцсети
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"USE_REVIEW" => "N",	// Разрешить отзывы
		"ADD_ELEMENT_CHAIN" => "Y",	// Включать название элемента в цепочку навигации
		"SHOW_DETAIL_LINK" => "Y",	// Отображать ссылку на детальную страницу
		"S_ASK_QUESTION" => "",
		"S_ORDER_SERVISE" => "",
		"T_GALLERY" => "",	// Текст подзаголовка "Галерея"
		"T_DOCS" => "",
		"T_GOODS" => "",
		"T_SERVICES" => "",
		"T_STUDY" => "",
		"COMPONENT_TEMPLATE" => "fm_blog",
		"SECTION_ELEMENTS_TYPE_VIEW" => "list_elements_2",	// Шаблон страницы блока списка элементов
		"ELEMENT_TYPE_VIEW" => "element_1",	// Шаблон страницы блока детальной страницы
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"T_VIDEO" => "",
		"T_NEXT_LINK" => "",
		"T_PREV_LINK" => "",	// Текст ссылки на список элементов
		"SHOW_SECTION_PREVIEW_DESCRIPTION" => "Y",
		"SHOW_SECTION_DESCRIPTION" => "Y",
		"LINE_ELEMENT_COUNT" => "2",
		"LINE_ELEMENT_COUNT_LIST" => "3",
		"DETAIL_SET_CANONICAL_URL" => "N",	// Устанавливать канонический URL
		"SHOW_NEXT_ELEMENT" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"SHOW_404" => "Y",	// Показ специальной страницы
		"MESSAGE_404" => "",
		"FORM_ID_ORDER_SERVISE" => "",
		"IMAGE_WIDE" => "Y",
		"NUM_NEWS" => "20",	// Количество новостей для экспорта
		"NUM_DAYS" => "30",	// Количество дней для экспорта
		"YANDEX" => "N",	// Экспортировать в диалект Яндекса
		"T_ALSO_ITEMS" => "",	// Заголовок блока "Это интересно"
		"ALSO_ITEMS_POSITION" => "side",	// Положение блока "Это интересно"
		"DETAIL_USE_COMMENTS" => "Y",	// Включить отзывы о товаре
		"DETAIL_BLOG_USE" => "N",	// Использовать комментарии
		"DETAIL_BLOG_URL" => "catalog_comments",
		"DETAIL_BLOG_EMAIL_NOTIFY" => "Y",
		"DETAIL_VK_USE" => "N",	// Использовать Вконтакте
		"DETAIL_VK_API_ID" => "",
		"DETAIL_FB_USE" => "N",	// Использовать Facebook
		"DETAIL_FB_APP_ID" => "",
		"COMMENTS_COUNT" => "10",
		"BLOG_TITLE" => "Комментарии",
		"VK_TITLE" => "Вконтакте",
		"FB_TITLE" => "Facebook",
		"DETAIL_STRICT_SECTION_CHECK" => "Y",
		"STRICT_SECTION_CHECK" => "Y",	// Строгая проверка раздела
		"FILTER_FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "",
		),
		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
		"LIST_VIEW" => "slider",	// Вид отображения связанных товаров
		"LINKED_ELEMENST_PAGE_COUNT" => "20",	// Количество связанных товаров на странице
		"ALSO_ITEMS_COUNT" => "5",	// Количество выводимых элементов сбоку
		"GALLERY_TYPE" => "small",	// Тип галлереи
		"SHOW_DISCOUNT_PERCENT_NUMBER" => "N",	// Отображать процент экономии
		"PRICE_CODE" => "",	// Тип цены
		"STORES" => array(	// Склады
			0 => "",
			1 => "",
		),
		"HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
		"FILE_404" => "",	// Страница для показа (по умолчанию /404.php)
		"TEMPLATE_THEME" => "blue",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"MEDIA_PROPERTY" => "",
		"SLIDER_PROPERTY" => "",
		"LIST_USE_SHARE" => "N",
		"SHARE_TEMPLATE" => "",
		"SHARE_HANDLERS" => array(
			0 => "delicious",
			1 => "lj",
			2 => "facebook",
			3 => "twitter",
			4 => "mailru",
			5 => "vk",
		),
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_SHORTEN_URL_KEY" => "",
		"GOOGLE_API_KEY" => "",
		"MAP_TYPE" => "0",
		"SHOW_FILTER_DATE" => "Y",
		"SECTIONS_TYPE_VIEW" => "sections_1",
		"SECTION_TYPE_VIEW" => "section_1",
		"TIZERS_IBLOCK_ID" => "",
		"LANDING_IBLOCK_ID" => "",
		"LANDING_SECTION_COUNT" => "10",
		"LANDING_TITLE" => "Популярные категории",
		"T_PROJECTS" => "",
		"T_REVIEWS" => "",
		"T_STAFF" => "",
		"IMAGE_CATALOG_POSITION" => "left",
		"SHOW_CHILD_SECTIONS" => "Y",
		"COUNT_IN_LINE" => "3",
		"DETAIL_BRAND_USE" => "N",
		"T_CLIENTS" => "",
		"SHARE_HIDE" => "N",
		"TAGS_CLOUD_ELEMENTS" => "150",
		"PERIOD_NEW_TAGS" => "",
		"DISPLAY_AS_RATING" => "rating",
		"FONT_MAX" => "50",
		"FONT_MIN" => "10",
		"COLOR_NEW" => "3E74E6",
		"COLOR_OLD" => "C0C0C0",
		"TAGS_CLOUD_WIDTH" => "100%",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE#/",
			"detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"rss" => "rss/",
			"rss_section" => "#SECTION_ID#/rss/",
		)
	),
	false
);?>
<script>
    //#netwiz start раскраска в стиле дзен

    //#netwiz end раскраска в стиле дзен
    //#netwiz start ленивая загрузка сторис
    function scrollTracking(){
        var windowTop = $(window).scrollTop();
        var windowHeight = $(window).height();
        var footerPosition = $('footer').offset().top - 110;
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
            zenColours();
        }
    }
    //если у нас все еще есть скрытая кнопка "показать еще посты" (то есть они не закончились)
    if($('.lazy-hidden')) {
        $(window).on('scroll', function () {
            //раскрашиваем под дзен если загрузили новое
            zenColours();
            //по скроллу проверяем, закончился ли у нас контент
            scrollTracking();
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
        if (tagType !== "") { //если для страницы существует баннер сравни
            if($('.content h2').length > 1) { //если у нас в статье не менее 2 заголовков h2
                //выводим первый баннер перед вторым заголовком
                $('.content h2').eq(1).before("<a href='/catalog/comparisons/'><img class='stories-banner-lg' src='/local/templates/aspro_next/images/banners/svg-lg/" + tagType + "-lg.svg' alt='' /><img class='stories-banner-sm' src='/local/templates/aspro_next/images/banners/stories/" + tagType + "-sm.svg' alt='' /></a>");
                if($('.content h2').length > 3 && tagOneClick !== "") { //если существует баннер заявки в 1 клик и заголовков h2 не менее 4
                    //выведем второй баннер перед ччетвертым заголовком
                    $('.content h2').eq(3).before("<img class='stories-banner-lg' src='/local/templates/aspro_next/images/banners/svg-lg/1-" + tagType + "-lg.svg' alt='' /><img class='stories-banner-sm' src='/local/templates/aspro_next/images/banners/stories/1-" + tagType + "-sm.svg' alt='' />");
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


</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>