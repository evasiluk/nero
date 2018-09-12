<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
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
?>
<?
CModule::IncludeModule("sale");
$status = $_POST["status"];
$id = $_POST["id"];


if($status == "F") {
    CSaleOrder::CancelOrder($id, "N", "");
    $order = Sale\Order::load($id);
    $order->setField('STATUS_ID', "F");
    $paymentCollection = $order->getPaymentCollection();
    $onePayment = $paymentCollection[0];
    $onePayment->setPaid("Y");
    $order->save();
    LocalRedirect("/managers/zakazy/?ID=".$id);
}

if($status == "N") {
    CSaleOrder::CancelOrder($id, "N", "");
    $order = Sale\Order::load($id);
    $order->setField('STATUS_ID', "N");
    $paymentCollection = $order->getPaymentCollection();
    $onePayment = $paymentCollection[0];
    $onePayment->setPaid("N");

    if($order->save()) {
        LocalRedirect("/managers/zakazy/?ID=".$id);
    }

}

if($status == "С") {
    CSaleOrder::CancelOrder($id, "Y", "");
    LocalRedirect("/managers/zakazy/?ID=".$id);
}


//if(in_array($_POST["status"], $statuses)) {
//    $order = Sale\Order::load($id);
//    print_pre($order); exit;
//    $paymentCollection = $order->getPaymentCollection();
//    $onePayment = $paymentCollection[0];
//    $onePayment->setPaid("N");
//    $order->save();
//
//    //print_pre($order);
////    CSaleOrder::StatusOrder($id, $_POST["status"]);
////    $paymentCollection = $order->getPaymentCollection();
////    //CSaleOrder::CancelOrder($id, "N", "");
////    LocalRedirect("/managers/zakazy/?ID=".$id);
//}

//if(in_array($_POST["status"], $cancel)) {
//    CSaleOrder::CancelOrder($id, "Y", "");
//    CSaleOrder::StatusOrder($id, "C");
//    LocalRedirect("/managers/zakazy/?ID=".$id);
//}

print_pre($_POST);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>