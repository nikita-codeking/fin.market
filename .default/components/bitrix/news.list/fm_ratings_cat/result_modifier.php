<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
foreach($arResult["ITEMS"] as &$arItem){
	$filter = Array("ID" => $arItem["CREATED_BY"]);
	$queryUser = CUser::GetList(($by="id"), ($order="desc"), $filter);
	$queryUserRes = $queryUser->Fetch();
	$queryUserRes["PERSONAL_PHOTO"] = CFile::GetPath($queryUserRes["PERSONAL_PHOTO"]);
	$arItem["USER"] = $queryUserRes;
}