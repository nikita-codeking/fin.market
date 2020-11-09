<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<? global $arTheme, $APPLICATION;?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/hc-sticky.js");?>
<div class="bubble"></div>
<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
	"COMPONENT_TEMPLATE" => ".default",
		"PATH" => SITE_DIR."include/left_block/menu.left_menu.php",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => "include_area.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>

<?$APPLICATION->ShowViewContent('left_menu');?>
<?$APPLICATION->ShowViewContent('under_sidebar_content');?>

<?CNext::get_banners_position('SIDE', 'Y');?>

<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
	"COMPONENT_TEMPLATE" => ".default",
		"PATH" => SITE_DIR."include/left_block/comp_subscribe.php",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "",
		"AREA_FILE_RECURSIVE" => "Y",
		"EDIT_TEMPLATE" => "include_area.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
    "COMPONENT_TEMPLATE" => ".default",
    "PATH" => SITE_DIR."include/left_block/comp_news.php",
    "AREA_FILE_SHOW" => "file",
    "AREA_FILE_SUFFIX" => "",
    "AREA_FILE_RECURSIVE" => "Y",
    "EDIT_TEMPLATE" => "include_area.php"
),
    false,
    array(
        "ACTIVE_COMPONENT" => "N"
    )
);?>
<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
    "COMPONENT_TEMPLATE" => ".default",
    "PATH" => SITE_DIR."include/left_block/comp_news_articles.php",
    "AREA_FILE_SHOW" => "file",
    "AREA_FILE_SUFFIX" => "",
    "AREA_FILE_RECURSIVE" => "Y",
    "EDIT_TEMPLATE" => "include_area.php"
),
    false,
    array(
        "ACTIVE_COMPONENT" => "N"
    )
);?>
<script>
    "use strict";
    var Sticky = new hcSticky('.left_block', {
        stickTo: '.wrapper_inner ',
        responsive: {
            980: {
                disable: true
            }
        }
    });
    $(document).ready(function() {
        if($(window).width()>960) {
            $(window).scroll(function() {
                var html = document.documentElement;
                var body = document.body;
                var scrollTop = html.scrollTop || body && body.scrollTop || 0;
                scrollTop -= html.clientTop; // в IE7- <html> смещён относительно (0,0)
                if (scrollTop > 200){
                    $('.bubble').addClass('grow');
                }else {
                    $('.bubble').removeClass('grow');
                }

            });
        }
    });
</script>
