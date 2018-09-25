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
    \Bitrix\Main\Context;


global $USER;
$site = Context::getCurrent()->getSite();
//$order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 539);  // дописать для неавторизованных
$order = Bitrix\Sale\Order::create(SITE_ID, $USER->GetID());
$order->setPersonTypeId(1);



$site_basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());


// вроде как не надо
//$discounts = Discount::loadByBasket($site_basket);
//$site_basket->refreshData(array('PRICE', 'COUPONS'));
//$discounts->calculate();
//$discountResult = $discounts->getApplyResult();
//$site_basket->save();


$basketItems = array();

//print_pre($site_basket); exit;

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

//print_pre($basketItems); exit;

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

//print_pre($basket);




$order->setBasket($basket);


$shipmentCollection = $order->getShipmentCollection();

// 1 - без доставки
// 5 - самовывоз
// 6 - курьер

$shipment = $shipmentCollection->createItem(
    Bitrix\Sale\Delivery\Services\Manager::getObjectById(6)
);

$shipmentItemCollection = $shipment->getShipmentItemCollection();

foreach ($basket as $basketItem)
{
    $item = $shipmentItemCollection->createItem($basketItem);
    $item->setQuantity($basketItem->getQuantity());
}

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
//print_pre($ar); exit;


$order->doFinalAction(true);
$result = $order->save();
$orderId = $order->getId();

//скидка
$order = Sale\Order::load($orderId);
$discount = $order->getDiscount();
$discount->calculate();
$ar = $discount->getApplyResult();
$order->save();


echo $orderId;

//print_pre($basketItems);