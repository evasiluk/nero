<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)) { ?>
    <nav class="topnav" role="navigation">
        <ul>
            <? $previousLevel = 0;
            foreach ($arResult as $arItem) { ?>

                <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) { ?>
                    <?= str_repeat("</div></div></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
                <? } ?>

                <? if ($arItem['PARAMS']['id'] == 'topnav-catalog-link'){?>
                    <li class="t-arrow <? if ($arItem["SELECTED"]): ?>selected<? endif ?>" id="<?=$arItem['PARAMS']['id']?>">
                        <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                    </li>
                <?} elseif ($arItem["IS_PARENT"]) { ?>
                    <li class="t-arrow <? if ($arItem["SELECTED"]): ?>selected<? endif ?>">
                    <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                    <div class="submenu">
                    <div class="submenu-in">
                <? } elseif ($arItem["PERMISSION"] > "D") {
                    if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                        <li class="<? if ($arItem["SELECTED"]): ?>selected<? endif ?>">
                            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                        </li>
                    <? } else { ?>
                        <p class="<? if ($arItem["SELECTED"]): ?>selected<? endif ?>">
                            <a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
                        </p>
                    <? }
                } ?>

                <? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

            <? } ?>

            <? if ($previousLevel > 1) {//close last item tags?>
                <?= str_repeat("</div></div></li>", ($previousLevel - 1)); ?>
            <? } ?>
        </ul>
    </nav>
<? } ?>