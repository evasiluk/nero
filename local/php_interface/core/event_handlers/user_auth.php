<?php
AddEventHandler("main", "OnBeforeUserLogin", Array("MyClass", "OnBeforeUserLoginHandler"));

class MyClass
{
    // создаем обработчик события "OnBeforeUserLogin"
    function OnBeforeUserLoginHandler(&$arFields)
    {

        $filter = Array("LOGIN" => $arFields["LOGIN"]);
        $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, array("SELECT"=>array("UF_*")));
        $arSpecUser = array();
        while ($arUser = $rsUsers->Fetch()) {
            $arSpecUser[] = $arUser;
        }

        if($arSpecUser[0]["ID"]) {
            if($arSpecUser[0]["UF_NERO_SITE"] != CURRENT_USER_HOST) {
                global $APPLICATION;
                $APPLICATION->throwException("Данный пользователь зарегистрирован в другом регионе.");
                return false;
            }
        }
    }
}