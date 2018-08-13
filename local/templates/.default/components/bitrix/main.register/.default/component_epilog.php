<?
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

use Astronim\OPAC\LibraryUserManager;
use Bitrix\Main\UserTable;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
global $APPLICATION;



if ($request->isAjaxRequest()) {
    $result = [];

    if(null !== $request->get('reload_captcha')){
        $result = $APPLICATION->CaptchaGetCode();

    } elseif (null !== $request->get('check_login')) {
        $user = UserTable::getList([
            'filter' => ['LOGIN' => $request->get('REGISTER')['LOGIN']],
            'limit' => 1
        ])->fetch();

        if ($user) {
            $result['error'] = true;
            $result['error_code'] = "login_exists";
            $result['error_message'] = "Этот логин уже занят!";
        } else {
            $result['success'] = true;
        }

    } elseif (
        (null !== $request->get('finish'))
        || (null !== $request->get('registered'))
    ) {
//        if ($USER->IsAuthorized()) {
//            $result['result'] = true;
//        } elseif ($arResult["ERRORS"]) {
//            $result['result'] = false;
//            $result[] = $arResult["ERRORS"];
//            $result['errors'] = $arResult['ERRORS'];
//            $result['captcha']['src'] = "/bitrix/tools/captcha.php?captcha_sid={$arResult["CAPTCHA_CODE"]}";
//            $result['captcha']['sid'] = $arResult["CAPTCHA_CODE"];
//        } elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y") {
//            $result['result'] = true;
//            $result['need_email_confirmation'] = true;
//        } else {
//            $result['result'] = false;
//            $result['captcha']['src'] = "/bitrix/tools/captcha.php?captcha_sid={$arResult["CAPTCHA_CODE"]}";
//            $result['captcha']['sid'] = $arResult["CAPTCHA_CODE"];
//        }
        if ($arResult["ERRORS"]) {
            $result['result'] = false;
            $result['errors'] = $arResult['ERRORS'];
            $result['captcha']['src'] = "/bitrix/tools/captcha.php?captcha_sid={$arResult["CAPTCHA_CODE"]}";
            $result['captcha']['sid'] = $arResult["CAPTCHA_CODE"];
        } else {
            $result['result'] = true;
        }
    }

    $APPLICATION->RestartBuffer();
     echo json_encode($result);
    die();
}