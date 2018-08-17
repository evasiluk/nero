<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
//print_pre($arResult);



foreach($arResult["ITEMS"] as &$item) {
    if($item["OFFERS"]) {
        foreach($item["OFFERS"] as $i=>&$offer) {
            $offer["PRICES"]["base"]["VALUE"] = convert_valute($offer["PRICES"]["base"]["VALUE"], $arParams["IBLOCK_ID"]);
        }
    } else {
        $item["PRICES"]["base"]["VALUE"] = convert_valute($item["PRICES"]["base"]["VALUE"], $arParams["IBLOCK_ID"]);
    }
}

$arResult["VALUTE_SHORT"] = get_valute_short($arParams["IBLOCK_ID"]);

