<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);


$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $mainId.'_skudiv',
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['MORE_PHOTO_COUNT'] > 1)
        {
            $showSliderControls = true;
            break;
        }
    }
}
else
{
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
    {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
    {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}
?>
<?
//print_pre($arResult);
?>

<h1 class="device-title show-980"><?=$arResult["NAME"]?></h1>

<div class="device-status device-status--available show-980">
    <span>В наличии</span>
</div>

<section class="device-section flex-row">

    <div class="col-xs-12 col-md-6">

        <div class="p-card__visual">

            <script>
                <?
                $str = "";
                if($arResult["OFFERS"]) {

                    foreach($arResult["OFFERS"] as $i=>$offer) {
                        if($offer["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) {
                            $ob = "";
                            foreach($offer["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $img) {
                                $ob .= "{'src': '".CFile::GetPath($img)."', 'thumb': '".CFile::GetPath($img)."', 'skin': '".$offer["PROPERTIES"]["COLOR_CODE"]["VALUE"]."', 'price' : '".$offer["PRICES"]["base"]["VALUE"]."'},";
                            }

                        } else {
                                $ob = "{'src': '".$offer["PREVIEW_PICTURE"]["SRC"]."', 'thumb': '".$offer["PREVIEW_PICTURE"]["SRC"]."', 'skin': '".$offer["PROPERTIES"]["COLOR_CODE"]["VALUE"]."', 'price' : '".$offer["PRICES"]["base"]["VALUE"]."'}";
                        }


                        $str .= $ob;
                    }
                } else {
                    $ob = "{'src': '".$arResult["DETAIL_PICTURE"]["SRC"]."', 'thumb': '".$arResult["DETAIL_PICTURE"]["SRC"]."', 'skin': '".$arResult["PROPERTIES"]["COLOR_CODE"]["VALUE"]."', 'price' : '".$arResult["PRICES"]["base"]["VALUE"]."'}";
                    $str = $ob;
                }
                ?>

                var pCardItems = [<?=$str?>]
            </script>

            <div class="p-card__gallery">

                <div class="js-cardgallery-opener p-card-plus"></div>

                <div class="card-slider js-card-slider">
                    <!-- tmpl.js.render -->
                </div>
            </div>

            <div class="p-card__nav">
                <div class="card-slider-nav js-card-slider-nav">
                    <!-- tmpl.js.render -->
                </div>
            </div>


        </div>

    </div>

    <div class="col-xs-12 col-md-6">

        <div class="device-aside">

            <div class="device-node">

                <h1 class="device-title hide-980"><?=$arResult["NAME"]?></h1>

                <p><?=$arResult["DETAIL_TEXT"]?></p>
            </div>

            <hr>

            <div class="device-node device-price">

                <div class="product-price">
                    <?if($arResult["OFFERS"]):?>
                        <span class="json-price"><?=$arResult["OFFERS"][0]["PRICES"]["base"]["VALUE"]?></span>
                    <?else:?>
                        <span><?=$arResult["PRICES"]["base"]["VALUE"]?></span>
                    <?endif?>
                    <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                </div>

            </div>

            <hr>

            <div class="device-node device-options">

                <div class="device-options-row">

                    <div class="device-options-col device-options-col-colors">
                        <ul class="device-colors js-device-colors">
                            <?if($arResult["OFFERS"]):?>
                                <?foreach($arResult["OFFERS"] as $i=>$offer):?>
                                    <li <?if($i == 0):?>class="active"<?endif?>>
                                        <a href="<?=$offer["PROPERTIES"]["COLOR_CODE"]["VALUE"]?>" style="background-color: <?=$offer["PROPERTIES"]["COLOR_CODE"]["VALUE"]?>;"></a>
                                    </li>
                                <?endforeach?>
                            <?else:?>
                                <li class="active">
                                    <a href="<?=$arResult["PROPERTIES"]["COLOR_CODE"]["VALUE"]?>" style="background-color: <?=$arResult["PROPERTIES"]["COLOR_CODE"]["VALUE"]?>;"></a>
                                </li>
                            <?endif?>
                        </ul>
                    </div>
                    <!--                    <div class="device-options-col device-options-col-number">-->
                    <!--                        <div class="c-number-input c-number-input__sm">-->
                    <!--										<span data-reactroot="" class="c-number-input c-number-input__sm">-->
                    <!--											<input type="number" value="1" class="js-number-input c-number-input_real">-->
                    <!--											<button data-delta="-1" class="c-number-input_btn c-number-input_btn__prev" type="button"></button>-->
                    <!--											<button data-delta="1" class="c-number-input_btn c-number-input_btn__next" type="button"></button>-->
                    <!--										</span>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="device-options-col device-options-col-button">-->
                    <!--                        <a href="#" class="button button--bgred button-buy">-->
                    <!--                            <svg class="ico-basket" viewBox="0 0 389.5 355.8"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-basket"></use></svg>-->
                    <!--                            <span>В корзину</span>-->
                    <!--                        </a>-->
                    <!--                    </div>-->

                </div>

                <!--                <div class="device-options-row device-options-row-status hide-980">-->
                <!--                    <div class="device-options-col">-->
                <!--                        <div class="device-status device-status--available">-->
                <!--                            <span>В наличии</span>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

                <div class="device-options-row">
                    <div class="device-options-col">

                            <?if($arParams["IBLOCK_ID"] == 30):?>
                                <div class="device-delivery">
                                    <div class="ico-delivery">
                                        <svg viewBox="0 0 540 540"><use xlink:href="#ico-delivery"></use></svg>
                                    </div>
                                    <span><b>Бесплатная доставка</b> по Минску и району, по РБ при заказе от 1000 рублей.  Срок 1–5 дней. Самовывоз из Минска, курьер, EMS.</span>
                                </div>
                            <?endif?>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="device-socials"></div>
</section>

<section class="device-section bg--white">

<div class="js-tabs device-tabs">

<?if($arResult["PROPERTIES"]["OSOBENNOSTY"]["VALUE"] || $arResult["PROPERTIES"]["HARACTERISTIKY_HTML"]["~VALUE"]["TEXT"] || $arResult["PROPERTIES"]["INSTALLING"]["~VALUE"]["TEXT"] || $arResult["PROPERTIES"]["CONTROLL_HTML"]["~VALUE"]["TEXT"] || $arResult["PROPERTIES"]["FILES"]["VALUE"]):?>
    <div class="tabs-row js-labels">
        <?if($arResult["PROPERTIES"]["OSOBENNOSTY"]["VALUE"]):?>
            <a href="#" data-label="0" class="is-active"><span><?=GetMessage("FEATURES");?></span></a>
        <?endif?>
        <?if($arResult["PROPERTIES"]["HARACTERISTIKY_HTML"]["~VALUE"]["TEXT"]):?>
            <a href="#" data-label="1"><span><?=GetMessage("CHARACTERISTICS");?></span></a>
        <?endif?>
        <?if($arResult["PROPERTIES"]["INSTALLING"]["~VALUE"]["TEXT"]):?>
            <a href="#" data-label="2"><span><?=GetMessage("INSTALL");?></span></a>
        <?endif?>
        <?if($arResult["PROPERTIES"]["CONTROLL_HTML"]["~VALUE"]["TEXT"]):?>
            <a href="#" data-label="3"><span><?=GetMessage("CONTROL");?></span></a>
        <?endif?>
        <?if($arResult["PROPERTIES"]["FILES"]["VALUE"]):?>
            <a href="#" data-label="4"><span><?=GetMessage("FILES");?></span></a>
        <?endif?>
    </div>
<?endif?>


<div class="tabs-list js-tabs-list">

<?if($arResult["PROPERTIES"]["OSOBENNOSTY"]["VALUE"]):?>
    <div class="mobile-label is-active" data-mobile-label="0"><span><?=GetMessage("FEATURES");?></span></div>
<?endif?>

<?if($arResult["PROPERTIES"]["OSOBENNOSTY"]["VALUE"]):?>
    <div class="js-tab" data-tab="0">
        <?
        global $osobFilter;
        $osobFilter["SECTION_ID"] = $arResult["PROPERTIES"]["OSOBENNOSTY"]["VALUE"];
        ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "item_osobennosty",
            Array(
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
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array("",""),
                "FILTER_NAME" => "osobFilter",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "32",
                "IBLOCK_TYPE" => "item_properties",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "20",
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
                "PROPERTY_CODE" => array("NAME_EN",""),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "NAME",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N"
            )
        );?>
    </div>
<?endif?>

<?if($arResult["PROPERTIES"]["HARACTERISTIKY_HTML"]["~VALUE"]["TEXT"]):?>
    <div class="mobile-label" data-mobile-label="1"><span><?=GetMessage("CHARACTERISTICS");?></span></div>
<?endif?>

<?if($arResult["PROPERTIES"]["HARACTERISTIKY_HTML"]["~VALUE"]["TEXT"]):?>
<div class="js-tab" data-tab="1">
    <div class="maxwrap">
        <div class="tab-heading heading-level-2 align-center"><?=GetMessage("CHARACTERISTICS");?></div>
        <div class="quality">
            <?=$arResult["PROPERTIES"]["HARACTERISTIKY_HTML"]["~VALUE"]["TEXT"]?>

            <div class="quality-full js-quality">
                <? $i = 0; ?>
                <?foreach($arResult["CHAR_SECTIONS"] as $id=>$sec):?>

                    <div class="flex-row<?if ($i != 0):?> hidden<?endif?>">
                        <div class="col-xs-12 col-sm-4">
                            <div class="quality-type">
                                <i class="ico-info"></i>
                                <?if(SITE_ID == "s1"):?>
                                    <span><?=$sec["NAME"]?></span>
                                <?else:?>
                                    <span><?=$sec["UF_NAME_EN"]?></span>
                                <?endif?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "item_character",
                                Array(
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
                                    "CACHE_TYPE" => "N",
                                    "CHECK_DATES" => "Y",
                                    "DETAIL_URL" => "",
                                    "DISPLAY_BOTTOM_PAGER" => "Y",
                                    "DISPLAY_DATE" => "Y",
                                    "DISPLAY_NAME" => "Y",
                                    "DISPLAY_PICTURE" => "Y",
                                    "DISPLAY_PREVIEW_TEXT" => "Y",
                                    "DISPLAY_TOP_PAGER" => "N",
                                    "FIELD_CODE" => array(0=>"",1=>"",),
                                    "FILTER_NAME" => "",
                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                    "IBLOCK_ID" => "33",
                                    "IBLOCK_TYPE" => "item_properties",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                    "INCLUDE_SUBSECTIONS" => "Y",
                                    "MESSAGE_404" => "",
                                    "NEWS_COUNT" => "20",
                                    "PAGER_BASE_LINK_ENABLE" => "N",
                                    "PAGER_DESC_NUMBERING" => "N",
                                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                    "PAGER_SHOW_ALL" => "N",
                                    "PAGER_SHOW_ALWAYS" => "N",
                                    "PAGER_TEMPLATE" => ".default",
                                    "PAGER_TITLE" => "Новости",
                                    "PARENT_SECTION" => $id,
                                    "PARENT_SECTION_CODE" => "",
                                    "PREVIEW_TRUNCATE_LEN" => "",
                                    "PROPERTY_CODE" => array(0=>"NAME_EN",1=>"",),
                                    "SET_BROWSER_TITLE" => "N",
                                    "SET_LAST_MODIFIED" => "N",
                                    "SET_META_DESCRIPTION" => "N",
                                    "SET_META_KEYWORDS" => "N",
                                    "SET_STATUS_404" => "N",
                                    "SET_TITLE" => "N",
                                    "SHOW_404" => "N",
                                    "SORT_BY1" => "SORT",
                                    "SORT_BY2" => "NAME",
                                    "SORT_ORDER1" => "DESC",
                                    "SORT_ORDER2" => "ASC",
                                    "STRICT_SECTION_CHECK" => "N"
                                )
                            );?>

                        </div>
                    </div>

                    <? $i++; ?>
                <?endforeach?>
                <div class="quality-full-footer align-center">
                    <a href="#" class="button button--red button--arrow-down js-quality-toggle"><span><?=GetMessage("ALL_CHARS")?></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?endif?>

<?if($arResult["PROPERTIES"]["INSTALLING"]["~VALUE"]["TEXT"]):?>
    <div class="mobile-label" data-mobile-label="2"><span><?=GetMessage("INSTALL");?></span></div>
<?endif?>

<?if($arResult["PROPERTIES"]["INSTALLING"]["~VALUE"]["TEXT"]):?>
    <div class="js-tab" data-tab="2">
        <div class="maxwrap">
            <?=$arResult["PROPERTIES"]["INSTALLING"]["~VALUE"]["TEXT"]?>
        </div>
    </div>
<?endif?>

<?if($arResult["PROPERTIES"]["CONTROLL_HTML"]["~VALUE"]["TEXT"]):?>
    <div class="mobile-label" data-mobile-label="3"><span><?=GetMessage("CONTROL");?></span></div>
<?endif?>

<?if($arResult["PROPERTIES"]["CONTROLL_HTML"]["~VALUE"]["TEXT"]):?>
<div class="js-tab" data-tab="3">
    <div class="control-tab-bg" <?if($arResult["PROPERTIES"]["CONTROLL_IMG"]["VALUE"]):?>style="background-image:url(<?=CFile::GetPath($arResult["PROPERTIES"]["CONTROLL_IMG"]["VALUE"])?>)"<?endif?>></div>
    <div class="maxwrap">
        <div class="tab-heading heading-level-2 align-center"><?=GetMessage("CONTROL");?></div>
        <div class="flex-row control-tab">
            <?=$arResult["PROPERTIES"]["CONTROLL_HTML"]["~VALUE"]["TEXT"]?>
        </div>
    </div>
</div>
<?endif?>

<?if($arResult["PROPERTIES"]["FILES"]["VALUE"]):?>
    <div class="mobile-label" data-mobile-label="4"><span><?=GetMessage("FILES");?></span></div>
<?endif?>
<?if($arResult["PROPERTIES"]["FILES"]["VALUE"]):?>
<div class="js-tab" data-tab="4">
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "item_files",
            Array(
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
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "COMPONENT_TEMPLATE" => "item_character",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_DATE" => "Y",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array(0=>"",1=>"",),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "34",
                "IBLOCK_TYPE" => "item_properties",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "Y",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "20",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => $arResult["PROPERTIES"]["FILES"]["VALUE"],
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array(0=>"NAME_EN",1=>"FILE_RU",2=>"FILE_EN",3=>"",),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "NAME",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N"
            )
        );?><br>
</div>
<?endif?>
</div>
</div>
</section>

<?if($arResult["ATTACHED_ITEMS"]):?>
    <section class="device-section device-match">

        <div class="device-wrap">
            <h3 class="device-match-title">Совместимые продукты</h3>
        </div>
        <?
        global $attachedFilter;
        $attachedFilter["ID"] = $arResult["ATTACHED_ITEMS"];
        ?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "attached_products",
            Array(
                "ACTION_VARIABLE" => "action",
                "ADD_PICT_PROP" => "-",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "BACKGROUND_IMAGE" => "-",
                "BASKET_URL" => "/personal/basket.php",
                "BROWSER_TITLE" => "-",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPATIBLE_MODE" => "Y",
                "CONVERT_CURRENCY" => "N",
                "CUSTOM_FILTER" => "",
                "DETAIL_URL" => "",
                "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "DISPLAY_COMPARE" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "ELEMENT_SORT_FIELD" => "sort",
                "ELEMENT_SORT_FIELD2" => "id",
                "ELEMENT_SORT_ORDER" => "asc",
                "ELEMENT_SORT_ORDER2" => "desc",
                "ENLARGE_PRODUCT" => "STRICT",
                "FILTER_NAME" => "attachedFilter",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "IBLOCK_TYPE" => "",
                "INCLUDE_SUBSECTIONS" => "Y",
                "LABEL_PROP" => "",
                "LAZY_LOAD" => "N",
                "LINE_ELEMENT_COUNT" => "3",
                "LOAD_ON_SCROLL" => "N",
                "MESSAGE_404" => "",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "META_DESCRIPTION" => "-",
                "META_KEYWORDS" => "-",
                "OFFERS_CART_PROPERTIES" => "",
                "OFFERS_FIELD_CODE" => array(0=>"",1=>"",),
                "OFFERS_LIMIT" => "5",
                "OFFERS_PROPERTY_CODE" => array(0=>"MORE_PHOTO",1=>"COLOR_CODE",2=>"MORE_ICONS",),
                "OFFERS_SORT_FIELD" => "sort",
                "OFFERS_SORT_FIELD2" => "id",
                "OFFERS_SORT_ORDER" => "asc",
                "OFFERS_SORT_ORDER2" => "desc",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Товары",
                "PAGE_ELEMENT_COUNT" => "18",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array(0=>"base",),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                "PRODUCT_DISPLAY_MODE" => "N",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPERTIES" => "",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE" => array(0=>"pult_canal_qnt",1=>"line",2=>"",),
                "PROPERTY_CODE_MOBILE" => "",
                "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                "RCM_TYPE" => "personal",
                "SECTION_CODE" => $arResult["ORIGINAL_PARAMETERS"]["SECTION_CODE"],
                "SECTION_ID" => "",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => array(0=>"",1=>"",),
                "SEF_MODE" => "N",
                "SET_BROWSER_TITLE" => "Y",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "Y",
                "SET_META_KEYWORDS" => "Y",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "Y",
                "SHOW_404" => "N",
                "SHOW_ALL_WO_SECTION" => "N",
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_FROM_SECTION" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "Y",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_MAIN_ELEMENT_SECTION" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N"
            )
        );?>
    </section>
