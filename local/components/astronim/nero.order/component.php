<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("sale")) return;
if (!CModule::IncludeModule("iblock")) return;
if (!CModule::IncludeModule("catalog")) return;
use Bitrix\Im\User;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\Collection;
use \Bitrix\Sale\Discount;
use \Bitrix\Sale\Basket,
    \Bitrix\Sale\Internals\OrderPropsValueTable,
    \Bitrix\Sale\Order,
    \Bitrix\Main\Config\Option,
    \Bitrix\Main\Loader,
    \Bitrix\Sale,
    \Bitrix\Sale\PriceMaths,
    \Bitrix\Main\Context,
    \Bitrix\Sale\Delivery;

// ________________________________user info
global $USER;
if($USER->IsAuthorized()) {
    $arResult["USER_LOGIN"] = true;

    $user_id = CUser::GetID();

    $filter = Array("ID" => $user_id);
    $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, array("SELECT"=>array("UF_*")));
    $arSpecUser = array();
    while ($arUser = $rsUsers->Fetch()) {
        $arSpecUser = $arUser;
    }

    if($arSpecUser) {
        $arResult["USER"] = array();
        $arResult["USER"]["NAME"] = $arSpecUser["NAME"];
        $arResult["USER"]["PHONE"] = $arSpecUser["PERSONAL_PHONE"]? $arSpecUser["PERSONAL_PHONE"] : $arSpecUser["WORK_PHONE"];
        $arResult["USER"]["EMAIL"] = $arSpecUser["EMAIL"];
    }
}

$class = new neroCatalogClass();
$dealer = $class->is_dealer(CUser::GetUserGroup(CUser::GetID()));
$arResult["IS_DEALER"] = $dealer ?  "Y" : "N";


// ______________________________basket info
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
$PRICE_ALL_REGION = 0;
$DISCOUNT_PRICE_ALL = 0;
$DISCOUNT_PRICE_ALL_REGION = 0;
$QUANTITY_ALL = 0;
$PRICE_ALL_BASE = 0;
$WEIGHT_ALL = 0;

$iblock_id = get_region_catalog_iblock();

//print_pre($arOrder["BASKET_ITEMS"]);

foreach ($arOrder["BASKET_ITEMS"] as $arOneItem)
{

    $PRICE_ALL += $arOneItem["PRICE"] * $arOneItem["QUANTITY"];
    $DISCOUNT_PRICE_ALL += $arOneItem["DISCOUNT_PRICE"] * $arOneItem["QUANTITY"];
    $PRICE_ALL_BASE += $arOneItem["BASE_PRICE"] * $arOneItem["QUANTITY"];
    $QUANTITY_ALL += $arOneItem['QUANTITY'];
    $WEIGHT_ALL += $arOneItem['QUANTITY'] * $arOneItem['WEIGHT'];


    $price_region = convert_valute($arOneItem["BASE_PRICE"], $iblock_id);
    $price_region = $price_region * $arOneItem["QUANTITY"];
    $PRICE_ALL_REGION += $price_region;
    $DISCOUNT_PRICE_ALL_REGION += convert_valute($arOneItem["DISCOUNT_PRICE"] * $arOneItem["QUANTITY"], $iblock_id);

}
$arResult['PRICE_ALL_EUR'] = $PRICE_ALL_BASE;
$arResult['DISCOUNT_PRICE_ALL_EUR'] = $DISCOUNT_PRICE_ALL;
$arResult['PRICE_ALL_FINAL_EUR'] = $PRICE_ALL;
$arResult['QUANTITY_ALL'] = $QUANTITY_ALL;
$arResult["PRICE_ALL_REGION"] = $PRICE_ALL_REGION;
$arResult['DISCOUNT_PRICE_ALL_REGION'] = $DISCOUNT_PRICE_ALL_REGION;
$arResult['PRICE_ALL_REGION_FINAL'] = $arResult["PRICE_ALL_REGION"] - $arResult['DISCOUNT_PRICE_ALL_REGION'];
$arResult["VALUTE_SHORT"] = get_valute_short($iblock_id);
$arResult["WEIGHT_ALL"] = $WEIGHT_ALL;


// _______________________________________________ new delivery
$delivery_default_city = array(
    BY_HOST => 236, // минск
    UA_HOST => 25, // киев
);

$arResult["LOCATION"] = $delivery_default_city[CURRENT_USER_HOST];

if($_GET["setLocation"]) {
    $arResult["LOCATION"] = $_GET["setLocation"];
}

