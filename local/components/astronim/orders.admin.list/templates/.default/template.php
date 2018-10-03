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


<div class="usercontent personal-history js-personal-history">
    <div class="personal-history-wrap bg--white">
    	<!-- <div class="personal-history-head">
            <div class="p-head-node">Дата</div>
            <div class="p-head-node">Статус заказа</div>
            <div class="p-head-node">Пользователь</div>
        </div> -->
        <div class="personal-history-head">
            <? foreach ($arResult['orders'] as $id => $order):?>
            	<div class="p-head-node">
            		<a href="<?= $order['link'] ?>" class="dotted color--black" style="<?= ($order['current'] ? 'font-weight: 600' : ''); ?>">
            			<span>
        					<?= $order['name'] ?>
        					<?if($order["current"]):?>
        						<?= ($order['order'] == 'asc' ? '&uarr;' : '&darr;'); ?>
        					<?endif?>
            			</span>
            		</a>
            	</div>
            <?endforeach?>
        </div>
        <? foreach ($arResult['ORDERS'] as $arOrder): ?>
        <div class="personal-basket-item">
            <div class="personal-history-item js-history-head">
                <div class="p-item-node"><a href="<?= $arOrder['DETAIL_URL'] ?>" class="dotted color--black"><span>Заказ №<?= $arOrder['ACCOUNT_NUMBER'] ?></span></a> от <?= $arOrder['DATE_INSERT'] ?></div>
                <div class="p-item-node">
                	<?if($arOrder["CANCELED"] == "Y"):?>
                		<span class="color--darkgrey">Отменен</span>
                	<?else:?>
                		<span class="<?if($arOrder['STATUS_ID'] == "F"):?>color--green<?elseif($arOrder['STATUS_ID'] == "N"):?>status--pending<?endif?>">
                			<?= $arResult['STATUS'][$arOrder['STATUS_ID']]['NAME'] ?>
                		</span>
                	<?endif?>
                </div>
                <div class="p-item-node">
                	<?= "{$arOrder['USER']['LAST_NAME']} {$arOrder['USER']['NAME']} {$arOrder['USER']['SECOND_NAME']}" ?>
                </div>
            </div>
        </div>
        <? endforeach; ?>
    </div>
</div>


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
