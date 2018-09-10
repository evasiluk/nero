<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Заказ детально",
	"DESCRIPTION" => "Страница просмотра и изменения заказа",
	"PATH" => array(
		"ID" => "astronim",
        "NAME" => "Кастомные компоненты Astronim*",
        "CHILD" => array(
			"ID" => "paid_services",
			"NAME" => "Платные услуги",
			"SORT" => 30
		),
	),
);