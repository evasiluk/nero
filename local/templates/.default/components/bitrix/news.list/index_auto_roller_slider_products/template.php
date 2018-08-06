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
<? foreach ($arResult["ITEMS"] as $arItem) { ?>
    <div class="entry-item">
        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
             alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>"
             class="entry-outline"/>
        <img src="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>"
             alt="<?= $arItem['DETAIL_PICTURE']['ALT'] ?>"
             class="entry-picture"/>
        <div class="entry-title"><?= $arItem['NAME'] ?></div>

        <? if ($arItem['PROPERTIES']['link']['VALUE']) { ?>
            <object class="entry-button">
                <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>"
                   target="_blank"
                   class="button button--red button-hover--white button--arrow">
                    <span><?= html_entity_decode($arItem['PROPERTIES']['text']['VALUE']) ?></span>
                </a>
            </object>
        <? } ?>
    </div>
<? } ?>