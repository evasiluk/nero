<?
//print_r($arResult);
?>

<?

$props = array();
foreach($arResult['ORDER_PROPS'] as $k=>$v)
{
	$props[$v['NAME']] = $v['VALUE'];
}

function formatPrice2($price)
{
	/*if(strpos($price, '.00') != FALSE)
		$price = str_replace(".00", "", $price);
	if(strpos($price, ',00') != FALSE)
		$price = str_replace(",00", "", $price);	
	$price = @number_format($price, 0, '', ' ');*/
	$price = @number_format($price, 2, '.', ' '); // Igor
	return $price;
}

//print_r($arResult);

?>

<h1>Заказ #<? echo $arResult['ID'] ?> от <? echo $arResult['DATE_INSERT'] ?></h1>
<? if ($USER->IsAdmin()){

}?>
<table>
	<tbody>
		<tr>
			<th>Текущий статус заказа:</td>
			<td style="background-color: #fff"><center><? echo get_order_status_by_id($arResult['STATUS_ID']); ?> (от <? echo $arResult['DATE_STATUS'] ?>)</center></td>
		</tr>

		<tr>
			<th>Сумма заказа:</td>
			<td style="background-color: #fff"><center><b><? echo $arResult['PRICE_FORMATED'] ?></b></center></td>
		</tr>
		
		<tr>
			<th>Склад заказа:</td>
			<td style="background-color: #fff"><center><b><? echo $arResult['ORDER_STORE'] ?></b></center></td>
		</tr>		

		<tr>
			<th>Условия оплаты:</td>
			<td style="background-color: #fff"><center><?if($props['Отсрочка платежа'] == 'Есть'){ echo 'Отсрочка платежа';} else { echo 'Предоплата';}?></center></td>
		</tr>
	</tbody>
</table>

<?if($arResult["UPDATED_ORDERS"]):?> 
	<table class="order">
		<tbody>
			<tr>
				<th>№</th>
				<th>Наименование</th>
				<th>Произ-ль</th>
				<th>Модель</th>
				<th style="min-width:88px;">Цена, руб.</th>
				<th style="width:20px">Кол-во</th>
				<th>Скидка, %</th>
				<th style="min-width:88px">Цена со скидкой, руб.</th>
				<th style="min-width:95px">Стоимость, руб.</th> 
				<th style="width: 75px;">Статус</th>
			</tr>
			
			<? 
				$i = 1; foreach($arResult['BASKET'] as $k=>$row): 
			?>
			
			<tr <? if($row['CLASS'] != '') echo 'class="'.$row['CLASS'].'"'; ?>>
				<td><? echo $i ?></td>
				<td><b><? echo $row['NAME']; ?></b></td>
				<td><? echo $row['BRAND']; ?></td>
				<td><? echo $row['MODEL']; ?></td>
				<td><center><b><? echo formatPrice2($row['CURRENT_PRICE']); ?></b> <? if($row['CURRENT_PRICE'] != $row['START_PRICE']) { echo '<br>(<span class="old_value">'.formatPrice2($row['START_PRICE']).'</span>)'; } ?></center></td>
				<td><center><? echo $row['CURRENT_AMOUNT']; ?> <? if($row['CURRENT_AMOUNT'] != $row['START_AMOUNT']) { echo '<br>(<span class="old_value">'.$row['START_AMOUNT'].'</span>)'; } ?></center></td>
				<td><center><? echo $row['CURRENT_DISCOUNT']; ?> <? if($row['CURRENT_DISCOUNT'] != $row['START_DISCOUNT']) { echo '<br>(<span class="old_value">'.$row['START_DISCOUNT'].'</span>)'; } ?></center></td>
				<td><center><b><? echo formatPrice2($row['CURRENT_DISCOUNT_PRICE']); ?></b> <? if($row['CURRENT_DISCOUNT_PRICE'] != $row['START_DISCOUNT_PRICE']) { echo '<br>(<span class="old_value">'.formatPrice2($row['START_DISCOUNT_PRICE']).'</span>)'; } ?></center></td>
				<td><center><b><? echo formatPrice2($row['CURRENT_SUMM']); ?></b> <? if($row['CURRENT_SUMM'] != $row['START_SUMM']) { echo '<br>(<span class="old_value">'.formatPrice2($row['START_SUMM']).'</span>)'; } ?></center></td>				
				<td><center><b><? if($row['RESERVE'] == 'Зарезервирован') { echo 'Зарезер<br>вирован'; } else { echo $row['RESERVE']; }?></b></center></td>
			</tr>
			<? $i++; endforeach ?>
		</tbody>
	</table>
