<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?CModule::IncludeModule('iblock');?>
<?if(isset($_GET["section_id"])):
    $listsQuery = CIBlockElement::GetList(["SORT"=>"ASC"],["IBLOCK_ID" => 37, "PROPERTY_TYPE" => 2283, "!PROPERTY_RAZDEL"=>[2369, 2366],'PROPERTY_INCLUDE_GROUP2'=>$_GET["section_id"]],false,false,["PROPERTY_CODE_PROP", "NAME","IBLOCK_ID", "ID"]);
    $arResult = array();
    while($elList = $listsQuery->GetNextElement()){
        $result = $elList->GetFields();
        $result["prop"] = $elList->GetProperties();
		$arrFilter = ["SECTION_ID" => $_GET["section_id"], "IBLOCK_ID" => 35, "!PROPERTY_".$result["prop"]["CODE_PROP"]["VALUE"]  => false, "ACTIVE" => "Y"];
		$queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilter, false, false, Array("NAME", "ID", "IBLOCK_ID"));
		while($resQueryCard = $queryCard->GetNextElement()):
            $countEl++;
		endwhile;
		if($countEl>0):
			$arResult["LISTS"]["ALL"][$result["prop"]["CODE_PROP"]["VALUE"]] = $result["NAME"];
		endif;
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
                <span data-stic_id="<?=$idstic?>"><?=$stic?></span>
            </li>
        <?endif;?>
    <?endforeach;?>
<?endif;
$countEl = 0;?>
<?if(isset($_GET["section_id"])):?>
	<?php
	$listsOtherQuery = CIBlockElement::GetList(["SORT"=>"ASC"],["IBLOCK_ID" => 37, "PROPERTY_TYPE" => 2385, "!PROPERTY_RAZDEL"=>[2369, 2366],'PROPERTY_INCLUDE_GROUP2'=>$_GET["section_id"]],false,false,["PROPERTY_CODE_PROP", "NAME","IBLOCK_ID", "ID"]);

	while($elList = $listsOtherQuery->GetNextElement()){
		$result = $elList->GetFields();
		$result["prop"] = $elList->GetProperties();
        $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>35, "CODE"=>$result["prop"]["CODE_PROP"]["VALUE"]));
        $countEl = 0;
        while($enum_fields = $property_enums->Fetch()){
            $arrFilter = ["IBLOCK_SECTION_ID" => $_GET["section_id"], "IBLOCK_ID" => 35, "PROPERTY_".$enum_fields["PROPERTY_CODE"]  => $enum_fields["ID"], "ACTIVE" => "Y"];
            $queryCard = CIBlockElement::GetList(Array("SORT" => "ASC"), $arrFilter, false, false, Array("NAME", "ID", "IBLOCK_ID","PROPERTY_".$enum_fields["PROPERTY_CODE"]));
            while($resQueryCard = $queryCard->Fetch()):
                //print_r($resQueryCard);
                //echo $resQueryCard['NAME'] . ' - ' . $enum_fields['PROPERTY_NAME'] . ' - ' .$enum_fields["ID"] . ' - ' . $enum_fields["PROPERTY_".$enum_fields["PROPERTY_CODE"]."_VALUE"]. '</br>';
                $countEl++;
            endwhile;
            if($countEl>0):
                $arResult["LISTS"]["OTHER"][$result["prop"]["CODE_PROP"]["VALUE"]][]=  $enum_fields;
            endif;
            $countEl = 0;
        }
	}
	?>
<?php foreach($arResult["LISTS"]["OTHER"] as $code => $vars):?>
		<?php foreach($vars as $var):?>
			<li class="swiper-slide sticker other-li">
				<span data-other_code="<?=$code?>" data-stic_id="<?=$var["ID"]?>"><?=$var["VALUE"]?></span>
			</li>
		<?php endforeach;?>
<?php endforeach;?>
<?endif;?>
<script>
    $(".all-li span").on("click", function() {
        $(".all-li span").removeClass("active");
        $(".hit-li span").removeClass("active");
        $(".other-li span").removeClass("active");
        $(this).addClass("active");
        section_id   = <?=$_GET["section_id"]?>;
        all_lists_id = $(".all_lists span.active").data("stic_id");
        hit_lists_id = "";
        $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
    });
    $(".all-li span:first").click();
</script>

<script>
    $(".hit-li span").on("click", function() {
        $(".all-li span").removeClass("active");
        $(".hit-li span").removeClass("active");
        $(".other-li span").removeClass("active");
        $(this).addClass("active");
        section_id = <?=$_GET["section_id"]?>;
        hit_lists_id = $(".all_lists span.active").data("stic_id");
        all_lists_id = "";
        $("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&all_lists_id="+all_lists_id+"&hit_lists_id="+hit_lists_id);
    });
</script>

<script>
	$(".other-li span").on("click", function(){
		section_id = <?=$_GET["section_id"]?>;
		hit_lists_id = 0;
		all_lists_id = "";
		$(".all-li span").removeClass("active");
		$(".hit-li span").removeClass("active");
		$(".other-li span").removeClass("active");
		$(this).addClass("active");
		other_code = $(".other-li span.active").data("other_code");
		other_id = $(".other-li span.active").data("stic_id");
		$("#choose_result").load("/ajax/fast_choose_ajax.php?section_id="+section_id+"&other_code="+other_code+"&other_id="+ other_id);
	});
</script>