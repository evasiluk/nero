<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
?>

<script>
     $(function () {
         initAjaxForm($("#web-form-<?= $arResult['uniq'] ?>"));
     });
</script>

<section class="wrap form-wrap">
    <div class="usercontent form-loading js-form-loading">
        <h4 class="align-center">Загрузка…</h4>
    </div>
    <? if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {
        /***********************************************************************************
         * form header
         ***********************************************************************************/
        ?>
    <?
    } // endif?>
    <? if ($arResult['is_ajax_submitted']) {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
    } ?>

    <?= $arResult["FORM_HEADER"] ?>
    <div class="form-step" style="display: none;">
        <h5 class="align-center"><?= $arResult["FORM_TITLE"] ?></h5>
        <input type="hidden" name="line_name" id="line_name" value=""/>
        <input type="hidden" name="xss_name" id="xss_name" value=""/>
        <input type="hidden" name="AJAX" value="Y">
        <input type="hidden" name="web_form_submit" value="submit">
        <input type="hidden" name="uniq" value="<?= $arResult['uniq'] ?>">
        <input type="hidden" name="register" value="Y" id="register">


        <div class="js-form__result js-form__replace" id="form-result-message">
            <? if ($arResult["isFormErrors"] == "Y" && strlen($arResult["FORM_ERRORS"])) { ?>
                <span class="error-text">
                        <?= nl2br($arResult["FORM_ERRORS"]); ?>
                    </span>
            <? } ?>
            <? if ($arResult['isFormNote'] && $arResult["FORM_NOTE"]): ?>
                <div class="success-text"><?= nl2br(preg_replace("/[\r\n]+/", "\n", $arResult["FORM_NOTE"])); ?></div>
            <? endif; ?>
        </div>
        <?foreach($arResult["QUESTIONS"] as $question):?>
            <div class="form-row flex-row">
                <?if(in_array($question["STRUCTURE"][0]["FIELD_TYPE"], array("dropdown"))):?>
                <div class="col-xs">
                    <?else:?>
                    <label class="col-xs">
                        <?endif?>
                        <div class="input">
                            <span class="input-label"><?=$question["CAPTION"]?><?if($question["REQUIRED"] == "Y"):?><sup>*</sup><?endif?></span>
                            <?if(in_array($question["STRUCTURE"][0]["FIELD_TYPE"], array("text"))):?>
                                <div class="input-in">
                                    <?if($question["REQUIRED"] == "Y"):?>
                                        <?$question["HTML_CODE"] = str_replace('type="text"', 'type="text" placeholder="" required data-parsley-required', $question["HTML_CODE"]);?>
                                    <?endif?>
                                    <?=$question["HTML_CODE"]?>

                                    <span class="focus-border"></span>
                                    <?if($question["REQUIRED"] == "Y"):?>
                                        <span class="input-note">Например, текст</span>
                                    <?else:?>
                                        <span class="input-note">Например, пустота</span>
                                    <?endif?>

                                </div>
                            <?endif?>
                            <?if(in_array($question["STRUCTURE"][0]["FIELD_TYPE"], array("email"))):?>
                                <div class="input-in">
                                    <?if($question["REQUIRED"] == "Y"):?>
                                        <?$question["HTML_CODE"] = str_replace('type="text"', 'type="email" id="user_register_email" placeholder="" required data-parsley-required', $question["HTML_CODE"]);?>
                                    <?endif?>
                                    <?=$question["HTML_CODE"]?>
                                    <span class="focus-border"></span>
                                    <span class="input-note">Например, adress@box.domen</span>
                                </div>
                            <?endif?>
                            <?if(in_array($question["STRUCTURE"][0]["FIELD_TYPE"], array("password"))):?>
                                <div class="input-in">
                                    <?if($question["REQUIRED"] == "Y"):?>
                                        <?$question["HTML_CODE"] = str_replace('type="password"', 'type="password" placeholder="" required data-parsley-required', $question["HTML_CODE"]);?>
                                    <?endif?>
                                    <?if($question["CAPTION"] == "Пароль"):?>
                                        <?$question["HTML_CODE"] = str_replace('type="password"', 'type="password" id="register_password"', $question["HTML_CODE"]);?>
                                    <?endif?>
                                    <?if($question["CAPTION"] == "Подтверждение пароля"):?>
                                        <?$question["HTML_CODE"] = str_replace('type="password"', 'type="password" id="register_password_confirm" data-parsley-equalto="#register_password"', $question["HTML_CODE"]);?>
                                    <?endif?>
                                    <?=$question["HTML_CODE"]?>
                                    <span class="focus-border"></span>
                                </div>
                            <?endif?>
                            <?if(in_array($question["STRUCTURE"][0]["FIELD_TYPE"], array("file"))):?>
                                <div class="input-in">
                                    <?=$question["HTML_CODE"]?>
                                </div>
                            <?endif?>
                            <?if(in_array($question["STRUCTURE"][0]["FIELD_TYPE"], array("dropdown"))):?>
                                <?if($question["REQUIRED"] == "Y"):?>
                                    <?$question["HTML_CODE"] = str_replace('<select', '<select data-select required data-parsley-required', $question["HTML_CODE"]);?>
                                <?else:?>
                                    <?$question["HTML_CODE"] = str_replace('<select', '<select data-select', $question["HTML_CODE"]);?>
                                <?endif?>
                                <?=$question["HTML_CODE"]?>
                            <?endif?>
                        </div>
                        <?if(in_array($question["STRUCTURE"][0]["FIELD_TYPE"], array("dropdown"))):?>
                </div>
            <?else:?>
                </label>
            <?endif?>
            </div>
        <?endforeach?>

        <? if ($arResult["isUseCaptcha"] == "Y" || true) {
            $FIELD_SID = '0';
            $is_error = (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])); ?>

            <div class="form-row flex-row">
                <div class="col-xs<? if ($is_error) echo ' error'; ?>">
                    <?= $arResult['recaptcha']['div'] . $arResult['recaptcha']['error'] ?>
                    <div class="js-form__replace" id="<?= $FIELD_SID ?>">
                        <? if ($is_error) { ?>
                            <span class="error-note"><?= "Заполните капчу!"//$arResult["FORM_ERRORS"][$FIELD_SID] ?></span>
                        <? } ?>
                        <? if ($arQuestion["REQUIRED"] == "Y" && (strlen($arQuestion["CAPTION"]) > 0)) { ?>
                            <?= $arResult["REQUIRED_SIGN"]; ?>
                        <? } ?>
                    </div>
                </div>
            </div>
        <? } // isUseCaptcha?>


    </div>

    <div class="form-navigation">
        <div class="form-row flex-row">
            <div class="col-xs-6 col-sm start-xs js-prev">
                <button class="button button--black button--big button--arrow-back"><span>Назад</span></button>
            </div>
            <div class="col-xs-6 col-sm end-xs js-next">
                <button class="button button--bgred button--big button--arrow"><span>Далее</span></button>
            </div>
            <div class="col-xs-6 col-sm end-xs js-submit">
                <input type="submit" class="button button--bgred button--big" value="Готово">
            </div>
        </div>
    </div>
    <?= $arResult["FORM_FOOTER"] ?>
    <? if ($arResult['is_ajax_submitted']) die; ?>
</section>
