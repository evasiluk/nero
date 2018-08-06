<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

\Astronim\Helper::addContent('body_class', ' page--has-m-aside');
$this->setFrameMode(true);
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

//look for section id
$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
);
if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
    $section = $obCache->GetVars();
} elseif ($obCache->StartDataCache()) {
    $section = array();
    if (Loader::includeModule("iblock")) {
        $dbRes = CIBlockSection::GetList([], $arFilter, false, ['ID', 'DEPTH_LEVEL'], ['nTopCount' => 1]);

        if (defined("BX_COMP_MANAGED_CACHE")) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($section = $dbRes->Fetch()) {
                $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);
                $section['HAS_SUBSECTION'] = CIBlockSection::GetList([], ['IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $section['ID']], false, ['ID'], ['nTopCount' => 1])->Fetch();
            }

            $CACHE_MANAGER->EndTagCache();
        } else {
            if (!$section = $dbRes->Fetch())
                $section = array();
        }
    }
    $obCache->EndDataCache($section);
}
if (!isset($section)) return;
//\look for section id
?>

<div class="sticky-bounds">
        <? if ($arParams['USE_FILTER'] == 'Y') {
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.smart.filter",
                "",
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "SECTION_ID" => $section['ID'],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    //"PRICE_CODE" => $arParams["PRICE_CODE"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SAVE_IN_SESSION" => "N",
                    "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                    "XML_EXPORT" => "Y",
                    "SECTION_TITLE" => "NAME",
                    "SECTION_DESCRIPTION" => "DESCRIPTION",
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    "SEF_MODE" => $arParams["SEF_MODE"],
                    "SEF_RULE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["smart_filter"],
                    "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                ),
                $component
            );
        } ?>

                <!--options panel-->
                <?
                $arAvailableSort = array(
                    "date" => Array('ACTIVE_FROM', "desc"),
                    "name" => Array("name", "asc"),
                    "price" => Array('CATALOG_PRICE_1', "asc"),
                );

                $sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "name";
                $sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : $arAvailableSort[$sort][1];
                ?>


                <? $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "",
                    Array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ELEMENT_SORT_FIELD" => $sort,//$arParams["ELEMENT_SORT_FIELD"],
                        "ELEMENT_SORT_ORDER" => $sort_order,//$arParams["ELEMENT_SORT_ORDER"],
                        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                        "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],

                        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        
                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                        "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                        "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
                        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

                        "COMPARE_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["compare"],
                        "COMPARE_NAME" => $arParams["COMPARE_NAME"],
                        "DISPLAY_IMG_WIDTH" => $arParams["DISPLAY_IMG_WIDTH"],
                        "DISPLAY_IMG_HEIGHT" => $arParams["DISPLAY_IMG_HEIGHT"],

                        "SHARPEN" => $arParams["SHARPEN"],
                    ),
                    $component
                );
                ?>
</div>