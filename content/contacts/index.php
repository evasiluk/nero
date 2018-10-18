<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
use \Astronim\Helper;
$region = \Astronim\Region\RegionController::getInstance()->getCurrentRegion()->getId();


//print_pre($_SERVER);
$region = 0;
switch($_SERVER["HTTP_HOST"]) {
    case BY_HOST: $region = 390;
        break;
    case UA_HOST : $region = 398;
        break;
    case SPB_HOST : $region = 392;
        break;
    case MSK_HOST : $region = 391;
        break;
    default: $region = 390;
        break;
}

if($_GET["set_region"] == "belarus") {
    $region = 390;
}
if($_GET["set_region"] == "ukraine") {
    $region = 398;
}
if($_GET["set_region"] == "moscow") {
    $region = 391;
}
if($_GET["set_region"] == "peterburg") {
    $region = 392;
}


//var_dump($region);
?>
<?Helper::includeFile('template/header/header', ['show_border' => false]);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "contacts",
    Array(
        "REGION" => $region,
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "N",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array("", ""),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "29",
        "IBLOCK_TYPE" => "about_us",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "200",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array("*"),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ID",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "DESC",
        "STRICT_SECTION_CHECK" => "N"
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>