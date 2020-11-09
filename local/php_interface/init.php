<?php
//*****************************************ОБЩИЕ ФУНКЦИИ*******************************//
function getObProp($name,$pr){
    $res = $pr;
    $arrPercent = Array();
    $arrPercent[] = 'Условия.Минимальный платеж в месяц %';
    $arrPercent[] = 'Условия.Процентная ставка на покупки';
    $arrPercent[] = 'Условия.Процентная ставка на наличные';
    if(is_array($pr)){
        foreach ($pr as $item){
            $val = $item;
            if (in_array($name, $arrPercent)){
                $val = $val*100;
            }

            if(strlen($res)==0){
                $res = $val;
            }else {
                $res = $res . " - " . $val;
            }
        }
    }
    /*$arrTrue = Array();
    $arrTrue[] = 'Условия.Кредитный лимит';
    $arrTrue[] = 'Условия.Годовое обслуживание';
    $arrTrue[] = 'Условия.Лимит на снятие наличных в месяц';
    $arrTrue[] = 'OFFERS.Кредитный лимит';
    $arrTrue[] = 'OFFERS.Годовое обслуживание';
    $arrTrue[] = 'OFFERS.Лимит на снятие наличных в месяц';
    if (in_array($name, $arrTrue)) :
        $ar_limit = str_split($res,3);

        if(count($ar_limit)>2){
            $kr_limit = (ceil($res/1000000))*1000000;
            $kr_limit = strval($kr_limit);
            $res = substr($kr_limit, 0,strlen($kr_limit)-6) . ' млн';
        }elseif(count($ar_limit)>1){
            $kr_limit = (ceil($res/1000))*1000;
            $kr_limit = strval($kr_limit);
            $res = substr($kr_limit, 0,strlen($kr_limit)-3) . ' тыс';
        }
    endif;*/
    return $res;
}
/**
 * @param $code_prop
 * @param $val_prop
 * @return string
 * получаем ед.изм
 */
function getEdIzm($code_prop,$val_prop)
{
    $edIzmR = "";
    $arFilterCP = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y', 'PROPERTY_CODE_PROP' => $code_prop];
    $arSelectCP = [ 'ID', 'NAME', 'PROPERTY_ED_IZM' ,'DATE_ACTIVE_FROM'];
    $resCP = CIBlockElement::GetList(array(),$arFilterCP,false,false,$arSelectCP);
    while($itemSortCP = $resCP->Fetch()):
        $edIzmR = $itemSortCP['PROPERTY_ED_IZM_VALUE'];
    endwhile;
    if($edIzmR=="дней")
    {
        $edIzmR = tpl_tpluralForm($val_prop,"день","дня","дней");
    }
    return $edIzmR;
}
/**
 * Склонение существительных с числительными.
 * Функция принимает число $n и три строки -
 * разные формы произношения измерения величины.
 * Необходимая величина будет возвращена.
 * Например: pluralForm(100, "рубль", "рубля", "рублей")
 * вернёт "рублей".
 *
 * @param int величина
 * @param string форма1
 * @param string форма2
 * @param string форма3
 * @return string
 */
function tpl_tpluralForm($n, $form1, $form2, $form3)
{

    $n = abs($n) % 100;
    $n1 = $n % 10;

    //echo $n .' - '.$n1;

    if ($n > 10 && $n < 20) {
        return $form3;
    }

    if ($n1 > 1 && $n1 < 5) {
        return $form2;
    }

    if ($n1 == 1) {
        return $form1;
    }

    return $form3;
}

/**
 * получить группу свойства
 */
function getGroupProperty($codeP)
{
    CModule::IncludeModule("iblock");
    $arrGroup = array();
    $arFilter = ['IBLOCK_ID' => 37, 'ACTIVE' => 'Y', 'PROPERTY_CODE_PROP'=>$codeP];
    $arSelect = [ 'ID', 'NAME', 'PROPERTY_GROUPS'];
    $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
    while($itemRes = $res->Fetch())
    {
        if($itemRes['PROPERTY_GROUPS_VALUE'])
        {
            $arrGroup['ID'] = $itemRes['PROPERTY_GROUPS_VALUE'];
            $resGr = CIBlockElement::GetByID($itemRes['PROPERTY_GROUPS_VALUE']);
            if($arGr = $resGr->GetNext())
                $arrGroup['NAME'] = $arGr['NAME'];
        }
    }
    return $arrGroup;
}


//*****************************************СОБЫТИЯ*******************************//

/**
 * проставляем обязательное свойство
 * чтобы отправить форму на почту
 */
