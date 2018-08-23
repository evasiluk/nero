<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
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
?>
<script id="basket-item-template" type="text/html">
    <div class="c-tr" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">
        <div class="c-td c-td--caption" data-label="Модель">
            <div class="td__val">
                <a href="{{DETAIL_PAGE_URL}}" class="caption-for-table">
                    <div class="img-for-table">
                        <img src="{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=$templateFolder?>/images/no_photo.png{{/IMAGE_URL}}" alt="{{NAME}}" />
                    </div>
                    <div class="title-for-table">
                        {{NAME}}
                    </div>
                </a>
            </div>
        </div>
        <div class="c-td c-td--price" data-label="Цена">
            <div class="c-td__val">
                <div class="order-calc__price-js" data-price="{{{PRICE}}}" id="basket-item-price-{{ID}}">{{{PRICE_FORMATED}}}</div>
            </div>
        </div>
        <div class="c-td c-td--spinner" data-label="Количество">
            <div class="c-td__val">
                <input class="spinner spinner-js order-calc__number-js"
                       type="text" name="value"  value="{{QUANTITY}}"
                        data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
                        id="basket-item-quantity-{{ID}}" data-only-number
                       {{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
                >
            </div>
        </div>
        <div class="c-td c-td--price" data-label="Сумма">
            <div class="c-td__val">
                <span class="order-calc__price-sum-js">0</span> р.
            </div>
        </div>
        <?if(in_array('DELETE', $arParams['COLUMNS_LIST'])){?>
        <div class="c-td c-td--del" id="basket-item-height-aligner-{{ID}}">
            <a href="#" class="btn-del" data-entity="basket-item-delete" title="Удалить товар с корзины">
                <svg class="svg-ico-close" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 57.2 57.2">
                    <path d="M34.3 28.6L56 6.9c1.6-1.6 1.6-4.1 0-5.7 -1.6-1.6-4.1-1.6-5.7 0L28.6 22.9 6.9 1.3c-1.6-1.6-4.1-1.6-5.7 0 -1.6 1.6-1.6 4.1 0 5.7l21.7 21.6L1.3 50.3c-1.6 1.5-1.6 4.1 0 5.6 0.8 0.8 1.8 1.2 2.8 1.2s2-0.4 2.8-1.2l21.7-21.6L50.3 56c0.8 0.8 1.8 1.2 2.8 1.2s2-0.4 2.8-1.2c1.6-1.6 1.6-4.1 0-5.7L34.3 28.6z"></path>
                </svg>
                <span>Удалить с корзины</span>
            </a>
        </div>
        <?}?>
    </div>
</script>