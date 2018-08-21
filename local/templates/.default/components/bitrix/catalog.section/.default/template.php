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
 */

$this->setFrameMode(true);


if (!empty($arResult['NAV_RESULT']))
{
    $navParams =  array(
        'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
        'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
        'NavNum' => $arResult['NAV_RESULT']->NavNum
    );
}
else
{
    $navParams = array(
        'NavPageCount' => 1,
        'NavPageNomer' => 1,
        'NavNum' => $this->randString()
    );
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
    $showTopPager = $arParams['DISPLAY_TOP_PAGER'];
    $showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
    $showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
    {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
    {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$arParams['~MESS_BTN_BUY'] = $arParams['~MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = $arParams['~MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = $arParams['~MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = $arParams['~MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = $arParams['~MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_SHOW_MAX_QUANTITY'] = $arParams['~MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = $arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = $arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

$arParams['MESS_BTN_LAZY_LOAD'] = $arParams['MESS_BTN_LAZY_LOAD'] ?: Loc::getMessage('CT_BCS_CATALOG_MESS_BTN_LAZY_LOAD');

$generalParams = array(
    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
    'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
    'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
    'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
    'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
    'COMPARE_PATH' => $arParams['COMPARE_PATH'],
    'COMPARE_NAME' => $arParams['COMPARE_NAME'],
    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
    'LABEL_POSITION_CLASS' => $labelPositionClass,
    'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
    'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
    'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
    '~BASKET_URL' => $arParams['~BASKET_URL'],
    '~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
    '~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
    '~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
    '~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
    'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
    'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
    'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
    'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
    'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
    'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);

$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-'.$navParams['NavNum'];

if ($showTopPager)
{
    ?>


    <?
}

?>
<?//print_pre($arResult)?>
<div class="catalog flex-row js-ajax-content" id="catalog-ajax">
    <?foreach($arResult["ITEMS"] as $item):?>
        <?$has_old_price = false;?>
        <div class="catalog-col col-xs-12 col-sm-6 col-lg-4">
            <?//print_pre($item["OFFERS"]);?>
            <?if($item["OFFERS"]):?>
                <?
                $json_str = "[";
                    foreach($item["OFFERS"] as $i=>$offer) {
                        //$ob = '{"image": "'.$offer["PREVIEW_PICTURE"]["SRC"].'", "color": "'.$offer["PROPERTIES"]["COLOR_CODE"]["VALUE"].'", "price": "'.$offer["PRICES"]["base"]["VALUE"].'"}';

                        $ob = '{';
                        $ob .= '"id" : "'.$offer["ID"].'", ';
                        $ob .= '"image" : "'.$offer["PREVIEW_PICTURE"]["SRC"].'", ';
                        $ob .= '"color" : "'.$offer["PROPERTIES"]["COLOR_CODE"]["VALUE"].'"';
                        if($offer["PRICES"]["dealer_price"]["VALUE"]) {
                            $has_old_price = true;
                            $ob .= ', "price" : "'.$offer["PRICES"]["dealer_price"]["VALUE"].'", "price-old" : "'.$offer["PRICES"]["rosnitsa_price"]["VALUE"].'"';
                        } else {
                            $ob .= ', "price" : "'.$offer["PRICES"]["rosnitsa_price"]["VALUE"].'"';

                        }
                        $ob .= '}';


                        $json_str .= $ob;
                        if(($i + 1) != count($item["OFFERS"])) {
                            $json_str .= ", ";
                        }
                    }
                $json_str .= "]";
                ?>
            <?else:?>
                <?
                //print_pre($item);
                //$json_str = '[{"image": "'.$item["PREVIEW_PICTURE"]["SRC"].'", "color": "'.$item["PROPERTIES"]["COLOR_CODE"]["VALUE"].'", "price": "'.$item["PRICES"]["base"]["VALUE"].'"}]';
                $json_str = '[{';
                $json_str .= '"id" : "'.$item["ID"].'", ';
                $json_str .= '"image" : "'.$item["PREVIEW_PICTURE"]["SRC"].'", ';
                $json_str .= '"color" : "'.$item["PROPERTIES"]["COLOR_CODE"]["VALUE"].'"';
                if($item["PRICES"]["dealer_price"]["VALUE"]) {
                    $has_old_price = true;
                    $json_str .= ', "price" : "'.$item["PRICES"]["dealer_price"]["VALUE"].'", "price-old" : "'.$item["PRICES"]["rosnitsa_price"]["VALUE"].'"';
                } else {
                    $json_str .= ', "price" : "'.$item["PRICES"]["rosnitsa_price"]["VALUE"].'"';
                }

                $json_str .= '}]';
                ?>
            <?endif?>
            <div class="product js-product" data-json='<?=$json_str?>'>

                <a href="<?=$item["DETAIL_PAGE_URL"]?>" class="product-img json-url">
                    <img src="/local/templates/.default/assets/i/preloader.svg" class="product-img-preloader js-preloader">
                    <?if(!$item["OFFERS"]):?>
                        <img src="/local/templates/.default/assets/i/preloader.svg" data-src="<?=$item["PREVIEW_PICTURE"]["SRC"]?>" alt="" class="json-image">
                    <?else:?>
                        <img src="/local/templates/.default/assets/i/preloader.svg" data-src="<?=$item["OFFERS"][0]["PREVIEW_PICTURE"]["SRC"]?>" alt="" class="json-image">
                    <?endif?>
                </a>
                <div class="product-descr">
                    <a href="<?=$item["DETAIL_PAGE_URL"]?>" class="product-title json-url"><?=$item["NAME"]?></a>
                    <div class="product-full">
                        <p><?=$item["PREVIEW_TEXT"]?></p>
                    </div>
                </div>
                <div class="product-footer">
                    <div class="product-footer-row">
                        <?if($item["PREVIEW_TEXT"]):?>
                            <div class="product-touch js-product-touch"></div>
                        <?endif?>
                        <div class="product-price">
                            <span class="json-price">
                            </span>
                            <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                        </div>
                        <?if($has_old_price):?>
                            <div class="product-price-old">
                                <span class="json-price-old">123</span>
                                <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                            </div>
                        <?endif?>
                    </div>
                    <div class="product-footer-row">
                        <div class="c-number-input c-number-input__sm">
									<span data-reactroot="" class="c-number-input c-number-input__sm">
										<input type="number" value="1" class="js-number-input c-number-input_real">
										<button data-delta="-1" class="c-number-input_btn c-number-input_btn__prev" type="button"></button>
										<button data-delta="1" class="c-number-input_btn c-number-input_btn__next" type="button"></button>
									</span>
                        </div>
                        <object>
                            <a href="#" class="button button--bgred button-buy json-product-id" data-id="">
                                <svg class="ico-basket" viewBox="0 0 389.5 355.8"><use xlink:href="#ico-basket"></use></svg>
                                <span>В корзину</span>
                            </a>
                        </object>
                    </div>
                </div>
                <div class="product-aside">
                    <ul class="product-icons">
                        <?if($item["PROPERTIES"]["line"]["VALUE"]):?>
                            <li class="product-icon">
                                <small class="color--red"><?=$item["PROPERTIES"]["line"]["VALUE"]?></small>
                            </li>
                        <?endif?>
                        <?if($item["PROPERTIES"]["ACTION_LENGTH"]["VALUE"]):?>
                            <li class="product-icon">
                                <small class="color--red"><?=$item["PROPERTIES"]["ACTION_LENGTH"]["VALUE"]?></small>
                            </li>
                        <?endif?>
                        <?if($item["PROPERTIES"]["MORE_ICONS"]["VALUE"]):?>
                            <?foreach($item["PROPERTIES"]["MORE_ICONS"]["VALUE"] as $file_id):?>
                                <li class="product-icon">
                                    <img src="<?=CFile::GetPath($file_id)?>">
                                </li>
                            <?endforeach?>
                        <?endif?>
                    </ul>
                </div>
                <ul class="product-colors json-colors"></ul>
            </div>
        </div>
    <?endforeach?>
</div>




<?


if ($showBottomPager)
{
    ?>
    <div data-pagination-num="<?=$navParams['NavNum']?>">
        <!-- pagination-container -->
        <?=$arResult['NAV_STRING']?>
        <!-- pagination-container -->
    </div>
    <?
}

$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