AddEventHandler('form', 'onBeforeResultAdd', 'my_onBeforeResultAdd');
function my_onBeforeResultAdd($WEB_FORM_ID, &$arFields, &$arrVALUES)
{
    global $APPLICATION;

    // действие обработчика распространяется только на форму с ID=10
    if ($WEB_FORM_ID == 10)
    {
        $arrVALUES['licenses_popup']='Y';
    }
}

/**
 * деактивируем каталоги
 * где нет активных товаров
 */
/*AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", Array("my_onBeforeIBlockSectionUpdateHandler", "OnBeforeIBlockSectionUpdateHandler"));
class my_onBeforeIBlockSectionUpdateHandler
{
    // создаем обработчик события "OnBeforeIBlockSectionUpdate"
    function OnBeforeIBlockSectionUpdateHandler(&$arFields)
    {
        $resSec = CIBlockSection::GetList(array(),array('ID'=>$arFields['ID'],'IBLOCK_ID'=>$arFields['IBLOCK_ID'],'XML_ID'=>$arFields["XML_ID"]),false,array('ID','DEPTH_LEVEL'));
        $deth_level = 0;
        $sec_id     = 0;
        while($obSec = $resSec->GetNextElement()) {
            $arFieldsSec = $obSec->GetFields();
            $deth_level  = $arFieldsSec['DEPTH_LEVEL'];
            $sec_id      = $arFieldsSec['ID'];
        }
        if($deth_level>=2){
            $activeElements = CIBlockSection::GetSectionElementsCount($sec_id, Array("CNT_ACTIVE"=>"Y"));
            if($activeElements==0){
                $arFields["ACTIVE"]="N";
            }
        }
    }
}*/


//*****************************************АГЕНТЫ*******************************//
/**
 * деактивация товаров/обновление картинок брендов
 */
function UnActiveProducts(){
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("highloadblock");

    //получим все товары, которые необходимо деактивировать
    $arFilter = ['IBLOCK_ID' => 17, 'ACTIVE' => 'Y', 'PROPERTY_UDALIT_NA_SAYTE' => 2136];
    $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
    $resProduct = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
    try {
        while($itemResProduct = $resProduct->Fetch()) {
            $el = new CIBlockElement;
            $arLoadProductArray = Array("ACTIVE" => "N");
            $PRODUCT_ID = $itemResProduct['ID'];  // изменяем элемент с кодом (ID) 2
            $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
        }
    } catch (Throwable $e) {
        echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
    }

    //получим все товары с картинкой для бренда
    $resArr = Array();
    $resID  = Array();
    $arFilter = ['IBLOCK_ID' => 17, 'ACTIVE' => 'Y', '!PROPERTY_KARTINKA_BRENDA' => false];
    $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_KARTINKA_BRENDA','PROPERTY_MAGAZIN'];
    $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
    while($itemRes = $res->Fetch()) {
        //получим картинку
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();
        $resImg = $entityClass::getList(array(
            'select' => array('*'),
            'filter' => array('UF_XML_ID' => $itemRes['PROPERTY_KARTINKA_BRENDA_VALUE'])
        ));
        if ($rowImg = $resImg->fetch()) {
            $resID[]  = $itemRes['ID'];
            $resArr[$itemRes['ID']] = Array('ID'=>$itemRes['ID'],'PICTURE'=>CFile::GetPath($rowImg['UF_FILE']));
        }
    }

//получим торговые предложения
    $arFilter = ['IBLOCK_ID' => 20, 'ACTIVE' => 'Y', '!PROPERTY_MAGAZIN' => false,'PROPERTY_CML2_LINK'=>$resID];
    $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM','PROPERTY_MAGAZIN','PROPERTY_CML2_LINK'];
    $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);

    $arResM = array();
    $arResPut = array();
    while($itemRes = $res->Fetch()) {
        if(!in_array($itemRes['PROPERTY_MAGAZIN_VALUE'],$arResM)){
            $arResM[] = $itemRes['PROPERTY_MAGAZIN_VALUE'];
            $arResPut[] = Array("PIC"=>$resArr[$itemRes['PROPERTY_CML2_LINK_VALUE']]['PICTURE'],"MAG"=>$itemRes['PROPERTY_MAGAZIN_VALUE']);
        }
    }

    foreach ($arResPut as $itemP) {
        //получим картинку из 17 инфоблока
        $pic = $itemP["PIC"];
        //установим картинку
        $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById(4)->fetch();
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();
        $resUpdImg = $entityClass::getList(array(
            'select' => array('*'),
            'filter' => array('UF_XML_ID' => $itemP["MAG"])
        ));
        $arFile = CFile::MakeFileArray($pic);
        if ($rowUpdImg = $resUpdImg->fetch()) {
            $data = array(
                "UF_FILE"=>$arFile,
            );

            $result = $entityClass::update($rowUpdImg["ID"], $data);
            if ($result->isSuccess())
            {
                //echo $rowUpdImg["ID"] . ' - ' . $rowUpdImg["UF_NAME"] . ' - '  . $pic . ' - ' . $itemP["MAG"] . '</br>';
            }
            else
            {
                //echo 'ERROR! - ' . $rowUpdImg["ID"] . ' - ' . $rowUpdImg["UF_NAME"] . ' - '  . $pic . ' - ' . $itemP["MAG"] . '</br>';
            }
        }

    }

    return "UnActiveProducts();";
}
/**
 * Добавляем картинки категориям
 */
