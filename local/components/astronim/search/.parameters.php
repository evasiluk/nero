<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */

if (!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-" => " "));

$arIBlocks = array();
$db_iblock = CIBlock::GetList(array("SORT" => "ASC"), array(
    "SITE_ID" => $_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : ""))
);
while ($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];

$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "PARAM_NAME_QUERY" => array(
            "PARENT" => "BASE",
            "NAME" => "Переменная с запросом",
            "TYPE" => "STRING",
            "DEFAULT" => 'q',
        ),),
);

