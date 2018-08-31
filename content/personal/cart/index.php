<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<div class="maxwrap">
    <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "nero_cart", Array(
	"ACTION_VARIABLE" => "basketAction",	// Название переменной действия
		"ADDITIONAL_PICT_PROP_30" => "-",	// Дополнительная картинка [Каталог Минск]
		"ADDITIONAL_PICT_PROP_31" => "-",	// Дополнительная картинка [ТП Минск]
		"ADDITIONAL_PICT_PROP_58" => "-",	// Дополнительная картинка [Каталог Украина]
		"ADDITIONAL_PICT_PROP_59" => "-",	// Дополнительная картинка [Каталог СП]
		"ADDITIONAL_PICT_PROP_60" => "-",	// Дополнительная картинка [Каталог Россия]
		"ADDITIONAL_PICT_PROP_61" => "-",	// Дополнительная картинка [ТП Петербург]
		"ADDITIONAL_PICT_PROP_62" => "-",	// Дополнительная картинка [ТП Россия]
		"ADDITIONAL_PICT_PROP_63" => "-",	// Дополнительная картинка [ТП Украина]
		"ADDITIONAL_PICT_PROP_64" => "-",
		"ADDITIONAL_PICT_PROP_65" => "-",
		"AUTO_CALCULATION" => "Y",	// Автопересчет корзины
		"BASKET_IMAGES_SCALING" => "adaptive",	// Режим отображения изображений товаров
		"COLUMNS_LIST_EXT" => array(	// Выводимые колонки
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"COLUMNS_LIST_MOBILE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
		"CORRECT_RATIO" => "Y",	// Автоматически рассчитывать количество товара кратное коэффициенту
		"DEFERRED_REFRESH" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_MODE" => "extended",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",	// Текст заголовка "Подарки"
		"GIFTS_CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"GIFTS_HIDE_BLOCK_TITLE" => "N",	// Скрыть заголовок "Подарки"
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
		"GIFTS_MESS_BTN_BUY" => "Выбрать",	// Текст кнопки "Выбрать"
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",	// Количество элементов в строке
		"GIFTS_PLACE" => "BOTTOM",	// Вывод блока "Подарки"
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",	// Показывать процент скидки
		"GIFTS_SHOW_IMAGE" => "Y",	// Показывать изображение
		"GIFTS_SHOW_NAME" => "Y",	// Показывать название
		"GIFTS_SHOW_OLD_PRICE" => "N",	// Показывать старую цену
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",	// Текст метки "Подарка"
		"HIDE_COUPON" => "N",	// Спрятать поле ввода купона
		"LABEL_PROP" => "",
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "",
		"OFFERS_PROPS" => "",	// Свойства, влияющие на пересчет корзины
		"PATH_TO_ORDER" => "/personal/order/make/",	// Страница оформления заказа
		"PRICE_DISPLAY_MODE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
		"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
		"QUANTITY_FLOAT" => "Y",	// Использовать дробное значение количества
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FILTER" => "Y",
		"SHOW_RESTORE" => "Y",
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"TOTAL_BLOCK_DISPLAY" => array(
			0 => "top",
		),
		"USE_DYNAMIC_SCROLL" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
		"USE_GIFTS" => "Y",	// Показывать блок "Подарки"
		"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
		"USE_PRICE_ANIMATION" => "Y"
	),
	false
);?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>