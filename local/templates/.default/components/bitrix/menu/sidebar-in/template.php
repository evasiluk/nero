<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)) { ?>
    <ul class="sidemenu">
            <? $previousLevel = 0;
            foreach ($arResult as $arItem) { ?>

                <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) { ?>
                    <?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
                <? } ?>

                <? if ($arItem["IS_PARENT"]) { ?>
                    <li class="<? if ($arItem["SELECTED"]): ?>is-active<? endif ?>">
                        <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                        <ul>
                <? } elseif ($arItem["PERMISSION"] > "D") {
                    if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                        <li class="<? if ($arItem["SELECTED"]): ?>is-active<? endif ?>">
                            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                        </li>
                    <? } else { ?>
                        <li class="<? if ($arItem["SELECTED"]): ?>is-active<? endif ?>">
                            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                        </li>
                    <? }
                } ?>

                <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

            <? } ?>

            <? if ($previousLevel > 1) {//close last item tags?>
                <?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
            <? } ?>
    </ul>
<? } ?>