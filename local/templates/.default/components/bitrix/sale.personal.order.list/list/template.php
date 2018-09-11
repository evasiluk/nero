<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>
<?
//print_pre($arResult);


//CModule::IncludeModule("currency");
////заказ за 04.09
//
////выборка курса за 04.09
//
//$arFilter = array(
//"CURRENCY" => "BYN",
//'DATE_RATE' => '04.09.2018',
//'!DATE_RATE' => '05.09.2018',
//);
//$by = "date";
//$order = "desc";
//
//$row = CCurrencyRates::GetList($by, $order, $arFilter)->Fetch();
//
//
////если нет на 04.09 - выбираем ближайшую предыдущую
//if(!$row) {
//$arFilter = array(
//"CURRENCY" => "BYN",
//'!DATE_RATE' => '04.09.2018',
//);
//$by = "date";
//$order = "desc";
//
//$row = CCurrencyRates::GetList($by, $order, $arFilter)->Fetch();
////print_pre($row);
//}
//
//if($row["DATE_RATE"]) {
//    echo CCurrencyRates::ConvertCurrency(100, "EUR", "BYN", date("Y-m-d", strtotime($row["DATE_RATE"])));
//} else {
//    echo CCurrencyRates::ConvertCurrency(100, "EUR", "BYN");
//}




?>
<div class="usercontent personal-history js-personal-history">
    <div class="personal-history-wrap bg--white">
        <div class="personal-history-head">
            <div class="p-head-node">Дата</div>
            <div class="p-head-node">Статус заказа</div>
            <div class="p-head-node">Сумма</div>
        </div>

        <?foreach($arResult["ORDERS"] as $arItem):?>
        <?//print_pre($arItem)?>
            <div class="personal-basket-item">
                <div class="personal-history-item js-history-head">
                    <div class="p-item-node"><a href="#" class="js-history-toggle js-history-toggle dotted color--black"><span>Заказ №<?=$arItem["ORDER"]["ID"]?> от <?=CIBlockFormatProperties::DateFormat('d F Y', strtotime($arItem["ORDER"]["DATE_INSERT_FORMATED"]))?></span></a></div>
                    <div class="p-item-node"><?=$arResult["INFO"]["STATUS"][$arItem["ORDER"]["STATUS_ID"]]["NAME"]?></div>
                    <div class="p-item-node">
                        <div class="basket-item-price align-left">
                            <span><?=$arItem["ORDER"]["PRICE_IN_REG_VALUTE"]?></span>
                            <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                        </div>
                    </div>
                </div>
                <div class="basket-wrap js-history-content" style="display: none;">
                    <div class="basket">
                        <div class="basket-head bg--grey">
                            <div class="b-head-node">Наименование</div>
                            <div class="b-head-node">Цвет</div>
                            <div class="b-head-node">Цена</div>
                            <div class="b-head-node">Кол-во</div>
                            <div class="b-head-node">Сумма</div>
                            <div class="b-head-node"></div>
                        </div>
                        <div class="basket-body bg--grey">
                            <?foreach($arItem["BASKET_ITEMS"] as $item):?>
                                <div class="basket-item">
                                    <div class="b-item-node">
                                        <a href="<?=$item["DETAIL_PAGE_URL"]?>" class="basket-device">
                                            <div class="basket-device-img">
                                                <img class="lozad" data-src="<?=$item["PICTURE"]?>" alt="">
                                            </div>
                                            <div class="basket-device-txt">
                                                <div class="basket-device-title"><?=$item["NAME"]?></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="b-item-node">
                                        <div class="device-color" style="background-color: <?=$item["COLOR_CODE"]?>;"></div>
                                    </div>
                                    <div class="b-item-node">
                                        <div class="basket-item-price">
                                            <span><?=$item["PRICE"]?></span>
                                            <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                        </div>
                                        <?if($item["PRICE_BEFORE_DISCOUNT"]):?>
                                        <div class="basket-item-price-old">
                                            <span><?=$item["PRICE_BEFORE_DISCOUNT"]?></span>
                                            <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                        </div>
                                        <?endif?>
                                    </div>
                                    <div class="b-item-node">
                                        <?=$item["QUANTITY"]?>
                                    </div>
                                    <div class="b-item-node">
                                        <div class="basket-item-price">
                                            <span><?=$item["PRICE_ALL"]?></span>
                                            <sup><?=$arResult["VALUTE_SHORT"]?></sup>
                                        </div>
                                    </div>
                                </div>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
            </div>
        <?endforeach?>
    </div>

</div>

