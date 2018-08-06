<?

$APPLICATION->SetTitle("Регистрация нового пользователя");	

$errors = $arResult['errors'];
$personal_data = $arResult['personal_data'];
$legal_details = $arResult['legal_details'];
$contact_details = $arResult['contact_details'];
$post_address = $arResult['post_address'];
$delivery_address = $arResult['delivery_address'];
$banking_details = $arResult['banking_details'];
$egr_details = $arResult['egr_details'];
$add_inf = $arResult['add_inf'];

?>

<script type="text/javascript">
	
	function set_address(addr_field_id, np_id, np_name){
		$('#'+addr_field_id).val(np_name);
		$('.'+addr_field_id).val(np_id);
		var str_lenght = addr_field_id.length;
		var res = addr_field_id.slice(0,str_lenght - 6); 
		document.getElementById(res+'_index').focus();
		setTimeout(function(){ 
			$('.title-search-result').css('display','none');
		}, 1500);
	}
	
	function copyAddr(addr_type){
		if($('#'+addr_type+'_copy').is(":checked")){
			$('#'+addr_type+'_np_id').val($('#legal_address_np_id').val());
			$('#'+addr_type+'_np').val($('#legal_address_np').val());
			$('#'+addr_type+'_index').val($('#legal_address_index').val());
			$('#'+addr_type+'_street_type').val($('#legal_address_street_type').val());
			$('#'+addr_type+'_street').val($('#legal_address_street').val());
			$('#'+addr_type+'_house').val($('#legal_address_house').val());
			$('#'+addr_type+'_house_corpus').val($('#legal_address_house_corpus').val());
			$('#'+addr_type+'_office_appart').val($('#legal_address_office_appart').val());
			setTimeout(function(){ 
				$('.title-search-result').css('display','none');
			}, 1500);			
		}
	}
	
	function getNpIdByName($name){	
		var $np_id;
		$.ajax({ 
			async: false,
			url: "/ajax/getNpIdByName.php",
			data: { name : $name},
			type: 'POST',
			dataType: 'text',
			success: function(data){
				$np_id = data;
			}
		});
		return $np_id;
	}
		
	$(document).ready(function(){
		/*setTimeout(function(){ 
			if($('#post_address_name').val() != ''){
				$('#post_address_np_id').val($('#post_address_name').val());
			}
			if($('#delivery_address_name').val() != ''){
				$('#delivery_address_np_id').val($('#delivery_address_name').val());
			}			
		}, 1500);*/					
		/*setTimeout(function(){ 
			$('.title-search-result').each(function(){
				$(this).css('display','none');
			});
		}, 3000);*/			
	});
	
