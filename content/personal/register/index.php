<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?>
<?
global $USER;
if($USER->IsAuthorized()) {
    LocalRedirect("/content/personal/lichnye-dannye/");
}
?>
<?$APPLICATION->IncludeComponent(
    "astronim:simple.register",
    "",
    Array()
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>