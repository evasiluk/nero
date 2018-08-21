<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();




if($arResult["PROPERTIES"]["HARACTERISTIKY"]["VALUE"]) {
    $top_sec_id = $arResult["PROPERTIES"]["HARACTERISTIKY"]["VALUE"];

    $arFilter = array('IBLOCK_ID' => 33, "SECTION_ID" => $top_sec_id);

    $rsSect = CIBlockSection::GetList(Array("ID"=>"ASC"), $arFilter, false, array("NAME", "CODE", "UF_NAME_EN"));

    $sections = array();

    while ($arSect = $rsSect->GetNext())
    {
        $sections[$arSect["ID"]] = $arSect;
    }

    $arResult["CHAR_SECTIONS"] = $sections;
}



if($arResult["PROPERTIES"]["ATTACHED_ITEMS"]["VALUE"]) {
    $arResult["ATTACHED_ITEMS"] = $arResult["PROPERTIES"]["ATTACHED_ITEMS"]["VALUE"];
}


//следующий/предыдущий товар
$IBLOCK_ID = $arResult["ORIGINAL_PARAMETERS"]["IBLOCK_ID"];
$section_code = $arResult["ORIGINAL_PARAMETERS"]["SECTION_CODE"];
echo $section_id;
// id элемента для которого ищем соседей
$ID = $arResult["ID"];

$siblings = [];

$query = CIBlockElement::GetList(array('ID' => 'ASC'), array(
        'IBLOCK_ID' => $IBLOCK_ID,
        'ACTIVE' => 'Y',
        "!ID" => $ID,
    "SECTION_CODE" => $section_code),
    false, array('nPageSize' => 2),
    array('NAME', 'ID', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE')
);
while($elem = $query->GetNextElement()){
    $arFields = $elem->GetFields();
    $siblings[] = $arFields;


}
$arResult["SIBLINGS"] = $siblings;






$class = new neroCatalogClass();
$dealer = $class->is_dealer(CUser::GetUserGroup(CUser::GetID()));

//print_pre($dealer);
//print_pre($arResult);
if($dealer) {
    if($arResult["OFFERS"]) {

        foreach($arResult["OFFERS"] as $i=>&$offer) {
            foreach($offer["PRICES"] as $key=>$of_price) {

                if($of_price["CAN_BUY"] == "Y" && $key != "rosn") {

                    $offer["PRICES"]["dealer_price"]["VALUE"] = convert_valute($of_price["VALUE"], $arParams["IBLOCK_ID"]);

                }
                if($of_price["CAN_BUY"] == "Y" && $key == "rosn") {
                    $offer["PRICES"]["rosnitsa_price"]["VALUE"] = convert_valute($of_price["VALUE"], $arParams["IBLOCK_ID"]);
                }
            }
        }
    } else {
        foreach($arResult["PRICES"] as $key=>$of_price) {
            if($of_price["CAN_BUY"] == "Y" && $key != "rosn") {
                $arResult["PRICES"]["dealer_price"]["VALUE"] = convert_valute($of_price["VALUE"], $arParams["IBLOCK_ID"]);
            }
            if($of_price["CAN_BUY"] == "Y" && $key == "rosn") {
                $arResult["PRICES"]["rosnitsa_price"]["VALUE"] = convert_valute($of_price["VALUE"], $arParams["IBLOCK_ID"]);
            }
        }
    }

} else {
    if($arResult["OFFERS"]) {
        foreach($arResult["OFFERS"] as $i=>&$offer) {
            $offer["PRICES"]["rosnitsa_price"]["VALUE"] = convert_valute($offer["PRICES"]["rosn"]["VALUE"], $arParams["IBLOCK_ID"]);
        }
    } else {
        $arResult["PRICES"]["rosnitsa_price"]["VALUE"] = convert_valute($arResult["PRICES"]["rosn"]["VALUE"], $arParams["IBLOCK_ID"]);
    }
}




//if($arResult["OFFERS"]) {
//    foreach($arResult["OFFERS"] as $i=>&$offer) {
//        $offer["PRICES"]["base"]["VALUE"] = convert_valute($offer["PRICES"]["base"]["VALUE"], $arParams["IBLOCK_ID"]);
//    }
//} else {
//    $arResult["PRICES"]["base"]["VALUE"] = convert_valute($arResult["PRICES"]["base"]["VALUE"], $arParams["IBLOCK_ID"]);
//}

$arResult["VALUTE_SHORT"] = get_valute_short($arParams["IBLOCK_ID"]);

//print_pre($arResult);