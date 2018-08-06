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
