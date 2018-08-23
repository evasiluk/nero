<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */

$documentRoot = Main\Application::getDocumentRoot();

if (empty($arParams['TEMPLATE_THEME'])) {
    $arParams['TEMPLATE_THEME'] = Main\ModuleManager::isModuleInstalled('bitrix.eshop') ? 'site' : 'blue';
}

if ($arParams['TEMPLATE_THEME'] === 'site') {
    $templateId = Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', $component->getSiteId());
    $templateId = preg_match('/^eshop_adapt/', $templateId) ? 'eshop_adapt' : $templateId;
    $arParams['TEMPLATE_THEME'] = Main\Config\Option::get('main', 'wizard_' . $templateId . '_theme_id', 'blue', $component->getSiteId());
}

if (!empty($arParams['TEMPLATE_THEME'])) {
    if (!is_file($documentRoot . '/bitrix/css/main/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css')) {
        $arParams['TEMPLATE_THEME'] = 'blue';
    }
}

if (!isset($arParams['DISPLAY_MODE']) || !in_array($arParams['DISPLAY_MODE'], array('extended', 'compact'))) {
    $arParams['DISPLAY_MODE'] = 'extended';
}

$arParams['USE_DYNAMIC_SCROLL'] = isset($arParams['USE_DYNAMIC_SCROLL']) && $arParams['USE_DYNAMIC_SCROLL'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_FILTER'] = isset($arParams['SHOW_FILTER']) && $arParams['SHOW_FILTER'] === 'N' ? 'N' : 'Y';

$arParams['PRICE_DISPLAY_MODE'] = isset($arParams['PRICE_DISPLAY_MODE']) && $arParams['PRICE_DISPLAY_MODE'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['TOTAL_BLOCK_DISPLAY']) || !is_array($arParams['TOTAL_BLOCK_DISPLAY'])) {
    $arParams['TOTAL_BLOCK_DISPLAY'] = array('top');
}

if (empty($arParams['PRODUCT_BLOCKS_ORDER'])) {
    $arParams['PRODUCT_BLOCKS_ORDER'] = 'props,sku,columns';
}

if (is_string($arParams['PRODUCT_BLOCKS_ORDER'])) {
    $arParams['PRODUCT_BLOCKS_ORDER'] = explode(',', $arParams['PRODUCT_BLOCKS_ORDER']);
}

$arParams['USE_PRICE_ANIMATION'] = isset($arParams['USE_PRICE_ANIMATION']) && $arParams['USE_PRICE_ANIMATION'] === 'N' ? 'N' : 'Y';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

if ($arParams['USE_GIFTS'] === 'Y') {
    $giftParameters = array(
        'SHOW_PRICE_COUNT' => 1,
        'PRODUCT_SUBSCRIPTION' => 'N',
        'PRODUCT_ID_VARIABLE' => 'id',
        'PARTIAL_PRODUCT_PROPERTIES' => 'N',
        'USE_PRODUCT_QUANTITY' => 'N',
        'ACTION_VARIABLE' => 'actionGift',
        'ADD_PROPERTIES_TO_BASKET' => 'Y',

        'BASKET_URL' => $APPLICATION->GetCurPage(),
        'APPLIED_DISCOUNT_LIST' => $arResult['APPLIED_DISCOUNT_LIST'],
        'FULL_DISCOUNT_LIST' => $arResult['FULL_DISCOUNT_LIST'],

        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_SHOW_VALUE'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],

        'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
        'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
        'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],
        'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
        'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
        'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
        'SHOW_NAME' => $arParams['GIFTS_SHOW_NAME'],
        'SHOW_IMAGE' => $arParams['GIFTS_SHOW_IMAGE'],
        'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
        'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
        'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
        'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
        'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

        'LINE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
    );
}

