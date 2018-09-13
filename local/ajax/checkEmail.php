<?
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_POST["email"]) {
    $email = $_POST["email"];

    if ($ar = CUser::GetList($by = "timestamp_x", $order = "desc", ['EMAIL' => $email])->GetNext()) {
        echo "false";
    } else {
        echo "true";
    }
}