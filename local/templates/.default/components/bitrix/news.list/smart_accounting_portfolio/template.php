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

<div class="js-portfolio-list">

    <div class="tabs-row">
        <a href="#" class="tabs-item--active"><span><?= Loc::getMessage('all') ?></span></a>
        <? foreach ($arResult['ITEMS_BY_TYPE'] as $type => $arType) {
            if (empty($arType['ITEMS'])) continue; ?>
            <a href="#portfolio-type-<?= $arType['XML_ID'] ?>" data-type="<?= $arType['XML_ID'] ?>">
                <span><?= $arType['VALUE'] ?></span>
            </a>
        <? } ?>
    </div>

    <div class="portfolio-list-loading">Загрузка...</div>

    <div class="portfolio-list">
        <div class="js-portfolio-slider portfolio-slider swiper-container">
            <div class="swiper-wrapper">
                <!-- all -->
                <? foreach ($arResult['ITEMS'] as $arItem) { ?>
                    <div id="portfolio-type-<?= $arItem['PROPERTIES']['type']['VALUE_XML_ID'] ?>" class="swiper-slide"
                         data-type="<?= $arItem['PROPERTIES']['type']['VALUE_XML_ID'] ?>">
                        <div class="portfolio">
                            <div class="portfolio-img"><img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                                            alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"></div>
                            <div class="portfolio-descr">
                                <div class="portfolio-title">
                                    <?= $arItem['NAME'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>

</div>