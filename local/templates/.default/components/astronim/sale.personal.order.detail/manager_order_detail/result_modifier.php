<?
CModule::IncludeModule("currency");

$class = new managersClass();
$manager_groups = CUser::GetUserGroup(CUser::GetID());

// определяем иблок не по общей функции
// т.к. манагер ВСЕГДА будет на by хосте и следовательно всегда будут возвращаться рубли, даже если это манагер украинец
// потому определяем по манагеру: его группа - его хост - id иблока
$iblock_id = $class->get_dealer_iblock($manager_groups);
$currency_code = get_currency_code($iblock_id);
$arResult["VALUTE_SHORT"] = get_valute_short($iblock_id);

$order_date = date("d.m.Y", strtotime($arResult["DATE_INSERT_FORMATED"]));
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

if(!$row) {
    $arFilter = array(
        "CURRENCY" => $currency_code,
        '!DATE_RATE' => $order_date,
    );
    $by = "date";
    $order = "desc";
    $row = CCurrencyRates::GetList($by, $order, $arFilter)->Fetch();
}

$arResult["PRICE_IN_VALUTE"] = convert_valute($arResult["PRICE"], $iblock_id, $row["DATE_RATE"]? $row["DATE_RATE"] : "");

$arResult["PRICE_ALL_POSITIONS_REG"] = 0;

foreach($arResult["BASKET"] as &$item) {
    $item["PRICE"] = convert_valute($item["PRICE"], $iblock_id, $row["DATE_RATE"]? $row["DATE_RATE"] : "");
    $item["PRICE_ALL"] = $item["PRICE"] * $item["QUANTITY"];
    $arResult["PRICE_ALL_POSITIONS_REG"] += $item["PRICE_ALL"];
}



//print_pre($arResult);