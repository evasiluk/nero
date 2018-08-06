<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var $APPLICATION CMain
 */
use Astronim\Helper,
    Bitrix\Main\Loader,
    \Bitrix\Main\Localization\Loc;
include(DOCUMENT_ROOT . DEFAULT_TEMPLATE_PATH . '/header.php');
Helper::addContent('header_class', ' l-header-inner header-is-white');
?>

<?Helper::includeFile('template/header/header', ['show_border' => false]);?>

<?Helper::includeFile('template/header/content-title-block', ['show_border' => false]);?>

    <?$APPLICATION->IncludeComponent(
        "bitrix:menu",
        "tabs",
        Array(
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
            "DELAY" => "N",
            "MAX_LEVEL" => "1",
            "MENU_CACHE_GET_VARS" => array(""),
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "ROOT_MENU_TYPE" => "left",
            "USE_EXT" => "Y"
        )
    );?>


