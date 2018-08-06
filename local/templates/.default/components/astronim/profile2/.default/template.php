<?

$APPLICATION->SetTitle("Редактирование данных пользователя");	

$errors = $arResult['errors'];
$personal_data = $arResult['personal_data'];
$legal_details = $arResult['legal_details'];
$contact_details = $arResult['contact_details'];
$post_address = $arResult['post_address'];
$delivery_address = $arResult['delivery_address'];
$banking_details = $arResult['banking_details'];
$egr_details = $arResult['egr_details'];
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

	$(document).ready(function(){
		var cities = [ "Минск", "Витебск", "Брест", "Гомель", "Гродно", "Могилёв", "минск", "витебск", "брест", "гомель", "гродно", "могилёв" ];
		setTimeout(function(){ 
			if($('#legal_address_name').val() != ''){
				$('#legal_address_np_id').val($('#legal_address_name').val());
			}			
			if($('#post_address_name').val() != ''){
				$('#post_address_np_id').val($('#post_address_name').val());
			}
			if($('#delivery_address_name').val() != ''){
				$('#delivery_address_np_id').val($('#delivery_address_name').val());
			}			
		}, 1500);					
		setTimeout(function(){ 
			$('.title-search-result').each(function(){
				$(this).css('display','none');
			});
		}, 4000);	
		$('input').on('focus', function(e){
			var $this = $(this);
			if($this.prop('class') != 'bx_input_text' && $('.title-search-result').css('display') == 'block'){
				$('.title-search-result').css('display','none');
			}
		});		
		$('.bx_input_text').on('keyup', function(e){
			var $this = $(this);
			var $val  = $this.val();
			if(jQuery.inArray( $val, cities ) !== -1){
				$this.val($val + ' г.');
			};
		});
	});
	
</script>

<? if($arResult['success_save']): ?>
	<h1>Редактирование данных пользователя</h1>
	Данные сохранены
	<? else: ?>
		<h1>Редактирование данных пользователя</h1>
		<? if($_GET['save'] == 'ok'): ?>
		<center><h3>Данные сохранены</h3></center>
		<? endif;?>
		
		<? if(count($arResult['ERRORS']) > 0): ?>
		<center><h3><font style="color:red;">Найдены ошибки в заполнении формы!</font></h3></center>
		<? endif;?>
		
		<? if($_GET['save'] != 'ok' and $_GET['return'] == 'cart') : ?>
		<center><h3>Пожалуйста, заполните информацию о ваших адресах новом формате.</h3></center>
		<? endif;?>
		
		<? if($_GET['save'] == 'ok' and isset($_REQUEST['return']) and $_REQUEST['return'] == 'cart') : ?>
			<? 
			header('Location: /personal/order/cart/index.php?order=updated#fill_order_info');
			?>
		<? else: ?>
<ul class="cartTabs ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
	<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="cart-tabs-2" aria-labelledby="ui-id-2" aria-selected="false"><a href="/personal/order/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Список заказов&nbsp;</a></li>
	<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="cart-tabs-3" aria-labelledby="ui-id-3" aria-selected="false"><a href="/personal/mutual_settlement/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Взаиморасчёты&nbsp;</a></li>	
	<li class="ui-tabs-active ui-state-default ui-corner-top ui-state-active" role="tab" tabindex="0" aria-controls="cart-tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="/personal/profile/" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Редактирование профиля</a></li>
</ul>
<form action="/personal/profile/index.php" method="post" id="registration_form">
<input type="hidden" id="return" name="return" value="<?=$_REQUEST['return']?>">
<div class="form">
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
				<input type="text" id="legal_address_index" placeholder="Индекс" style="width: 60px; <?if(isset($arResult['ERRORS']["legal_details"]["legal_address_index"])) { echo 'border-color: red;'; }?>" name="legal_details[legal_address_index]" value="<? echo $legal_details['legal_address_index'] ?>">
				<select id="legal_address_street_type" name="legal_details[legal_address_street_type]" style="width: 120px;" >
					<? foreach($arResult['STREET_TYPE'] as $street_type) : ?>
					<option value="<?=$street_type['ID']?>"<? if( $legal_details['legal_address_street_type'] == $street_type['ID']) echo ' selected' ?>><?=$street_type['STREET_TYPE']?></option>
					<? endforeach; ?>
				</select>
				<input type="text" id="legal_address_street" placeholder="Улица" style="width: 200px;" name="legal_details[legal_address_street]" value="<? echo $legal_details['legal_address_street'] ?>">
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
				<input type="hidden" id="post_address_name" name="post_address[name]" value="<? echo $contact_details['post_address'] ?>">
				<div class="addressCheck error">
					<span><? echo $errors['post_address']['np'] ?></span>
				</div>
			</td>	
		</tr>
		<tr>
			<th></th>
			<td>		
				<input type="text" id="post_address_index" placeholder="Индекс" style="width: 60px; <?if(isset($arResult['ERRORS']["post_address"]["index"])) { echo 'border-color: red;'; }?>" name="post_address[index]" value="<? echo $post_address['index'] ?>">
				<select id="post_address_street_type" name="post_address[street_type]" style="width: 120px;" >
					<? foreach($arResult['STREET_TYPE'] as $street_type) : ?>
					<option value="<?=$street_type['ID']?>"<? if( $post_address['street_type'] == $street_type['ID']) echo ' selected' ?>><?=$street_type['STREET_TYPE']?></option>
					<? endforeach; ?>
				</select>
				<input type="text" id="post_address_street" placeholder="Улица" style="width: 200px;" name="post_address[street]" value="<? echo $post_address['street'] ?>">
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
				<input type="hidden" id="delivery_address_name" name="delivery_address[name]" value="<? echo $contact_details['delivery_address'] ?>">
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
					<option value="<?=$street_type['ID']?>"<? if( $delivery_address['street_type'] == $street_type['ID']) echo ' selected' ?>><?=$street_type['STREET_TYPE']?></option>
					<? endforeach; ?>
				</select>
				<input type="text" id="delivery_address_street" placeholder="Улица" style="width: 200px;" name="delivery_address[street]" value="<? echo $delivery_address['street'] ?>">
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
		$('#legal_address_name').val($('#legal_address_np_id').val());
		$('#post_address_name').val($('#post_address_np_id').val());
		$('#delivery_address_name').val($('#delivery_address_np_id').val());
		//$('#registration_form form').remove();
		setTimeout(function(){
			$('#registration_form').submit();
		},1000);
		return false;
	}

</script>
<? endif;?>
<? endif; ?>