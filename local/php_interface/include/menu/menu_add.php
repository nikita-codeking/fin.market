<?
AddEventHandler("main", "OnBuildGlobalMenu", "newAddMenu");
function newAddMenu(&$adminMenu, &$moduleMenu){
    /**
     * SEO копир
     */
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_settings",
        "icon" =>        "default_menu_icon",
        "page_icon" =>   "default_page_icon",
        "sort"=>         "900",
        "text"=>         "SEO копир",
        "title"=>        "SEO копир",
        "url"=>          "fm_seo_copir.php?lang=".LANG,  // ссылка на пункте меню
        "more_url"=>      array(),
    );
    /**
     * визуальная карта сайта
     */
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_settings",
        "icon" =>        "default_menu_icon",
        "page_icon" =>   "default_page_icon",
        "sort"=>         "901",
        "text"=>         "SEO VISUAL MAP",
        "title"=>        "SEO VISUAL MAP",
        "url"=>          "fm_site_map.php?lang=".LANG,  // ссылка на пункте меню
        "more_url"=>      array(),
    );
    /**
     * загрузка городов
     */
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_settings",
        "icon" =>        "default_menu_icon",
        "page_icon" =>   "default_page_icon",
        "sort"=>         "902",
        "text"=>         "Загрузка регионов в продукты",
        "title"=>        "Загрузка регионов в продукты",
        "url"=>          "fm_load_geo_product.php?lang=".LANG,  // ссылка на пункте меню
        "more_url"=>      array(),
    );
}

?>