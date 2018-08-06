<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Список файлов для скачивания",
	"DESCRIPTION" => "Отображение списка файлов для скачивания",
	"PATH" => array(
		"ID" => "astronim",
        "NAME" => "Компоненты Astronim*",
		"CHILD" => array(
			"ID" => "files",
			"NAME" => "Файлы",
			"SORT" => 20,
		),
	),
);