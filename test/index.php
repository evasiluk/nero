<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>
    <script>
        // обновление корзины
        $(document).ready(function() {

            // изменение количества
//            var postData = {
//                sessid: BX.bitrix_sessid(),
//                site_id: BX.message('SITE_ID'),
//                action_var: 'basketAction',
//                basketAction: "recalculate",
//
//                QUANTITY_38: 2,
//                QUANTITY_39: 5,
//                QUANTITY_40: 6
//            };
//
//            $.ajax({
//                type: "POST",
//                url: "/bitrix/components/bitrix/sale.basket.basket/ajax.php",
//                data: postData,
//                dataType: 'json',
//                success: function(msg){
//                console.log(msg);
//                }
//            });

            //удаление
//            var postData = {
//                sessid: BX.bitrix_sessid(),
//                site_id: BX.message('SITE_ID'),
//                action_var: 'basketAction',
//                basketAction: "recalculate",
//
//                DELETE_38: "Y"
//
//            };
//
//            $.ajax({
//                type: "POST",
//                url: "/bitrix/components/bitrix/sale.basket.basket/ajax.php",
//                data: postData,
//                dataType: 'json',
//                success: function(msg){
//                    console.log(msg);
//                }
//            });




        })
    </script>






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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>