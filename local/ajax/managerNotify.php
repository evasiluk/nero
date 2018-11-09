<?
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');

//$arOrder = CSaleOrder::GetByID(101);
//
//print_pre($arOrder); exit;


if($_POST["order"]) {

    // делаем выборку менеджеров текущего портала
    $class = new managersClass();
    $group = $class->get_manager_group($_POST["pcode"]);

    $filter = Array("GROUPS_ID" => array($group));
    $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, array("SELECT"=>array()));
    $arSpecUser = array();
    while ($arUser = $rsUsers->Fetch()) {
        $arSpecUser[] = $arUser;
    }

    // если они есть - собираем их email адреса и формируем уведомления для них и для пользователя
    if($arSpecUser) {
        $fields = array();
        $fields["SENDTO"] = "";

        foreach($arSpecUser as $i => $user) {
            if($i > 0) $fields["SENDTO"] .= ", ";
            $fields["SENDTO"] .= $user["EMAIL"];
        }


        $fields["ORDER"] = $_POST["order"];

        $arOrder = CSaleOrder::GetByID($fields["ORDER"]);

        $fields["USER_NAME"] = $arOrder["USER_NAME"]." ".$arOrder["USER_LAST_NAME"];
        $fields["USER_LOGIN"] = $arOrder["USER_LOGIN"];
        $fields["USER_EMAIL"] = $arOrder["USER_EMAIL"];

        $iblock_id = get_region_catalog_iblock();
        $fields["ORDER_PRICE"] = convert_valute(($arOrder["PRICE"] - $arOrder["PRICE_DELIVERY"]), $iblock_id);
        $fields["VALUTE_SHORT"] = get_valute_short($iblock_id);

        //группа
        $res = CGroup::GetList();
        $groups = array();
        while ($group = $res->GetNext()){
            $groups[$group["ID"]] = $group;
        }

        $allGroups = $groups;
        $userGroups = CUser::GetUserGroup($arOrder["USER_ID"]);

        $fields["USER_DEALER_GROUP"] = "";

        foreach($userGroups as $i => $id) {
            if(in_array($id, array(1,2,3,4))) continue;
            $fields["USER_DEALER_GROUP"] = $allGroups[$id]["NAME"];
        }

        //состав заказа
        $fields["ITEMS"] = "";
        $obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $fields["ORDER"])));
        while($bItem = $obBasket->Fetch()){
            $fields["ITEMS"] .= $bItem["NAME"] . " - ". round($bItem["QUANTITY"]) . " шт.; ";
        }

        // адрес доставки
        $obProps = Bitrix\Sale\Internals\OrderPropsValueTable::getList(array('filter' => array('ORDER_ID' => $fields["ORDER"])));
        while($prop = $obProps->Fetch()){
            if($prop["CODE"] == "ADRESS") {
                $fields["DELIVERY_ADRESS"] = $prop["VALUE"];
            }
            if($prop["CODE"] == "STREET") {
                $fields["DELIVERY_STREET"] = $prop["VALUE"];
            }
            if($prop["CODE"] == "HOUSE") {
                $fields["DELIVERY_HOUSE"] = $prop["VALUE"];
            }
            if($prop["CODE"] == "KORPUS") {
                $fields["DELIVERY_KORPUS"] = $prop["VALUE"];
            }
            if($prop["CODE"] == "ROOM") {
                $fields["DELIVERY_ROOM"] = $prop["VALUE"];
            }
        }

        $fields["DELIVERY_PRICE"] = $_POST["delivery_price"];
        $fields["DELIVERY_NAME"] = $_POST["delivery_name"];

        print_pre($fields);



        CEvent::Send("MANAGER_ORDER_NOTIFY", SITE_ID, $fields);
        CEvent::Send("USER_ORDER_NOTIFY", SITE_ID, $fields);

    }
}
