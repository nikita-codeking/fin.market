<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$newArResult = Array();?>
<?$newArResultOther = Array();?>
<?$start_clear = false;?>
<?php
//сервисы и бизнес тоже  в прочие на десктопе добавь
foreach ($arResult as &$item){ 
    /*if($item['TEXT']=='Для бизнеса'){
        $start_clear = true;
        $item['DEPTH_LEVEL'] = 2;
        $item['IS_PARENT']   = 0;
        $newArResultOther[] = $item;
    }else{
        if($item['IS_PARENT']==0 && $start_clear){
            //$newArResultOther[] = $item;
        }else{
            if($item['IS_PARENT']>0){
                $start_clear = false;
            }
        }

    }*/
	if($item['DEPTH_LEVEL'] != 3){
		if($item["TEXT"] == "Кредитные карты" || $item["TEXT"] == "Карты рассрочки"
			 || $item["TEXT"] == "Дебетовые карты" || $item["TEXT"] == "Займы" || $item["TEXT"] == "Ипотека"
			 || $item["TEXT"] == "Автокредиты" || $item["TEXT"] == "Рефинансирование" || $item["TEXT"] == "Кредиты наличными" || $item["TEXT"] == "Расчётные счета"){
			$item['IS_PARENT'] = 0;
		}
		//see($item,true);
		$newArResult[] = $item;
	}
}
?>
<?
$newArResult[] = Array(
    'TEXT' => 'Прочее',
    'LINK' => '',
    'PERMISSION' => 'R',
    'ADDITIONAL_LINKS' => Array(),
    'ITEM_TYPE' => 'D',
    'DEPTH_LEVEL' => 1,
    'IS_PARENT' => 1
);
$newArResult[] = Array(
    'TEXT' => 'Рейтинги',
    'LINK' => '/ratings/',
    'PERMISSION' => 'R',
    'ADDITIONAL_LINKS' => Array(),
    'ITEM_TYPE' => 'D',
    'DEPTH_LEVEL' => 2,
    'IS_PARENT' => 0
);
///articles/?tags=Обзоры
$newArResult[] = Array(
    'TEXT' => 'Обзоры',
    'LINK' => '/reviews/',
    'PERMISSION' => 'R',
    'ADDITIONAL_LINKS' => Array(),
    'ITEM_TYPE' => 'D',
    'DEPTH_LEVEL' => 2,
    'IS_PARENT' => 0
);
$newArResult[] = Array(
    'TEXT' => 'Сторис',
    'LINK' => '/articles/',
    'PERMISSION' => 'R',
    'ADDITIONAL_LINKS' => Array(),
    'ITEM_TYPE' => 'D',
    'DEPTH_LEVEL' => 2,
    'IS_PARENT' => 0
);

/**
 * На мобилие Рейтинги и Сюжеты отдельными разделами
 */

$newArResult[] = Array(
    'TEXT' => 'Рейтинги',
    'LINK' => '/ratings/',
    'PERMISSION' => 'R',
    'ADDITIONAL_LINKS' => Array(),
    'ITEM_TYPE' => 'D',
    'DEPTH_LEVEL' => 1,
    'IS_PARENT' => 1
);
$newArResult[] = Array(
    'TEXT' => 'Обзоры',
    'LINK' => '/reviews/',
    'PERMISSION' => 'R',
    'ADDITIONAL_LINKS' => Array(),
    'ITEM_TYPE' => 'D',
    'DEPTH_LEVEL' => 1,
    'IS_PARENT' => 1
);
$newArResult[] = Array(
    'TEXT' => 'Сторис',
    'LINK' => '/articles/',
    'PERMISSION' => 'R',
    'ADDITIONAL_LINKS' => Array(),
    'ITEM_TYPE' => 'D',
    'DEPTH_LEVEL' => 1,
    'IS_PARENT' => 1
);

$arResult = $newArResult;
?>
