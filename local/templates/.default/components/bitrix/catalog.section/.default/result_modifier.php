<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();



$class = new neroCatalogClass();
$dealer = $class->is_dealer(CUser::GetUserGroup(CUser::GetID()));

//print_pre($dealer);

if($dealer) {
    foreach($arResult["ITEMS"] as &$item) {
        if($item["OFFERS"]) {
            foreach($item["OFFERS"] as $i=>&$offer) {
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
            foreach($item["PRICES"] as $key=>$of_price) {
                if($of_price["CAN_BUY"] == "Y" && $key != "rosn") {
                    $item["PRICES"]["dealer_price"]["VALUE"] = convert_valute($of_price["VALUE"], $arParams["IBLOCK_ID"]);
                }
                if($of_price["CAN_BUY"] == "Y" && $key == "rosn") {
                    $item["PRICES"]["rosnitsa_price"]["VALUE"] = convert_valute($of_price["VALUE"], $arParams["IBLOCK_ID"]);
                }
            }
        }
    }
} else {
    foreach($arResult["ITEMS"] as &$item) {
        if($item["OFFERS"]) {
            foreach($item["OFFERS"] as $i=>&$offer) {
                $offer["PRICES"]["rosnitsa_price"]["VALUE"] = convert_valute($offer["PRICES"]["rosn"]["VALUE"], $arParams["IBLOCK_ID"]);
            }
        } else {
            $item["PRICES"]["rosnitsa_price"]["VALUE"] = convert_valute($item["PRICES"]["rosn"]["VALUE"], $arParams["IBLOCK_ID"]);
        }
    }
}

//print_pre($arResult["ITEMS"]);


//foreach($arResult["ITEMS"] as &$item) {
//    if($item["OFFERS"]) {
//        foreach($item["OFFERS"] as $i=>&$offer) {
//            $offer["PRICES"]["base"]["VALUE"] = convert_valute($offer["PRICES"]["base"]["VALUE"], $arParams["IBLOCK_ID"]);
//        }
//    } else {
//        $item["PRICES"]["base"]["VALUE"] = convert_valute($item["PRICES"]["base"]["VALUE"], $arParams["IBLOCK_ID"]);
//    }
//}





$arResult["VALUTE_SHORT"] = get_valute_short($arParams["IBLOCK_ID"]);

