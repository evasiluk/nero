<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Админстартивный раздел для менеджеров");
?>
<?//LocalRedirect("/managers/zayavki/");?>
<?
global $USER;
if($USER->IsAuthorized()) {
    LocalRedirect("/managers/zayavki/");
}
?>
    <div class="managers-wrap">
        <div class="usercontent bg--white wrap wrap-content">
            <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "nero_auth", Array(
                    "FORGOT_PASSWORD_URL" => "",	// Страница забытого пароля
                    "PROFILE_URL" => "/content/personal/lichnye-dannye/",	// Страница профиля
                    "REGISTER_URL" => "",	// Страница регистрации
                    "SHOW_ERRORS" => "N",	// Показывать ошибки
                ),
                false
            );?>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>