<?else:?>
	<table class="order">
		<tbody>
			<tr>
				<th>№</th>
				<th>Наименование</th>
				<th>Производитель</th>
				<th>Модель</th>
				<th>Цена, руб.</th>
				<th>Количество</th>
				<th>Скидка, %</th>
				<th>Цена со скидкой, руб.</th>
				<th>Стоимость, руб.</th>
			</tr>
			<? $i = 1; foreach($arResult['BASKET'] as $k=>$row): ?>
			<?
				$iprops = array();
				foreach($row['PROPS'] as $k=>$v)
				{
					$iprops[$v['NAME']] = $v['VALUE'];
				}
			?>
			<tr>
				<td><? echo $i ?></td>
				<td><b><? echo $row['NAME'] ?></b></td>
				<td><? echo $iprops['Производитель'] ?></td>
				<td><? echo $iprops['Модель'] ?></td>
				<td><center><b><? echo formatPrice2($row['PRICE']+$row['DISCOUNT_PRICE']) ?></b></center></td>
				<td><center><? echo $row['QUANTITY'] ?></center></td>
				<td><center><? echo $row['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></center></td>
				<td><center><b><? echo formatPrice2($row['PRICE']) ?></b></center></td>
				<td><center><b><? echo formatPrice2($row['PRICE']*$row["QUANTITY"]) ?></b></center></td>
			</tr>
			<? $i++; endforeach ?>
		</tbody>
	</table>
<?endif;?>

<div class="orderInfo open">
	<dl>
		<dt>Доставка: 
		<?
			if($arResult['DELIVERY']['NAME'] == 'Доставка курьером') print 'транспортом СООО "Багория"';
			else print 'транспортной компанией';
		?>
		</dt>
	</dl> 
	<div class="form">
		<div class="caption">Адрес доставки</div>
		<table>
			<tbody><tr>
				<th>Город:</th>
				<td><? echo $props['[Адрес доставки] Название населённого пункта'] ?></td>
			</tr>
			<tr>
				<th>Адрес:</th>
				<?
					if($props['[Адрес доставки] Индекс'] != '') $total_address = $props['[Адрес доставки] Индекс'] . ', ' . $props['[Адрес доставки] Тип улицы'] . $props['[Адрес доставки] Улица'] . ' ' . $props['[Адрес доставки] Дом'];
					else $total_address = $props['[Адрес доставки] Тип улицы'] . $props['[Адрес доставки] Улица'] . ' ' . $props['[Адрес доставки] Дом'];
					if($props['[Адрес доставки] Корпус'] != '') $total_address = $total_address . '/' . $props['[Адрес доставки] Корпус'];
					if($props['[Адрес доставки] Офис/квартира'] != '') $total_address = $total_address . ', ' . $props['[Адрес доставки] Офис/квартира'];
				?>
				<td><? echo $total_address ?></td>
			</tr>
			<tr>
				<th>Контактное лицо:</th>
				<td><? echo $props['Контактное лицо'] ?></td>
			</tr>
			<tr>
				<th>Телефон:</th>
				<td><? echo $props['Телефон'] ?></td>
			</tr>
			<tr>
				<th>Факс:</th>
				<td><? echo $props['Факс'] ?></td>
			</tr>
		</tbody></table>
	</div>
</div>

<div class="orderInfo open">
<dl>
	<dt>Условия оплаты:</dt>
</dl>
	<div class="form">
		<div class="caption">Юридические реквизиты</div>
		<table>
			<tbody><tr>
				<th>Название организации:</th>
				<td><? echo $props['Название организации'] ?></td>
			</tr>
			<tr>
				<th>ФИО руководителя:</th>
				<td><? echo $props['ФИО руководителя'] ?></td>
			</tr>
			<tr>
				<th>Юридический адрес:</th>
				<?
					if($props['[Юр. адрес] Индекс'] != '') $legal_address = $props['[Юр. адрес] Индекс'] . ', ' . $props['[Юр. адрес] Тип улицы'] . $props['[Юр. адрес] Улица'] . ' ' . $props['[Юр. адрес] Дом'];
					else $legal_address = $props['[Юр. адрес] Тип улицы'] . $props['[Юр. адрес] Улица'] . ' ' . $props['[Юр. адрес] Дом'];
					if($props['[Юр. адрес] Корпус'] != '') $legal_address = $legal_address . '/' . $props['[Юр. адрес] Корпус'];
					if($props['[Юр. адрес] Офис/квартира'] != '') $legal_address = $legal_address . ', ' . $props['[Юр. адрес] Офис/квартира'];
				?>
				<td><? echo $legal_address ?></td>
			</tr>
			<tr>
				<th>УНП:</th>
				<td><? echo $props['УНП'] ?></td>
			</tr>
		</tbody></table>
		<div class="caption">Банковские реквизиты</div>
		<table>
			<tbody><tr>
				<th>Расчетный счет:</th>
				<td><? echo $props['Расчетный счет'] ?></td>
			</tr>
			<tr>
				<th>Название банка:</th>
				<td><? echo $props['Название банка'] ?></td>
			</tr>
			<tr>
				<th>Код банка:</th>
				<td><? echo $props['Код банка'] ?></td>
			</tr>
		</tbody></table>
	</div>
</div>
