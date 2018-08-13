<?php
Bitrix\Main\EventManager::getInstance()->addEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
//Bitrix\Main\EventManager::getInstance()->addEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserRegisterHandler");
function OnBeforeUserRegisterHandler(&$args)
{
    if($args['ID']) {
        $before_args = \Bitrix\Main\UserTable::getById($args['ID'])->fetch();
    }


    $psswd = uniqid();
    $args['PASSWORD'] = $psswd;
    $args['CONFIRM_PASSWORD'] = $psswd;
    $args['ACTIVE'] = "N";

    if ($args['EMAIL'])
        $args['LOGIN'] = trim($args['EMAIL']);

    if (!$before_args) {
        $return = true;

        if ($ar = CUser::GetList($by = "timestamp_x", $order = "desc", ['EMAIL' => $args['EMAIL']])->GetNext()) {
            $GLOBALS['APPLICATION']->ThrowException('Извините, этот e-mail уже используется.');
            $return = false;
        }

        return $return;
    }
}



