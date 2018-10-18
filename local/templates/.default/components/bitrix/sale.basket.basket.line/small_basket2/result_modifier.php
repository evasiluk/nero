<?php
//print_pre($arResult);
$id = 30;
switch($_SERVER["HTTP_HOST"]) {
    case BY_HOST: $id = 30;
        break;
    case UA_HOST : $id = 58;
        break;
    case SPB_HOST : $id = 59;
        break;
    case MSK_HOST : $id = 60;
        break;
}


$sum = 0;
$discount_sum = 0;

$arResult["TOTAL_ITEMS"] = 0;


if($arResult["CATEGORIES"]["READY"]) {
    foreach($arResult["CATEGORIES"]["READY"] as $item) {
        $arResult["TOTAL_ITEMS"] += $item["QUANTITY"];
        $item_price = convert_valute($item["BASE_PRICE"], $id);
        $item_price = $item_price * $item["QUANTITY"];
        $sum += $item_price;
        $discount_sum += convert_valute($item["DISCOUNT_PRICE"] * $item["QUANTITY"], $id);
    }
}


$arResult["SUM"] = $sum - $discount_sum;
$arResult["VALUTE_SHORT"] = get_valute_short($id);
