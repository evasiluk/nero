<?
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if (!CModule::IncludeModule("sale")) return;
if (!CModule::IncludeModule("iblock")) return;
use Bitrix\Im\User;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type\Collection;
use \Bitrix\Sale\Discount;
use \Bitrix\Sale\Basket, \Bitrix\Sale\Internals\OrderPropsValueTable,
    \Bitrix\Sale\Order,
    \Bitrix\Main\Config\Option,
    \Bitrix\Main\Loader,
    \Bitrix\Sale,
    \Bitrix\Main\Context,
    \Bitrix\Sale\Delivery;


global $USER;
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

//$shipmentCollection = $order->getShipmentCollection();
//$shipment = $shipmentCollection->createItem(
//    Bitrix\Sale\Delivery\Services\Manager::getObjectById(18)
//);
//
//$shipmentItemCollection = $shipment->getShipmentItemCollection();
//
//foreach ($basket as $basketItem)
//{
//    $item = $shipmentItemCollection->createItem($basketItem);
//    $item->setQuantity($basketItem->getQuantity());
//}


//$shipmentCollection = $order->getShipmentCollection();
//$shipment = $shipmentCollection->createItem();
//$shipment->setFields(array(
//    'DELIVERY_ID' => 6,
//    'DELIVERY_NAME' => 'Курьер',
//    'CURRENCY' => "BYN",
//    'PRICE_DELIVERY' => 100
//));
//
//
//$shipmentItemCollection = $shipment->getShipmentItemCollection();
//
//foreach ($order->getBasket() as $item)
//{
//    $shipmentItem = $shipmentItemCollection->createItem($item);
//    $shipmentItem->setQuantity($item->getQuantity());
//}


$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
$service = Delivery\Services\Manager::getById(6);
$shipment->setFields(array(
    'DELIVERY_ID' => $service['ID'],
    'DELIVERY_NAME' => $service['NAME'],
));
$shipmentItemCollection = $shipment->getShipmentItemCollection();
$shipmentItem = $shipmentItemCollection->createItem($basketItem);
$shipmentItem->setQuantity($basketItem->getQuantity());


/*Payment*/
$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem(
    Bitrix\Sale\PaySystem\Manager::getObjectById(2)
);


$payment->setField("SUM", $order->getPrice());
$payment->setField("CURRENCY", $order->getField("CURRENCY"));
$order->setField('COMMENTS', 'Заказ оформлен через АПИ. ');
$order->setField('USER_DESCRIPTION', "Случайный текст комментария пользователя");



$propertyCollection = $order->getPropertyCollection();
$adress = $propertyCollection->getItemByOrderPropertyId(2);
$adress->setValue("Минск");
$street = $propertyCollection->getItemByOrderPropertyId(3);
$street->setValue("ул. Октябрьская");
$house = $propertyCollection->getItemByOrderPropertyId(4);
$house->setValue("25");
$korpus = $propertyCollection->getItemByOrderPropertyId(5);
$korpus->setValue("");
$room = $propertyCollection->getItemByOrderPropertyId(6);
$room->setValue("312");
//print_pre($order); exit;

//$pr = $order->getDeliveryPrice();
//echo $pr; exit;

$order->doFinalAction(true);
$result = $order->save();
//print_pre($result);
$orderId = $order->getId();

//скидка
$order = Sale\Order::load($orderId);
$discount = $order->getDiscount();
$discount->calculate();
$ar = $discount->getApplyResult();


$order->save();

$arFields = array(
    "PRICE_DELIVERY" => 15
);
CSaleOrder::Update($orderId, $arFields);


echo $orderId;

//print_pre($basketItems);