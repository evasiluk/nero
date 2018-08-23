<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>
<script>
    $(document).ready(function() {
        var postData = {
            sessid: BX.bitrix_sessid(),
            site_id: BX.message('SITE_ID'),
            action_var: 'basketAction',
            basketAction: "recalculate",
            QUANTITY_32: 30,
            QUANTITY_33: 1,
            QUANTITY_34: 1
        };


        $.ajax({
            type: "POST",
            url: "/bitrix/components/bitrix/sale.basket.basket/ajax.php",
            data: postData,
            dataType: 'json',
            success: function(msg){

            }
        });
    })
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>