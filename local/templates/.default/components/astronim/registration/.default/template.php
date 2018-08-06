<?

$APPLICATION->SetTitle("Регистрация нового пользователя");	

$errors = $arResult['errors'];
$personal_data = $arResult['personal_data'];
$legal_details = $arResult['legal_details'];
$contact_details = $arResult['contact_details'];
$banking_details = $arResult['banking_details'];
$egr_details = $arResult['egr_details'];
$add_inf = $arResult['add_inf'];

?>

<? if($arResult['success_reg']): ?>
<h1>Регистрация нового пользователя</h1>
Вы успешно зарегистрировались. В течение 2-х дней ваша анкета будет рассмотрена. После рассмотрения на ваш электронный адрес будет отправлено уведомление с дополнительными инструкциями и предоставлены расширенные права в каталоге.
<script type="text/javascript">
    window.onload = function() {
        yaCounter24544484.reachGoal('SITE-REG')
    }
</script>
<? else: ?>
<h1>Регистрация нового пользователя</h1>
<form action="" method="post" id="registration_form"><div class="form">
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
			<td><input type="email" name="personal_data[email]" value="<? echo $personal_data['email'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['email'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Повторите адрес электронной почты</th>
			<td><input type="email" name="personal_data[email_confirm]" value="<? echo $personal_data['email_confirm'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['email_confirm'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Пароль</th>
			<td><input type="password" name="personal_data[password]" value="<? echo $personal_data['password'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['password'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Подтверждение пароля</th>
			<td><input type="password" name="personal_data[password_confirm]" value="<? echo $personal_data['password_confirm'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['personal_data']['password_confirm'] ?></span>
				</div>
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
			<td><input type="text" id="form_unp" name="legal_details[unp]" value="<? echo $legal_details['unp'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['legal_details']['unp'] ?></span>
				</div>
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
			<td><input type="text" id="legal_city" name="legal_details[city]" value="<? echo $legal_details['city'] ?>"><span class="required">*</span>
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
				<div class="addressCheck">
					<input type="checkbox" id="adr-1">
					<label for="adr-1">Почтовый адрес совпадает с юридическим</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>Адрес доставки</th>
			<td><input type="text" name="contact_details[delivery_address]" id="delivery_address" value="<? echo $contact_details['delivery_address'] ?>"><span class="required">*</span>
				<div class="addressCheck">
					<input type="checkbox" id="adr-2">
					<label for="adr-2">Адрес доставки совпадает с юридическим</label>
				</div>
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
		<?/*
		<tr>
			<th>Регистрационный номер</th>
			<td><input type="text" name="egr_details[number]" value="<? echo $egr_details['number'] ?>"><span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['egr_details']['number'] ?></span>
				</div>
			</td>
		</tr>
		*/?>
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
			<td><input type="text" class="date-picker" id="datepicker" name="egr_details[date]" value="<? echo $egr_details['date'] ?>"><span class="required">*</span>  
				<div class="addressCheck error">
					<span><? echo $errors['egr_details']['date'] ?></span>
				</div>			
			</td> 
		</tr>
	</table>
	<div class="caption">Дополнительная информация</div>
	<table>
		<tr>
			<th>Цель приобретения</th>
			<td>
				<select name="add_inf[goal]">
					<option value="">Выбрать</option>
					<option value="SALE"<? if( $_POST['add_inf']['goal'] == 'SALE') echo ' selected' ?>>Для оптовой и/или розничной торговли</option>
					<option value="PERSONAL"<? if( $_POST['add_inf']['goal'] == 'PERSONAL') echo ' selected' ?>>Для собственного потребления</option>
				</select>
				<span class="required">*</span>
				<div class="addressCheck error">
					<span><? echo $errors['add_inf']['goal'] ?></span>
				</div>
			</td>
		</tr>
		<tr>
			<th>Выбор склада</th>
			<td><?=$arResult['stores']?>
				<div class="addressCheck error">
					<span><? echo $errors['add_inf']['store'] ?></span>
				</div>
			</td>
		</tr>
	</table>
	<div class="caption">Пользовательское соглашение</div>
	<table>
		<tr>
			<td>
				
				<div style="width: 100%; height: 150px; overflow-x: hidden;">
					<div style="margin-left: 29px; margin-right: 5px; "><h4 style="margin-top: 0px;">Основные понятия</h4><b>Сайт </b>- <a href="http://www.bagoria.by">http://www.bagoria.by</a><br><b>Владелец Сайта</b> – СООО «Багория».<br><b>Администрация Сайта</b> – лица, уполномоченные Владельцем Сайта осуществлять от его имени управление и использование Сайта.<br><b>Пользователь </b>– любое юридическое лицо (индивидуальный предприниматель), добровольно прошедшее регистрацию Сайте и имеющее уникальные учетные данные (логин/пароль) для пользования Системой.<br><b>Регистрация </b>– процедура внесения персональных данных Пользователя в специальную форму на Сайте, необходимая для предоставления доступа Пользователя к Системе.<br><b>Система</b>– автоматизированная система заказа товаров через интернет с обновлением наличия товаров на складе on-line с интернет-сайта, принадлежащего Продавцу, расположенному в сети интернет по адресу <a href="http://www.bagoria.by">http://www.bagoria.by</a>, где представлены Товары, предлагаемые Продавцом для приобретения Покупателями.<br><b>Авторизация </b>– идентификация Пользователя в Системе посредством ввода в поле авторизации личного кода авторизации.<br><b>Покупатель </b>– юридическое лицо или индивидуальный предприниматель, разместившее Заказ(-ы) в Системе на сайте <a href="http://www.bagoria.by">http://www.bagoria.by</a>.<br><b>Продавец </b>–Совместное общество с ограниченной ответственностью «БАГОРИЯ».<br><b>Товар </b>– объект материального мира, представленный к продаже на Сайте Продавца.<br><b>Заказ </b>– должным образом оформленный запрос Покупателя на приобретение Товаров, отобранных на Сайте.<br><br>Система <b>не является</b> интернет-магазином.<br>Система <b>не предусматривает</b> возможность оплаты товара через Интернет.<br><h4 style="margin-top: 10px;">1. Общие положения</h4>1.1. Настоящее пользовательское соглашение регулирует отношения между Владельцем Сайта в лице Администрации Сайта и Пользователями Сайта, возникающие в связи с использованием Сайта.<br>1.2. Настоящее пользовательское соглашение вступает в силу непосредственно после выражения Пользователем согласия с условиями данного Соглашения путем нажатия Пользователем кнопки «Я согласен с пользовательским соглашением» во время регистрации на сайте.<br>1.3. Вопросы, не урегулированные настоящим пользовательским соглашением, регламентируются законодательством Республики Беларусь.<br>1.4. Положения настоящего пользовательского соглашения устанавливаются, изменяются и отменяются Администрацией Сайта в одностороннем порядке без согласия Пользователей Сайта. С момента размещения на Сайте новой редакции пользовательского соглашения предыдущая редакция считается утратившей свою силу.<br>1.5. Действующая редакция настоящего пользовательского соглашения размещена в сети Интернет по адресу <a href="http://www.bagoria.by/agreement/">http://www.bagoria.by/agreement/</a>.<br>1.6. Бездействие со стороны Владельца сайта в случае нарушения Покупателем положений Соглашения не лишает Владельца сайта права предпринять соответствующие действия в защиту своих интересов позднее, а также не означает отказа Владельца сайта от своих прав в случае совершения в последующем подобных либо сходных нарушений.<br><h4 style="margin-top: 10px;">2. Регистрация, авторизация и безопасность</h4>2.1. Регистрация на Сайте является обязательной для оформления Заказа.Для получения доступа к Системе и возможности размещения заказов Пользователю необходимо осуществить процедуру регистрации, заключающуюся в выполнении следующих действий: - заполнить форму регистрации; - подтвердить введенные данные. <br>2.2. Пользователь несет ответственность за безопасность учетных данных, а также за все, что будет сделано с использованием сервисов Системы под авторизацией Пользователя. <br>2.3. Пользователь соглашается с тем, что только он самостоятельно осуществляет безопасное завершение работы под своимиучетными данными (кнопка «Выход») по окончании каждой сессии работы с Системой и обязуется обеспечивать конфиденциальность своихучетных данных. <br>2.4. Пользователь подтверждает, что не имеет права передавать своиучетные данные третьим лицам, а также не имеет права получать его от третьих лиц. <br>2.5. Пользователь соглашается с тем, что он обязан незамедлительно уведомить Администрацию сайта о любом случае несанкционированного доступа к его учетным данным.&nbsp; В случае возникновения у Пользователя подозрений относительно безопасности его логина и пароля или возможности их несанкционированного использования третьими лицами, Пользователь обязуется незамедлительно уведомить об этом Администрацию сайта, направив электронное письмо по адресу: <a href="mailto:seo@bagoria.by">seo@bagoria.by</a>.<br>2.6. Администрация сайта не несет ответственности за точность и правильность информации, предоставляемой Пользователем при регистрации.<br><h4 style="margin-top: 10px;">3. Права и обязанности Пользователя</h4>3.1. Пользователь обязан предоставить достоверную и полную информацию по вопросам, предлагаемым при Регистрации, и необходимую для выполнения обязательств со стороны Продавца в отношении приобретаемого Вами Товара,а также поддерживать эту информацию в актуальном состоянии. <br>3.2. В случае, если Пользователь предоставил неверную информацию, или у Администрации сайта есть основания полагать, что предоставленная Пользователем информация неполна и/или недостоверна, Администрация сайта имеет право заблокировать либо удалить учетную запись Пользователя и отказать в использовании своих сервисов.<br>3.3. Пользователь вправе использовать Сайт по его Целевому назначению.<br>3.4. Пользователь обязан соблюдать условия, предусмотренные настоящим пользовательским соглашением.<br>3.5. Зарегистрировавшись на сайте, Пользователь разрешает использование своих персональных данных Администрации Сайта c целью улучшения качества услуг, информирования Пользователя о покупках, для извещения Пользователя о новостях, для возможности участия в конкурсных программах и иных сервисах, предусмотренных для посетителей Сайта, о мероприятиях, проводимых Владельцем сайта и партнерами, а также для достижения целей, предусмотренных другими пунктами пользовательского соглашения.<br>3.6. Пользователь обязуется письменно уведомить Владельца сайта о любых случаях изменения персональных данных Пользователя. Изменение данных (смена наименования, юридического адреса, банковских реквизитов и т.п.) Пользователем в Системе носит информационный характер и не влечет автоматическое изменение реквизитов контрагента СООО «Багория» при документальном оформлении сделок.<br>3.7. Пользователь имеет право отозвать данное ранее согласие на использование персональных данных, обратившись письменно к Администрации Сайта.<br><h4 style="margin-top: 10px;">4. Права и обязанности Администрации Сайта</h4>4.1. Администрация Сайта осуществляет текущее управление Сайтом (Системой) и определяет порядок его использования, определяет состав сервисов Сайта, его структуру и внешний вид, разрешает и ограничивает доступ к Системе, осуществляет иные принадлежащие ей права.<br>4.2. Администрация Сайта вправе в одностороннем порядке без согласия Пользователя по любым причинам, в том числе, но не ограничиваясь, в случае нарушения Пользователем условий, установленных настоящим пользовательским соглашением, удалить учетную запись Пользователя.<br>4.3. Администрация Сайта вправе в одностороннем порядке отказать Пользователю в приеме оформленного заказа без объяснения.<br><h4 style="margin-top: 10px;">5. Система</h4>5.1. Авторские права на Систему принадлежат Владельцу сайта.<br>5.2. Система выполняет следующие задачи:<br>- регистрация Пользователей;<br>- просмотр остатков товаров на складе;<br>- просмотр остатков товаров с ценами (после авторизации в Системе);<br>- возможность оформления заказа с автоматическим резервированием товаров из имеющихся на момент оформления заказа остатков товаров;<br>- оформление счета-фактуры после обработки заказа;<br>- смена пароля.</div>
				</div>
				<div class="rights" style="margin: 15px 0 16px 30px"><input type="checkbox" name="rights" id="rights"> <label for="rights">Я согласен с пользовательским соглашением</label></div>
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
	<a href="javascript:void(0);" id="registration_btn" class="btn disabled" onClick="submit_registration_form(); return false;">Зарегистрироваться</a>
</div>
</form>

<script type="text/javascript">

	$("#rights").on('click', function(){

		if( $("#rights").attr('checked') == 'checked' )
		{
			$("#registration_btn").removeClass("disabled");
		} else {
			$("#registration_btn").addClass("disabled");
		}

	});


	$("#adr-1").on('click', function(){

		if( $("#adr-1").attr('checked') == 'checked' )
		{
			$("#post_address").val($("#legal_city").val()+", "+$("#legal_address").val());
		} else {
			$("#post_address").val('');
		}

	});

	$("#adr-2").on('click', function(){

		if( $("#adr-2").attr('checked') == 'checked' )
		{
			$("#delivery_address").val($("#legal_city").val()+", "+$("#legal_address").val());
		} else {
			$("#delivery_address").val('');
		}

	});

	$("#form_unp").on('change', function(){
		$.get('/personal/registration/check_unp.php', { unp: $(this).val() }, function(res){
			$("#form_unp").parent().find(".addressCheck.error span").html(res);
		});
	});

	var submit_registration_form = function()
	{
		if ($("#registration_btn").hasClass('disabled') == false) $('#registration_form').submit();
		return false;
	}

</script>
<? endif; ?>