<h1>Восстановление пароля</h1>
<h4><? echo $arResult['error']; ?></h4>
<form action="" id="lostpassword_form" method="post">
	<input type="hidden" name="send_form" value="yes">
	<div class="form">
		<div class="caption">Введите данные пользователя</div>
		<table>
			<tbody>
			<tr>
				<th>Ваш электронный адрес</th>
				<td><input name="email" value="" type="text"></td>
			</tr>
			<tr>
				<th>УНП</th>
				<td><input name="unp" value="" type="text"></td>
			</tr>
			</tbody>
		</table>
	</div>
</form>

<div class="buttons">
	<a href="javascript:void(0);" id="registration_btn" class="btn" onclick="$('#lostpassword_form').submit(); return false;">Восстановить пароль</a>
</div>