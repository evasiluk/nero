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
use \Bitrix\Main\Localization\Loc;
?>

<section class="section-history bg--darkblue">
    <h2 class="section-header color--white align-center"><?= Loc::getMessage('history'); ?></h2>

    <img src="<?= DEFAULT_ASSETS_PATH ?>/userimg/history-1.jpg" class="b-history-bg js-history-bg">

    <div class="js-history b-history swiper-container">
        <div class="swiper-wrapper">
            <? foreach ($arResult["ITEMS"] as $arItem) { ?>
                <div class="swiper-slide" id="history<?=$arItem['CODE']?>">
                    <div class="wrap flex-row">
                        <div class="history-col col-xs hide-768"><img
                                    src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"></div>
                        <div class="history-col col-xs">
                            <h4><?= $arItem['PREVIEW_TEXT'] ?></h4>
                            <p><?= $arItem['DETAIL_TEXT'] ?></p>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>

        <div class="js-history-nav b-history-nav swiper-container">
            <div class="swiper-wrapper b-legend">
                <? foreach ($arResult["ITEMS"] as $arItem) { ?>
                    <div class="swiper-slide"><?= $arItem['NAME'] ?></div>
                <? } ?>
            </div>
        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>