<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */
/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Astronim\Helper;
$helper = new \Astronim\RegisterTemplateHtml($arParams, $arResult); ?>

<? if (($_REQUEST['registered'] !== null) || $USER->IsAuthorized()) { ?>
    <div class="reg-form js-reg-form-success">
        <div class="usercontent">
            <?Helper::includeFile('registration/authorized')?>
        </div>
    </div>
<? } else { ?>
    <? if (count($arResult["ERRORS"]) > 0) {
        foreach ($arResult["ERRORS"] as $key => $error)
            if (intval($key) == 0 && $key !== 0)
                $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);

        ShowError(implode("<br />", $arResult["ERRORS"]));

    } elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y") { ?>
        <p><? echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
    <? } ?>

    <noscript>
        <div class="usercontent">
            <h3>Для регистрации необходимо сключить javascript в вашем браузере.</h3>
        </div>
    </noscript>

    <section class="maxwrap reg js-reg">

        <header class="reg-steps js-reg-steps" style="display: none;">

            <div class="reg-step reg-step--active">
                <div class="step-num">
                    <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle" cy="25" cx="25" r="22" stroke-width="3" fill="none"/>
                        <text class="text" xml:space="preserve" text-anchor="start" font-size="16" y="30" x="21"
                              fill-opacity="null" stroke-opacity="null" stroke-width="0">1</text>
                    </svg>
                </div>
                <span class="step-text"><?=GetMessage('ORGANISATION')?></span>
            </div>

            <div class="reg-step">
                <div class="step-num">
                    <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle" cy="25" cx="25" r="22" stroke-width="3" fill="none"/>
                        <text class="text" xml:space="preserve" text-anchor="start" font-size="16" y="30" x="20"
                              fill-opacity="null" stroke-opacity="null" stroke-width="0">2</text>
                    </svg>
                </div>
                <span class="step-text"><?=GetMessage('PERSONAL_DATA')?></span>
            </div>

            <div class="reg-step">
                <div class="step-num">
                    <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle" cy="25" cx="25" r="22" stroke-width="3" fill="none"/>
                        <text class="text" xml:space="preserve" text-anchor="start" font-size="16" y="30" x="20"
                              fill-opacity="null" stroke-opacity="null" stroke-width="0">3</text>
                    </svg>
                </div>
                <span class="step-text"><?=GetMessage('SERVICES')?></span>
            </div>

            <div class="reg-step">
                <div class="step-num">
                    <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                        <circle class="circle" cy="25" cx="25" r="22" stroke-width="3" fill="none"/>
                        <text class="text" xml:space="preserve" text-anchor="start" font-size="16" y="30" x="19"
                              fill-opacity="null" stroke-opacity="null" stroke-width="0">4</text>
                    </svg>
                </div>
                <span class="step-text"><?=GetMessage('CONFIRM')?></span>
            </div>

        </header>

        <div class="usercontent reg-loading js-reg-loading">
            <h4>Загрузка…</h4>
        </div>

        <form class="reg-form js-reg-form" method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform"
              enctype="multipart/form-data">
            <input type="hidden" name="REGISTER[LOGIN]" value="<?= uniqid() ?>"/>
            <input type="hidden" name="finish" value="1"/>
            <input type="hidden" name="register_submit_button" value="1"/>
            <input type="hidden" name="UF_NERO_SITE" value="<?=CURRENT_USER_HOST?>">
            <?$psswd = uniqid();?>
            <input type="hidden" name="REGISTER[PASSWORD]" value="<?=$psswd?>">
            <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]" value="<?=$psswd?>">
            <? if ($arResult["BACKURL"] <> ''): ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <? endif; ?>

            <div class="reg-form-step" style="display: none;">

                <? $helper->text('WORK_COMPANY', GetMessage('WORK_COMPANY')); ?>

                <? $helper->text('WORK_PROFILE', GetMessage('WORK_PROFILE')); ?>

                <? $helper->select('WORK_COUNTRY', GetMessage('WORK_COUNTRY'), [
                    '' => GetMessage('CHOOSE_COUNTRY'),
                    4 => 'Беларусь',
                    1 => 'Россия',
                    14 => 'Украина',
                ]); ?>

                <? $helper->text('WORK_PHONE', [GetMessage('WORK_PHONE'), GetMessage('WORK_PHONE_PLACEHOLDER')]); ?>

                <? $helper->text('WORK_STREET', [GetMessage('WORK_STREET'), GetMessage('WORK_STREET_PLACEHOLDER')]); ?>

                <? $helper->text('WORK_WWW', [GetMessage('WORK_WWW'), GetMessage('WORK_WWW_PLACEHOLDER')]); ?>
            </div>

            <div class="reg-form-step" style="display: none;">
                <? $helper->text('LAST_NAME', GetMessage('LAST_NAME')); ?>

                <? $helper->text('NAME', GetMessage('NAME')); ?>

                <? $helper->text('SECOND_NAME', GetMessage('SECOND_NAME')); ?>

                <? $helper->text('PERSONAL_PHONE', GetMessage('PERSONAL_PHONE')); ?>

                <? $helper->text('WORK_POSITION', GetMessage('WORK_POSITION')); ?>

                <? $helper->text('EMAIL', GetMessage('EMAIL'), ['type' => 'email']); ?>
            </div>

            <div class="reg-form-step" style="display: none;">
                <?
                //print_pre($arResult['USER_PROPERTIES']['DATA']['UF_SERVICES']['VALUES']);
                ?>
                <div class="form-row flex-row">
                    <div class="col-xs">
                        <div class="input">
                            <span class="input-label">Услуги (выбрать из списка)</span>
                            <select value="" data-select="" id="Uf_services" name="UF_SERVICES">
                                <option value="">Выберите услугу</option>
                                <?foreach($arResult['USER_PROPERTIES']['DATA']['UF_SERVICES']['VALUES'] as $id=>$val):?>
                                    <option value="<?=$id?>"><?=$val?></option>
                                <?endforeach?>

                            </select>
                        </div>
                    </div>
                </div>
