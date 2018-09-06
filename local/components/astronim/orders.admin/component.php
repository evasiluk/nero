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

$arComponentVariables = array(
    "ID",
);
$arDefaultUrlTemplates404 = array(
    "list" => "",
    "detail" => "#ID#/"
);
$arDefaultVariableAliases = array();
$arDefaultVariableAliases404 = array();
$arVariables = array();

$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, "");
$arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
CComponentEngine::initComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

$componentPage = "";

if (isset($arVariables["ID"]) && intval($arVariables["ID"]) > 0)
    $componentPage = "detail";
else
    $componentPage = "list";

$arResult = array(
    "FOLDER" => "",
    "URL_TEMPLATES" => array(
        "news" => htmlspecialcharsbx($APPLICATION->GetCurPage()),
        "detail" => htmlspecialcharsbx($APPLICATION->GetCurPage() . "?" . $arVariableAliases["ID"] . "=#ID#"),
    ),
    "VARIABLES" => $arVariables,
    "ALIASES" => $arVariableAliases
);

$this->IncludeComponentTemplate($componentPage);