$res = \Bitrix\Sale\Location\LocationTable::getList(array(
    'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, "ID" => $arResult["LOCATION"]),
    'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE')
));
$item = $res->fetch();

$ID = CSaleLocation::getLocationIDbyCODE($item["CODE"]);
$arVal = CSaleLocation::GetByID( $ID, "ru");
//print_pre($arVal);
$arResult["LOCATION_PATH"] = $arVal["CITY_NAME_ORIG"];
$arResult["LOCATION_PATH"] .= $arVal["REGION_NAME_ORIG"] ? ", ".$arVal["REGION_NAME_ORIG"] : "";



// самовывоз
$showroom_regions = array(
    BY_HOST => 390,
    MSK_HOST => 391,
    SPB_HOST => 392,
    UA_HOST => 398
);

$arFilter = array('IBLOCK_ID'=> 29, "PROPERTY_CHECKOUT_VALUE" => "Y", "PROPERTY_region" => $showroom_regions[CURRENT_USER_HOST]);
$arSelect = array();
$arOrder = array("SORT" => "ASC");

$rooms = array();

$res = CIBlockElement::GetList($arOrder , $arFilter, false, Array("nPageSize" => 1), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $props = $ob->GetProperties();
    $arFields["PROPS"] = $props;
    $room = $arFields;
}

if($room) {
    $arResult["SHOWROOM"]["ADRESS"] = $room["PREVIEW_TEXT"];
    $arResult["SHOWROOM"]["COORD"] = $room["PROPS"]["coordinates"]["VALUE"];
    $arResult["SHOWROOM"]["PHONE"] = $room["PROPS"]["phone"]["VALUE"];
    $arResult["SHOWROOM"]["WORKTIME"] = $room["PROPS"]["worktime"]["VALUE"];
}

//print_pre($room);


// курьер
$delivery_parents_array = array(
    BY_HOST => 27,
    MSK_HOST => 40,
    SPB_HOST => 42,
    UA_HOST => 44
);

$delivery_parent_courier_id = $delivery_parents_array[CURRENT_USER_HOST];



if($delivery_parent_courier_id) {
    $db_dtype = CSaleDelivery::GetList(
        array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
        array(
            "ACTIVE" => "Y",
            "PARENT_ID" => $delivery_parent_courier_id,
            "ORDER_PRICE" => $arResult['PRICE_ALL_REGION_FINAL'],
            "WEIGHT" => $arResult["WEIGHT_ALL"],
            "LOCATION" => $arResult["LOCATION"]
        ),
        false,
        false,
        array()
    );
    if ($ar_dtype = $db_dtype->Fetch())
    {
        do
        {
            $arResult["DELIVERY"]["COURIER"][] = $ar_dtype;
        }
        while ($ar_dtype = $db_dtype->Fetch());

        if(CURRENT_USER_HOST == MSK_HOST) {
            $arResult["DELIVERY"]["COURIER"]["NOTICE"] = "Возможность доставки уточняйте у менеджера";
        }
    }
}

//print_pre($arResult["DELIVERY"]["COURIER"]);


//грузоперевозчики
$delivery_parents_array = array(
    BY_HOST => 32,
);
$delivery_parent_cargo_id = $delivery_parents_array[CURRENT_USER_HOST];

if($delivery_parent_cargo_id) {

    $db_dtype = CSaleDelivery::GetList(
        array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
        array(
            "ACTIVE" => "Y",
            "PARENT_ID" => $delivery_parent_cargo_id,
            "ORDER_PRICE" => $arResult['PRICE_ALL_REGION_FINAL'],
            "WEIGHT" => $arResult["WEIGHT_ALL"],
            "LOCATION" => $arResult["LOCATION"]
        ),
        false,
        false,
        array()
    );
    if ($ar_dtype = $db_dtype->Fetch())
    {
        do
        {
            $arResult["DELIVERY"]["CARGO"] = $ar_dtype;
        }
        while ($ar_dtype = $db_dtype->Fetch());
    }
}

//print_pre($arResult["DELIVERY"]["CARGO"]);


// ______________ new delivery end


$portal_codes = array(
    BY_HOST => "BY",
    MSK_HOST => "MSK",
    SPB_HOST => "SPB",
    UA_HOST => "UA",
    EN_HOST => "EN"
);

$arResult["PORTAL_CODE"] = $portal_codes[CURRENT_USER_HOST];


$this->IncludeComponentTemplate();
?>

