<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
use Bitrix\Main\Loader,
    \Bitrix\Main\Application;

$i = 0;
while($file = $arParams["FILE_{$i}"]){
    $path = Application::getDocumentRoot() . $file;
    $arFile = [
        'src' => $file,
        'path' => $path,
        'extension' => pathinfo($path, PATHINFO_EXTENSION),
        'name' => pathinfo($path, PATHINFO_FILENAME),
        'description' => $arParams["DESCRIPTION_{$i}"],
        'size' => filesize($path),
        'time' => filemtime($path)
    ];

    $arResult['ITEMS'][] = $arFile;

    $i++;
}

$this->IncludeComponentTemplate();
