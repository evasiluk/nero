<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">
    <div class="c-table-result" data-entity="basket-checkout-aligner">
        <div class="c-table-result__total order-calc__total-results-js show">
            <div class="c-table-result__label">Итого:</div>
<!--            <span class="c-table-result__count order-calc__counts-total-js">{{QUANTITY}}</span>-->
<!--            позиций на&nbsp;-->
            <span class="c-table-result__price" data-entity="basket-total-price">{{{PRICE_FORMATED}}}</span>
        </div>
        <button class="btn-default order-calc-btn float-right" style="display: none;">Заказать</button>
    </div>
</script>