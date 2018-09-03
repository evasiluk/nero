<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="maxwrap">

    <form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data" class="usercontent wrap-content personal-data js-personal-data bg--white">
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
        <?=$arResult["BX_SESSION_CHECK"]?>
        <?
        if ($arResult['DATA_SAVED'] == 'Y')
            ShowNote(GetMessage('PROFILE_DATA_SAVED'));
        ?>
        <div class="flex-row flex-row-padding">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="field-editable js-editable personal-item">
                    <label class="personal-label"><?=GetMessage('NAME')?></label>
                    <div class="personal-input">
                        <input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>

                <div class="field-editable js-editable personal-item">
                    <label class="personal-label"><?=GetMessage('LAST_NAME')?></label>
                    <div class="personal-input">
                        <input type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>

                <div class="field-editable js-editable personal-item">
                    <label class="personal-label"><?=GetMessage('SECOND_NAME')?></label>
                    <div class="personal-input">
                        <input type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>

                <div class="field-editable js-editable personal-item">
                    <label class="personal-label">Email:</label>
                    <div class="personal-input">
                        <input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>"/>
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>

                <div class="field-editable js-editable personal-item">
                    <label class="personal-label"><?=GetMessage('USER_PHONE')?></label>
                    <div class="personal-input">
                        <input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>

                <?if($arResult["USER_DISCOUNT"]):?>
                    <div class="personal-item personal-info-header">
                        Ваша скидка
                    </div>
                    <div class="personal-item">
                        <label class="personal-label label-off">Накопительная:</label>
                        <div class="personal-input"><span class="bg--red outline--red"><?=$arResult["USER_DISCOUNT"]?></span></div>
                    </div>
                <?endif?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="field-editable js-editable personal-item">
                    <label class="personal-label">Название организации:</label>
                    <div class="personal-input">
                        <input type="text" name="WORK_COMPANY" maxlength="255" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" />                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>
                <div class="field-editable js-editable personal-item">
                    <label class="personal-label">Деятельность организации:</label>
                    <div class="personal-input">
                        <input type="text" name="WORK_PROFILE" maxlength="255" value="<?=$arResult["arUser"]["WORK_PROFILE"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>

                <div class="field-editable js-editable personal-item">
                    <label class="personal-label">Сайт:</label>
                    <div class="personal-input">
                        <input type="text" name="WORK_WWW" maxlength="255" value="<?=$arResult["arUser"]["WORK_WWW"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>

                <div class="field-editable js-editable personal-item">
                    <label class="personal-label">Телефон:</label>
                    <div class="personal-input">
                        <input type="text" name="WORK_PHONE" maxlength="255" value="<?=$arResult["arUser"]["WORK_PHONE"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>
                <div class="field-editable js-editable personal-item">
                    <label class="personal-label">Должность:</label>
                    <div class="personal-input">
                        <input type="text" name="WORK_POSITION" maxlength="255" value="<?=$arResult["arUser"]["WORK_POSITION"]?>" />
                    </div>
                    <div class="field-editable-save"><svg viewBox="0 0 24 24"><use xlink:href="#ico-check-2"></use></svg></div>
                </div>
            </div>

        </div>

        <div class="flex-row flex-row-padding personal-data-footer">
            <div class="col-xxs-12 col-xs-6">
                <div class="note-edited">
                    <p class="color--red">* Есть несохраненные изменения</p>
                </div>
            </div>
            <div class="col-xxs-12 col-xs-6 end-xs">
                <button type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>" class="button button--bgred button--big">Сохранить</button>
            </div>
        </div>
    </form>
</div>

