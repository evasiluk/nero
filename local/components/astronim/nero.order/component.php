<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("sale")) return;
if (!CModule::IncludeModule("catalog")) return;

use Bitrix\Sale,
Bitrix\Sale\Basket,
    Bitrix\Sale\PriceMaths,
    \Bitrix\Main\Context;




global $USER;
if($USER->IsAuthorized()) {
    $arResult["USER_LOGIN"] = true;
}







$dbBasketItems = CSaleBasket::GetList(
    array("ID" => "ASC"),
    array(
        'FUSER_ID' => CSaleBasket::GetBasketUserID(),
        'LID' => SITE_ID,
        'ORDER_ID' => 'NULL'
    ),
    false,
    false,
    array(
        'ID', 'PRODUCT_ID', 'QUANTITY', 'PRICE', 'DISCOUNT_PRICE', 'WEIGHT'
    )
);

$allSum = 0;
$allWeight = 0;
$arItems = array();

while ($arBasketItems = $dbBasketItems->Fetch())
{
    $allSum += ($arItem["PRICE"] * $arItem["QUANTITY"]);
    $allWeight += ($arItem["WEIGHT"] * $arItem["QUANTITY"]);
    $arItems[] = $arBasketItems;
}

$arOrder = array(
    'SITE_ID' => SITE_ID,
    'USER_ID' => $GLOBALS["USER"]->GetID(),
    'ORDER_PRICE' => $allSum,
    'ORDER_WEIGHT' => $allWeight,
    'BASKET_ITEMS' => $arItems
);

$arOptions = array(
    'COUNT_DISCOUNT_4_ALL_QUANTITY' => 'Y',
);

$arErrors = array();

CSaleDiscount::DoProcessOrder($arOrder, $arOptions, $arErrors);

$PRICE_ALL = 0;
$DISCOUNT_PRICE_ALL = 0;
$QUANTITY_ALL = 0;
$PRICE_ALL_BASE = 0;


foreach ($arOrder["BASKET_ITEMS"] as $arOneItem)
{
    //print_pre($arOneItem);
    $PRICE_ALL += $arOneItem["PRICE"] * $arOneItem["QUANTITY"];
    $DISCOUNT_PRICE_ALL += $arOneItem["DISCOUNT_PRICE"] * $arOneItem["QUANTITY"];
    $PRICE_ALL_BASE += $arOneItem["BASE_PRICE"] * $arOneItem["QUANTITY"];
    $QUANTITY_ALL += $arOneItem['QUANTITY'];
}

$result['PRICE_ALL'] = $PRICE_ALL;
$result['DISCOUNT_PRICE_ALL'] = $DISCOUNT_PRICE_ALL;
$result['QUANTITY_ALL'] = $QUANTITY_ALL;
$result['PRICE_ALL_BASE'] = $PRICE_ALL_BASE;

//print_pre($result);

$this->IncludeComponentTemplate();
?>

