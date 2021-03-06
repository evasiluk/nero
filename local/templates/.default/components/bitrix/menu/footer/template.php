<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)) { ?>
    <? $previousLevel = 0;
    foreach ($arResult as $arItem) { ?>

        <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) { ?>
            <?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
        <? } ?>

        <? if ($arItem["IS_PARENT"]) { ?>
            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
            <ul>
        <? } elseif ($arItem["PERMISSION"] > "D") {
            if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                <ul></ul>
            <? } else { ?>
                <li class="<? if ($arItem["SELECTED"]): ?>selected<? endif ?>">
                    <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                </li>
            <? }
        } ?>

        <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

    <? } ?>

    <? if ($previousLevel > 1) {//close last item tags?>
        <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
    <? } ?>
<? } ?>