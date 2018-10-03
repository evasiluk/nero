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



if($_POST["make_order"]) {

}

global $USER;
$user_id = $USER->GetID();

$person_id = 1; //дилер

if(!$user_id) {
    $us_name = $_POST["user"]["name"];
    $us_email = $_POST["user"]["email"];
    $us_phone = $_POST["user"]["phone"];

    $ar = CUser::GetList($by = "timestamp_x", $order = "desc", ['EMAIL' => $us_email])->GetNext();
    if($ar["ID"]) {
        $user_id = $ar["ID"];
        $person_id = 2; //зарегестрированный пользователь
    } else {
        $user = new CUser;
        $psswd = uniqid();

        $arFields = array(
            'NAME'             => $us_name,
            'EMAIL'            => $us_email,
            'LOGIN'            => $us_email, // минимум 3 символа
            'ACTIVE'           => 'Y',
            'PASSWORD'         => $psswd, // минимум 6 символов
            'CONFIRM_PASSWORD' => $psswd,
            'GROUP_ID'         => array(26),
            'PERSONAL_PHONE'   => $us_phone,
            "UF_NERO_SITE"     => CURRENT_USER_HOST
        );

        if($user_id = $user->Add($arFields)) {
            $person_id = 3; // незарегестрированный пользователь
        } else {
            echo json_encode(array("status" => "error", "error" => "New user create error."));
            exit;
        }
    }


}

$site = Context::getCurrent()->getSite();
//$order = Order::create($siteId, $USER->isAuthorized() ? $USER->GetID() : 539);  // дописать для неавторизованных
$order = Bitrix\Sale\Order::create(SITE_ID, $user_id);



$order->setPersonTypeId($person_id);


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

$items_total_sum =  $order->getPrice();

/*Shipment*/
$delivery_id = 5; // самовывоз
if($_POST["delivery"][0] == 2) {
    $delivery_id = 23; //курьер
}

$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
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



if($_POST["delivery"][0] == 2 && $person_id == 1) {
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

if($_POST["delivery"][0] == 2 && $person_id == 2) {
    $propertyCollection = $order->getPropertyCollection();
    $adress = $propertyCollection->getItemByOrderPropertyId(7);
    $adress->setValue($_POST["kur"]["city"]);
    $street = $propertyCollection->getItemByOrderPropertyId(8);
    $street->setValue($_POST["kur"]["street"]);
    $house = $propertyCollection->getItemByOrderPropertyId(9);
    $house->setValue($_POST["kur"]["house"]);
    $korpus = $propertyCollection->getItemByOrderPropertyId(10);
    $korpus->setValue($_POST["kur"]["house-2"]);
    $room = $propertyCollection->getItemByOrderPropertyId(11);
    $room->setValue($_POST["kur"]["kv"]);
}

if($_POST["delivery"][0] == 2 && $person_id == 3) {
    $propertyCollection = $order->getPropertyCollection();
    $adress = $propertyCollection->getItemByOrderPropertyId(12);
    $adress->setValue($_POST["kur"]["city"]);
    $street = $propertyCollection->getItemByOrderPropertyId(13);
    $street->setValue($_POST["kur"]["street"]);
    $house = $propertyCollection->getItemByOrderPropertyId(14);
    $house->setValue($_POST["kur"]["house"]);
    $korpus = $propertyCollection->getItemByOrderPropertyId(15);
    $korpus->setValue($_POST["kur"]["house-2"]);
    $room = $propertyCollection->getItemByOrderPropertyId(16);
    $room->setValue($_POST["kur"]["kv"]);
}
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


if($_POST["delivery"][0] == 2 && $items_total_sum > 300) {
    $arFields = array(
        "PRICE_DELIVERY" => 0
    );
    CSaleOrder::Update($orderId, $arFields);
}

echo json_encode(array("status" => "ok", "order_id" => $orderId));



