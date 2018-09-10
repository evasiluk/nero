<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<div class="bg--white wrap">
    <?$APPLICATION->IncludeComponent("astronim:sale.personal.order.detail", "manager_order_detail", Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
            "ALLOW_INNER" => "N",	// Разрешить оплату с внутреннего счета
            "CACHE_GROUPS" => "Y",	// Учитывать права доступа
            "CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "CACHE_TYPE" => "A",	// Тип кеширования
            "CUSTOM_SELECT_PROPS" => array(	// Дополнительные свойства инфоблока
                0 => "",
            ),
            "ID" => $_GET["ID"],	// Идентификатор заказа
            "ONLY_INNER_FULL" => "N",	// Разрешить оплату с внутреннего счета только в полном объеме
            "PATH_TO_CANCEL" => "",	// Страница отмены заказа
            "PATH_TO_COPY" => "",	// Страница повторения заказа
            "PATH_TO_LIST" => "",	// Страница со списком заказов
            "PATH_TO_PAYMENT" => "",	// Страница подключения платежной системы
            "PICTURE_HEIGHT" => "110",	// Ограничение по высоте для анонсного изображения, px
            "PICTURE_RESAMPLE_TYPE" => "1",	// Тип масштабирования
            "PICTURE_WIDTH" => "110",	// Ограничение по ширине для анонсного изображения, px
            "REFRESH_PRICES" => "N",	// Пересчитывать заказ после смены платежной системы
            "RESTRICT_CHANGE_PAYSYSTEM" => array(	// Запретить смену платежной системы у заказов в статусах
                0 => "0",
            ),
            "SET_TITLE" => "N",	// Устанавливать заголовок страницы
        ),
        false
    );?>
</div>