$this->addExternalCss('/bitrix/css/main/bootstrap.css');
$this->addExternalCss($templateFolder . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css');

$this->addExternalJs($templateFolder . '/js/mustache.js');
$this->addExternalJs($templateFolder . '/js/action-pool.js');
$this->addExternalJs($templateFolder . '/js/filter.js');
$this->addExternalJs($templateFolder . '/js/component.js');

$mobileColumns = isset($arParams['COLUMNS_LIST_MOBILE'])
    ? $arParams['COLUMNS_LIST_MOBILE']
    : $arParams['COLUMNS_LIST'];
$mobileColumns = array_fill_keys($mobileColumns, true);

$jsTemplates = new Main\IO\Directory($documentRoot . $templateFolder . '/js-templates');
/** @var Main\IO\File $jsTemplate */
foreach ($jsTemplates->getChildren() as $jsTemplate) {
    include($jsTemplate->getPath());
}

$displayModeClass = $arParams['DISPLAY_MODE'] === 'compact' ? ' basket-items-list-wrapper-compact' : '';

if (empty($arResult['ERROR_MESSAGE'])) {
    if ($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'TOP') {
        $APPLICATION->IncludeComponent(
            'bitrix:sale.gift.basket',
            '.default',
            $giftParameters,
            false
        );
    }

    if ($arResult['BASKET_ITEM_MAX_COUNT_EXCEEDED']) {
        ?>
        <div id="basket-item-message">
            <?= Loc::getMessage('SBB_BASKET_ITEM_MAX_COUNT_EXCEEDED', array('#PATH#' => $arParams['PATH_TO_BASKET'])) ?>
        </div>
        <?
    }
    ?>
    <div id="basket-root" class="bx-basket bx-<?= $arParams['TEMPLATE_THEME'] ?> bx-step-opacity" style="opacity: 0;">
        <?
        if (
            $arParams['BASKET_WITH_ORDER_INTEGRATION'] !== 'Y'
            && in_array('top', $arParams['TOTAL_BLOCK_DISPLAY'])
        ) {
            ?>
            <div class="row">
                <div class="col-xs-12" data-entity="basket-total-block"></div>
            </div>
            <?
        }
        ?>
<?//print_pre($arResult)?>
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-warning alert-dismissable" id="basket-warning" style="display: none;">
                    <span class="close" data-entity="basket-items-warning-notification-close">&times;</span>
                    <div data-entity="basket-general-warnings"></div>
                    <div data-entity="basket-item-warnings">
                        <?= Loc::getMessage('SBB_BASKET_ITEM_WARNING') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="basket-items-list-wrapper basket-items-list-wrapper-height-fixed basket-items-list-wrapper-light<?= $displayModeClass ?>"
                     id="basket-items-list-wrapper">
                    <!--                    <div class="basket-items-list-header" data-entity="basket-items-list-header">-->
                    <!--                        <div class="basket-items-search-field" data-entity="basket-filter">-->
                    <!--                            <div class="form has-feedback">-->
                    <!--                                <input type="text" class="form-control"-->
                    <!--                                       placeholder="-->
                    <? //= Loc::getMessage('SBB_BASKET_FILTER') ?><!--"-->
                    <!--                                       data-entity="basket-filter-input">-->
                    <!--                                <span class="form-control-feedback basket-clear"-->
                    <!--                                      data-entity="basket-filter-clear-btn"></span>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                        <div class="basket-items-list-header-filter">-->
                    <!--                            <a href="javascript:void(0)" class="basket-items-list-header-filter-item active"-->
                    <!--                               data-entity="basket-items-count" data-filter="all" style="display: none;"></a>-->
                    <!--                            <a href="javascript:void(0)" class="basket-items-list-header-filter-item"-->
                    <!--                               data-entity="basket-items-count" data-filter="similar" style="display: none;"></a>-->
                    <!--                            <a href="javascript:void(0)" class="basket-items-list-header-filter-item"-->
                    <!--                               data-entity="basket-items-count" data-filter="warning" style="display: none;"></a>-->
                    <!--                            <a href="javascript:void(0)" class="basket-items-list-header-filter-item"-->
                    <!--                               data-entity="basket-items-count" data-filter="delayed" style="display: none;"></a>-->
                    <!--                            <a href="javascript:void(0)" class="basket-items-list-header-filter-item"-->
                    <!--                               data-entity="basket-items-count" data-filter="not-available" style="display: none;"></a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="basket-items-list-container" id="basket-items-list-container">
                        <div class="basket-items-list-overlay" id="basket-items-list-overlay"
                             style="display: none;"></div>
                        <div class="basket-items-list" id="basket-item-list">
                            <div class="basket-search-not-found" id="basket-item-list-empty-result"
                                 style="display: none;">
                                <div class="basket-search-not-found-icon"></div>
                                <div class="basket-search-not-found-text">
                                    <?= Loc::getMessage('SBB_FILTER_EMPTY_RESULT') ?>
                                </div>
                            </div>

                            <div class="bottom-space-lg order-calc-js">
                                <div class="c-table">
                                    <div class="c-thead">
                                        <div class="c-tr">
                                            <div class="c-th c-th--caption">Модель</div>
                                            <!--                                            <div class="c-th c-th--stock">Наличие</div>-->
                                            <div class="c-th c-th--price">Цена</div>
                                            <div class="c-th c-th--spinner">Количество</div>
                                            <div class="c-th c-th--total">сумма</div>
                                            <? if (in_array('DELETE', $arParams['COLUMNS_LIST'])) { ?>
                                                <div class="c-th c-th--del">
                                                    <svg class="svg-ico-bin" xmlns="http://www.w3.org/2000/svg"
                                                         width="20"
                                                         height="20" viewBox="0 0 48 58">
                                                        <path d="M45 6H30V3c0-1.7-1.3-3-3-3h-6c-1.7 0-3 1.3-3 3v3H3C1.3 6 0 7.3 0 9v3h48V9C48 7.3 46.7 6 45 6zM3 55c0 1.7 1.3 3 3 3h36c1.7 0 3-1.3 3-3V15H3V55zM33 24c0-1.7 1.3-3 3-3s3 1.3 3 3v25c0 1.7-1.3 3-3 3s-3-1.3-3-3V24zM21 24c0-1.7 1.3-3 3-3s3 1.3 3 3v25c0 1.7-1.3 3-3 3s-3-1.3-3-3V24zM9 24c0-1.7 1.3-3 3-3s3 1.3 3 3v25c0 1.7-1.3 3-3 3s-3-1.3-3-3V24z"></path>
                                                    </svg>
                                                    <span>Удалить</span></div>
                                            <? } ?>
                                        </div>
                                    </div>
                                    <div class="c-tbody" id="basket-item-table">
                                    </div>
                                </div>
                                <?
                                if (
                                    $arParams['BASKET_WITH_ORDER_INTEGRATION'] !== 'Y'
                                    && in_array('bottom', $arParams['TOTAL_BLOCK_DISPLAY'])
                                ) {
                                    ?>
                                    <div data-entity="basket-total-block"></div>
                                    <?
                                }
                                ?>
                            </div>
                            <div class="headingм">
                                <h2>Комментарий к заказу <span class="sep">&nbsp;</span></h2>
                            </div>
                            <div class="comment-form">
                                <!--<label for="form-clear-ta-base">Ваше сообщение...</label>-->
                                <textarea placeholder="Ваше сообщение..." class="dark-form" id="order-message"></textarea>
                                <div class="error-note">Поле обязательное для заполнения</div>
                                <div class="success-note">Подтверждено</div>
                                <div class="form-buttons">
                                    <button class="btn-default order-calc-btn float-right" id="make-order">Заказать</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?
    if (!empty($arResult['CURRENCIES']) && Main\Loader::includeModule('currency')) {
        CJSCore::Init('currency');

        ?>
        <script>
            BX.Currency.setCurrencies(<?=CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)?>);
        </script>
        <?
    }

    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.basket.basket');
    $messages = Loc::loadLanguageFile(__FILE__);
    ?>
    <script>
        BX.message(<?=CUtil::PhpToJSObject($messages)?>);
        BX.Sale.BasketComponent.init({
            result: <?=CUtil::PhpToJSObject($arResult, false, false, true)?>,
            params: <?=CUtil::PhpToJSObject($arParams)?>,
            signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
            siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
            ajaxUrl: '<?=CUtil::JSEscape($component->getPath() . '/ajax.php')?>',
            templateFolder: '<?=CUtil::JSEscape($templateFolder)?>'
        });
    </script>
    <?
    if ($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'BOTTOM') {
        $APPLICATION->IncludeComponent(
            'bitrix:sale.gift.basket',
            '.default',
            $giftParameters,
            false
        );
    }
} else {
    ShowError($arResult['ERROR_MESSAGE']);
}