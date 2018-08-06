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
?>
<header class="mob-section-header">
    <div class="mob-header-ico">
        <svg class="cnav-svg" xmlns="http://www.w3.org/2000/svg" width="33" height="42" x="0px" y="0px"
             viewBox="568.8 227.7 85.3 104">
            <path d="M611.5 297.3c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.3-5-5-5zm-32.6-21.1l1.1.6c8 4 19.5 6.3 31.5 6.3s23.4-2.3 31.5-6.3l1.1-.6v-38.1h-65.2v38.1zm4-34.1H640v31.6c-7.4 3.4-17.8 5.4-28.6 5.4s-21.1-2-28.6-5.4v-31.6zm64.8-14.4h-72.5c-3.5 0-6.4 2.9-6.4 6.4v91.1c0 3.5 2.9 6.4 6.4 6.4h72.5c3.5 0 6.4-2.9 6.4-6.4v-91.1c0-3.5-2.9-6.4-6.4-6.4zm2.4 97.6c0 1.3-1.1 2.4-2.4 2.4h-72.5c-1.3 0-2.4-1.1-2.4-2.4v-91.1c0-1.3 1.1-2.4 2.4-2.4h72.5c1.3 0 2.4 1.1 2.4 2.4v91.1z"/>
        </svg>
    </div>
    <div class="mob-header-text">Умный учет</div>
</header>

<div class="owl-carousel owl-animated-in owl-carousel--details">
    <? foreach ($arResult["ITEMS"] as $arItem) {
        $color = ($arItem['PROPERTIES']['bg']['VALUE_XML_ID'] == 'light' ? 'black' : 'white');
        switch ($arItem['PROPERTIES']['type']['VALUE']) {
            case '1':
                ?>
                <div data-slide-bg="<?= $arItem['PROPERTIES']['bg']['VALUE_XML_ID'] ?>"
                     class="<?= $arItem['PROPERTIES']['class']['VALUE'] ?>">
                    <? if ($arItem['DETAIL_PICTURE']) { ?>
                        <img alt="<?= $arItem['DETAIL_PICTURE']['ALT'] ?>" class="slide-bg"
                             src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>">
                    <? } ?>
                    <div class="slide-in">
                        <div class="slide-content">
                            <div class="slide-header color--<?= $color ?>">
                                <div class="slide-title">
                                    <?= $arItem['PREVIEW_TEXT'] ?>
                                </div>
                            </div>
                            <? if ($arItem['PROPERTIES']['link']['VALUE']) { ?>
                                <p>
                                    <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>"
                                       class="button button--red button--arrow">
                                        <span><?= $arItem['PROPERTIES']['text']['VALUE'] ?></span>
                                    </a>
                                </p>
                            <? } ?>
                        </div>
                    </div>
                    <? if ($arItem['PREVIEW_PICTURE']) { ?>
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                             alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"
                             class="screen-2-1-elem">
                    <? } ?>
                </div>
                <?
                break;
            case '2':
                ?>
                <div data-slide-bg="<?= $arItem['PROPERTIES']['bg']['VALUE_XML_ID'] ?>"
                     class="<?= $arItem['PROPERTIES']['class']['VALUE'] ?>">
                    <? if ($arItem['DETAIL_PICTURE']) { ?>
                        <img alt="<?= $arItem['DETAIL_PICTURE']['ALT'] ?>" class="slide-bg"
                             src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>">
                    <? } ?>
                    <div class="slide-in">
                        <div class="slide-content">
                            <div class="slide-header color--<?= $color ?>">
                                <div class="slide-title">
                                    <?= $arItem['PREVIEW_TEXT'] ?>
                                </div>
                            </div>
                            <? if ($arItem['PROPERTIES']['link']['VALUE']) { ?>
                                <p>
                                    <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>"
                                       class="button button--white button--arrow">
                                        <span><?= $arItem['PROPERTIES']['text']['VALUE'] ?></span>
                                    </a>
                                </p>
                            <? } ?>
                            <? if ($arItem['PROPERTIES']['video']['VALUE']) { ?>
                                <a href="<?= $arItem['PROPERTIES']['video']['src'] ?>"
                                   class="slide-preview youtube-video">
                                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['NAME'] ?>">
                                    <div class="slide-play">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M144 124.9L353.8 256 144 387.1V124.9M128 96v320l256-160L128 96z"/>
                                        </svg>
                                    </div>
                                </a>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <?
                break;
            case '3':
            default:
                ?>
                <div data-slide-bg="<?= $arItem['PROPERTIES']['bg']['VALUE_XML_ID'] ?>"
                     class="<?= $arItem['PROPERTIES']['class']['VALUE'] ?>">
                    <? if ($arItem['DETAIL_PICTURE']) { ?>
                        <img alt="<?= $arItem['DETAIL_PICTURE']['ALT'] ?>" class="slide-bg"
                             src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>">
                    <? } ?>

                    <img data-src="<?= DEFAULT_ASSETS_PATH ?>/userimg/screen-map-bg.png" alt=""
                         class="slide-bg slide-bg--map slide-map-bg">
                    <img data-src="<?= DEFAULT_ASSETS_PATH ?>/userimg/screen-map-labels.png" alt=""
                         class="slide-bg slide-bg--map slide-map-labels">
                    <img data-src="<?= DEFAULT_ASSETS_PATH ?>/userimg/screen-map-titles.png" alt=""
                         class="slide-bg slide-bg--map slide-map-titles">

                    <div class="slide-in">
                        <div class="slide-content">
                            <div class="slide-header color--<?= $color ?>">
                                <div class="slide-title">
                                    <?= $arItem['PREVIEW_TEXT'] ?>
                                </div>
                            </div>
                            <? if ($arItem['PROPERTIES']['link']['VALUE']) { ?>
                                <p>
                                    <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>"
                                       class="button button--red button--arrow">
                                        <span><?= $arItem['PROPERTIES']['text']['VALUE'] ?></span>
                                    </a>
                                </p>
                            <? } ?>
                        </div>
                    </div>

                </div>
                <?
                break;
        } ?>
    <? } ?>
</div>

<div class="slide-nav">
    <? foreach ($arResult["ITEMS"] as $arItem) { ?>
        <div class="slide-tab js-slide-tab">
            <div class="tab-dot"><b></b></div>
            <div class="tab-txt"><?=html_entity_decode($arItem['NAME'])?></div>
        </div>
    <? } ?>
</div>
