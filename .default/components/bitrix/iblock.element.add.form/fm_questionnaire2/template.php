<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
CJSCore::Init(array('date'));
$this->setFrameMode(false);
?>
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.maskedinput-1.2.2.js"></script>
<? 
if (!empty($arResult["ERRORS"])):?>
	<p id="errors_show">Пожалуйста, заполните все поля корректно</p>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;
if (strlen($arResult["MESSAGE"]) > 0):?>
	<? ShowNote($arResult["MESSAGE"])?>
<?endif?>
<form name="iblock_add" id="input_form" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
	<table class="data-table" style="width: 90%">
		<?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>
		<tbody>
            <?
            //kk-->
            //if ($USER->IsAdmin()){
                //текущее значение - вида
                $name_type_property = "";
                if(isset($_GET['TYPE']) && !empty($_GET['TYPE'])) {
                    $name_type_property = $_GET['TYPE'];
                }elseif (isset($arParams["OSN"])){
                    $name_type_property = $arParams["OSN"];
                }else{
                    foreach ($arResult["PROPERTY_LIST_FULL"][564]["ENUM"] as $key => $arEnum) {
                        if (is_array($arResult["ELEMENT_PROPERTIES"][564])) {
                            foreach ($arResult["ELEMENT_PROPERTIES"][564] as $arElEnum) {
                                if ($arElEnum["VALUE"] == $key) {
                                    $name_type_property = $arElEnum["VALUE_ENUM"];
                                    break;
                                }
                            }
                        }
                    }
                }
            //}
            global $USER;
            $rsUsers = CUser::GetByID($USER->GetID());
            $arUser = $rsUsers->Fetch();
            //<--kk
            ?>
			<?foreach ($arResult["PROPERTY_LIST"] as $propertyID):?>
                <?
                //kk-->
                //if ($USER->IsAdmin()){
                    $visible_property = false;
                    $name_property = $arResult["PROPERTY_LIST_FULL"][$propertyID]['CODE'];
                    //echo $name_property . '</br>';
                    if($name_property=='TYPE' || $name_property=='LAST_NAME' || $name_property=='NAME' || $name_property=='SECOND_NAME'|| $name_property==''){
                        $visible_property = true;
                    }else{
                        $visible_property_arr = $arResult['VISIBLE'][$name_property];
                        if(count($visible_property_arr)>1){
                            for ($i = 1; $i < count($visible_property_arr); $i++) {
                                if($visible_property_arr[$i]==$name_type_property){
                                    $visible_property = true;
                                    break;
                                }//if($visible_property_arr[$i]==$name_type_property)
                            }//for ($i = 1; $i < count($visible_property_arr); $i++)
                        }//if(count($visible_property_arr)>1)
                    }//if($name_property=='TYPE' || $name_property=='LAST_NAME' || $name_property=='NAME' || $name_property=='SECOND_NAME')
                    if(!$visible_property){
                        continue;
                    }
                //}
                //<--kk
                ?>

				<tr>
					<td <?if($propertyID=='NAME'):?>class="main_name_q_label"<?endif;?>><?if (intval($propertyID) > 0):?><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?><?else:?><?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?><?endif?><?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?><span class="starrequired">*</span><?endif?></td>
                    <?
                    $val_main = "";
                    if($propertyID=='NAME'){
                        $val_main = $arUser["LAST_NAME"] . ' ' . $arUser["NAME"] . ' ' . $arUser["SECOND_NAME"];
                    }elseif ($propertyID==334){ //LAST_NAME
                        $val_main = $arUser["LAST_NAME"];
                    }elseif ($propertyID==335){ //NAME
                        $val_main = $arUser["NAME"];
                    }elseif ($propertyID==336){ //SECOND_NAME
                        $val_main = $arUser["SECOND_NAME"];
                    }
                    //echo $val_main. '</br>';
                    ?>

                    <?php
                        $class = '';
                        switch ($propertyID):
                            case 'NAME':
                                $class = 'class="main_name_q_input"';
                                break;
                            case 338: //место рождения
                                $class = 'class="q_input_338"';
                                break;
                            case 343: //город регистрации
                                $class = 'class="q_input_343"';
                                break;
                            case 357: //город получения кредита
                                $class = 'class="q_input_357"';
                                break;
			     case 344: //Адрес проживания, населенный пункт
                                $class = 'class="q_input_344"';
                                break;
			     case 568: //Адрес регистрации, населенный пункт
                                $class = 'class="q_input_568"';
                                break;
 			     case 571: //Адрес работы, населенный пункт
                                $class = 'class="q_input_571"';
                                break;
			    case 340: //
                                $class = 'class="q_input_340"';
                                break;
			    case 368: //
                                $class = 'class="q_input_368"';
                                break;
                        endswitch;
                    ?> 
                    <td <?=$class;?>>

						<?
						if (intval($propertyID) > 0)
						{
							if (
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
							elseif (
								(
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
									||
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
								)
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
						}
						elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
							$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
						{
							$inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
							$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
						}
						else
						{
							$inputNum = 1;
						}

						if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
							$INPUT_TYPE = "USER_TYPE";
						else
							$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];
                        ?>

                        <?
						switch ($INPUT_TYPE):
							case "USER_TYPE":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["~VALUE"] : $arResult["ELEMENT"][$propertyID];
										$description = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["DESCRIPTION"] : "";
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
										$description = "";
									}
									else
									{
										$value = "";
										$description = "";
									}
									echo call_user_func_array($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"],
										array(
											$arResult["PROPERTY_LIST_FULL"][$propertyID],
											array(
												"VALUE" => $value,
												"DESCRIPTION" => $description,
											),
											array(
												"VALUE" => "PROPERTY[".$propertyID."][".$i."][VALUE]",
												"DESCRIPTION" => "PROPERTY[".$propertyID."][".$i."][DESCRIPTION]",
												"FORM_NAME"=>"iblock_add",
											),
										));
								?><br /><?
								}
							break;
							case "TAGS":
								$APPLICATION->IncludeComponent(
									"bitrix:search.tags.input",
									"",
									array(
										"VALUE" => $arResult["ELEMENT"][$propertyID],
										"NAME" => "PROPERTY[".$propertyID."][0]",
										"TEXT" => 'size="'.$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"].'"',
									), null, array("HIDE_ICONS"=>"Y")
								);
								break;
							case "HTML":
								$LHE = new CHTMLEditor;
								$LHE->Show(array(
									'name' => "PROPERTY[".$propertyID."][0]",
									'id' => preg_replace("/[^a-z0-9]/i", '', "PROPERTY[".$propertyID."][0]"),
									'inputName' => "PROPERTY[".$propertyID."][0]",
									'content' => $arResult["ELEMENT"][$propertyID],
									'width' => '100%',
									'minBodyWidth' => 350,
									'normalBodyWidth' => 555,
									'height' => '200',
									'bAllowPhp' => false,
									'limitPhpAccess' => false,
									'autoResize' => true,
									'autoResizeOffset' => 40,
									'useFileDialogs' => false,
									'saveOnBlur' => true,
									'showTaskbars' => false,
									'showNodeNavi' => false,
									'askBeforeUnloadPage' => true,
									'bbCode' => false,
									'siteId' => SITE_ID,
									'controlsMap' => array(
										array('id' => 'Bold', 'compact' => true, 'sort' => 80),
										array('id' => 'Italic', 'compact' => true, 'sort' => 90),
										array('id' => 'Underline', 'compact' => true, 'sort' => 100),
										array('id' => 'Strikeout', 'compact' => true, 'sort' => 110),
										array('id' => 'RemoveFormat', 'compact' => true, 'sort' => 120),
										array('id' => 'Color', 'compact' => true, 'sort' => 130),
										array('id' => 'FontSelector', 'compact' => false, 'sort' => 135),
										array('id' => 'FontSize', 'compact' => false, 'sort' => 140),
										array('separator' => true, 'compact' => false, 'sort' => 145),
										array('id' => 'OrderedList', 'compact' => true, 'sort' => 150),
										array('id' => 'UnorderedList', 'compact' => true, 'sort' => 160),
										array('id' => 'AlignList', 'compact' => false, 'sort' => 190),
										array('separator' => true, 'compact' => false, 'sort' => 200),
										array('id' => 'InsertLink', 'compact' => true, 'sort' => 210),
										array('id' => 'InsertImage', 'compact' => false, 'sort' => 220),
										array('id' => 'InsertVideo', 'compact' => true, 'sort' => 230),
										array('id' => 'InsertTable', 'compact' => false, 'sort' => 250),
										array('separator' => true, 'compact' => false, 'sort' => 290),
										array('id' => 'Fullscreen', 'compact' => false, 'sort' => 310),
										array('id' => 'More', 'compact' => true, 'sort' => 400)
									),
								));
								break;
							case "T":
								for ($i = 0; $i<$inputNum; $i++)
								{

									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) > 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
									}
									else
									{
										$value = "";
									}
								?>
						<textarea <?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?>required<?endif?> cols="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>" rows="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]?>" name="PROPERTY[<?=$propertyID?>][<?=$i?>]"><?=$value?></textarea>
								<?
								}
							break;

							case "S":
							case "N":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

									}
									else
									{
										$value = "";
									}
								?>
                                <?php
                                     $str_class = "";
                                     if($propertyID==334){
                                         $str_class = 'class="q_input_last_name"';
                                     }
                                    if($propertyID==335){
                                        $str_class = 'class="q_input_name"';
                                    }
                                    if($propertyID==336){
                                        $str_class = 'class="q_input_second_name"';
                                    }
                                    if($propertyID==345 || $propertyID==347 || $propertyID==361){
                                        $str_class = 'class="q_phone"';
                                    }
                                ?>
                                <?
                                    $placeholder = get_placeholder($propertyID,$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]);
                                    $style       = get_style($propertyID);
                                ?>
                                <?if(strlen($value)==0){$value = $val_main;}?>
								<input <?if($propertyID==337 || $propertyID==575) echo 'onclick="BX.calendar({node: this, field: this, bTime: false});"';?> <?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?>required<?endif?> type="text" <?=$str_class?> name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]; ?>" value="<?=$value?>" style="<?=$style?>" placeholder="<?=$placeholder?>"/><?
								if($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "DateTime"):?><?
									$APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'',
										array(
											'FORM_NAME' => 'iblock_add',
											'INPUT_NAME' => "PROPERTY[".$propertyID."][".$i."]",
											'INPUT_VALUE' => $value,
										),
										null,
										array('HIDE_ICONS' => 'Y')
									);
									?><small><?=GetMessage("IBLOCK_FORM_DATE_FORMAT")?><?=FORMAT_DATETIME?></small><?
								endif;
                                if(get_input_search($propertyID)){
                                    $APPLICATION->IncludeComponent("bitrix:sale.location.selector.search", "template1", Array(
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CODE" => $value,	// Символьный код местоположения
		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
		"FILTER_BY_SITE" => "N",	// Фильтровать по сайту
		"ID" => "",	// ID местоположения
		"INITIALIZE_BY_GLOBAL_EVENT" => "",	// Инициализировать компонент только при наступлении указанного javascript-события на объекте window.document
		"INPUT_NAME" => "LOCATION",	// Имя поля ввода
		"JS_CALLBACK" => "",	// Javascript-функция обратного вызова
		"JS_CONTROL_GLOBAL_ID" => "",	// Идентификатор javascript-контрола
		"PROVIDE_LINK_BY" => "id",	// Сохранять связь через
		"SHOW_DEFAULT_LOCATIONS" => "Y",	// Отображать местоположения по-умолчанию
		"SUPPRESS_ERRORS" => "N",	// Не показывать ошибки, если они возникли при загрузке компонента
	),
	false
);
                                }
								?><?
								}
							break;

							case "F":
							    //print_r($arResult["ELEMENT_PROPERTIES"][$propertyID]);
							    $numFile = count($arResult["ELEMENT_PROPERTIES"][$propertyID]) + 1;
							    if($numFile==2){
							        if(strlen($arResult["ELEMENT_PROPERTIES"][$propertyID][0]["VALUE"])==0){
                                        $numFile = 1;
                                    }
                                }
                                //$numFile = 4;
								for ($i = 0; $i<$numFile; $i++)
								{
									$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									?>
						<input type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" value="<?=$value?>" />
						<input type="file" <?if($i==($numFile-1)):?>class="last_file"<?endif;?> size="<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["COL_COUNT"]?>"  name="PROPERTY_FILE_<?=$propertyID?>_<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>" />
									<?

									if (!empty($value) && is_array($arResult["ELEMENT_FILES"][$value]))
									{
										?>
					<input type="checkbox" name="DELETE_FILE[<?=$propertyID?>][<?=$arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE_ID"] : $i?>]" id="file_delete_<?=$propertyID?>_<?=$i?>" value="Y" /><label for="file_delete_<?=$propertyID?>_<?=$i?>"><?=GetMessage("IBLOCK_FORM_FILE_DELETE")?></label><br />
										<?

										if ($arResult["ELEMENT_FILES"][$value]["IS_IMAGE"])
										{
											?>
					<img style="display: block;" src="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>" height="<?=$arResult["ELEMENT_FILES"][$value]["HEIGHT"]?>" width="<?=$arResult["ELEMENT_FILES"][$value]["WIDTH"]?>" border="0" /><br />
											<?
										}
										else
										{
											?>
					<?=GetMessage("IBLOCK_FORM_FILE_NAME")?>: <?=$arResult["ELEMENT_FILES"][$value]["ORIGINAL_NAME"]?><br />
					<?=GetMessage("IBLOCK_FORM_FILE_SIZE")?>: <?=$arResult["ELEMENT_FILES"][$value]["FILE_SIZE"]?> b<br />
					[<a href="<?=$arResult["ELEMENT_FILES"][$value]["SRC"]?>"><?=GetMessage("IBLOCK_FORM_FILE_DOWNLOAD")?></a>]<br />
											<?
										}
									}
								}
								echo '<div class="add_file" id="' . $numFile .'">Ещё</div>';

							break;
							case "L":

								if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["LIST_TYPE"] == "C")
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "checkbox" : "radio";
								else
									$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "multiselect" : "dropdown";

								switch ($type):
									case "checkbox":
									case "radio":
										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
											{
												if (is_array($arResult["ELEMENT_PROPERTIES"][$propertyID]))
												{
													foreach ($arResult["ELEMENT_PROPERTIES"][$propertyID] as $arElEnum)
													{
														if ($arElEnum["VALUE"] == $key)
														{
															$checked = true;
															break;
														}
													}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}

											?>
							<input <?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?>required<?endif?> type="<?=$type?>" name="PROPERTY[<?=$propertyID?>]<?=$type == "checkbox" ? "[".$key."]" : ""?>" value="<?=$key?>" id="property_<?=$key?>"<?=$checked ? " checked=\"checked\"" : ""?> /><label for="property_<?=$key?>"><?=$arEnum["VALUE"]?></label><br />
											<?
										}
									break;

									case "dropdown":
									case "multiselect":
									?>
							<select <?if(in_array($propertyID, $arResult["PROPERTY_REQUIRED"])):?>required<?endif?> name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>" <?if($propertyID==564):?>class="main_type_prop"<?endif;?>>
								<option value=""><?echo GetMessage("CT_BIEAF_PROPERTY_VALUE_NA")?></option>
									<?
										if (intval($propertyID) > 0) $sKey = "ELEMENT_PROPERTIES";
										else $sKey = "ELEMENT";

										foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
										{
											$checked = false;
											if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
											{
												foreach ($arResult[$sKey][$propertyID] as $elKey => $arElEnum)
												{
													if ($key == $arElEnum["VALUE"])
													{
														$checked = true;
														break;
													}
												}
											}
											else
											{
												if ($arEnum["DEF"] == "Y") $checked = true;
											}
											if(isset($_GET) and $_GET["TYPE"] == $arEnum["VALUE"]){
                                                $checked = true;
                                            }
											?>
								<option value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arEnum["VALUE"]?></option>
											<?
										}
									?>
							</select>
									<?
									break;

								endswitch;
							break;
						endswitch;?>
					</td>
				</tr>
			<?endforeach;?>
			<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_TITLE")?></td>
					<td>
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</td>
				</tr>
				<tr>
					<td><?=GetMessage("IBLOCK_FORM_CAPTCHA_PROMPT")?><span class="starrequired">*</span>:</td>
					<td><input type="text" required name="captcha_word" maxlength="50" value=""></td>
				</tr>
			<?endif?>
		</tbody>
		<?endif?>
		<tfoot>
			<tr>
				<td colspan="2">
					<? if(isset($arParams["OSN"])) { ?>
					<div class="assist_buttons_group"><button id="submit_button" class="assist_button_1">Отправить в банк</button></div>
					<?} else {?>
					<input type="submit" name="iblock_submit" class="main_q_submit" value="<?if(isset($arParams["OSN"])){echo GetMessage("IBLOCK_FORM_SUBMIT2");}else{echo GetMessage("IBLOCK_FORM_SUBMIT");}?>" />
					<? } ?>
					<?if (strlen($arParams["LIST_URL"]) > 0):?>
						<input type="submit" name="iblock_apply" class="main_q_submit" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" />
						<input
							type="button"
							name="iblock_cancel"
                            class="main_q_submit"
							value="<? echo GetMessage('IBLOCK_FORM_CANCEL'); ?>"
							onclick="location.href='<? echo CUtil::JSEscape($arParams["LIST_URL"])?>';"
						>
					<?endif?>
				</td>
			</tr>
		</tfoot>
	</table>
