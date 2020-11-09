<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?if($GET["debug"] == "y")
    error_reporting(E_ERROR | E_PARSE);
IncludeTemplateLangFile(__FILE__);
global $APPLICATION, $arRegion, $arSite, $arTheme, $selectCity;
$arSite = CSite::GetByID(SITE_ID)->Fetch();
$htmlClass = ($_REQUEST && isset($_REQUEST['print']) ? 'print' : false);
$bIncludedModule = (\Bitrix\Main\Loader::includeModule("aspro.next"));?>

    <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>" <?=($htmlClass ? 'class="'.$htmlClass.'"' : '')?>>
    <head>
        <title><?$APPLICATION->ShowTitle()?> <?php if($APPLICATION->GetCurDir() == "/articles/" || $APPLICATION->GetCurDir() == "/reviews/" || ($APPLICATION->GetCurDir() == "/catalog/offers/" && empty($_GET["ELEMENT_ID"]))):?><?=$APPLICATION->GetProperty("ПОДЗАГОЛОВОК");?><?php endif;?>
		</title>
        <?$APPLICATION->ShowMeta("viewport");?>
        <?$APPLICATION->ShowMeta("HandheldFriendly");?>
        <?$APPLICATION->ShowMeta("apple-mobile-web-app-capable", "yes");?>
        <?$APPLICATION->ShowMeta("apple-mobile-web-app-status-bar-style");?>
        <?$APPLICATION->ShowMeta("SKYPE_TOOLBAR");?>
        <?$APPLICATION->ShowHead();?>
        <?$APPLICATION->AddHeadString('<script>BX.message('.CUtil::PhpToJSObject( $MESS, false ).')</script>', true);?>
        <?if($bIncludedModule)
            CNext::Start(SITE_ID);?>
        <meta name="verify-admitad" content="2f192ce72a" />
        <!--VK-PIXEL-START-->
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?162",t.onload=function(){VK.Retargeting.Init("VK-RTRG-427063-4pb6j"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script>
        <!--VK-PIXEL-END-->
        <meta name="yandex-verification" content="7f33335296c112d8" />
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '221918265508132');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=221918265508132&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
        <meta name="yandex-verification" content="1283192ef4ec6dfc" />
        <meta name="yandex-verification" content="d183e4f3192b00e9" />
        <meta name="yandex-verification" content="070521348e43d81d" />
        <meta name="yandex-verification" content="1283192ef4ec6dfc" />
        <meta name="google-site-verification" content="OurBGtAt2uQA0pVzyy1K5kaUuEY9tYEjYveK96aE75Q" />
        <meta name="p:domain_verify" content="d264eb73c9b200178f8985554eb634d7"/>
        <meta name="yandex-verification" content="afb703ec5bf12e3f" />
        <!--<script src="https://sravni.ru/f/apps/build/widgets/sravni-widgets.js"></script>-->
        <!--<script src="https://unpkg.com/fast-average-color/dist/index.min.js"></script>-->
        <meta name="yandex-verification" content="71e64791cc5a6230" />
        <style>
            body {
                margin: 0;
            }

            .preloader {
                /*фиксированное позиционирование*/
                position: fixed;
                /* координаты положения */
                left: 0;
                top: 0;
                right: 0;
                bottom: 0;
                /* фоновый цвет элемента */
                background: #fff;
                /* размещаем блок над всеми элементами на странице (это значение должно быть больше, чем у любого другого позиционированного элемента на странице) */
                z-index: 1001;
            }
            .preloader .logo {
                width: 190px;
                position: absolute;
                z-index: 2000;
                top: calc(50% - 60px);
                left: 50%;
                transform: translateX(-50%) translateY(-50%);
            }
            .preloader__row {
                position: relative;
                top: 50%;
                left: 50%;
                width: 70px;
                height: 70px;
                margin-top: -35px;
                margin-left: -35px;
                text-align: center;
                animation: preloader-rotate 2s infinite linear;
            }

            .preloader__item {
                position: absolute;
                display: inline-block;
                top: 0;
                background-color: #6fa5f3;
                border-radius: 100%;
                width: 35px;
                height: 35px;
                animation: preloader-bounce 2s infinite ease-in-out;
            }

            .preloader__item:last-child {
                top: auto;
                bottom: 0;
                animation-delay: -1s;
            }

            @keyframes preloader-rotate {
                100% {
                    transform: rotate(360deg);
                }
            }

            @keyframes preloader-bounce {

                0%,
                100% {
                    transform: scale(0);
                }

                50% {
                    transform: scale(1);
                }
            }

            .loaded_hiding .preloader {
                transition: 0.3s opacity;
                opacity: 0;
            }

            .loaded .preloader {
                display: none;
            }
        </style>
    </head>
