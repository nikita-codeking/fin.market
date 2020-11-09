<?
use \Bitrix\Main\Localization\Loc;
Loc::LoadMessages(__FILE__);
/**
 * Настройка столбцов списка элементов ИБ в админке инфоблоков
 *
 * @param integer $IBlockID — ID инфоблока
 * @param string $arIBlockListAdminColumns — символьные коды полей и свойств для показа в списке элементов ИБ
 * @param string $orderByColumnName — наименования поля или свойства по которому нудно отсортировать
 * @param string $orderDirection - направление сортировки
 * @param integer $pageSize - количество элементов на страницу
 * @param boolean $isToAllUsers - значение будет для всех, или для текущего пользователя
 * @return boolean
 */
function SetIBlockAdminListDisplaySettings($IBlockID, $arIBlockListAdminColumns, $orderByColumnName, $orderDirection, $pageSize, $isToAllUsers = TRUE)
{
    if($IBlockID==35)
    {
        // по ID инфоблока получить его тип
        $IBlockType = CIBlock::GetArrayByID($IBlockID, 'IBLOCK_TYPE_ID');
        if(FALSE == $IBlockType)
        {
            return FALSE;
        }
        // и все его свойства
        $arPropertyCode = array();
        $obProperties = CIBlockProperty::GetList(array("sort"=>"asc"), array("IBLOCK_ID"=>$IBlockID));
        while($arProp = $obProperties->GetNext(true, false)) {
            $arPropertyCode[$arProp['CODE']] = $arProp['ID'];
        }
        echo '<pre>';
        print_r($arPropertyCode);
        echo '</pre>';
        exit();
        // пройти по массиву для показа и заменить CODE на PROPERTY_ID свойства
        /*$arColumnList = array();
        foreach($arIBlockListAdminColumns as $columnCode)
        {
            if(TRUE == array_key_exists($columnCode, $arPropertyCode))
            {
                $arColumnList[] = 'PROPERTY_'.$arPropertyCode[$columnCode];
            }
            else
            {
                $arColumnList[] = $columnCode;
            }
        }
        $columnSettings = implode(',',$arColumnList);

        // выставляем поля в списке
        $arOptions[] = array(
            'c' => 'list',
            'n' => "tbl_iblock_list_".md5($IBlockType.".".$IBlockID),
            'v' => array(
                'columns'=> strtoupper($columnSettings),
                'by'=> strtoupper($orderByColumnName),
                'order'=> strtoupper($orderDirection),
                'page_size' => $pageSize
            ),
        );
        if(TRUE == $isToAllUsers)
        {
            $arOptions[0]['d']='Y';
        }
        CUserOptions::SetOptionsFromArray($arOptions);*/
    }//if($IBlockID==35)

}// end of SetIBlockAdminListDisplaySettings



?>