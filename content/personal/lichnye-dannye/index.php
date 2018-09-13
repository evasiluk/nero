<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личные данные");
?>
    <div class="maxwrap">
        <?
        global $USER;
        if($USER->IsAuthorized()):
        ?>
        <?$APPLICATION->IncludeComponent("bitrix:main.profile", "personal_user_profile", Array(
            "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CHECK_RIGHTS" => "N",	// Проверять права доступа
                "SEND_INFO" => "N",	// Генерировать почтовое событие
                "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
                "USER_PROPERTY" => array(	// Показывать доп. свойства
                    0 => "UF_SERVICES_ADDITION",
                    1 => "UF_SERVICES_WHERE",
                    2 => "UF_SERVICES",
                ),
                "USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
            ),
            false
        );?>
        <?else:?>
            <div class="usercontent bg--white basket-is-empty js-basket-is-empty">
                <div class="wrap wrap-content">
                    <a href="/content/personal/register/">Зарегистрируйтесь</a> и/или <a href="/content/personal/auth/">авторизуйтесь</a> для просмотра личных данных.
                </div>
            </div>
        <?endif?>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>