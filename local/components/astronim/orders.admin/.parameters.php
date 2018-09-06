<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
    return;

$arComponentParameters = array(
    "GROUPS" => array(
    ),
    "PARAMETERS" => array(
        "VARIABLE_ALIASES" => Array(
            "ID" => Array("NAME" => "ID")
        ),
        "FILTER_NAME" => array(
            "NAME" => "Имя фильтра",
            "DEFAULT" => "eddOrdersFilter"
        ),
        "SEF_MODE" => Array(
            "list" => array(
                "NAME" => "Страница списка",
                "DEFAULT" => "",
                "VARIABLES" => array(),
            ),
            "detail" => array(
                "NAME" => "Сраница редактирования",
                "DEFAULT" => "#ID#/",
                "VARIABLES" => array("ID"),
            )
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
        "CACHE_FILTER" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("BN_P_CACHE_FILTER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BN_CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
    ),
);

CIBlockParameters::AddPagerSettings(
    $arComponentParameters,
    GetMessage("T_IBLOCK_DESC_PAGER_NEWS"), //$pager_title
    true, //$bDescNumbering
    true, //$bShowAllParam
    true, //$bBaseLink
    $arCurrentValues["PAGER_BASE_LINK_ENABLE"]==="Y" //$bBaseLinkEnabled
);

//CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
