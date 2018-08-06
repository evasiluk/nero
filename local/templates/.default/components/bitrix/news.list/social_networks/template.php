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

<ul>
    <? foreach ($arResult["ITEMS"] as $arItem) { ?>
        <li>
            <a href="<?= $arItem['PROPERTIES']['link']['VALUE'] ?>" class="social-link" target="_blank">
                <i><?= html_entity_decode($arItem['PROPERTIES']['svg']['VALUE']); ?>
                </i>
                <span><?= $arItem['NAME'] ?></span></a>
        </li>
    <? } ?>
</ul>
