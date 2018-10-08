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
        ),
        false,
        false,
        array()
    );
    if ($ar_dtype = $db_dtype->Fetch())
    {
        do
        {
            $arResult["DELIVERY"]["COURIER"] = $ar_dtype;
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

    $arResult["DELIVERY"]["CARGO"][BY_HOST]["REGIONS"] = array(
        "Брестская область",
        "Витебская область",
        "Гомельская область",
        "Березинский район",
        "Клецкий район",
        "Копыльский район",
        "Стародорожский район",
        "Узденский район",
        "Червенский район",
        "Мядельский район",
        "Несвижский район",
        "Любанский район",
        "Молодечненский район",
        "Крупский район",
        "Логойский район",
        "Смолевичский район",
        "Столбцовский район",
        "Солигорский район",
        "Пуховичский район",
        "Слуцкий район",
        "Дзержинский район",
        "Воложинский район",
        "Вилейский район",
        "Борисовский район",
        "Жодино",
        "Могилёвская область",
        "Гродненская область",
        "Старые Дороги",
        "Заславль");
}

//print_pre($arResult["DELIVERY"]["CARGO"]);


// ______________ new delivery end




//$arResult["DELIVERY"] = array();
//$arResult["DELIVERY"]["COURIER"][BY_HOST]["PHRASE"] = "Минску и Минскому району";
//$arResult["DELIVERY"]["COURIER"][BY_HOST]["COST"] = ($arResult['PRICE_ALL_FINAL_EUR'] > 300)? "бесплатно" : "5 руб.";
//$arResult["DELIVERY"]["COURIER"][BY_HOST]["COST_INT"] = ($arResult['PRICE_ALL_FINAL_EUR'] > 300)? 0 : 5;
//$arResult["DELIVERY"]["COURIER"][MSK_HOST]["PHRASE"] = "Москве";
//$arResult["DELIVERY"]["COURIER"][MSK_HOST]["COST"] = "Возможность доставки уточняйте у менеджера";
//$arResult["DELIVERY"]["COURIER"][MSK_HOST]["COST_INT"] = "Возможность доставки уточняйте у менеджера";
//$arResult["DELIVERY"]["COURIER"][SPB_HOST]["PHRASE"] = "Санкт-Петербургу";
//$arResult["DELIVERY"]["COURIER"][SPB_HOST]["COST"] = "бесплатно";
//$arResult["DELIVERY"]["COURIER"][SPB_HOST]["COST_INT"] = 0;
//$arResult["DELIVERY"]["COURIER"][UA_HOST]["PHRASE"] = "Киеву";
//$arResult["DELIVERY"]["COURIER"][UA_HOST]["COST"] = "бесплатно";
//$arResult["DELIVERY"]["COURIER"][UA_HOST]["COST_INT"] = 0;

//$arResult["DELIVERY"]["CARGO"][BY_HOST]["PHRASE"] = "Доставка грузоперевозчиком по Беларуси";
//$arResult["DELIVERY"]["CARGO"][BY_HOST]["REGIONS"] = array(
//    "Брестская область",
//    "Витебская область",
//    "Гомельская область",
//    "Березинский район",
//    "Клецкий район",
//    "Копыльский район",
//    "Стародорожский район",
//    "Узденский район",
//    "Червенский район",
//    "Мядельский район",
//    "Несвижский район",
//    "Любанский район",
//    "Молодечненский район",
//    "Крупский район",
//    "Логойский район",
//    "Смолевичский район",
//    "Столбцовский район",
//    "Солигорский район",
//    "Пуховичский район",
//    "Слуцкий район",
//    "Дзержинский район",
//    "Воложинский район",
//    "Вилейский район",
//    "Борисовский район",
//    "Жодино",
//    "Могилёвская область",
//    "Гродненская область",
//    "Старые Дороги",
//    "Заславль");
//
//if($arResult['PRICE_ALL_REGION_FINAL'] > 1000) {
//    $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST"] = "бесплатно";
//    $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST_INT"] = 0;
//} else {
//    if($arResult["WEIGHT_ALL"] <= 1000) {
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST"] = "4 руб";
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST_INT"] = 4;
//    }
//    if($arResult["WEIGHT_ALL"] >= 1001 && $arResult["WEIGHT_ALL"] <= 2000) {
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST"] = "8 руб";
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST_INT"] = 8;
//    }
//    if($arResult["WEIGHT_ALL"] >= 2001 && $arResult["WEIGHT_ALL"] <= 3000) {
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST"] = "12 руб";
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST_INT"] = 12;
//    }
//    if($arResult["WEIGHT_ALL"] >= 3001 && $arResult["WEIGHT_ALL"] <= 4000) {
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST"] = "16 руб";
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST_INT"] = 16;
//    }
//    if($arResult["WEIGHT_ALL"] >= 5001 && $arResult["WEIGHT_ALL"] <= 6000) {
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST"] = "24 руб";
//        $arResult["DELIVERY"]["CARGO"][BY_HOST]["COST_INT"] = 24;
//    }
//}


//print_pre($arResult);


// order

if($_POST["make_order"]) {
    $site = Context::getCurrent()->getSite();
//$order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 539);  // дописать для неавторизованных
    $order = Bitrix\Sale\Order::create(SITE_ID, $USER->GetID());
    $order->setPersonTypeId(1);

    $site_basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    $basketItems = array();

    foreach ($site_basket as $i=>$basketItem) {

        $basketItems[$i]["PRODUCT_ID"] = $basketItem->getField('PRODUCT_ID');
        $basketItems[$i]["NAME"] = $basketItem->getField('NAME');
        $basketItems[$i]["DETAIL_PAGE_URL"] = $basketItem->getField('DETAIL_PAGE_URL');
        $basketItems[$i]["PRICE"] = $basketItem->getPrice();
        $basketItems[$i]["DISCOUNT_PRICE"] = $basketItem->getDiscountPrice();
        $basketItems[$i]["CURRENCY"] = "EUR";
        $basketItems[$i]["QUANTITY"] = $basketItem->getQuantity();
        $basketItemPropertyCollection = $basketItem->getPropertyCollection();

        unset($props["PRODUCT.XML_ID"]);
        unset($props["CATALOG.XML_ID"]);
        $basketItems[$i]["PROPS"] = $props;
    }

    $basket = Basket::create($site);


    foreach($basketItems as $item) {
        $basketItem = $basket->createItem('catalog', $item["PRODUCT_ID"]);

        $basketItem->setFields([
            'QUANTITY' => $item["QUANTITY"],
            'CURRENCY' => $item["CURRENCY"],
            'LID' => $site,
            'PRICE' => $item["PRICE"],
            'DISCOUNT_PRICE' => $item["DISCOUNT_PRICE"],
            'NAME' => $item["NAME"],
            'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
            'PRODUCT_PROVIDER_CLASS' => "CCatalogProductProvider"
        ]);

        $basketItemPropertyCollection = $basketItem->getPropertyCollection();
    }

    $order->setBasket($basket);

    /*Shipment*/

    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();

    $delivery_id = 5; // самовывоз
    if($_POST["delivery"][0] == 2) {
        $delivery_id = 23; //курьер
    }


    $service = Delivery\Services\Manager::getById($delivery_id);
    $shipment->setFields(array(
        'DELIVERY_ID' => $service['ID'],
        'DELIVERY_NAME' => $service['NAME'],
    ));
    $shipmentItemCollection = $shipment->getShipmentItemCollection();
    $shipmentItem = $shipmentItemCollection->createItem($basketItem);
    $shipmentItem->setQuantity($basketItem->getQuantity());


    /*Payment*/
    $payment_id = 2; //наличные
    if($_POST["payment"][0] == 2) {
        $payment_id = 3;
    }

    $paymentCollection = $order->getPaymentCollection();
    $payment = $paymentCollection->createItem(
        Bitrix\Sale\PaySystem\Manager::getObjectById($payment_id)
    );


    $payment->setField("SUM", $order->getPrice());
    $payment->setField("CURRENCY", $order->getField("CURRENCY"));
    $order->setField('COMMENTS', 'Заказ оформлен через АПИ. ');

    if($_POST["user_comment"]) {
        $order->setField('USER_DESCRIPTION', $_POST["user_comment"]);
    }

    if($_POST["delivery"][0] == 2) {
        $propertyCollection = $order->getPropertyCollection();
        $adress = $propertyCollection->getItemByOrderPropertyId(2);
        $adress->setValue($_POST["kur"]["city"]);
        $street = $propertyCollection->getItemByOrderPropertyId(3);
        $street->setValue($_POST["kur"]["street"]);
        $house = $propertyCollection->getItemByOrderPropertyId(4);
        $house->setValue($_POST["kur"]["house"]);
        $korpus = $propertyCollection->getItemByOrderPropertyId(5);
        $korpus->setValue($_POST["kur"]["house-2"]);
        $room = $propertyCollection->getItemByOrderPropertyId(6);
        $room->setValue($_POST["kur"]["kv"]);
    }

    //сохранение
    $order->doFinalAction(true);
    $result = $order->save();

    $orderId = $order->getId();

    //скидка
    $order = Sale\Order::load($orderId);
    $discount = $order->getDiscount();
    $discount->calculate();
    $ar = $discount->getApplyResult();
    $order->save();

    if($_POST["delivery"][0] == 2 && $arResult['PRICE_ALL_FINAL_EUR'] > 300) {
        $arFields = array(
            "PRICE_DELIVERY" => 0
        );
        CSaleOrder::Update($orderId, $arFields);
    }




}
$this->IncludeComponentTemplate();
?>

