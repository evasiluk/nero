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

<section class="section-gallery bg--darkblue">
    <div class="wrap" id="wideslider_sizer"></div>

    <h2 class="section-header color--white align-center"><?= Loc::getMessage('photogallery'); ?></h2>

    <div class="js-wideslider wideslider swiper-container">
        <div class="swiper-wrapper">
            <? foreach ($arResult["ITEMS"] as $arItem) { ?>
                <div id="vacancy<?= $arItem['ID'] ?>" class="swiper-slide" title="Завод">
                    <a href="#" class="js-lightgallery-opener">
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
                    </a>
                    <div class="in-gallery js-lightgallery">
                        <?foreach ($arItem['PROPERTIES']['photo']['VALUE'] as $key => $photo){?>
                        <a href="<?= $photo['SRC'] ?>" data-sub-html="<?=$arItem['PROPERTIES']['photo']['DESCRIPTION'][$key]?>">
                            <img src="<?= DEFAULT_ASSETS_PATH ?>/i/preloader.svg">
                        </a>
                        <?}?>
                    </div>
                </div>
            <? } ?>

        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
