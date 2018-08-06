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

<div class="js-fb-slider fb-slider swiper-container">
    <div class="swiper-wrapper">
        <?
        $step = 1;
        foreach ($arResult["ITEMS"] as $arItem) { ?>
            <div class="swiper-slide">
                <div class="fb-box">
                    <div class="fb-img"><img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                             alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"></div>
                    <div class="fb-dsc">
                        <h4>
                            <span class="color--red">
                                <?= Loc::getMessage('step_num', ['#step#' => $step++]) ?>
                            </span>
                            <?= $arItem['NAME'] ?>
                        </h4>
                        <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

