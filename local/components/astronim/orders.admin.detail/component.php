<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponent $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */

/** @var string $componentPath */

use Bitrix\Main\Loader,
    \Astronim\PaidService,
    Bitrix\Sale\Internals\StatusTable,
    Bitrix\Main\Application,
    Bitrix\Main\Web\Uri,
    Astronim\AHelper as Helper;

Loader::includeModule('sale');
$request = Application::getInstance()->getContext()->getRequest();

// collecting fields

$arResult['ORDER'] = \CSaleOrder::GetByID($arParams['ID']);
$arResult['NAME'] = "Заказ №{$arResult['ORDER']['ACCOUNT_NUMBER']}";

$rs = CSaleStatus::GetList(['SORT' => 'ASC'], ['TYPE' => 'O', 'LID' => LANGUAGE_ID], false, false, ['ID', 'NAME']);
while ($ar = $rs->GetNext()) {
    $arResult['STATUS_LIST'][] = $ar;
}

//in actual content only one item in order
$arResult['BASKET'] = \CSaleBasket::GetList([], ["ORDER_ID" => $arResult['ORDER']["ID"]])->GetNext();

$element_id = $arResult['BASKET']['PRODUCT_ID'];
if ($element_id > 0) {
    $arResult['ITEM'] = new PaidService\Item($element_id);
    $arResult['ORDER_PROPS'] = $arResult['ITEM']->basketProperties;

    if (empty($arResult['ORDER_PROPS'])) {
        $arResult['ERROR'] = true;
        $arResult['ERRORS'][] = 'element_not_exists';
    }

    $arResult['PAY_SYSTEMS'] = \Bitrix\Sale\PaySystem\Manager::getList(array(
        'filter' => array(
            "ACTIVE" => "Y"
        )
    ))->fetchAll();
}
$fields = \Astronim\PaidService\Controller::getFormFields($arResult['ITEM']);
foreach ($fields as $prop) {
    unset($prop['ID']);
    $arResult['BASKET']['PROPS'][$prop['CODE']] = $prop;

}
$rsBasketProps = \CSaleBasket::GetPropsList([], ["BASKET_ID" => $arResult['BASKET']['ID']]);
while ($arBasketProp = $rsBasketProps->GetNext()) {
    $arResult['BASKET']['PROPS'][$arBasketProp['CODE']] = $arBasketProp;

    $arResult['ITEM']->basketProperties[$arBasketProp['CODE']] = $arBasketProp['VALUE'];
}

$arResult['USER'] = \CUser::GetByID($arResult['ORDER']['USER_ID'])->GetNext();


$rs = StatusTable::getList([
    'select' => array(
        'ID',
        'SORT',
        'LID' => 'Bitrix\Sale\Internals\StatusLangTable:STATUS.LID',
        'NAME' => 'Bitrix\Sale\Internals\StatusLangTable:STATUS.NAME',
        'DESCRIPTION' => 'Bitrix\Sale\Internals\StatusLangTable:STATUS.DESCRIPTION'
    ),
    'filter' => [
        '=Bitrix\Sale\Internals\StatusLangTable:STATUS.LID' => LANGUAGE_ID,
        '=TYPE' => 'O'
    ]
]);
while ($ar = $rs->fetch()) {
    $arResult['STATUS'][$ar['ID']] = $ar;
}
// \collecting fields


// print
//$print_uri = new Uri( '/bitrix/admin/sale_print.php' );
//$print_uri->addParams([
//    'doc' => 'order_form',
//    'ORDER_ID' => $arResult['ORDER']['ID'],
//    'PROPS_ENABLE' => 'Y',
//    'SHOW_ALL' => 'Y',
//]);
$print_uri = new Uri($request->getRequestUri());
$print_uri->addParams([
    'print' => 1
]);
$arResult['PRINT_URL'] = $print_uri->getUri();
unset($print_uri);
// \print


// delete
$delete_uri = new Uri($request->getRequestUri());
$delete_uri->addParams(['delete' => '']);
$arResult['DELETE_URL'] = $delete_uri->getUri();
unset($delete_uri);

if (($request->get("delete") !== null) && !$arResult['ERROR']) {
    $arResult['DELETED'] = \Bitrix\Sale\Order::delete($arParams['ID'])->isSuccess();
    unset($arResult['ORDER']);
}// \delete

// update
elseif (($request->get("update") !== null) && !$arResult['ERROR']) {
    foreach ($arResult['BASKET']['PROPS'] as $code => $prop) {
        switch ($arResult['ITEM']->properties[$code]['PROPERTY_TYPE']) {
            case 'F':
                if ($value = $request->getFile($code)) {
                    $value = CFile::SaveFile($value, '/paid_services/');
                    $property = $value;
                }
                break;
            default:
                if ($value = $request->get($code)) {
                    if($arResult['ITEM']->properties[$code]['MULTIPLE'] == 'Y' && is_array($value))
                        $value = implode(PaidService\Controller::SEPARATOR, $value);
                    $property = htmlspecialcharsbx($value);
                }
                break;
        }

        if ($value) {
            if($prop['ID'])
                $arResult['ITEM']->updateBasketProperty($prop['ID'], $code, $value);
            else
                $arResult['ITEM']->addBasketProperty($arResult['BASKET']['ID'], $code, $value);
        }
    }

    $params = [];
    foreach ($arResult['ORDER'] as $code => $field) {
        if ($request->get('field_' . $code) !== null)
            $params[$code] = $request->get('field_' . $code);
    }

    if ($params['STATUS_ID'] != $arResult['ORDER']['STATUS_ID']) {
        CSaleOrder::StatusOrder($arResult['ORDER']['ID'], $params['STATUS_ID']);
    }

    // pay
//    if ($params['PAYED'] != 'Y') {
//        $params['PAYED'] = 'N';
//    }
    if ($params['STATUS_ID'] == Helper::getSaleStatus('PAYED')) {
        $params['PAYED'] = 'Y';
    }
    if ($params['PAYED'] != $arResult['ORDER']['PAYED']) {
        CSaleOrder::PayOrder($arResult['ORDER']['ID'], $params['PAYED']);
    }
    // \pay

    // cancellation
//    if ($params['CANCELED'] != 'Y') {
//        $params['CANCELED'] = 'N';
//    }
    if ($params['STATUS_ID'] == Helper::getSaleStatus('CANCELED')) {
        $params['CANCELED'] = 'Y';
//        $params['PAYED'] = 'N';
    } else {
        $params['CANCELED'] = 'N';
    }
    if ($params['CANCELED'] != $arResult['ORDER']['CANCELED']) {
        CSaleOrder::CancelOrder($arResult['ORDER']['ID'], $params['CANCELED'], $params['REASON_CANCELED']);
    }
    // \cancellation


    if ($request->get('price_recount')) {
        $params['PRICE'] = PaidService\Controller::getInstance()->calculateFullPrice($arResult['ITEM']);
    }

//    print_pre($request->get('price_recount'), $params);
//    return;
    $result = CSaleOrder::Update($arResult['ORDER']['ID'], $params);

    LocalRedirect($APPLICATION->GetCurPageParam('', ['update']));
} // \update


$arResult['ACTION_URL'] = $APPLICATION->GetCurPageParam('update');

if (isset($arResult['NAME']) && $arResult['ORDER']['ID']) {
    $APPLICATION->AddChainItem($arResult['NAME']);
    $APPLICATION->SetTitle($arResult['NAME']);
}

$this->IncludeComponentTemplate();
