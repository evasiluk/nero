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

<section class="section-hs-slider">

    <div class="wrap">

        <div class="hs-slider js-hs-slider">

            <? foreach ($arResult["ITEMS"] as $key => $arItem) { ?>
                <div class="hs-slide <? if (!$key) { ?>hs-hover<? } ?>">
                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"
                         class="hs-bg">
                    <div class="hs-slide-in">
                        <header><?= html_entity_decode($arItem['NAME']) ?></header>
                        <div class="hs-descr">
                            <div class="hs-preview"><?= $arItem['PREVIEW_TEXT'] ?></div>
                            <div class="hs-fulltext"><?= $arItem['DETAIL_TEXT'] ?></div>
                        </div>
                    </div>
                </div>
            <? } ?>

        </div>

    </div>

</section>