<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach ($arResult['ITEMS_SECTION'] as $code=>$itemSection){?>
    <?$count=count($itemSection);?>
    <div class="count <?=($count ? '' : 'empty_items');?>" data-title="<?=$code?>">
            <span>
                <div class="items">
                    <div><?=$count;?></div>
                </div>
            </span>
    </div>
<?}?>
<?if(count($arResult['ERRORS'])>0):?>
    <div class="error_fly">
        <label for="popupCheckboxOne" class="error_fly-closer" id="close-error_fly">&#215;</label>
        <div class="error_fly-content">
            <?foreach ($arResult['ERRORS'] as $item):?>
                <h2><?=$item?></h2>
            <?endforeach;?>
        </div>
    </div>
<?endif?>
<script>
    $('#close-error_fly').click(function(){
        $(this).parent().remove();
    })
</script>