<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="param_credit_assist">
    <div class="brand_ca"></div>
    <div class="questionnaire_ca"></div>
    <div class="product_ca"></div>
</div>
<div class="main_credit_assist">
    <div class="step1_credit_assist">
        <div class="personal_wrapper">
            <?if($arResult['BRANDS']):?>
                <h2><?=GetMessage("TITLE_H2_STEP1")?></h2>
                <div class="row sale-personal-section-row-flex">
                    <?foreach ($arResult['BRANDS'] as $itemBrand):?>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 brandid" id="<?=$itemBrand['ID'];?>">
                            <div class="sale-personal-section-index-block bx-theme-">
                                <a class="sale-personal-section-index-block-link" href="javascript:void(0);">
                                    <img src="<?=$itemBrand['IMG'];?>" height="60"  alt="<?=$itemBrand['NAME'];?>" />
                                    <h2 class="sale-personal-section-index-block-name"><?=$itemBrand['NAME'];?></h2>
                                </a>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            <?else:?>
                <h2><?=GetMessage("TITLE_H2_STEP1_ERROR")?></h2>
            <?endif;?>
        </div>
    </div>
    <div class="step2_credit_assist" style="display: none;">
        <div class="personal_wrapper">
            <?if($arResult['QUEST']):?>
                <h2><?=GetMessage("TITLE_H2_STEP2")?></h2>
            <?else:?>
                <h2><?=GetMessage("TITLE_H2_STEP2_ERROR")?></h2>
            <?endif;?>
        </div>
    </div>
    <div class="step3_credit_assist" style="display: none;">
        Выбирай товар
    </div>

</div>
