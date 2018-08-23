<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test2");
?>
<?
//выборка накопительных скидок

CModule::IncludeModule("sale");
$db_res = CSaleDiscount::GetList(
    array("SORT" => "ASC"),
    array(
        "LID" => SITE_ID,
        "ACTIVE" => "Y",
        "USER_GROUPS" => array(6), // фильтруем по группам

    ),
    false,
    false,
    array()
);
if ($ar_res = $db_res->Fetch())
{
    print_pre($ar_res);
}



// выбираем конкретную скидку для получения процентов и цен - id из предыдущего массива
$res = CSaleDiscount::GetByID(1);

print_pre(unserialize($res["ACTIONS"]));




?>
ff
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>