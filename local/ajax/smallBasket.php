<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "small_basket_ajax", Array(
        "HIDE_ON_BASKET_PAGES" => "Y",	// Не показывать на страницах корзины и оформления заказа
        "PATH_TO_AUTHORIZE" => "",	// Страница авторизации
        "PATH_TO_BASKET" => SITE_DIR."content/basket/",	// Страница корзины
        "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",	// Страница оформления заказа
        "PATH_TO_PERSONAL" => SITE_DIR."personal/",	// Страница персонального раздела
        "PATH_TO_PROFILE" => SITE_DIR."personal/",	// Страница профиля
        "PATH_TO_REGISTER" => SITE_DIR."login/",	// Страница регистрации
        "POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
        "SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
        "SHOW_DELAY" => "N",	// Показывать отложенные товары
        "SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
        "SHOW_IMAGE" => "Y",	// Выводить картинку товара
        "SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
        "SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
        "SHOW_PERSONAL_LINK" => "Y",	// Отображать персональный раздел
        "SHOW_PRICE" => "Y",	// Выводить цену товара
        "SHOW_PRODUCTS" => "Y",	// Показывать список товаров
        "SHOW_SUMMARY" => "Y",	// Выводить подытог по строке
        "SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
    ),
    false
);?>