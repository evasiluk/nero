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
        <svg class="cnav-svg" width="40" height="36" viewBox="426 231.6 104.4 93.9">
            <path d="M520.4 231.6H436c-5.5 0-10 4.5-10 10 0 4.8 3.4 8.9 8 9.8v66.9c0 4 3.2 7.2 7.2 7.2h81.9c4 0 7.2-3.2 7.2-7.2v-76.7c.1-5.5-4.4-10-9.9-10zm-84.4 16c-3.3 0-6-2.7-6-6s2.7-6 6-6h76.4c-1.3 1.7-2 3.7-2 6 0 2.2.8 4.3 2 6H436zm90.4 70.7c0 1.8-1.5 3.2-3.2 3.2h-81.9c-1.8 0-3.2-1.5-3.2-3.2v-66.7h82.4c2.2 0 4.3-.8 6-2v68.7zm-6-70.7c-3.3 0-6-2.7-6-6s2.7-6 6-6 6 2.7 6 6-2.7 6-6 6z"/>
        </svg>
    </div>
    <div class="mob-header-text">Автоматика для&nbsp;роллет</div>
</header>

<div class="owl-carousel owl-animated-in owl-carousel--details">
    <? foreach ($arResult["ITEMS"] as $arItem) {
        $color = ($arItem['PROPERTIES']['bg']['VALUE_XML_ID'] == 'light' ? 'black' : 'white');
        switch ($arItem['PROPERTIES']['type']['VALUE']) {
            case '1':
                ?>
                <div data-slide-bg="<?= $arItem['PROPERTIES']['bg']['VALUE_XML_ID'] ?>">
                    <div class="slide-in slide--shrink">
                        <div class="slide-content">
                            <div class="slide-header color--<?= $color ?> slide-header-mix">
                                <div class="slide-title">
                                    <?= $arItem['PREVIEW_TEXT'] ?>
                                </div>
                            </div>

                            <div class="entry">
                                <? if ($arItem['DETAIL_PICTURE']) { ?>
                                    <img data-src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>"
                                         alt="<?= $arItem['DETAIL_PICTURE']['ALT'] ?>" class="entry-bg">
                                <? } ?>
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:news.list",
                                    "index_auto_roller_slider_products",
                                    array_merge($arParams, ['IBLOCK_ID' => $arParams['ADD_IBLOCK_ID']]),
                                    false
                                ); ?>
                            </div>

                            <? if ($arItem['PROPERTIES']['link']['VALUE']) { ?>
                                <div class="screen-3-1-elem">
                                    <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>"
                                       target="_blank"
                                       class="button button--red button--arrow"><span><?= html_entity_decode($arItem['PROPERTIES']['text']['VALUE']) ?></span></a>
                                </div>
                            <? } ?>

                        </div>
                    </div>
                </div>
                <?
                break;
            case '2':
                ?>
                <div data-slide-bg="<?= $arItem['PROPERTIES']['bg']['VALUE_XML_ID'] ?>">
                    <? if ($arItem['DETAIL_PICTURE']) { ?>
                        <div class="pattern-bg"
                             style="background-image: url('<?= $arItem['DETAIL_PICTURE']['SRC'] ?>');"></div>
                    <? } ?>
                    <div class="slide-in slide--shrink">
                        <div class="slide-content">
                            <div class="slide-header color--<?= $color ?>">
                                <div class="slide-title">
                                    <?= $arItem['NAME'] ?>
                                </div>
                            </div>
                            <?= $arItem['PREVIEW_TEXT'] ?>
                            <? if ($arItem['PROPERTIES']['link']['VALUE']) { ?>
                                <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>"
                                   target="_blank"
                                   class="button button--white button--arrow"><span><?= html_entity_decode($arItem['PROPERTIES']['text']['VALUE']) ?></span></a>
                            <? } ?>
                        </div>
                    </div>
                    <div class="screen-3-2-elem">
                        <img src="<?= DEFAULT_ASSETS_PATH ?>/userimg/screen-3-2-elem.png" alt="" class="">
                        <a class="b-zoom b-zoom--big screen-3-2-button js-image-open"
                           href="<?= DEFAULT_ASSETS_PATH ?>/userimg/screen-3-2-detailed.jpg">
                            <div></div>
                        </a>
                    </div>
                </div>
                <?
                break;
            case '3':
            default:
                ?>
                <div data-slide-bg="<?= $arItem['PROPERTIES']['bg']['VALUE_XML_ID'] ?>">
                    <? if ($arItem['DETAIL_PICTURE']) { ?>
                        <img data-src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>" alt="" class="slide-bg">
                    <? } ?>
                    <div class="slide-in slide--shrink">
                        <div class="slide-content">
                            <div class="slide-header color--<?= $color ?>">
                                <div class="slide-title">
                                    <?= $arItem['PREVIEW_TEXT'] ?>
                                </div>
                            </div>
                            <? if ($arItem['PROPERTIES']['link']['VALUE']) { ?>
                                <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>"
                                   target="_blank"
                                   class="button button--white button--arrow"><span><?= html_entity_decode($arItem['PROPERTIES']['text']['VALUE']) ?></span></a>
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

