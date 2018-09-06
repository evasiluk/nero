<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Управиление заказами",
	"DESCRIPTION" => "Управение заказами",
	"ICON" => "/images/news_all.gif",
	"COMPLEX" => "Y",
	"PATH" => array(
		"ID" => "astronim",
        "NAME" => "Кастомные компоненты Astronim*",
		"CHILD" => array(
			"ID" => "orders",
			"NAME" => "Заказы",
			"SORT" => 10
		),
	),
);