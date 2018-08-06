<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

/** @var PageNavigationComponent $component */

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");


$arResult['previous'] = $arResult["sUrlPath"] . "?" . $strNavQueryString . "PAGEN_" . $arResult["NavNum"] . "=" . ($arResult["NavPageNomer"] - 1);

$arResult['next'] = $arResult["sUrlPath"] . "?" . $strNavQueryString . "PAGEN_" . $arResult["NavNum"] . "=" . ($arResult["NavPageNomer"] + 1) ;

$arResult['begin'] = $arResult["sUrlPath"];

$arResult['end'] = $arResult["sUrlPath"] . "?" . $strNavQueryString. "PAGEN_" . $arResult["NavNum"] . "=" . $arResult["NavPageCount"];