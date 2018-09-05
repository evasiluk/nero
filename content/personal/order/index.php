<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>
    <div class="maxwrap">
        <?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list", 
	"list", 
	array(
		
	),
	$component
);?>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>