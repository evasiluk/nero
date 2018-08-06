<?

$APPLICATION->SetTitle("Редактирование данных пользователя");	

$errors = $arResult['errors'];
$personal_data = $arResult['personal_data'];
$legal_details = $arResult['legal_details'];
$contact_details = $arResult['contact_details'];
$banking_details = $arResult['banking_details'];
$egr_details = $arResult['egr_details'];

?>

<? if($arResult['success_save']): ?>
<h1>Редактирование данных пользователя</h1>
Данные сохранены
<? else: ?>
<h1>Редактирование данных пользователя</h1>
<? if($_GET['save'] == 'ok'): ?>
<center><h3>Данные сохранены</h3></center>
<? endif;?>
<ul class="cartTabs ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
	<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="cart-tabs-2" aria-labelledby="ui-id-2" aria-selected="false"><a href="/personal/order/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Список заказов&nbsp;</a></li>
	<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="cart-tabs-3" aria-labelledby="ui-id-3" aria-selected="false"><a href="/personal/mutual_settlement/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Взаиморасчёты&nbsp;</a></li>	
	<li class="ui-tabs-active ui-state-default ui-corner-top ui-state-active" role="tab" tabindex="0" aria-controls="cart-tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="/personal/profile/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Редактирование профиля</a></li>
</ul>
<form action="/personal/profile/" method="post" id="registration_form"><div class="form">
	<div class="caption">Личные данные</div>
	<table>
		<tr>
			<th>Имя</th>
			<td><input type="text" name="personal_data[first_name]" value="<? echo $personal_data['first_name'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['first_name'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Фамилия</th>
			<td><input type="text" name="personal_data[last_name]" value="<? echo $personal_data['last_name'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['last_name'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Ваш электронный адрес</th>
			<td><input type="text" style="color: gray;" value="<? echo $personal_data['email'] ?>" disabled></span>
			</td>
		</tr>
		<tr>
			<th>Пароль</th>
			<td><input type="password" name="personal_data[password]" value="<? echo $personal_data['password'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['password'] ?></span>
				</div>
			</td>
			</td>
		</tr>
		<tr>
			<th>Подтверждение пароля</th>
			<td><input type="password" name="personal_data[password_confirm]" value="<? echo $personal_data['password_confirm'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['password_confirm'] ?></span>
				</div>
			</td>
			</td>
		</tr>
	</table>
	<div class="caption">Юридические реквизиты</div>
	<table>
		<tr>
			<th>Название организации / ИП</th>
			<td><input type="text" name="legal_details[name]" value="<? echo $legal_details['name'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['legal_details']['name'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>УНП</th>
			<td><input type="text" style="color: gray;" value="<? echo $legal_details['unp'] ?>" disabled></span>
			</td>
		</tr>
		<tr>
			<th>ФИО руководителя</th>
			<td><input type="text" name="legal_details[head_name]" value="<? echo $legal_details['head_name'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['legal_details']['head_name'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Город</th>
			<td><input type="text" name="legal_details[city]" value="<? echo $legal_details['city'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['legal_details']['city'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Юридический адрес</th>
			<td><input type="text" id="legal_address" name="legal_details[legal_address]" value="<? echo $legal_details['legal_address'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['legal_details']['legal_address'] ?></span>
				</div>
			</td>
		</tr>
	</table>
	<div class="caption">Контактные реквизиты</div>
	<table>
		<tr>
			<th>Контактное лицо (ФИО)</th>
			<td><input type="text" name="contact_details[name]" value="<? echo $contact_details['name'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['contact_details']['name'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Должность</th>
			<td><input type="text" name="contact_details[post]" value="<? echo $contact_details['post'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['contact_details']['post'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Телефон/факс</th>
			<td><input type="text" name="contact_details[phone]" value="<? echo $contact_details['phone'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['contact_details']['phone'] ?></span>
				</div>
			</td>
		</tr>		
		<tr>
			<th>Почтовый адрес</th>
			<td><input type="text" name="contact_details[post_address]" id="post_address" value="<? echo $contact_details['post_address'] ?>"><span class="required">*</span>
			</td>
		</tr>
		<tr>
			<th>Адрес доставки</th>
			<td><input type="text" name="contact_details[delivery_address]" id="delivery_address" value="<? echo $contact_details['delivery_address'] ?>"><span class="required">*</span>
			</td>
		</tr>
	</table>
	<div class="caption">Банковские реквизиты</div>
	<table>
		<tr>
			<th>Расчетный счет</th>
			<td><input type="text" name="banking_details[rs]" value="<? echo $banking_details['rs'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['banking_details']['rs'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Название банка</th>
			<td><input type="text" name="banking_details[name]" value="<? echo $banking_details['name'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['banking_details']['name'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Код банка</th>
			<td><input type="text" name="banking_details[code]" value="<? echo $banking_details['code'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['banking_details']['code'] ?></span>
				</div>
			</td>
		</tr>
	</table>
	<div class="caption">Сведения из Единого государственного реестра</div>
	<table>
		<tr>
			<th>Регистрационный номер</th>
			<td><input type="text" name="egr_details[number]" value="<? echo $egr_details['number'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['egr_details']['number'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Орган, осуществивший регистрацию</th>
			<td><input type="text" name="egr_details[organ]" value="<? echo $egr_details['organ'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['egr_details']['organ'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Дата решения о гос. регистрации</th>
			<td><input type="text" name="egr_details[date]" value="<? echo $egr_details['date'] ?>"><span class="required">*</span>
			</td>
		</tr>
	</table>
	<div class="caption">Дополнительная информация</div>
	<table>
		<tr>
			<th>Цель приобретения</th>
			<td>
				<select style="color: gray;" disabled>
					<option><? echo $arResult['add_inf']['goal'] ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<th>Выбор склада</th>
			<td>
				<select style="color: gray;" disabled>
					<option><? echo $arResult['add_inf']['store'] ?></option>
				</select>
			</td>
		</tr>
	</table>
	
</div>
<div style="font: 12px/14px Tahoma, sans-serif; float: right;">Поля, помеченные символом <span style="font-weight: bold; color: #00519b;">*</span> являются обязательными для заполнения</div>
<!--<div class="captcha">
	<img src="i/captcha.jpg" alt=""><br>
	Введите текст изображенный на картинке: <input type="text">
</div>-->

<div class="buttons">
	<a href="javascript:void(0);" id="registration_btn" class="btn" onClick="submit_registration_form(); return false;">Сохранить</a>
</div>
</form>

<script type="text/javascript">

	var submit_registration_form = function()
	{
		$('#registration_form').submit();
		return false;
	}

</script>
<? endif; ?>