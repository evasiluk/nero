<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();
?>



<?if($arResult["FORM_TYPE"] == "login"):?>
    <br>
<form class="reg-form js-reg-form" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
    <?if($arResult['ERROR_MESSAGE']["TYPE"] == "ERROR"):?>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div id="ajax_result" class="form-error" style="display: block;"><ol>
                        <li><?=$arResult['ERROR_MESSAGE']["MESSAGE"]?></li>
                    </ol></div>
            </label>
        </div>
    <?endif?>
    <h5 class="align-center">Авторизация</h5>
    <?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />



            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">*<?=GetMessage("AUTH_LOGIN")?></span>
                        <div class="input-in">
                            <input type="text" name="USER_LOGIN" maxlength="50" value="" size="17" />
                        </div>
                    </div>
                </label>
            </div>
			<script>
				BX.ready(function() {
					var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
					if (loginCookie)
					{
						var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
						var loginInput = form.elements["USER_LOGIN"];
						loginInput.value = loginCookie;
					}
				});
			</script>

            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">*<?=GetMessage("AUTH_PASSWORD")?></span>
                        <div class="input-in">
                            <input type="password" name="USER_PASSWORD" maxlength="50" size="17" autocomplete="off" />
                        </div>
                    </div>
                </label>
            </div>

            <div class="form-row flex-row">
                <div class="col-xs">
                    <div class="input">
                        <div class="input-in">
                            <label>
                                <input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" />
                                <span><?=GetMessage("AUTH_REMEMBER_ME")?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        <div class="form-row flex-row">
            <div class="col-xs">
                <div class="input">
                    <div class="input-in">
                        <a href="/content/personal/forgot/">Забыли пароль?</a>
                    </div>
                </div>
            </div>
        </div>


    <div class="col-xs-6 col-sm end-xs js-reg-submit">
        <input type="submit" class="button button--bgred button--big" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>">
    </div>
</form><br>



<?
elseif($arResult["FORM_TYPE"] == "otp"):
?>

<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="OTP" />
	<table width="95%">
		<tr>
			<td colspan="2">
			<?echo GetMessage("auth_form_comp_otp")?><br />
			<input type="text" name="USER_OTP" maxlength="50" value="" size="17" autocomplete="off" /></td>
		</tr>
<?if ($arResult["CAPTCHA_CODE"]):?>
		<tr>
			<td colspan="2">
			<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br />
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
			<input type="text" name="captcha_word" maxlength="50" value="" /></td>
		</tr>
<?endif?>
<?if ($arResult["REMEMBER_OTP"] == "Y"):?>
		<tr>
			<td valign="top"><input type="checkbox" id="OTP_REMEMBER_frm" name="OTP_REMEMBER" value="Y" /></td>
			<td width="100%"><label for="OTP_REMEMBER_frm" title="<?echo GetMessage("auth_form_comp_otp_remember_title")?>"><?echo GetMessage("auth_form_comp_otp_remember")?></label></td>
		</tr>
<?endif?>
		<tr>
			<td colspan="2"><input type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" /></td>
		</tr>
		<tr>
			<td colspan="2"><noindex><a href="<?=$arResult["AUTH_LOGIN_URL"]?>" rel="nofollow"><?echo GetMessage("auth_form_comp_auth")?></a></noindex><br /></td>
		</tr>
	</table>
</form>

<?
else:
?>

<form action="<?=$arResult["AUTH_URL"]?>">
	<table width="95%">
		<tr>
			<td align="center">
				<?=$arResult["USER_NAME"]?><br />
				[<?=$arResult["USER_LOGIN"]?>]<br />
				<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=GetMessage("AUTH_PROFILE")?></a><br />
			</td>
		</tr>
		<tr>
			<td align="center">
			<?foreach ($arResult["GET"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<input type="hidden" name="logout" value="yes" />
			<input type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />
			</td>
		</tr>
	</table>
</form>
<?endif?>

