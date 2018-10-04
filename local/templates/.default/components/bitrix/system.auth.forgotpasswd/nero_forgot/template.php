<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>
<section class="wrap form-wrap">
<?

ShowMessage($arParams["~AUTH_RESULT"]);

?>
<form name="bform" class="reg-form js-reg-form" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">
    <h5 class="align-center"><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></h5>

    <div class="form-row flex-row">
        <label class="col-xs">
            <div class="input">
                <span class="input-label"><?=GetMessage("AUTH_EMAIL")?><sup></sup></span>
                <div class="input-in">
                    <input type="text" name="USER_EMAIL" maxlength="255" />
                    <span class="focus-border"></span>
                </div>
            </div>
        </label>
    </div>

    <?if($arResult["USE_CAPTCHA"]):?>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?echo GetMessage("system_auth_captcha")?><sup></sup></span>
                    <div class="input-in">
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        <input type="text" name="captcha_word" maxlength="50" value="" />
                    </div>
                </div>
            </label>
        </div>
    <?endif?>

    <div class="form-row flex-row form-footer">
        <div class="col-xs center-xs">
            <p><button type="submit" class="button button--big button-hover--bgblack" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>">Отправить</button></p>
            <div class="form-note">* Поля обязательные для заполнения</div>
        </div>
    </div>
</form>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
</section>