function AddPicturesInCategories(){
    /*CModule::IncludeModule("iblock");
    $url_parse = "https://myfinmarket.ru";
    $arFilter = Array('IBLOCK_ID'=>17, 'GLOBAL_ACTIVE'=>'Y');
    $rsSect  = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
    while ($arSect = $rsSect->GetNext())
    {*/
    /**
     * получим первый попавшийся товар из раздела
     */
    /*$arFilterEl = Array('IBLOCK_ID'=>17, 'ACTIVE'=>'Y','SECTION_ID'=>$arSect["ID"]);
    $arSelectEl = Array('ID','NAME','DETAIL_PICTURE');
    $rsElem = CIBlockElement::GetList(Array("RAND" => "ASC"), $arFilterEl,false,Array("nTopCount"=>1),$arSelectEl);
    while ($arElem = $rsElem->GetNext()){
        $pic = CFile::GetPath($arElem['DETAIL_PICTURE']);*/
    //echo 'Раздел - ' . $arSect['ID'] . ' имя - ' . $arSect['NAME'] . '</br>';
    //echo 'Элемент - ' . $arElem['ID'] . ' имя - ' . $arElem['NAME'] . ' картинка - ' . $pic . '</br>';
    /**
     * устанавливаем картинку раздела
     */
    /*$sec = new CIBlockSection;
    $arLoadProductArray = Array(
        "ACTIVE"         => "Y",
        "PICTURE" => CFile::MakeFileArray($url_parse . $pic),
    );
    $results = $sec->Update($arSect["ID"], $arLoadProductArray);
}
}*/

    return "AddPicturesInCategories();";
}

/**
 * Добавляем маркеры Для Путешествий
 */
function AddHitsTravel(){
    CModule::IncludeModule("iblock");

    //1.получим все у кого заполнено свойство для путешествий
    $arFilter = ['IBLOCK_ID' => 17, 'ACTIVE' => 'Y', '!PROPERTY_DLYA_PUTESHESTVIY' => false];
    $arSelect = [ 'ID', 'NAME', 'PROPERTY_HIT','PROPERTY_DLYA_PUTESHESTVIY'];
    $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);

    $arrUpdate = Array();
    while($itemRes = $res->Fetch()){
        if(isset($arrUpdate[$itemRes['ID']])){
            if($itemRes['PROPERTY_HIT_ENUM_ID']=='2131'){
                $arrUpdate[$itemRes['ID']]['LOAD']="Y";
            }
        }else{
            if($itemRes['PROPERTY_HIT_ENUM_ID']=='2131'){
                $arrUpdate[$itemRes['ID']]['LOAD'] = 'Y';
            }else{
                $arrUpdate[$itemRes['ID']]['LOAD'] = 'N';
            }
        }
        $arrUpdate[$itemRes['ID']]['HIT'][] = $itemRes['PROPERTY_HIT_ENUM_ID'];
    }
    foreach ($arrUpdate as $key=>$item){
        //2.получим текущие хиты(и если надо добавим 2131 - для путешествий)
        if($item['LOAD']=='N'){
            $arrLoad = $item['HIT'];
            $arrLoad[] = '2131';
            CIBlockElement::SetPropertyValuesEx($key, false, array('HIT' => $arrLoad));
        }
    }
    return "AddHitsTravel();";
}
/**
 * Добавляем регионы новым товарам
 */
