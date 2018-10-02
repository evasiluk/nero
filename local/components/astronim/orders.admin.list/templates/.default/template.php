<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
?>
<?
//print_pre($arResult);
?>
<div>
    <span>Сортировать по:</span>
    <ul>
        <? foreach ($arResult['orders'] as $id => $order):?>
            <li class="<?= ($order['current'] ? 'active' : ''); ?>"><a href="<?= $order['link'] ?>">
                    <?= $order['name'] ?> <?= ($order['order'] == 'asc' ? '&uarr;' : '&darr;'); ?>
                </a></li>
        <?endforeach?>
    </ul>
</div>

<? $APPLICATION->IncludeComponent(
    "bitrix:main.pagenavigation",
    "nero_order_list_pagination",
    array(
        "NAV_OBJECT" => $arResult['nav'],
        "SEF_MODE" => "N",
    ),
    false
); ?>

<div class="admin-orders-list flex-row">
    <? foreach ($arResult['ORDERS'] as $arOrder): ?>
        <div class="admin-order-item col-xs-12">
            <div class="item-id">
                <?= "
                    <a href='{$arOrder['DETAIL_URL']}'>
                    Заказ  
                    №{$arOrder['ACCOUNT_NUMBER']}
                    </a>
                " ?>
            </div>
            <div class="flex-row item-props">
                <div class="col-xs-12 col-sm-6">
                    <div class="item-prop flex-row">
                        <div class="key col-xs-12 col-sm-6">Пользователь:</div>
                        <div class="value  col-xs-12 col-sm-6"><?= "{$arOrder['USER']['LAST_NAME']} {$arOrder['USER']['NAME']} {$arOrder['USER']['SECOND_NAME']}" ?></div>
                    </div>
                    <div class="item-prop flex-row">
                        <div class="key col-xs-12 col-sm-6">Статус:</div>
                        <div class="value col-xs-12 col-sm-6">
                            <?if($arOrder["CANCELED"] == "Y"):?>
                                Отменен
                            <?else:?>
                                <?= $arResult['STATUS'][$arOrder['STATUS_ID']]['NAME'] ?>
                            <?endif?>
                        </div>
                    </div>
                    <div class="item-prop flex-row">
                        <div class="key col-xs-12 col-sm-6">Создан:</div>
                        <div class="value col-xs-12 col-sm-6"><?= $arOrder['DATE_INSERT'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    <? endforeach; ?>
</div>
<style>
    .admin-order-item {
        padding: 15px 20px;
        border-bottom: 1px #999 solid;
    }

    .admin-order-item .item-id {
        margin-bottom: 5px;
    }

    .admin-order-item .item-id a {
        color: #000083;
        font-size: 22px;
        font-weight: bolder;
    }

    .item-prop > div {
        display: inline-block;
        margin-top: 5px;
    }

    .item-prop .key {
        font-size: 14px;
        color: #999;
        text-transform: uppercase;
    }

    .item-prop .value {
        font-size: 14px;
        color: #019875;
        text-transform: uppercase;
    }
</style>
<?
$APPLICATION->IncludeComponent(
    "bitrix:main.pagenavigation",
    "nero_order_list_pagination",
    array(
        "NAV_OBJECT" => $arResult['nav'],
        "SEF_MODE" => "N",
    ),
    false
);
?>