<?endif?>


<?if($arResult["SIBLINGS"]):?>
    <section class="device-nav">
        <div class="flex-row bg--white">
            <?if($arResult["SIBLINGS"][0]):?>
                <div class="col-xs-6">
                    <a href="<?=$arResult["SIBLINGS"][0]["DETAIL_PAGE_URL"]?>" class="device-nav-item">
                        <div class="device-nav-img">
                            <img class="lozad" src="/local/templates/.default/assets/i/img-preloader.svg" data-src="<?=CFile::GetPath($arResult["SIBLINGS"][0]["PREVIEW_PICTURE"])?>" alt="">
                        </div>
                        <div class="device-nav-txt">
                            <span><?=GetMessage("PREV_ITEM")?></span>
                            <div class="device-nav-title"><?=$arResult["SIBLINGS"][0]["NAME"]?></div>
                        </div>
                    </a>
                </div>
            <?endif?>
            <?if($arResult["SIBLINGS"][1]):?>
                <div class="col-xs-6">
                    <a href="<?=$arResult["SIBLINGS"][1]["DETAIL_PAGE_URL"]?>" class="device-nav-item">
                        <div class="device-nav-img">
                            <img class="lozad" src="/local/templates/.default/assets/i/img-preloader.svg" data-src="<?=CFile::GetPath($arResult["SIBLINGS"][1]["PREVIEW_PICTURE"])?>" alt="">
                        </div>
                        <div class="device-nav-txt">
                            <span><?=GetMessage("NEXT_ITEM")?></span>
                            <div class="device-nav-title"><?=$arResult["SIBLINGS"][1]["NAME"]?></div>
                        </div>
                    </a>
                </div>
            <?endif?>
        </div>
    </section>
<?endif?>
