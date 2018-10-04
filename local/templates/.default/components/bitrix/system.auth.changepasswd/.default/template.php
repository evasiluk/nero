<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="wrap form-wrap">

<?
ShowMessage($arParams["~AUTH_RESULT"]);
?>
<form class="reg-form js-reg-form" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
	<?if (strlen($arResult["BACKURL"]) > 0): ?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<? endif ?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="CHANGE_PWD">
    <h5 class="align-center"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h5>
    <div class="form-row flex-row">
        <label class="col-xs">
            <div class="input">
                <span class="input-label"><?=GetMessage("AUTH_LOGIN")?><sup>*</sup></span>
                <div class="input-in">
                    <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="bx-auth-input" />
                    <span class="focus-border"></span>
                    <span class="input-note">login@email.com</span>
                </div>
            </div>
        </label>
    </div>
    <div class="form-row flex-row">
        <label class="col-xs">
            <div class="input">
                <span class="input-label"><?=GetMessage("AUTH_CHECKWORD")?><sup>*</sup></span>
                <div class="input-in">
                    <input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" />
                    <span class="focus-border"></span>
                </div>
            </div>
        </label>
    </div>
    <div class="form-row flex-row">
        <label class="col-xs">
            <div class="input">
                <span class="input-label"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?><sup>*</sup></span>
                <div class="input-in">
                    <input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
                    <span class="focus-border"></span>
                </div>
            </div>
        </label>
    </div>
    <div class="form-row flex-row">
        <label class="col-xs">
            <div class="input">
                <span class="input-label"><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?><sup>*</sup></span>
                <div class="input-in">
                    <input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
                    <span class="focus-border"></span>
                </div>
            </div>
        </label>
    </div>
    <?if($arResult["USE_CAPTCHA"]):?>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?echo GetMessage("system_auth_captcha")?><sup>*</sup></span>
                    <div class="input-in">
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        <input type="text" name="captcha_word" maxlength="50" value="" />
                        <span class="focus-border"></span>
                    </div>
                </div>
            </label>
        </div>
    <?endif?>
    <div class="form-row flex-row form-footer">
        <div class="col-xs center-xs">
            <p><button type="submit" class="button button--big button-hover--bgblack" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>">Отправить</button></p>
            <div class="form-note">* Поля обязательные для заполнения</div>
        </div>
    </div>


<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
<p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
<p>
<a href="/content/personal/auth/"><b><?=GetMessage("AUTH_AUTH")?></b></a>
</p>

</form>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
</section>