</script>

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
			<th>Населённый пункт</th>
			<td>
				<?$APPLICATION->IncludeComponent("bitrix:search.title", "np", Array(
					"NUM_CATEGORIES" => "1",	// Количество категорий поиска
					"TOP_COUNT" => "30",	// Количество результатов в каждой категории
					"ORDER" => "rank",	// Сортировка результатов
					"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
					"CHECK_DATES" => "N",	// Искать только в активных по дате документах
					"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
					"CATEGORY_0_TITLE" => "Населённые пункты",	// Название категории
					"CATEGORY_0" => array(	// Ограничение области поиска
						0 => "iblock_address",
					),
					"CATEGORY_0_iblock_address" => array(	// Искать в информационных блоках типа "iblock_address"
						0 => "33",
					),
					"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
					"INPUT_ID" => "legal_address_np_id",	// ID строки ввода поискового запроса
					"CONTAINER_ID" => "title-search",	// ID контейнера, по ширине которого будут выводиться результаты
					"PRICE_CODE" => "",	// Тип цены
					"PRICE_VAT_INCLUDE" => "N",	// Включать НДС в цену
					"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода
					"SHOW_PREVIEW" => "N",	// Показать картинку
					"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
					),
					false
				);?>
				<input type="hidden" id="legal_address_np" class="legal_address_np_id" name="legal_details[legal_address_np]" value="<? echo $legal_details['legal_address_np'] ?>">
				<input type="hidden" id="legal_address_name" name="legal_details[legal_address_name]" value="<? echo $legal_details['legal_address_name'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['legal_details']['legal_address_np'] ?></span>
				</div>
			</td>		
		</tr>
		<tr>
			<th>Адрес</th>
			<td>		
				<input type="text" id="legal_address_index" placeholder="Индекс" style="width: 60px;" name="legal_details[legal_address_index]" value="<? echo $legal_details['legal_address_index'] ?>">
				<select id="legal_address_street_type" name="legal_details[legal_address_street_type]" style="width: 120px;" >
					<? foreach($arResult['STREET_TYPE'] as $street_type) : ?>
					<option value="<?=$street_type['ID']?>"<? if( $_POST['legal_details']['legal_address_street_type'] == $street_type['ID']) echo ' selected' ?>><?=$street_type['STREET_TYPE']?></option>
					<? endforeach; ?>
				</select>
				<input type="text" id="legal_address_street" placeholder="Наименование" style="width: 200px;" name="legal_details[legal_address_street]" value="<? echo $legal_details['legal_address_street'] ?>">
				<input type="text" id="legal_address_house" placeholder="Дом" style="width: 30px;" name="legal_details[legal_address_house]" value="<? echo $legal_details['legal_address_house'] ?>">
				<input type="text" id="legal_address_house_corpus" placeholder="Корпус" style="width: 50px;" name="legal_details[legal_address_house_corpus]" value="<? echo $legal_details['legal_address_house_corpus'] ?>">
				<input type="text" id="legal_address_office_appart" placeholder="Офис/квартира" style="width: 100px;" name="legal_details[legal_address_office_appart]" value="<? echo $legal_details['legal_address_office_appart'] ?>">
				<span class="required">*</span>
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
			<td>
				<?$APPLICATION->IncludeComponent("bitrix:search.title", "np", Array(
					"NUM_CATEGORIES" => "1",	// Количество категорий поиска
					"TOP_COUNT" => "30",	// Количество результатов в каждой категории
					"ORDER" => "rank",	// Сортировка результатов
					"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
					"CHECK_DATES" => "N",	// Искать только в активных по дате документах
					"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
					"CATEGORY_0_TITLE" => "Населённые пункты",	// Название категории
					"CATEGORY_0" => array(	// Ограничение области поиска
						0 => "iblock_address",
					),
					"CATEGORY_0_iblock_address" => array(	// Искать в информационных блоках типа "iblock_address"
						0 => "33",
					),
					"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
					"INPUT_ID" => "post_address_np_id",	// ID строки ввода поискового запроса
					"CONTAINER_ID" => "title-search-2",	// ID контейнера, по ширине которого будут выводиться результаты
					"PRICE_CODE" => "",	// Тип цены
					"PRICE_VAT_INCLUDE" => "N",	// Включать НДС в цену
					"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода
					"SHOW_PREVIEW" => "N",	// Показать картинку
					"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
					),
					false
				);?>
				<input type="hidden" id="post_address_np" class="post_address_np_id" name="post_address[np]" value="<? echo $post_address['np'] ?>">
				<input type="hidden" id="post_address_name" name="post_address[name]" value="<? echo $post_address['name'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['post_address']['np'] ?></span>
				</div>
			</td>	
		</tr>
		<tr>
			<th></th>
			<td>		
				<input type="text" id="post_address_index" placeholder="Индекс" style="width: 60px;" name="post_address[index]" value="<? echo $post_address['index'] ?>">
				<select id="post_address_street_type" name="post_address[street_type]" style="width: 120px;" >
					<? foreach($arResult['STREET_TYPE'] as $street_type) : ?>
					<option value="<?=$street_type['ID']?>"<? if( $_POST['post_address']['street_type'] == $street_type['ID']) echo ' selected' ?>><?=$street_type['STREET_TYPE']?></option>
					<? endforeach; ?>
				</select>
				<input type="text" id="post_address_street" placeholder="Наименование" style="width: 200px;" name="post_address[street]" value="<? echo $post_address['street'] ?>">
				<input type="text" id="post_address_house" placeholder="Дом" style="width: 30px;" name="post_address[house]" value="<? echo $post_address['house'] ?>">
				<input type="text" id="post_address_house_corpus" placeholder="Корпус" style="width: 50px;" name="post_address[house_corpus]" value="<? echo $post_address['house_corpus'] ?>">
				<input type="text" id="post_address_office_appart" placeholder="Офис/квартира" style="width: 100px;" name="post_address[office_appart]" value="<? echo $post_address['office_appart'] ?>">
				<span class="required">*</span>
				<div class="addressCheck" style="margin-bottom: 8px;">
					<input type="checkbox" id="post_address_copy" onClick="copyAddr('post_address')">
					<label for="post_address_copy">Почтовый адрес совпадает с юридическим</label>
				</div>
				</br>
			</td>
		</tr>
		<tr>
			<th>Адрес доставки</th>
			<td>
				<?$APPLICATION->IncludeComponent("bitrix:search.title", "np", Array(
					"NUM_CATEGORIES" => "1",	// Количество категорий поиска
					"TOP_COUNT" => "30",	// Количество результатов в каждой категории
					"ORDER" => "rank",	// Сортировка результатов
					"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
					"CHECK_DATES" => "N",	// Искать только в активных по дате документах
					"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
					"CATEGORY_0_TITLE" => "Населённые пункты",	// Название категории
					"CATEGORY_0" => array(	// Ограничение области поиска
						0 => "iblock_address",
					),
					"CATEGORY_0_iblock_address" => array(	// Искать в информационных блоках типа "iblock_address"
						0 => "33",
					),
					"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
					"INPUT_ID" => "delivery_address_np_id",	// ID строки ввода поискового запроса
					"CONTAINER_ID" => "title-search-3",	// ID контейнера, по ширине которого будут выводиться результаты
					"PRICE_CODE" => "",	// Тип цены
					"PRICE_VAT_INCLUDE" => "N",	// Включать НДС в цену
					"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода
					"SHOW_PREVIEW" => "N",	// Показать картинку
					"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
					),
					false
				);?>
				<input type="hidden" id="delivery_address_np" class="delivery_address_np_id" name="delivery_address[np]" value="<? echo $delivery_address['np'] ?>">
				<input type="hidden" id="delivery_address_name" name="delivery_address[name]" value="<? echo $delivery_address['name'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['delivery_address']['np'] ?></span>
				</div>
			</td>	
		</tr>
		<tr>
			<th></th>
			<td>		
				<input type="text" id="delivery_address_index" class="delivery_address_np_id_next" placeholder="Индекс" style="width: 60px;" name="delivery_address[index]" value="<? echo $delivery_address['index'] ?>">
				<select id="delivery_address_street_type" name="delivery_address[street_type]" style="width: 120px;" >
					<? foreach($arResult['STREET_TYPE'] as $street_type) : ?>
					<option value="<?=$street_type['ID']?>"<? if( $_POST['delivery_address']['street_type'] == $street_type['ID']) echo ' selected' ?>><?=$street_type['STREET_TYPE']?></option>
					<? endforeach; ?>
				</select>
				<input type="text" id="delivery_address_street" placeholder="Наименование" style="width: 200px;" name="delivery_address[street]" value="<? echo $delivery_address['street'] ?>">
				<input type="text" id="delivery_address_house" placeholder="Дом" style="width: 30px;" name="delivery_address[house]" value="<? echo $delivery_address['house'] ?>">
				<input type="text" id="delivery_address_house_corpus" placeholder="Корпус" style="width: 50px;" name="delivery_address[house_corpus]" value="<? echo $delivery_address['house_corpus'] ?>">
				<input type="text" id="delivery_address_office_appart" placeholder="Офис/квартира" style="width: 100px;" name="delivery_address[office_appart]" value="<? echo $delivery_address['office_appart'] ?>">
				<span class="required">*</span>
				<div class="addressDetailCheck error">
					<span><? echo $errors['delivery_address']['detail'] ?></span>
				</div>
				<div class="addressCheck" style="margin-bottom: 8px;">
					<input type="checkbox" id="delivery_address_copy" onClick="copyAddr('delivery_address')">
					<label for="delivery_address_copy">Адрес доставки совпадает с юридическим</label>
				</div>
				</br>
			</td>
		</tr>		
	</table>
	<div class="caption">Банковские реквизиты</div>
	<table>
		<tr>
			<th>Расчетный счет (IBAN)</th>
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
			<th>Код банка (IBAN)</th>
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
		$('#legal_address_name').val($('#legal_address_np_id').val());
		$('#legal_address_np').val(getNpIdByName($('#legal_address_np_id').val()));
		
		$('#post_address_name').val($('#post_address_np_id').val());
		$('#post_address_np').val(getNpIdByName($('#post_address_np_id').val()));
		
		$('#delivery_address_name').val($('#delivery_address_np_id').val());
		$('#delivery_address_np').val(getNpIdByName($('#delivery_address_np_id').val()));		
		
		if ($("#registration_btn").hasClass('disabled') == false) $('#registration_form').submit();
		return false;
	}

</script>
<? endif; ?>