<?$bIndexBot = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false); // is indexed yandex/google bot?>
<body class="site_<?=SITE_ID?> <?=($bIncludedModule ? "fill_bg_".strtolower(CNext::GetFrontParametrValue("SHOW_BG_BLOCK")) : "");?> <?=($bIndexBot ? "wbot" : "");?> <?=($isIndex ? ' index' : '')?>" id="main">
    <!-- Прелоадер -->
    <div class="preloader">
        <div class="logo">
            <img src="/upload/CNext/fd9/fd9276a41f6df78af744ea73f752a11a.svg" alt="ФинМаркет" title="ФинМаркет">
        </div>
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?if(!$bIncludedModule):?>
    <?$APPLICATION->SetTitle(GetMessage("ERROR_INCLUDE_MODULE_ASPRO_NEXT_TITLE"));?>
    <center><?$APPLICATION->IncludeFile(SITE_DIR."include/error_include_module.php");?></center></body></html><?die();?>
<?endif;?>

<?$arTheme = $APPLICATION->IncludeComponent("aspro:theme.next", ".default", array("COMPONENT_TEMPLATE" => ".default"), false, array("HIDE_ICONS" => "Y"));?>
<?include_once('defines.php');?>
<?CNext::SetJSOptions();?>

<div class="wrapper1 <?=($isIndex && $isShowIndexLeftBlock ? "with_left_block" : "");?> <?=CNext::getCurrentPageClass();?> <?=CNext::getCurrentThemeClasses();?> ">
<?CNext::get_banners_position('TOP_HEADER');?>

    <div class="header_wrap visible-lg visible-md title-v<?=$arTheme["PAGE_TITLE"]["VALUE"];?><?=($isIndex ? ' index1' : '')?>">
        <header id="header">
            <?CNext::ShowPageType('header');?>
        </header>
    </div>
<?CNext::get_banners_position('TOP_UNDERHEADER');?>

<?if($arTheme["TOP_MENU_FIXED"]["VALUE"] == 'Y'):?>
    <div id="headerfixed">
        <?CNext::ShowPageType('header_fixed');?>
    </div>
<?endif;?>

    <div id="mobileheader" class="visible-xs visible-sm <?=($isIndex ? ' mob_index' : '')?>">
        <?CNext::ShowPageType('header_mobile');?>
        <div id="mobilemenu" class="<?=($arTheme["HEADER_MOBILE_MENU_OPEN"]["VALUE"] == '1' ? 'leftside':'dropdown')?> <?=($arTheme['HEADER_MOBILE_MENU_COMPACT']['VALUE'] == 'Y' ? 'menu-compact':'')?> ">
            <?CNext::ShowPageType('header_mobile_menu');?>
        </div>
    </div>

<?if($arTheme['MOBILE_FILTER_COMPACT']['VALUE'] === 'Y'):?>
    <div id="mobilefilter" class="visible-xs visible-sm scrollbar-filter"></div>
<?endif;?>

<?/*filter for contacts*/
if($arRegion)
{
    if($arRegion['LIST_STORES'] && !in_array('component', $arRegion['LIST_STORES']))
    {
        if($arTheme['STORES_SOURCE']['VALUE'] != 'IBLOCK')
            $GLOBALS['arRegionality'] = array('ID' => $arRegion['LIST_STORES']);
        else
            $GLOBALS['arRegionality'] = array('PROPERTY_STORE_ID' => $arRegion['LIST_STORES']);
    }
}
if($isIndex)
{
    $GLOBALS['arrPopularSections'] = array('UF_POPULAR' => 1);
    $GLOBALS['arrFrontElements'] = array('PROPERTY_SHOW_ON_INDEX_PAGE_VALUE' => 'Y');
}
?>

<div class="wraps hover_<?=$arTheme["HOVER_TYPE_IMG"]["VALUE"];?>" id="content">
<?if(!$is404 && !$isForm && !$isIndex):?>
    <?$APPLICATION->ShowViewContent('section_bnr_content');?>
    <?if($APPLICATION->GetProperty("HIDETITLE") !== 'Y'):?>
        <!--title_content-->
        <!--<a href="/catalog/comparisons/" id="catalogTopPageTitle"></a>--><?CNext::ShowPageType('page_title');?>
        <!--end-title_content-->
    <?endif;?>
    <?$APPLICATION->ShowViewContent('top_section_filter_content');?>
<?endif;?>

<?if($isIndex):?>
    <div class="wrapper_inner front <?=($isShowIndexLeftBlock ? "" : "wide_page");?>">
    <?elseif(!$isWidePage):?>
    <div class="wrapper_inner <?=($isHideLeftBlock ? "wide_page" : "");?>">
<?endif;?>

<?if(($isIndex && $isShowIndexLeftBlock) || (!$isIndex && !$isHideLeftBlock) && !$isBlog):?>
    <div class="right_block <?=(defined("ERROR_404") ? "error_page" : "");?> wide_<?=CNext::ShowPageProps("HIDE_LEFT_BLOCK");?>">
<?endif;?>
<div class="middle <?=($is404 ? 'error-page' : '');?>">
<?CNext::get_banners_position('CONTENT_TOP');?>
<?if(!$isIndex):?>
    <div class="container">
    <?//h1?>
    <?if($isHideLeftBlock && !$isWidePage):?>
    <div class="maxwidth-theme">
    <?endif;?>
    <?if($isBlog):?>
    <div class="row">
    <div class="col-md-9 col-sm-12 col-xs-12 content-md blog-content <?=CNext::ShowPageProps("ERROR_404");?>">
<?endif;?>
<?endif;?>
<?CNext::checkRestartBuffer();?>