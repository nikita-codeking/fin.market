<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?CModule::IncludeModule('iblock');?>
<?if(isset($_GET["section_id"])):
    $listsQuery = CIBlockElement::GetList(["SORT"=>"ASC"],["IBLOCK_ID" => 37, "PROPERTY_TYPE" => 2283, "!PROPERTY_RAZDEL"=>[2369, 2366],'PROPERTY_INCLUDE_GROUP2'=>$_GET["section_id"]],false,false,["PROPERTY_CODE_PROP", "NAME","IBLOCK_ID", "ID"]);
    $arResult = array();
    while($elList = $listsQuery->GetNextElement()){
        $result = $elList->GetFields();
        $result["prop"] = $elList->GetProperties();
        $arResult["LISTS"]["ALL"][$result["prop"]["CODE_PROP"]["VALUE"]] = $result["NAME"];
    }
    $first = true;
    foreach($arResult["LISTS"]["ALL"] as $idstic => $stic):?>
        <li class="swiper-slide sticker all-li">
            <span data-stic_id="<?=$idstic?>" <?if($first):?>class="active"<?endif;?>><?=$stic?></span>
        </li>
        <?$first=false;?>
    <?endforeach;?>
<?endif;?>
<?if(isset($_GET["section_id"])):
    $arResult = array();
    $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>35, "CODE"=>"HIT"));
    $countEl = 0;
    while($enum_fields = $property_enums->GetNext())
    {
        $arResult["LISTS"]["HIT"][$enum_fields["ID"]] = $enum_fields["VALUE"];
    }
    foreach($arResult["LISTS"]["HIT"] as $idstic => $stic):?>
        <?
        /**
         * проверка на наличие элементов по тегам
         */
        $tagHit = $idstic;
        $secID  = $_GET["section_id"];

        $arrFilter = ["SECTION_ID" => $secID, "IBLOCK_ID" => 35, "PROPERTY_HIT"  => $tagHit, "ACTIVE" => "Y"];
        $queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilter, false, false, Array("NAME", "ID", "PREVIEW_PICTURE", "IBLOCK_ID"));
        $countEl = 0;
        while($resQueryCard = $queryCard->GetNextElement()):
            $countEl++;
        endwhile;
        if($countEl>0):?>
            <li class="swiper-slide sticker hit-li">
                <span data-stic_hit_id="<?=$idstic?>"><?=$stic?></span>
            </li>
        <?endif;?>
    <?endforeach;?>
<?endif;?>
<script>
    $(".all-li span").on("click", function() {
        $(".all-li span").removeClass("active");
        $(this).addClass("active");
        section_id   = <?=$_GET["section_id"]?>;
        all_lists_id = $(".all_lists span.active").data("stic_id");
        hit_lists_id = 0;
        $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
    });
    $(".all_lists span:first").click();
</script>

<script>
    $(".hit-li span").on("click", function() {
        $(".hit-li span").removeClass("active");
        $(this).addClass("active");
        section_id = <?=$_GET["section_id"]?>;
        hit_lists_id = $(".all_lists span.active").data("stic_id");
        all_lists_id = "";
        $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
    });
</script>
<?if($countEl>0):?>
    <script>
        $('.hit_lists').show();
    </script>
<?endif;?>
