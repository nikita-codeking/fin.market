<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

        <div class="slider_team_new zen-colour swiper-container">
            <ul  id="" class="slider_team_new_list swiper-wrapper">
                <?foreach($arResult["ITEMS"] as $arItem):?>
                    <li class="slider_team_item item_bottom swiper-slide">
                        <div class="slider_team_img">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<div class="title_name item__gradient"><?=$arItem["NAME"]?></div>
                                <?php
                                $arFileTmp = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]['ID'], array("width" => 212, "height" => 90), BX_RESIZE_IMAGE_EXACT,true);
                                ?>
								<img class="" src="<?=$arFileTmp["src"]?>" alt="<?=$arItem["DETAIL_PICTURE"]["ALT"]?>">
							</a>
                        </div>
                    </li>
                <?endforeach;?>
            </ul>
        </div>
<div class="rateswiper-control swiper-button-prev"></div>
<div class="rateswiper-control swiper-button-next"></div>
<script></script>
