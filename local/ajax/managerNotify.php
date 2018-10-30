<?
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");



if($_POST["order"]) {
    $class = new managersClass();
    $group = $class->get_manager_group($_POST["pcode"]);

    $filter = Array("GROUPS_ID" => array($group));
    $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, array("SELECT"=>array()));
    $arSpecUser = array();
    while ($arUser = $rsUsers->Fetch()) {
        $arSpecUser[] = $arUser;
    }

    if($arSpecUser) {
        $fields = array();
        $fields["SENDTO"] = "";

        foreach($arSpecUser as $i => $user) {
            if($i > 0) $fields["SENDTO"] .= ", ";
            $fields["SENDTO"] .= $user["EMAIL"];
        }

        $fields["ORDER"] = $_POST["order"];

        CEvent::Send("MANAGER_ORDER_NOTIFY", SITE_ID, $fields);
    }
}
