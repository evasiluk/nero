<?php
//print_pre($arResult);
$sum = 0;

if($arResult["CATEGORIES"]["READY"]) {
    foreach($arResult["CATEGORIES"]["READY"] as $item) {
        $sum += $item["PRICE"] * $item["QUANTITY"];
    }
}


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

$sum = convert_valute($sum, $id);
$arResult["SUM"] = $sum;
$arResult["VALUTE_SHORT"] = get_valute_short($id);
