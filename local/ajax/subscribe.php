<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

Loader::includeModule('subscribe');
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$result = [];

if (
    ($email = $request->get('email'))
    && (filter_var($email, FILTER_VALIDATE_EMAIL))
    && !empty($rubrics = $request->get('rubrics'))
) {
    global $USER;

    if (CSubscription::GetList([], ["EMAIL" => $email, "RUB_ID" => $rubrics])->Fetch()) {
        $result['result'] = false;
        $result['text'] = 'Вы уже подписаны!';
    } else {
        $obSubscription = new CSubscription;
        $arFields = Array(
            "USER_ID" => ($USER->IsAuthorized() ? $USER->GetID() : false),
            "FORMAT" => "html",
            "EMAIL" => $email,
            "ACTIVE" => "Y",
            "CONFIRMED" => "N",
            "SEND_CONFIRM" => "Y",
            "RUB_ID" => $rubrics
        );
        if ($result['result'] = $obSubscription->Add($arFields))
            $result['text'] = 'Вы успешно подписаны!';
        else
            $result['text'] = $obSubscription->LAST_ERROR;

//        $result['debug'] = var_export($arFields, true);
    }
} else {
    $result['result'] = false;
    $result['text'] = 'Введите корректный email!';
}

echo json_encode($result, 1);