<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test2");
?><?
$a["QUESTION"] = "sdfsdf";
$a["ANSWER"] = "dfgdfg";
$a["EMAIL"] = "evasiluk@gmail.com";

//print_pre($a); exit;
CEvent::Send("ANSWER_SEND", SITE_ID, $a);
?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>