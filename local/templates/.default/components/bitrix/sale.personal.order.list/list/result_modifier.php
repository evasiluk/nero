<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arResult["ORDER_BY_STATUS"] = Array();
foreach($arResult["ORDERS"] as $val)
{
	$arResult["ORDER_BY_STATUS"][$val["ORDER"]["STATUS_ID"]][] = $val;
}







//________
CModule::IncludeModule("currency");

$iblock_id = get_region_catalog_iblock();
$currency_code = get_currency_code($iblock_id);
$arResult["VALUTE_SHORT"] = get_valute_short($iblock_id);


foreach($arResult["ORDERS"] as &$arItem) {
    $order_date = $arItem["ORDER"]["DATE_STATUS"]->format("d.m.Y");
    $order_date_plus_1 = date("d.m.Y", strtotime("+1 day", strtotime($order_date)));

    //выборка курса на дату заказа
    $arFilter = array(
        "CURRENCY" => $currency_code,
        'DATE_RATE' => $order_date,
        '!DATE_RATE' => $order_date_plus_1,
    );
    $by = "date";
    $order = "desc";

    $row = CCurrencyRates::GetList($by, $order, $arFilter)->Fetch();

    //если за дату заказа курса нет - выбираем ближайший предыдущий
    if(!$row) {
        $arFilter = array(
            "CURRENCY" => $currency_code,
            '!DATE_RATE' => $order_date,
        );
        $by = "date";
        $order = "desc";
        $row = CCurrencyRates::GetList($by, $order, $arFilter)->Fetch();
    }

    foreach($arItem["BASKET_ITEMS"] as &$item) {
        $arSelect = Array("ID", "NAME", "PROPERTY_COLOR_CODE", "PREVIEW_PICTURE");
        $arFilter = Array("ID" => $item["PRODUCT_ID"]);

        $dbEl = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        $element = array();

        while($obEl = $dbEl->GetNextElement()) {
            $arFields = $obEl->GetFields() ;

            $item["PICTURE"] = CFile::GetPath($arFields["PREVIEW_PICTURE"]);
            $item["COLOR_CODE"] = $arFields["PROPERTY_COLOR_CODE_VALUE"];
        }

        $item["PRICE"] = convert_valute($item["PRICE"], $iblock_id, $row["DATE_RATE"]? $row["DATE_RATE"] : "");
        if(round($item["DISCOUNT_PRICE"])) {
            $item["PRICE_BEFORE_DISCOUNT"] = convert_valute($item["BASE_PRICE"], $iblock_id, $row["DATE_RATE"]? $row["DATE_RATE"] : "");
        }
        $item["PRICE_ALL"] = $item["PRICE"] * $item["QUANTITY"];
    }


    $arItem["ORDER"]["PRICE_IN_REG_VALUTE"] = convert_valute($arItem["ORDER"]["PRICE"], $iblock_id, $row["DATE_RATE"]? $row["DATE_RATE"] : "");
}
?>