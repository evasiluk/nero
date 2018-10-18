<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixBasketComponent $component */
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
);
$this->addExternalCss($templateData['TEMPLATE_THEME']);

$curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);
unset($curPage);

$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"],
	'EVENT_ONCHANGE_ON_START' => (!empty($arResult['EVENT_ONCHANGE_ON_START']) && $arResult['EVENT_ONCHANGE_ON_START'] === 'Y') ? 'Y' : 'N',
	'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
	'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
	'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>;
</script>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

if($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'TOP')
{
	$APPLICATION->IncludeComponent(
		"bitrix:sale.gift.basket",
		".default",
		array(
			"SHOW_PRICE_COUNT" => 1,
			"PRODUCT_SUBSCRIPTION" => 'N',
			'PRODUCT_ID_VARIABLE' => 'id',
			"PARTIAL_PRODUCT_PROPERTIES" => 'N',
			"USE_PRODUCT_QUANTITY" => 'N',
			"ACTION_VARIABLE" => "actionGift",
			"ADD_PROPERTIES_TO_BASKET" => "Y",

			"BASKET_URL" => $APPLICATION->GetCurPage(),
			"APPLIED_DISCOUNT_LIST" => $arResult["APPLIED_DISCOUNT_LIST"],
			"FULL_DISCOUNT_LIST" => $arResult["FULL_DISCOUNT_LIST"],

			"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_SHOW_VALUE"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

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

			"LINE_ELEMENT_COUNT" => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
		),
		false
	);
}