function AddRegionsInProduct(){
    CModule::IncludeModule("iblock");

    $regions = Array();
    $arFilter = ['IBLOCK_ID' => 2, 'ACTIVE' => 'Y'];
    $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
    $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
    while($itemRes = $res->Fetch()){
        $regions[] = $itemRes['ID'];
    }
    $arFilter = ['IBLOCK_ID' => 17, 'ACTIVE' => 'Y', 'PROPERTY_LINK_REGION' => false];
    $arSelect = [ 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
    $res = CIBlockElement::GetList(array(),$arFilter,false,false,$arSelect);
    while($itemRes = $res->Fetch()){
        $el_id          = $itemRes['ID'];
        $iblock_id      = 17;
        $PROPERTY_CODE  = "LINK_REGION";
        $PROPERTY_VALUE = $regions;
        $prop = array($PROPERTY_CODE => $PROPERTY_VALUE);
        CIBlockElement::SetPropertyValuesEx($el_id, $iblock_id, $prop);
        //echo 'установили регионы для ID - ' . $el_id . '</br>';
        //break;
    }
    return "AddRegionsInProduct();";
}
/**
 * деактивируем каталоги
 * где нет активных товаров
 */
function DeactivationEmptySections(){
    CModule::IncludeModule("iblock");

    $resSec = CIBlockSection::GetList(array(),array('IBLOCK_ID'=>17),false,array('ID','DEPTH_LEVEL','XML_ID'));
    while($obSec = $resSec->GetNextElement()) {
        $arFieldsSec = $obSec->GetFields();
        $deth_level  = $arFieldsSec['DEPTH_LEVEL'];
        $sec_id      = $arFieldsSec['ID'];
        $xml_id      = $arFieldsSec['XML_ID'];
        if($deth_level>=2){
            $activeElements = CIBlockSection::GetSectionElementsCount($sec_id, Array("CNT_ACTIVE"=>"Y"));
            if($activeElements==0){
                $arFields = Array();
                $bs = new CIBlockSection;
                $res = $bs->Update($sec_id, $arFields);
            }
        }
    }

    return "DeactivationEmptySections();";
}
function see($obj, $v = false)
{
	if($v==true){
		global $USER;
		if ($USER->IsAdmin()){
			echo '<pre>';
			print_r($obj);
			echo '</pre>';
		}
	} else {
		echo '<pre>';
		print_r($obj);
		echo '</pre>';
	}
	
}
function formatToHuman($number)
{        
	if ($number < 1000) {
		return sprintf('%d', $number);
	}

	if($number < 10000){
        return $newVal = $number ;
    }

	if ($number >= 10000 && $number < 1000000) {
		$number = $number / 1000;
		return $newVal = number_format($number,0) . ' тыс.';
	}

	if ($number >= 1000000 && $number < 1000000000) {
		$number = $number / 1000000;
		return $newVal = number_format($number,0) . ' млн.';
	}

	if ($number >= 1000000000 && $number < 1000000000000) {
		$number = $number / 1000000000;
		return $newVal = number_format($number,0) . ' B';
	}

	return sprintf('%d%s', floor($number / 1000000000000), 'T+');        
}

/*
 * функция для определения что писать после числа если нудно подставить значения ГОД, ГОДА, ЛЕТ.
 *
 */
function declension($number, array $data)
{
    $rest = array($number % 10, $number % 100);

    if ($rest[1] > 10 && $rest[1] < 20) {
        return $data[2];
    } elseif ($rest[0] > 1 && $rest[0] < 5) {
        return $data[1];
    } else if ($rest[0] == 1) {
        return $data[0];
    }

    return $data[2];
}

/*
 * пример вызова функции.
$number = 47;
echo $number, ' ', declension($number, array('год', 'года', 'лет'));
*/


//*****************************************ПОДКЛЮЧАЕМЫЕ СОБЫТИЯ*******************************//
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/const.php'))
    require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/const.php');
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/event_handlers.php'))
    require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/event_handlers.php');
/*if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/list_iblocks.php'))
    require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/list_iblocks.php');*/
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/tables_for_advertiser.php')) 
	require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/tables_for_advertiser.php');
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_mobile_pay_setter.php'))
	require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_mobile_pay_setter.php');
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_documents_setter.php'))
	require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_documents_setter.php');
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_documents_ip_setter.php'))
	require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_documents_ip_setter.php');
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_documents_ooo_setter.php'))
	require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/property_documents_ooo_setter.php');
if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/menu/menu_add.php'))
    require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/menu/menu_add.php');
//if(file_exists($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/custom_iblock.php'))
	//require_once($_SERVER["DOCUMENT_ROOT"].'/local/php_interface/include/custom_iblock.php');
?>
