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

<?if(CSite::InDir("/content/lines/auto-rollers/") && $APPLICATION->GetCurDir()!= "/content/lines/auto-rollers/"):?>
    <div class="sticky-bounds">
<?endif?>

<?Helper::includeFile('template/header/header', ['show_border' => false]);?>

<?Helper::includeFile('template/header/content-title-block', ['show_border' => false]);?>
<?if(CSite::InDir("/content/lines/auto-rollers/") && $APPLICATION->GetCurDir()!= "/content/lines/auto-rollers/"):?>
    </div>
<?endif?>
