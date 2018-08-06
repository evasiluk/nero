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
<div class="cu-form-wrap" id="form_faq">
    <? if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {
        /***********************************************************************************
         * form header
         ***********************************************************************************/
        if ($arResult["isFormTitle"]) { ?>
            <div class="form-row flex-row form-header">
                <div class="col-xs center-xs">
                    <?= $arResult["FORM_TITLE"] ?>
                </div>
            </div>
        <? } //endif ;

        if ($arResult["isFormImage"] == "Y") { ?>
            <a href="<?= $arResult["FORM_IMAGE"]["URL"] ?>" target="_blank"
               alt="<?= Loc::getMessage("FORM_ENLARGE") ?>">
                <img src="<?= $arResult["FORM_IMAGE"]["URL"] ?>" <?= $arResult["FORM_IMAGE"]["ATTR"] ?> />
            </a>
        <? } //endif?>

        <p><?= $arResult["FORM_DESCRIPTION"] ?></p>
        <?
    } // endif?>
    <? if ($arResult['is_ajax_submitted']) {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
    } ?>

        <?= $arResult["FORM_HEADER"] ?>
        <input type="hidden" name="line_name" id="line_name" value=""/>
        <input type="hidden" name="xss_name" id="xss_name" value=""/>
        <input type="hidden" name="AJAX" value="Y">
        <input type="hidden" name="web_form_submit" value="submit">
        <input type="hidden" name="uniq" value="<?= $arResult['uniq'] ?>">


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

        <? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
            $is_file = ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'file');
            $is_error = (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS']));
            if ($is_error) $arQuestion["HTML_CODE"] = str_replace('<input', '<input class="error"', $arQuestion["HTML_CODE"]);

            switch ($arQuestion['STRUCTURE'][0]['FIELD_TYPE']) {
                case 'hidden': ?>
                    <input type="hidden"
                           id="<?= $FIELD_SID ?>"
                           name="form_<?= "{$arQuestion['STRUCTURE'][0]['FIELD_TYPE']}_{$arQuestion['STRUCTURE'][0]['ID']}" ?>"
                           value="<?= $arParams[$arQuestion['STRUCTURE'][0]['FIELD_ID'] . '_VALUE'] ?>"/>
                    <?
                    break;
                case 'radio': ?>
                    <div class="input-wrap js-form__replace"
                         id="<?= $FIELD_SID ?>">
                        <div class="label-holder<? if ($is_error) echo ' error'; ?>">
                        <span class="label">
                            <?= $arQuestion["CAPTION"] ?>
                            <? if ($arQuestion["REQUIRED"] == "Y" && (strlen($arQuestion["CAPTION"]) > 0)) echo $arResult["REQUIRED_SIGN"]; ?>
                        </span>
                        </div>
                        <ul class="radio-list reset-list js-form__replace" id="<?= $FIELD_SID ?>">
                            <? foreach ($arQuestion['STRUCTURE'] as $key => $arItem) {
                                $value = $arItem['ID'];
                                $name = "form_{$arQuestion['STRUCTURE'][0]['FIELD_TYPE']}_{$FIELD_SID}";
                                $checked = ($request->get($name) == $value ? ' checked' : ''); ?>
                                <li>
                                    <label class="radio-label" for="<?= $arItem['ID'] ?>">
                                        <input<?= $checked ?> type="radio" id="<?= $arItem['ID'] ?>"
                                                              name="<?= $name ?>"
                                                              value="<?= $value ?>">
                                        <i>&nbsp;</i>
                                        <span><?= $arItem['MESSAGE'] ?></span>
                                    </label>
                                </li>
                            <? } ?>
                        </ul>
                        <span class="error-note"><?= $arResult["FORM_ERRORS"][$FIELD_SID] ?></span>
                        <span class="confirm-note">&nbsp;</span>
                    </div>
                    <?
                    break;
                case 'checkbox': ?>
                    <div class="input-wrap js-form__replace"
                         id="<?= $FIELD_SID ?>">
                        <div class="label-holder<? if ($is_error) echo ' error'; ?>">
                            <label for="form_field_<?= $FIELD_SID ?>">
                                <?= $arQuestion["CAPTION"] ?>
                                <? if ($arQuestion["REQUIRED"] == "Y" && (strlen($arQuestion["CAPTION"]) > 0)) echo $arResult["REQUIRED_SIGN"]; ?>
                            </label>
                        </div>
                        <ul class="checkbox-list reset-list js-form__replace" id="<?= $FIELD_SID ?>">
                            <? foreach ($arQuestion['STRUCTURE'] as $key => $arItem) {
                                $value = $arItem['ID'];
                                $name = "form_{$arQuestion['STRUCTURE'][0]['FIELD_TYPE']}_{$FIELD_SID}";
                                $checked = ($request->get($name) == $value ? ' checked' : ''); ?>
                                <li>
                                    <label class="check-label" for="<?= $arItem['ID'] ?>">
                                        <input<?= $checked ?> type="radio" id="<?= $arItem['ID'] ?>"
                                                              name="<?= $name ?>"
                                                              value="<?= $value ?>">
                                        <i>&nbsp;</i>
                                        <span><?= $arItem['MESSAGE'] ?></span>
                                    </label>
                                </li>
                            <? } ?>
                        </ul>
                        <span class="error-note"><?= $arResult["FORM_ERRORS"][$FIELD_SID] ?></span>
                        <span class="confirm-note">&nbsp;</span>
                    </div>
                    <?
                    break;
                case 'multiselect':
                case 'select':
                    ?>
                    <div class="input-wrap js-form__replace"
                         id="<?= $FIELD_SID ?>">
                        <div class="label-holder<? if ($is_error) echo ' error'; ?>">
                            <label for="form_field_<?= $FIELD_SID ?>">
                                <?= $arQuestion["CAPTION"] ?>
                                <? if ($arQuestion["REQUIRED"] == "Y" && (strlen($arQuestion["CAPTION"]) > 0)) echo $arResult["REQUIRED_SIGN"]; ?>
                            </label>
                        </div>
                        <div class="select<? if ($is_error) echo ' error'; ?>" id="<?= $FIELD_SID ?>">
                            <select class="cselect<? if ($is_error) echo ' error'; ?>"
                                    data-placeholder="- Выбрать -"
                                    name="form_<?= $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ?>_<?= $FIELD_SID ?>[]">
                                <option value="">- Выбрать -</option>
                                <!--Важно! У первого опшина value должен быть равен ""-->
                                <? foreach ($arQuestion['STRUCTURE'] as $key => $arItem) { ?>
                                    <option value="<?= $arItem['ID'] ?>"><?= $arItem['MESSAGE'] ?></option>
                                <? } ?>
                            </select>
                        </div>
                        <span class="error-note"><?= $arResult["FORM_ERRORS"][$FIELD_SID] ?></span>
                        <span class="confirm-note">&nbsp;</span>
                    </div>
                    <?
                    break;
                case 'file':
                    ?>
                    <div class="input-wrap<? if ($is_error) echo ' error'; ?>">
                        <div class="label-holder">
                        <span class="label">
                            <?= $arQuestion["CAPTION"] ?><? if ($arQuestion["REQUIRED"] == "Y" && (strlen($arQuestion["CAPTION"]) > 0)): ?><?= $arResult["REQUIRED_SIGN"]; ?><? endif; ?>
                        </span>
                        </div>
                        <div class="input-holder upload-file__container">
                            <input class="upload-file"
                                   name="form_<?= $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ?>_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>"
                                   type="file"
                                   data-jfiler-limit="1">
                        </div>
                    </div>
                    <?
                    break;
                case 'text':
                case 'textarea':
                default:
                    $arQuestion['HTML_CODE'] = str_replace(
                        ['<input', '<textarea'],
                        ["<input placeholder='{$arQuestion["CAPTION"]}'", "<textarea placeholder='{$arQuestion["CAPTION"]}'"],
                        $arQuestion['HTML_CODE']
                    )
                    ?>
                    <div class="form-row flex-row js-form__replace" id="<?= $FIELD_SID ?>">
                        <div class="col-xs<? if ($is_error) echo ' error'; ?>">
                            <? if ($is_error) { ?>
                                <span class="error-note"><?= $arResult["FORM_ERRORS"][$FIELD_SID] ?></span>
                            <? } ?>
                            <?= $arQuestion["HTML_CODE"] ?>
                            <? if ($arQuestion["REQUIRED"] == "Y" && (strlen($arQuestion["CAPTION"]) > 0)) { ?>
                                <?= $arResult["REQUIRED_SIGN"]; ?>
                            <? } ?>
                        </div>
                    </div>
                    <?
                    break;
            }
        } //endforeach?>
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

        <div class="form-row flex-row form-footer">
            <div class="col-xs center-xs">
                <p>
                    <button type="submit" class="button button--big button--white button-hover--bgblack">
                        <?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? Loc::getMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>
                    </button>
                </p>
                <div class="cu-form-note">
                    * &ndash; <?= Loc::getMessage("FORM_REQUIRED_FIELDS") ?></div>
            </div>
        </div>
        <?= $arResult["FORM_FOOTER"] ?>
    <? if ($arResult['is_ajax_submitted']) die; ?>
</div>
