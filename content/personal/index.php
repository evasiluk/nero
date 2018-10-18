<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
?>
<?
global $USER;
if($USER->IsAuthorized()):?>
	<div class="personal-wrap">
	    <div class="usercontent bg--white wrap wrap-content">
	        <h3>В персональном разделе приведены средства просмотра и редактирования личной информации пользователя:</h3>
	        <ul>
	            <li>На странице <b>Корзина</b> пользователь сможет увидеть все выбранные им товары и приступить к оформлению заказа. </li>
	            <li>На странице <b>Личные данные</b> пользователь имеет возможность редактировать личные данные, регистрационную информацию, информацию о работе и т. д. </li>
	            <li>На странице <b>История заказов</b> пользователь имеет возможность просмотреть все сделанные им заказы, наблюдать за изменением их статусов, просматривать подробную информацию о заказе.</li>
	        </ul>
	    </div>
    </div>
<?else:?>
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
<?endif?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>