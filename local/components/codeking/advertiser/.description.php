<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("COMPONENT_NAME"),
    "DESCRIPTION" => Loc::getMessage("COMPONENT_DESCRIPTION"),
    "COMPLEX" => "N",
    "PATH" => [
        "ID" => Loc::getMessage("PATH_ID"),
        "NAME" => Loc::getMessage("PATH_NAME"),
    ],
];
?>
