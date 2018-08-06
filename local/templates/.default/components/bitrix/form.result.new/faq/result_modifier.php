<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$arResult['uniq'] = md5(serialize($arParams));

$arResult["REQUIRED_SIGN"] = '&nbsp;<div class="required">*</div>';

$arResult['FORM_HEADER'] = str_replace(
    '<form',
    "<form id='web-form-{$arResult['uniq']}' class=\"cu-form cu-form--narrow\"",
    $arResult['FORM_HEADER']
);

$arResult['is_ajax_submitted'] = ($request->isAjaxRequest() && ($request->get('uniq') == $arResult['uniq']));