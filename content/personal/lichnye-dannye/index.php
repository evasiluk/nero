<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личные данные");
?>
    <div class="maxwrap">
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
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>