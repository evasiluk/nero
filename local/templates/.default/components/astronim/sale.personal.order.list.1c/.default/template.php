<?
define('UPLOAD_DIR', realpath($_SERVER["DOCUMENT_ROOT"] . '/upload/1c_orders/E0sOXPiL32aCcGgjjNb9mXslUfYDyW'));
//print_r($arResult['ORDERS']);

//Проверяем, перешли ли мы на данную страницу со страницы добавления нового заказа, и, если да, то добавляем информацию о нём в инфоблок "Изменения в заказах"
//if($_SESSION['ORDER_ID'] != NULL) setNewOrderProducts($_SESSION['ORDER_ID']);

//if($_REQUEST['dev'] == 'Y') var_dump($arResult);

?>
<?
$sort_list = array(
	"DATE_UPDATE.ASC"=>'по дате изменения заказа (по возрастанию)',
	"DATE_UPDATE.DESC"=>'по дате изменения заказа (по убыванию)',
	"ID.ASC"=>'по номеру заказа (по возрастанию)',
	"ID.DESC"=>'по номеру заказа (по убыванию)',
	"STATUS_ID.ASC"=>'по статусу заказа (по возрастанию)',
	"STATUS_ID.DESC"=>'по статусу заказа (по убыванию)',
	"PRICE.ASC"=>'по цене (по возрастанию)',
	"PRICE.DESC"=>'по цене (по убыванию)',
);
?>

<h1>Список заказов</h1>
<ul class="cartTabs ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
	<li class="ui-tabs-active ui-state-default ui-corner-top ui-state-active" role="tab" tabindex="0" aria-controls="cart-tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="/personal/order/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Список заказов&nbsp;</a></li>
	<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="cart-tabs-3" aria-labelledby="ui-id-3" aria-selected="false"><a href="/personal/mutual_settlement/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Взаиморасчёты&nbsp;</a></li>		
	<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="cart-tabs-2" aria-labelledby="ui-id-2" aria-selected="false"><a href="/personal/profile/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Редактирование профиля</a></li>
</ul>

<div class="catalog_sort_by" style="display: inline-block; margin-top: 12px;">
	<span>Сортировать: </span>
	<select id="order_sort_list" onchange="redirect()">
		<option>- выберите -</option>
		<? foreach($sort_list as $k=>$v): ?>
			<option value="<?=$k?>" <? echo $_REQUEST['by'].'.'.$_REQUEST['order'] == $k ? ' selected':'' ?>><?=$v?></option>
		<? endforeach; ?>
	</select>
</div>

<script type="text/javascript">
	function redirect(){
		$sort_params = $( "#order_sort_list option:selected" ).val();
		$sort_params = $sort_params.split('.');
		location.href = '/personal/order/?by='+$sort_params[0]+'&order='+$sort_params[1];
	}
</script>

<table>
	<tbody>
		<tr>
			<th><center>Дата изменения заказа</b></center></th>
			<th><center>№ заказа</b></center></th>
			<th><center>Содержимое заказа</center></th>
			<th><center>Сумма заказа</center></th>
			<th><center>Статус заказа</center></th>
			<th><center>Счет</center></th>
		</tr>
		<? foreach($arResult['ORDERS'] as $k=>$row): ?>
			<tr>
				<td><center><? echo $row['ORDER']["DATE_UPDATE"] ?></center></td>
				<td><center><? echo $row['ORDER']['ID'] ?></center></td>
				<td><center><a href="<?=$row['ORDER']['URL_TO_DETAIL'] ?>&USER_ID=<?=$row['ORDER']["USER_ID"]?>">Просмотреть заказ</a></center></td>
				<td><center><? echo $row['ORDER']['FORMATED_PRICE'] ?></center></td>
				<!--<td><center><?=$arResult["INFO"]["STATUS"][$row["ORDER"]["STATUS_ID"]]["NAME"];?><br /><span style="font-size: 9px;"><? echo $row['ORDER']['DATE_STATUS'] ?></span></center></td>-->
				<td><center><span class="order_<?=$row['ORDER']['STATUS_ID']?>"><? $arStatus = CSaleStatus::GetByID($row['ORDER']['STATUS_ID']); echo $arStatus['NAME'] ?></span><br /><span style="font-size: 9px;"><? echo $row['ORDER']['DATE_STATUS'] ?></span></center></td>
				<td><center><? 
				if (file_exists(UPLOAD_DIR .'/'. $row['ORDER']['ID'].'.pdf') && $row['ORDER']['STATUS_ID'] != 'C'){
					echo '<a href="/personal/order/get_invoice.php?order_id='.$row['ORDER']['ID'].'" title="Скачать счёт-фактуру"><img src="/bitrix/templates/bagoria/i/pdf.png"></a>';
				}
				?></center></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<?if(strlen($arResult["NAV_STRING"]) > 0):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>