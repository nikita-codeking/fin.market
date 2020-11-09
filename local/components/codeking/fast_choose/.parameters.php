<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * */
 
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if( !Loader::includeModule("iblock") ) {
    throw new \Exception('Не загружены модули необходимые для работы компонента');
}

// типы инфоблоков
$arIBlockType = CIBlockParameters::GetIBlockTypes();

// инфоблоки выбранного типа
$arIBlock = [];
$iblockFilter = !empty($arCurrentValues['IBLOCK_TYPE'])
    ? ['TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y']
    : ['ACTIVE' => 'Y'];

$rsIBlock = CIBlock::GetList(['SORT' => 'ASC'], $iblockFilter);
while ($arr = $rsIBlock->Fetch()) {
    $arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
}
$arIBlockSections = [];
if(!empty($arCurrentValues["IBLOCK_ID"])){
$rsSections = CIBlockSection::GetList(["SORT"=>"ASC"], ["IBLOCK_ID" =>  $arCurrentValues["IBLOCK_ID"],"DEPTH_LEVEL" => [1,2],"ACTIVE" => "Y"],false,array("ID","NAME"));
	while ($arr = $rsSections->Fetch()) {
		$arIBlockSections[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
	}
}
unset($arr, $rsIBlock, $iblockFilter);
$arComponentParameters = [
    // группы в левой части окна
    "GROUPS" => [
        "SETTINGS" => [
            "NAME" => Loc::getMessage('EXAMPLE_COMPSIMPLE_PROP_SETTINGS'),
            "SORT" => 550,
        ],
    ],
    // поля для ввода параметров в правой части
    "PARAMETERS" => [
        // Произвольный параметр типа СПИСОК
        "IBLOCK_TYPE" => [
            "PARENT" => "SETTINGS",
            "NAME" => Loc::getMessage('EXAMPLE_COMPSIMPLE_PROP_IBLOCK_TYPE'),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y"
        ],
        "IBLOCK_ID" => [
            "PARENT" => "SETTINGS",
            "NAME" => Loc::getMessage('EXAMPLE_COMPSIMPLE_PROP_IBLOCK_ID'),
            "TYPE" => "LIST",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y"
        ],
		"IBLOCK_SECTIONS" => [
            "PARENT" => "SETTINGS",
            "NAME" => Loc::getMessage('EXAMPLE_COMPSIMPLE_PROP_IBLOCK_SECTIONS'),
            "TYPE" => "LIST",
			"MULTIPLE" => "Y",
            "ADDITIONAL_VALUES" => "Y",
            "VALUES" => $arIBlockSections,
            "REFRESH" => "N"
        ],
        // Настройки кэширования
        'CACHE_TIME' => ['DEFAULT' => 0],
    ]
];