<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "GROUPS" => array(
    ),
    "PARAMETERS" => array(
        "ID_IBLOCK" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("FM_COMPARE_SEO_ID_IBLOCK"),
            "TYPE" => "STRING",
            "ROWS" => 1
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000)
    ),
);
?>
