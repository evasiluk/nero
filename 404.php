<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

$sapi_type = php_sapi_name();
if ($sapi_type == "cgi")
    header("Status: 404");
else
    header("HTTP/1.1 404 Not Found");

@define("ERROR_404", "Y");

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("404 - Страница не найдена"); ?>

    <h1>404 - Страница не найдена</h1>

<? $APPLICATION->IncludeComponent("bitrix:main.map", ".default", Array(
        "LEVEL" => "3",
        "COL_NUM" => "2",
        "SHOW_DESCRIPTION" => "Y",
        "SET_TITLE" => "Y",
        "CACHE_TIME" => "3600"
    )
);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>