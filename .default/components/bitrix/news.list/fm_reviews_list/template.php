<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?$isAjax = (isset($_GET["AJAX_REQUEST"]) && $_GET["AJAX_REQUEST"] == "Y");?>
<?if($arResult['ITEMS']):?>
	<?if(!$isAjax):?>
	<div id="ajax-cont">
		<div class="stories banners-small blog ">
	<?endif;?>
			<?foreach($arResult['ITEMS'] as $arItems):?>
				<div class="items row">
					<?foreach($arItems['ITEMS'] as $key => $arItem):?>
						<?
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

						// preview image
						$bImage = (is_array($arItem['DETAIL_PICTURE']) && $arItem['DETAIL_PICTURE']['SRC']);
						$imageSrc = ($bImage ? $arItem['DETAIL_PICTURE']['SRC'] : false);

						// use detail link?
						$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

						$isWideBlock = (isset($arItem['CLASS_WIDE']) && $arItem['CLASS_WIDE']);
						$hasWideBlock = (isset($arItem['CLASS']) && $arItem['CLASS']);
						?>
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="item item_bottom shadow animation-boxs <?=($isWideBlock ? 'wide-block' : '')?> <?=($hasWideBlock ? '' : 'normal-block')?>"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">

									        <div class="inner-item">

										<?if($bImage):?>
											<div class="image shine">
												<?if($bDetailLink):?><div class="card"><?endif;?>
													<?
													echo('<pre class="user-info">');
                                                    $rsUser = CUser::GetByID($arItem["FIELDS"]['CREATED_BY']);
                                                    $arUser = $rsUser->Fetch();
                                                    $personalPhoto = CFile::GetPath($arUser['PERSONAL_PHOTO']);
                                                    ?><img src="<? echo $personalPhoto?>">
													<?
                                                    see($arUser['NAME'], true);
                                                    see($arUser['LAST_NAME'], true);
                                                    see($arUser['ID'], true);
                                                    see($arUser['PERSONAL_ICQ'], true);
													echo('</pre>');
													?>
													<?if($arUser['ID'] != 1):?>
													<span class="preview-user-info">
														<?if($personalPhoto):?>
														<span href="<?=$arUser['PERSONAL_ICQ']?>"  class="preview-user-image">
															<img src="<? echo $personalPhoto?>" alt="">
														</span>
														<?endif?>
														<?if($arUser['NAME'] || $arUser['LAST_NAME']):?>
														<span class="preview-user-links">
															<span href="<?=$arUser['PERSONAL_ICQ']?>" class="preview-user-social">
																<?if($arUser['NAME']):?>
																	<span><?=$arUser['NAME']?></span>
																<?endif?>
																<?if($arUser['LAST_NAME']):?>
																	<span><?=$arUser['LAST_NAME']?></span>
																<?endif?>
															</span>
														</span>
														<?endif?>
													</span>
													<?endif?>
													
												    <img src=<?=$imageSrc?> alt="<?=($bImage ? $arItem['DETAIL_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['DETAIL_PICTURE']['TITLE'] : $arItem['NAME'])?>"/>
												    <?if($bDetailLink):?>
                                                    <canvas></canvas>
                                                </div><?endif;?>
											</div>
										<?endif;?>
                                                <div class="item__gradient">
                                                    <div class="item__gradient_horizontal">
                                            <div class="title">
                                                <?if($bDetailLink):?><div><?endif;?>
                                                    <p><?=$arItem['NAME']?></p>
                                                    <?if($bDetailLink):?></div><?endif;?>
                                                <?if($arItem['PREVIEW_TEXT'] && ($isWideBlock || !$bImage)):?>
                                                    <div class="prev_text-block"><?=$arItem['PREVIEW_TEXT'];?></div>
                                                <?else:?>
                                                    <div class="prev_text-block"><?=$arItem['PREVIEW_TEXT'];?></div>
                                                <?endif;?>
                                                <?if($arItem['DISPLAY_ACTIVE_FROM']):?>
                                                    <div class="date-block"><?=$arItem['DISPLAY_ACTIVE_FROM'];?></div>
                                                <?endif;?>
                                            </div>
                                    </div>
                                        </div>
									</div>
								</a>
					<?endforeach;?>
				</div>
			<?endforeach;?>

			<div class="bottom_nav lazy-hidden" <?=($isAjax ? "style='display: none; '" : "");?>>
				<?if( $arParams["DISPLAY_BOTTOM_PAGER"] == "Y" ){?><?=$arResult["NAV_STRING"]?><?}?>
			</div>
	<?if(!$isAjax):?>
		</div>
	</div>
	<?endif;?>
<?endif;?>

