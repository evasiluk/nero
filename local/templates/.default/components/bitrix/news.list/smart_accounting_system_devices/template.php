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

<div class="js-sbs-slider sbs-slider swiper-container swiper-is-loading">

    <div class="swiper-preloader"></div>

    <div class="swiper-wrapper">
        <?foreach ($arResult["ITEMS"] as $key => $arItem) { ?>
            <div class="swiper-slide">
                <div class="sbs-box">
                    <div class="sbs-img"><img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                              alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"></div>
                    <div class="sbs-dsc">
                        <p><?= $arItem['DETAIL_TEXT'] ?></p>
                        <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                    </div>
                </div>
            </div>
            <div class="bullet-tab js-bullet-tab<?if(0 == $key){?> 1bullet-tab--active<?}?>">
                <div class="tab-dot"><b></b></div>
                <div class="tab-txt"><?= $arItem['NAME'] ?></div>
            </div>
        <? } ?>
    </div>

    <div class="bullet-tabs js-bullet-tabs">
        <?foreach ($arResult["ITEMS"] as $key => $arItem) { ?>
            <div class="bullet-tab js-bullet-tab<?if(!$key){?> 1bullet-tab--active<?}?>">
                <div class="tab-dot"><b></b></div>
                <div class="tab-txt"><?= $arItem['NAME'] ?></div>
            </div>
        <? } ?>
    </div>

</div>
