<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)) { ?>
    <div class="tabs-row tabs-row--border">
        <? foreach ($arResult as $arItem) {
            if ($arItem["DEPTH_LEVEL"] > 1) continue; ?>
            <a href="<?= $arItem["LINK"] ?>"<? if ($arItem["SELECTED"]): ?> class="tabs-item--active"<? endif ?>
               data-navigo>
                <span><?= $arItem["TEXT"] ?></span>
            </a>
        <? } ?>
    </div>
<? } ?>