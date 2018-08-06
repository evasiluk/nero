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
        <svg class="cnav-svg" width="40" height="36" xmlns="http://www.w3.org/2000/svg"
             viewBox="688.4 233.3 107.6 98">
            <path d="M771.7 331.3h-56c-5.5 0-10-4.5-10-10v-38h-17.4l53.8-50.1 53.8 50.1h-14.4v38c.2 5.5-4.3 10-9.8 10zM696 280.4h12.7v41c0 3.8 3.1 7 7 7h56c3.8 0 7-3.1 7-7v-41h9.7l-46.2-43-46.2 43z"/>
        </svg>
    </div>
    <div class="mob-header-text">Умный дом</div>
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
                            <div class="slide-header color--<?=$color?>">
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
                    <div class="screen-4-1-elem">
                        <img src="<?= DEFAULT_ASSETS_PATH ?>/userimg/screen-4-1-elem.png" alt="" class="img">
                        <img src="<?= DEFAULT_ASSETS_PATH ?>/userimg/node-4-1-1.png" alt="" class="node-1">
                        <img src="<?= DEFAULT_ASSETS_PATH ?>/userimg/node-4-1-2.png" alt="" class="node-2">
                    </div>
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
                            <div class="slide-header color--<?=$color?>">
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
                                <a href="<?= $arItem['PROPERTIES']['video']['src'] ?>" class="slide-play youtube-video">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-html="#video-04">
                                        <path d="M144 124.9L353.8 256 144 387.1V124.9M128 96v320l256-160L128 96z"/>
                                    </svg>
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

                    <div class="slide-in">
                        <div class="slide-content">
                            <div class="slide-header color--<?=$color?>">
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
                                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                         alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>">
                                    <div class="slide-play">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M144 124.9L353.8 256 144 387.1V124.9M128 96v320l256-160L128 96z"></path>
                                        </svg>
                                    </div>
                                </a>
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
