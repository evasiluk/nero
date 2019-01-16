<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");

if (!($arOrder = CSaleOrder::GetByID(85)))
{
    echo "Заказ с кодом ".$ORDER_ID." не найден";
}
else
{
    echo "<pre>";
    //print_r($arOrder);
    echo "</pre>";
}

//$res = CGroup::GetList();
//$groups = array();
//while ($group = $res->GetNext()){
//    $groups[$group["ID"]] = $group;
//}
//
//$arResult["ALL_GROUPS"] = $groups;
//
//print_pre($arResult["ALL_GROUPS"]);

$arGroups = CUser::GetUserGroup(40);
//print_pre($arGroups);

$obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => 112)));
while($bItem = $obBasket->Fetch()){
   //print_pre($bItem);
}

$obProps = Bitrix\Sale\Internals\OrderPropsValueTable::getList(array('filter' => array('ORDER_ID' => 121)));
while($prop = $obProps->Fetch()){
    print_pre($prop);
}
