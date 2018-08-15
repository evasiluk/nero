<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
if (!$this->__component->__parent || empty($this->__component->__parent->__name)):
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/forum/templates/.default/style.css');
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/forum/templates/.default/themes/blue/style.css');
	$GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/forum/templates/.default/styles/additional.css');
endif;
$path = str_replace(array("\\", "//"), "/", dirname(__FILE__)."/interface.php");
include_once($path);
// *****************************************************************************************
if (!empty($arResult["ERROR_MESSAGE"])): 
?>
<div class="forum-note-box forum-note-error">
	<div class="forum-note-box-text"><?=ShowError($arResult["ERROR_MESSAGE"], "forum-note-error");?></div>
</div>
<?
endif;
if (!empty($arResult["OK_MESSAGE"])): 
?>
<div class="forum-note-box forum-note-success">
	<div class="forum-note-box-text"><?=ShowNote($arResult["OK_MESSAGE"], "forum-note-success")?></div>
</div>
<?
endif;
/*?>
<div class="forum-header-box">
	<div class="forum-header-options">
		<span class="forum-option-profile">
			<a href="<?=$arResult["profile_view"]?>"><?=GetMessage("F_PROFILE")?></a>
		</span>
	</div>
	<div class="forum-header-title"><span><?=GetMessage("F_CHANGE_PROFILE")?></span></div>
</div>
<?*/
?>
<?//print_pre($arResult)?>
<?//print_pre($arResult["ALL_GROUPS"])?>
<br>
<h1>Регистрационные данные дилера</h1>
<div>
    <form class="reg-form js-reg-form" method="post" name="form1" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data">
        <input type="hidden" name="PAGE_NAME" value="profile" />
        <input type="hidden" name="Update" value="Y" />
        <input type="hidden" name="UID" value="<?=$arParams["UID"]?>" />
        <?=bitrix_sessid_post()?>
        <input type="hidden" name="ACTION" value="EDIT" />
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?=GetMessage("F_NAME")?></span>
                    <div class="input-in">
                        <input type="text" name="NAME" size="40" maxlength="50" value="<?=$arResult["str_NAME"]?>"/>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">Активен</span>
                    <div class="input-in">
                        <input type="checkbox" name="ACTIVE" size="40" maxlength="50" <?if($arResult["USER"]["ACTIVE"] == "Y"):?>checked<?endif?>/>
                    </div>
                </div>
            </label>
        </div>
        <?if($arResult["REGION_DEALERS_GROUPS"]):?>
            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label">Группа дилеров</span>
                        <div class="input-in">
                            <select name="DEALER_GROUP">
                                <option value="0">Выбрать</option>
                                    <?foreach ($arResult["REGION_DEALERS_GROUPS"] as  $id):?>
                                        <option value="<?=$id?>"><?=$arResult["ALL_GROUPS"][$id]["NAME"]?></option>
                                    <?endforeach?>
                            </select>
                        </div>
                    </div>
                </label>
            </div>
        <?endif?>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?=GetMessage("F_LAST_NAME")?></span>
                    <div class="input-in">
                        <input type="text" name="LAST_NAME" size="40" maxlength="50" value="<?=$arResult["str_LAST_NAME"]?>"/>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">Отчество</span>
                    <div class="input-in">
                        <input type="text" name="SECOND_NAME" size="40" maxlength="50" value="<?=$arResult["str_SECOND_NAME"]?>"/>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">Телефон:</span>
                    <div class="input-in">
                        <input type="text" name="PERSONAL_PHONE" size="40" maxlength="50" value="<?=$arResult["str_PERSONAL_PHONE"]?>"/>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">*E-Mail:</span>
                    <div class="input-in">
                        <input type="text" name="EMAIL" size="40" maxlength="50" value="<?=$arResult["str_EMAIL"]?>"/>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">*<?=GetMessage("F_LOGIN")?></span>
                    <div class="input-in">
                        <input type="text" name="LOGIN" size="40" maxlength="50" value="<?=$arResult["str_LOGIN"]?>"/>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?=GetMessage("F_NEW_PASSWORD")?></span>
                    <div class="input-in">
                        <input type="text" name="NEW_PASSWORD" size="40" maxlength="50" value="<?=$arResult["NEW_PASSWORD"]?>" />
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?=GetMessage("F_PASSWORD_CONFIRM")?></span>
                    <div class="input-in">
                        <input type="text" name="NEW_PASSWORD_CONFIRM" size="40" maxlength="50" value="<?=$arResult["NEW_PASSWORD_CONFIRM"]?>" />
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">Название организации</span>
                    <div class="input-in">
                        <input type="text" name="WORK_COMPANY" size="40" maxlength="50" value="<?=$arResult["str_WORK_COMPANY"]?>" />
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">Телефон:</span>
                    <div class="input-in">
                        <input type="text" name="WORK_PHONE" size="40" maxlength="50" value="<?=$arResult["str_WORK_PHONE"]?>"/>
                    </div>
                </div>
            </label>
        </div>
        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">Деятельность организации</span>
                    <div class="input-in">
                        <input type="text" name="WORK_PROFILE" size="40" maxlength="50" value="<?=$arResult["str_WORK_PROFILE"]?>" />
                    </div>
                </div>
            </label>
        </div>

        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?=GetMessage("F_COMPANY_LOCATION")?></span>
                    <div class="input-in">
                        <select name="WORK_COUNTRY" id="WORK_COUNTRY">
                            <option value=""><?=GetMessage("F_COUNTRY_NONE")?></option>
                            <?if (is_array($arResult["arr_WORK_COUNTRY"]["data"]) && !empty($arResult["arr_WORK_COUNTRY"]["data"])):?>
                                <?foreach ($arResult["arr_WORK_COUNTRY"]["data"] as $value => $option):?>
                                    <option value="<?=$value?>" <?=(($arResult["arr_WORK_COUNTRY"]["active"] == $value) ? "selected" : "")?>><?=$option?></option>
                                <?endforeach?>
                            <?endif;?>
                        </select>
                    </div>
                </div>
            </label>
        </div>

        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label">Сайт</span>
                    <div class="input-in">
                        <input type="text" name="WORK_WWW" size="40" maxlength="50" value="<?=$arResult["str_WORK_WWW"]?>" />
                    </div>
                </div>
            </label>
        </div>

        <div class="form-row flex-row">
            <label class="col-xs">
                <div class="input">
                    <span class="input-label"><?=GetMessage("F_COMPANY_ROLE")?></span>
                    <div class="input-in">
                        <input type="text" name="WORK_POSITION" size="40" maxlength="50" value="<?=$arResult["str_WORK_POSITION"]?>" />
                    </div>
                </div>
            </label>
        </div>
        <?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
            <div class="form-row flex-row">
                <label class="col-xs">
                    <div class="input">
                        <span class="input-label"><?=$arUserField["EDIT_FORM_LABEL"]?></span>
                        <div class="input-in">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:system.field.edit",
                                $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?>
                        </div>
                    </div>
                </label>
            </div>
        <?endforeach;?>
        <div class="col-xs-6 col-sm end-xs js-reg-submit">
            <input type="submit" class="button button--bgred button--big" name="save" value="<?=GetMessage("F_SAVE")?>">
        </div><br>
    </form>
</div>