<!--                --><?// $helper->select_uf('UF_SERVICES',
//                    GetMessage('UF_SERVICES'),
//                    array_merge([
//                        '' => 'Выберите услугу'
//                    ], $arResult['USER_PROPERTIES']['DATA']['UF_SERVICES']['VALUES']),
//                    ['multiple' => '', 'data-multiple' => '']); ?>

<!--                --><?// $helper->text_uf('UF_SERVICES_ADDITION', GetMessage('UF_SERVICES_ADDITION'), ['data-editable' => '']); ?>
                <div class="form-row flex-row">
                    <label class="col-xs">
                        <div class="input">
                            <span class="input-label">Услуги (если нет в списке)</span>
                            <div class="input-in">
                                <input value="" type="text" name="UF_SERVICES_ADDITION[]">
                                <span class="focus-border"></span>
                                <span class="input-note"></span>
                            </div>
                        </div>
                    </label>
                </div>

<!--                --><?// $helper->select_uf('UF_SERVICES_WHERE',
//                    GetMessage('UF_SERVICES_WHERE'),
//                    array_merge([
//                        '' => 'Выберите'
//                    ], $arResult['USER_PROPERTIES']['DATA']['UF_SERVICES_WHERE']['VALUES']),
//                    ['multiple' => '', 'data-multiple' => '']); ?>
                <div class="form-row flex-row">
                    <div class="col-xs">
                        <div class="input">
                            <span class="input-label"><?=GetMessage('UF_SERVICES_WHERE')?></span>
                            <select value="" data-select="" id="Uf_services" name="UF_SERVICES_WHERE">
                                <option value="">Выберите услугу</option>
                                <?foreach($arResult['USER_PROPERTIES']['DATA']['UF_SERVICES_WHERE']['VALUES'] as $id=>$val):?>
                                    <option value="<?=$id?>"><?=$val?></option>
                                <?endforeach?>

                            </select>
                        </div>
                    </div>
                </div>



            </div>

            <div class="reg-form-step" style="display: none;">
                <div class="reg-form js-reg-form-success" style="display: none;">
                    <div class="usercontent">
                        <?Helper::includeFile('registration/success')?>
                    </div>
                </div>

                <div class="reg-form js-reg-form-error" style="display: none;">
                    <div class="usercontent">
                        <h2>Ошибка</h2>
                        <div id="reg-errors"></div>
                    </div>
                </div>



                <div class="form-row flex-row">
                    <div class="col-xs ">
                        <div class="input">
                            <span class="input-label"><?=GetMessage('CONFIRM_PHRASE')?></span>
                        </div>
                    </div>
                </div>

<!--                --><?// $helper->text('PASSWORD', GetMessage('PASSWORD'), [
//                    'id' => 'registration_password',
//                    'type' => 'password',
//                    'placeholder' => '',
//                    'required' => '',
//                    'autocomplete' => 'off',
//                    'data-parsley-min-length' => '6'
//                ]); ?>
<!--                --><?// $helper->text('CONFIRM_PASSWORD', GetMessage('CONFIRM_PASSWORD'), [
//                    'id' => 'registration_password_confirm',
//                    'type' => 'password',
//                    'data-parsley-equalto' => '#registration_password',
//                    'placeholder' => '',
//                    'required' => '',
//                    'autocomplete' => 'off',
//                    'data-parsley-min-length' => '6'
//                ]); ?>
                <? if ($arResult["USE_CAPTCHA"] == "Y") {?>

                    <div class="form-row flex-row">
                        <div class="col-xs">
                            <?= $arResult['recaptcha']['div'] . $arResult['recaptcha']['error'] ?>
                        </div>
                    </div>
                <? } // isUseCaptcha?>
            </div>

            <div class="form-navigation">
                <div class="form-row flex-row">
                    <div class="col-xs-6 col-sm start-xs js-reg-prev">
                        <button class="button button--black button--big button--arrow-back"><span><?=GetMessage("REG_BACK")?></span></button>
                    </div>
                    <div class="col-xs-6 col-sm end-xs js-reg-next">
                        <button class="button button--bgred button--big button--arrow"><span><?=GetMessage("REG_NEXT")?></span></button>
                    </div>
                    <div class="col-xs-6 col-sm end-xs js-reg-submit">
                        <input type="submit" class="button button--bgred button--big" name="register_submit_button" value="<?=GetMessage("REG_DONE")?>">
                    </div>
                </div>
            </div>

        </form>



    </section>
<? } ?>
