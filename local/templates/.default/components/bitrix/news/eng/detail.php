<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(true);

use Astronim\Helper;

?>

<?
$this->SetViewTarget('this_news_item');
$ElementID = $APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "",
    Array(
        "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
        "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "META_KEYWORDS" => $arParams["META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
        "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "MESSAGE_404" => $arParams["MESSAGE_404"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "SHOW_404" => $arParams["SHOW_404"],
        "FILE_404" => $arParams["FILE_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
        "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
        "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
        "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
        "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
        "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
        "CHECK_DATES" => $arParams["CHECK_DATES"],
        "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "USE_SHARE" => $arParams["USE_SHARE"],
        "SHARE_HIDE" => $arParams["SHARE_HIDE"],
        "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
        "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
        "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
        "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
        "ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
        'STRICT_SECTION_CHECK' => (isset($arParams['STRICT_SECTION_CHECK']) ? $arParams['STRICT_SECTION_CHECK'] : ''),
    ),
    $component
);
$this->EndViewTarget();
if ($ElementID) {
    $arItem = \Bitrix\Iblock\ElementTable::getRow([
        'filter' => ['ID' => $ElementID],
        'select' => ['ID', 'NAME', 'ACTIVE_FROM']
    ]);

    $arItem['DISPLAY_ACTIVE_FROM'] = FormatDate($arParams['DETAIL_ACTIVE_DATE_FORMAT'], strtotime($arItem['ACTIVE_FROM']));
}
?>

<? Helper::includeFile('template/header/header', ['show_border' => false]); ?>
<? Helper::includeFile('template/header/content-news-title-block', ['show_border' => false], ['arItem' => $arItem]); ?>

<div class="usercontent wrap wrap-content news-content bg--white">
    <div class="share-aside js-share-aside">
        <div class="likely likely-light">
            <div class="twitter"></div>
            <div class="facebook"></div>
            <div class="vkontakte"></div>
            <div class="telegram"></div>
            <span class="likely-title">Share:</span>
        </div>
    </div>

    <?
    $APPLICATION->ShowViewContent('this_news_item');
    ?>

    <div class="news-content-footer">
        <? $backurl = $_REQUEST['backurl'] ?: $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"]; ?>
        <a href="<?= $backurl ?>" class="button">All news</a>
    </div>

</div>

<? $nearest = \Astronim\Helper::getClosestElements($ElementID, $arParams);
if (count($nearest) > 0) { ?>
    <section class="device-nav">
        <div class="flex-row bg--white">

            <? if ($nearest['prev']) { ?>
                <div class="col-xs-6">
                    <a href="<?= $nearest['prev']['DETAIL_PAGE_URL'] ?>" class="device-nav-item">
                        <div class="device-nav-img">
                            <img src="<?= $nearest['prev']['PREVIEW_PICTURE']['SRC'] ?>"
                                 alt="<?= $nearest['prev']['PREVIEW_PICTURE']['ALT'] ?>">
                        </div>
                        <div class="device-nav-txt">
                            <span>Next new</span>
                            <div class="news-nav-title">
                                <?= $nearest['prev']['NAME'] ?>
                            </div>
                        </div>
                    </a>
                </div>
            <? } ?>
            <? if ($nearest['next']) { ?>
                <div class="col-xs-6">
                    <a href="<?= $nearest['next']['DETAIL_PAGE_URL'] ?>" class="device-nav-item">
                        <div class="device-nav-img">
                            <img src="<?= $nearest['next']['PREVIEW_PICTURE']['SRC'] ?>"
                                 alt="<?= $nearest['next']['PREVIEW_PICTURE']['ALT'] ?>">
                        </div>
                        <div class="device-nav-txt">
                            <span>Previous new</span>
                            <div class="news-nav-title">
                                <?= $nearest['next']['NAME'] ?>
                            </div>
                        </div>
                    </a>
                </div>
            <? } ?>
        </div>

    </section>
<? } ?>