if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	?>
	<div id="warning_message">
		<?
		if (!empty($arResult["WARNING_MESSAGE"]) && is_array($arResult["WARNING_MESSAGE"]))
		{
			foreach ($arResult["WARNING_MESSAGE"] as $v)
				ShowError($v);
		}
		?>
	</div>
	<?

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? 'style="display:none;"' : '';

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? 'style="display:none;"' : '';

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? 'style="display:none;"' : '';

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? 'style="display:none;"' : '';

	foreach (array_keys($arResult['GRID']['HEADERS']) as $id)
	{
		$data = $arResult['GRID']['HEADERS'][$id];
		$headerName = (isset($data['name']) ? (string)$data['name'] : '');
		if ($headerName == '')
			$arResult['GRID']['HEADERS'][$id]['name'] = GetMessage('SALE_'.$data['id']);
		unset($headerName, $data);
	}
	unset($id);
}
	?>
    <!-- наш шаблон-->

    <!-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> -->
    <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->

   <!--  <div id="basketPage" class="usercontent personal-basket" style="display: none;">
        <p>{{ message }}</p>
        <div class="personal-basket-header">
            <div class="flex-row flex-row-padding">
                <div class="col-xs-6">
                    <div class="personal-basket-title">
                        Товаров в заказе: <span>0</span>
                    </div>
                </div>
                <div class="col-xs-6 end-xs">
                    <a href="#basket-cleanup" class="basket-cleanup">
                        <span>Очистить корзину</span>
                        <svg class="ico-close" viewBox="0 0 32 32">
                            <use xlink:href="#ico-close"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="basket">
            <div class="basket-head bg--white">
                <div class="b-head-node">Наименование</div>
                <div class="b-head-node">Цвет</div>
                <div class="b-head-node">Цена</div>
                <div class="b-head-node">Кол-во</div>
                <div class="b-head-node">Сумма</div>
                <div class="b-head-node"></div>
            </div>
            <div class="basket-body bg--white">
                <div class="basket-item" v-for="item in items" :key="item.id">
                    <div class="b-item-node">
                        <a :href="item.HREF" class="basket-device">
                            <div class="basket-device-img">
                                <img class="lozad" :src="item.IMAGE" alt="">
                            </div>
                            <div class="basket-device-txt">
                                <div class="basket-device-title">{{item.NAME}}</div>
                            </div>
                        </a>
                    </div>
                    <div class="b-item-node">
                        <div class="device-color" :style="{ 'background-color' : item.COLOR_CODE }"></div>
                    </div>
                    <div class="b-item-node">
                        <div class="basket-item-price">
                            <span>{{item.ITEM_PRICE}}</span>
                            <sup>{{item.VALUTE}}</sup>
                        </div>
                        <div class="basket-item-price-old">
                            <span></span>
                            <sup></sup>
                        </div>
                    </div>
                    <div class="b-item-node">
                        <div class="c-number-input c-number-input__sm">
                            <span class="c-number-input c-number-input__sm">
                                <input type="number" :value="item.QUANTITY" class="c-number-input_real">
                                <button data-delta="1" class="c-number-input_btn c-number-input_btn__next" type="button" @click="number('inc', item)"></button>
                                <button data-delta="-1" class="c-number-input_btn c-number-input_btn__prev" type="button" @click="number('dec', item)"></button>
                            </span>
                        </div>
                    </div>
                    <div class="b-item-node">
                        <div class="basket-item-price">
                            <span>{{item.NEW_SUM}}</span>
                            <sup>{{item.VALUTE}}</sup>
                        </div>
                    </div>
                    <div class="b-item-node">
                        <div class="basket-item-remove">
                            <svg class="ico-close" viewBox="0 0 32 32">
                                <use xlink:href="#ico-close"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <script>
    /*
    var basketPage = new Vue({
        el: '#basketPage',
        data() {
            return {
                postData: {
                    sessid: BX.bitrix_sessid(),
                    site_id: BX.message('SITE_ID'),
                    action_var: 'basketAction',
                    basketAction: 'default'
                },
                message: 'Hello Vue!',
                basket: {},
                items: [],
                itemsLength: 0
            }
        },

        // template: '#basketItemTemplate',

        created: function(){
            // console.log('created');
            this.fetchBasket();
        },

        methods: {
            fetchBasket: function () {
                // console.log('fetchBasket');
                axios.get('/local/ajax/basketNewSum.php')
                  .then(function (response) {
                    console.log(response.data);
                    basketPage.basket = response.data;
                    basketPage.items = response.data['ITEMS'];
                    basketPage.itemsLength = basketPage.items.length;
                  })
                  .catch(function (error) {
                    console.log(error);
                  })
                  .then(function () {
                    // always executed
                  });
            },
            number: function(param, item) {
                // console.log(param, item);

                var quantity = item['QUANTITY'];
                if (quantity > 1 && quantity < 1000) {
                    if (param === 'inc') {
                        item['QUANTITY'] += 1;
                    }
                    if (param === 'dec') {
                        item['QUANTITY'] -= 1;
                    }

                    console.log(basketPage.postData);

                    var postData = basketPage.postData;
                    postData.basketAction = 'recalculate';
                    postData['QUANTITY_' + item.id] = item['QUANTITY'];

                    this.recalculate(postData);
                }

            },

            recalculate: function(postData) {
                console.log(postData);

                axios.post('/bitrix/components/bitrix/sale.basket.basket/ajax.php', postData)
                  .then(function (response) {
                    // console.log(response);
                    basketPage.fetchBasket();
                  })
                  .catch(function (error) {
                    // console.log(error);
                  });
            },
        }
    });
    */
    </script>


    <?if(count($arResult["BASKET_ITEMS"])):?>
        <form action="/content/personal/cart/make/" class="usercontent personal-basket js-personal-basket" method="post">
            <?//print_pre($arResult["BASKET_ITEMS"]);?>
            <div class="personal-basket-header">
                <div class="flex-row flex-row-padding">
                    <div class="col-xs-6">
                        <div class="personal-basket-title">
                            Товаров в заказе: <span class="js-basket-products-count"><?=$arResult["TOTAL_ITEMS_COUNT"]?></span>
                        </div>
                    </div>
                    <div class="col-xs-6 end-xs">
                        <a href="#basket-cleanup" class="basket-cleanup js-basket-cleanup">
                            <span>Очистить корзину</span>
                            <svg class="ico-close" viewBox="0 0 32 32">
                                <use xlink:href="#ico-close"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="basket">
                <div class="basket-head bg--white">
                    <div class="b-head-node">Наименование</div>
                    <div class="b-head-node">Цвет</div>
                    <div class="b-head-node">Цена</div>
                    <div class="b-head-node">Кол-во</div>
                    <div class="b-head-node">Сумма</div>
                    <div class="b-head-node"></div>
                </div>
                <div class="basket-body bg--white">
                    <?foreach($arResult["BASKET_ITEMS"] as $arItem):?>
                        <div class="basket-item js-basket-product" id="<?=$arItem["ID"]?>">
                            <div class="b-item-node">
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="basket-device">
                                    <div class="basket-device-img">
                                        <img class="lozad" data-src="<?=$arItem["PREVIEW_PICTURE_SRC"]?>" alt="">
                                    </div>
                                    <div class="basket-device-txt">
                                        <div class="basket-device-title"><?=$arItem["NAME"]?></div>
                                        <!--                                    <div class="basket-device-status is-available">-->
                                        <!--                                        <span>В наличии</span>-->
                                        <!--                                    </div>-->
                                    </div>
                                </a>
                            </div>
                            <div class="b-item-node">
                                <div class="device-color" style="background-color: <?=$arItem["COLOR_CODE"]?>;"></div>
                            </div>
                            <div class="b-item-node">
                                <div class="basket-item-price">
                                    <span class="js-basket-product-price" data-price="<?=$arItem["FULL_PRICE"]?>"><?=$arItem["FULL_PRICE"]?></span>
                                    <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                </div>
                                <?if($arItem["ROSN_PRICE"]):?>
                                    <div class="basket-item-price-old">
                                        <span><?=$arItem["ROSN_PRICE"]?></span>
                                        <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                    </div>
                                <?endif?>
                            </div>
                            <div class="b-item-node">
                                <div class="c-number-input c-number-input__sm">
									<span class="c-number-input c-number-input__sm">
										<input type="number" data-id="<?=$arItem["ID"]?>" value="<?=$arItem["QUANTITY"]?>" class="js-number-input c-number-input_real">
										<button data-delta="-1" class="c-number-input_btn c-number-input_btn__prev" type="button"></button>
										<button data-delta="1" class="c-number-input_btn c-number-input_btn__next" type="button"></button>
									</span>
                                </div>
                            </div>
                            <div class="b-item-node">
                                <div class="basket-item-price">
                                    <span class="js-basket-product-sum"><?=$arItem["FULL_PRICE_SUM"]?></span>
                                    <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                </div>
                            </div>
                            <div class="b-item-node">
                                <div class="basket-item-remove js-basket-product-remove" data-id="<?=$arItem["ID"]?>">
                                    <svg class="ico-close" viewBox="0 0 32 32">
                                        <use xlink:href="#ico-close"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    <?endforeach?>
                </div>
                <div class="basket-foot">
                    <div class="flex-row flex-row-padding">
                        <div class="col-xs-4">
                            <?if($arResult["USER_DISCOUNT"]):?>
                                <div class="basket-discount bg--white">
                                    <div class="personal-item personal-info-header">
                                        Ваша скидка
                                    </div>
                                    <!--                            <div class="personal-item">-->
                                    <!--                                <label class="personal-label label-off">Базовая:</label>-->
                                    <!--                                <div class="personal-input"><span class="bg--red outline--red" data-discound-base="5%">5%</span></div>-->
                                    <!--                            </div>-->
                                    <div class="personal-item">
                                        <label class="personal-label label-off">Накопительная:</label>
                                        <div class="personal-input"><span class="bg--red outline--red" data-discound-custom="<?=$arResult["USER_DISCOUNT"]?>"><?=$arResult["USER_DISCOUNT"]?></span></div>
                                    </div>
                                    <input type="hidden" class="js-basket-discount-value" value="<?=$arResult["USER_DISCOUNT"]?>">
                                </div>
                            <?endif?>
                        </div>
                        <div class="col-xs-4">
                            <!--                        <div class="device-delivery basket-device-delivery">-->
                            <!--                            <div class="ico-delivery">-->
                            <!--                                <svg viewBox="0 0 540 540"><use xlink:href="#ico-delivery"></use></svg>-->
                            <!--                            </div>-->
                            <!--                            <span><b>Бесплатная доставка</b> по Минску и району, по РБ при заказе от 1000 рублей.  Срок 1–5 дней. Самовывоз из Минска, курьер, EMS.</span>-->
                            <!--                        </div>-->
                        </div>
                        <div class="col-xs-4 end-xs">
                            <div class="basket-summary">
                                <?if($arResult["USER_DISCOUNT"]):?>
                                <div class="b-summary-node">
                                    <span>Сумма без скидки:</span>
                                    <div class="basket-item-price">
                                        <span class="js-basket-price"><?=$arResult["TOTAL_SUM"]?></span>
                                        <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                    </div>
                                </div>
                                <div class="b-summary-node">
                                    <span>Cкидка:</span>
                                    <div class="basket-item-price">
                                        <span class="js-basket-discount"><?=$arResult["TOTAL_SUM_DISCOUNT"]?></span>
                                        <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                    </div>
                                </div>
                                <?endif?>
                                <div class="b-summary-node b-summary-result">
                                    <span>Итого:</span>
                                    <div class="basket-item-price basket-item-price--big">
                                        <span class="js-total"><?=$arResult["FINAL_SUM"]?></span>
                                        <input type="hidden" class="js-input-total" value="---">
                                        <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                    </div>
                                </div>
                                <?if($arResult["TOTAL_DEALER_SAVINGS"]):?>
                                    <div class="b-summary-node">
                                        <span>Вы экономите:</span>
                                        <div class="basket-item-price">
                                            <span class="js-basket-savings"><?=$arResult["TOTAL_DEALER_SAVINGS"]?></span>
                                            <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                        </div>
                                    </div>
                                <?endif?>
                                <div class="b-summary-node">
                                    <button class="button button--big button--bgred">Оформить заказ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?endif?>

    <div class="usercontent bg--white basket-is-empty js-basket-is-empty" <?if(count($arResult["BASKET_ITEMS"])):?>style="display: none;"<?endif?>>
        <div class="wrap wrap-content">
            <h2 class="align-center">Корзина пуста</h2>
        </div>
    </div>
    <!-- наш шаблон конец-->











