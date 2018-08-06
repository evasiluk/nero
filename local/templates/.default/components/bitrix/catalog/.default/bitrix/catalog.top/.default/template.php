<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogTopComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

if (!empty($arResult['ITEMS'])) { ?>
    <div class="tape-slider swiper-container nav-bottom grid-view similar-slider-js">
        <div class="swiper-wrapper products__list">
            <? foreach ($arResult['ITEMS'] as $key => $arItem) {
                $in_cart = false;
                $no_image = empty($arItem['PREVIEW_PICTURE']); ?>
                <div class="tape-slider__item swiper-slide<?= ($in_cart ? ' in-cart' : '') . ($no_image ? ' no-image' : '') ?>">
                    <div class="products__inner">
                        <? if ($brand = $arItem['PROPERTIES']['brand']['VALUE']) {
                            $class = \Astronim\Helper::getHLClassByTable($arItem['PROPERTIES']['brand']['USER_TYPE_SETTINGS']['TABLE_NAME']);
                            $brand = $class::getRow(['filter' => ['UF_XML_ID' => $brand]]);
                            $brand['UF_FILE'] = CFile::GetFileArray($brand['UF_FILE']); ?>
                            <div class="products__brand">
                                <img style="max-width: 50px" src="<?= $brand['UF_FILE']['SRC'] ?>"
                                     alt="<?= $brand['UF_NAME'] ?>"/>
                            </div>
                        <? } ?>
                        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                            <div class="products__visual">
                                <div class="products__figure">
                                    <div class="products__img">
                                        <? if (!$no_image) { ?>
                                            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                                 alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"/>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="products__title"><span><?= $arItem['NAME'] ?></span>
                                <em class="products__model"><?= $arItem['PROPERTIES']['model']['VALUE'] ?></em></div>
                        </a>
                        <div class="products__footer">
                            <div class="products__price">
                                <div class="cur"><strong class="val"><?= $arItem['MIN_PRICE']['PRINT_VALUE'] ?></strong>
                                    <span class="unit"><?= $arItem['CATALOG_CURRENCY_' . $arItem['MIN_PRICE']['ID']] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
        <!-- pagination -->
        <div class="tape-slider-pagination swiper-pagination"></div>
        <!-- navigation buttons -->
        <div class="tape-slider-prev swiper-button-prev">Предыдущий</div>
        <div class="tape-slider-next swiper-button-next">Слудующий</div>
    </div>
<? }