</form>
<?
function get_placeholder($id,$name){
    $res_placeholder = '';
    switch ($id):
        case 345:
            $res_placeholder = "+7(999)999-99-99";
            break;
        case 347:
            $res_placeholder = "+7(999)999-99-99";
            break;
        case 361:
            $res_placeholder = "+7(999)999-99-99";
            break;
        case 349:
            $res_placeholder = "index@mail.ru";
            break;
        case 340:
            $res_placeholder = "5555";
            break;
        case 368:
            $res_placeholder = "123456";
            break;
        default:
            $res_placeholder = "";
            break;
    endswitch;
    return $res_placeholder;
}
function get_style($id){
    $style = "";

    switch ($id):
        case 338: //место рождения
            $style = "display:none;";
            break;
        case 343: //город регистрации
            $style = "display:none;";
            break;
        case 357: //город получения кредита
            $style = "display:none;";
            break;
	case 344: //Адрес проживания, населенный пункт
            $style = "display:none;";
            break;
	case 568: //Адрес регистрации, населенный пункт
            $style = "display:none;";
            break;
 	case 571: //Адрес работы, населенный пункт
            $style = "display:none;";
            break;
    endswitch;

    return $style;
}
function get_input_search($id){
    $comp = false;

    switch ($id):
        case 338: //место рождения
            $comp = true;
            break;
        case 343: //город регистрации
            $comp = true;
            break;
        case 357: //город получения кредита
            $comp = true;
            break;
	case 344: //Адрес проживания, населенный пункт
             $comp = true;
            break;
	case 568: //Адрес регистрации, населенный пункт
             $comp = true;
            break;
 	case 571: //Адрес работы, населенный пункт
             $comp = true;
            break;
    endswitch;

    return $comp;


}
?>