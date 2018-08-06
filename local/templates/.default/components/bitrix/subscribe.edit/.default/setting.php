<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
//***********************************
//setting section
//***********************************
?>
<form action="<?= $arResult["FORM_ACTION"] ?>" method="post">
        <? echo bitrix_sessid_post(); ?>
        <div class="table-auto">
            <table class="tbl">
            <thead>
            <tr>
                <td colspan="2"><? echo GetMessage("subscr_title_settings") ?></td>
            </tr>
            </thead>
            <tr valign="top">
                <td width="40%">
                    <div class="input-wrap field-effects-js">
                        <div class="label-holder">
                            <label for="EMAIL"><? echo GetMessage("subscr_email") ?>: <span class="form-mark">*</span></label>
                        </div>
                        <div class="input-holder">
                            <input type="text" name="EMAIL" id="EMAIL"
                                   value="<?= $arResult["SUBSCRIPTION"]["EMAIL"] != "" ? $arResult["SUBSCRIPTION"]["EMAIL"] : $arResult["REQUEST"]["EMAIL"]; ?>"
                                   size="30" maxlength="255"/>
                            <span class="error-note">Поле обязательное для заполнения</span>
                            <span class="confirm-note">Подтверждено</span>
                        </div>
                    </div>
                    <div class="input-wrap field-effects-js">
                        <div class="label-holder">
                            <label for="RUB_ID">
                                <? echo GetMessage("subscr_rub") ?> <span class="form-mark">*</span>
                            </label>
                        </div>
                        <ul class="checkbox-list reset-list" id="RUB_ID">
                            <? foreach ($arResult["RUBRICS"] as $itemID => $itemValue) { ?>
                                <li>
                                    <label class="check-label" for="rub_<?= $itemValue["ID"] ?>">
                                        <input type="checkbox"
                                               id="rub_<?= $itemValue["ID"] ?>"
                                               name="RUB_ID[]"
                                              value="<?= $itemValue["ID"] ?>"<? if ($itemValue["CHECKED"]) echo " checked" ?> >
                                        <i>&nbsp;</i>
                                        <span><?= $itemValue["NAME"] ?></span>
                                    </label>
                                </li>
                            <? } ?>
                        </ul>
                        <span class="error-note">Поле обязательное для заполнения</span>
                        <span class="confirm-note">Подтверждено</span>
                    </div>
                    <div class="input-wrap field-effects-js">
                        <div class="label-holder">
                        <span class="label">
                            <? echo GetMessage("subscr_fmt") ?>
                        </span>
                        </div>
                        <ul class="radio-list reset-list js-ajax_replace">
                            <li>
                                <label class="radio-label" for="FORMAT">
                                    <input type="radio" id="FORMAT" name="FORMAT"
                                          value="text"<? if ($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked" ?>>
                                    <i>&nbsp;</i>
                                    <span><? echo GetMessage("subscr_text") ?></span>
                                </label>
                            </li>
                            <li>
                                <label class="radio-label" for="FORMAT_HTML">
                                    <input type="radio" id="FORMAT_HTML" name="FORMAT"
                                                          value="html"<? if ($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked" ?> ">
                                    <i>&nbsp;</i>
                                    <span>HTML</span>
                                </label>
                            </li>
                        </ul>
                        <span class="error-note">Поле обязательное для заполнения</span>
                        <span class="confirm-note">Подтверждено</span>
                    </div>
                </td>
                <td width="60%">
                    <p><? echo GetMessage("subscr_settings_note1") ?></p>
                    <p><? echo GetMessage("subscr_settings_note2") ?></p>
                </td>
            </tr>
            <tfoot>
            <tr>
                <td colspan="2">
                    <input type="submit" name="Save" class="btn-default"
                           value="<? echo($arResult["ID"] > 0 ? GetMessage("subscr_upd") : GetMessage("subscr_add")) ?>"/>
<!--                    <input type="reset" value="--><?// echo GetMessage("subscr_reset") ?><!--" name="reset" class="btn-default-alt"/>-->
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <input type="hidden" name="PostAction" value="<? echo($arResult["ID"] > 0 ? "Update" : "Add") ?>"/>
    <input type="hidden" name="ID" value="<? echo $arResult["SUBSCRIPTION"]["ID"]; ?>"/>
    <? if ($_REQUEST["register"] == "YES"): ?>
        <input type="hidden" name="register" value="YES"/>
    <? endif; ?>
    <? if ($_REQUEST["authorize"] == "YES"): ?>
        <input type="hidden" name="authorize" value="YES"/>
    <? endif; ?>
</form>
