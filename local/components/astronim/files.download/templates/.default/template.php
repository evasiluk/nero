<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<ul class="reset-list">
    <? foreach ($arResult['ITEMS'] as $item) { ?>
        <li>
            <a href="<?= $item['src'] ?>" class="file">
                <?= $item['svg'] ?>
                <span><?= ($item['description'] ?: $item['name']) ?></span>
                <em>
                    <?= strtoupper($item['extension']) ?>
                    / <?= formatBytes($item['size']) ?>
                    / <?= date('d.m.Y', $item['time']) ?>
                </em>
            </a>
        </li>
    <? } ?>
</ul>
