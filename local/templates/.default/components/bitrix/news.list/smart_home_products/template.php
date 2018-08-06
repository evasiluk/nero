<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

use Bitrix\Main\Localization\Loc;

?>

<h2 class="align-center"><?= $arResult['NAME'] ?></h2>

<div class="js-product-list">

    <div class="tabs-row">
<!--        <a href="#product-type-all" class="tabs-item--active"><span>--><?//= Loc::getMessage('all') ?><!--</span></a>-->
        <? foreach ($arResult['ITEMS_BY_TYPE'] as $type => $arType) {
            if(empty($arType['ITEMS'])) continue;?>
            <a href="#product-type-<?= $arType['XML_ID'] ?>" <?if($arType['DEF'] == 'Y'){?>class="tabs-item--active"<?}?>>
                <span><?= $arType['VALUE'] ?></span>
            </a>
        <? } ?>
    </div>

    <div class="product-list-loading">Загрузка...</div>

    <div class="product-list">
        <!-- all -->
<!--        <div id="product-type-all" class="js-product-slider product-slider swiper-container">-->
<!--            --><?// foreach ($arResult['ITEMS_BY_TYPE'] as $type => $arType) { ?>
<!--                --><?// foreach ($arType['ITEMS'] as $arItem) { ?>
<!--                    <div class="swiper-wrapper">-->
<!--                        <div class="swiper-slide">-->
<!--                            <div class="product">-->
<!--                                <div class="product-img">-->
<!--                                    <img src="--><?//= $arItem['PREVIEW_PICTURE']['SRC'] ?><!--"-->
<!--                                         alt="--><?//= $arItem['PREVIEW_PICTURE']['ALT'] ?><!--">-->
<!--                                </div>-->
<!--                                <div class="product-descr">-->
<!--                                    <div class="product-title">--><?//= $arItem['NAME'] ?><!--</div>-->
<!---->
<!--                                    <div class="product-full">-->
<!--                                        <p>--><?//= $arItem['PREVIEW_TEXT'] ?><!--</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                --><?// } ?>
<!--            --><?// } ?>
<!--            <div class="swiper-button-prev"></div>-->
<!--            <div class="swiper-button-next"></div>-->
<!--        </div>-->

        <? foreach ($arResult['ITEMS_BY_TYPE'] as $type => $arType) { ?>
            <!-- <?= $arType['VALUE'] ?> -->
            <div id="product-type-<?= $arType['XML_ID'] ?>" class="js-product-slider product-slider swiper-container">
                <div class="swiper-wrapper">
                    <? foreach ($arType['ITEMS'] as $arItem) { ?>
                        <div class="swiper-slide">
                            <div class="product">
                                <div class="product-img">
                                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                         alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>">
                                </div>
                                <div class="product-descr">
                                    <div class="product-title"><?= $arItem['NAME'] ?></div>

                                    <div class="product-full">
                                        <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <? } ?>
    </div>

</div>

<div class="product-list-footer">
    <a href="<?=$arResult['LIST_PAGE_URL']?>" class="button button--red button--arrow"><span><?=Loc::getMessage('web_shop')?></span></a>
</div>
