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

<div class="wrap">
    <div class="l-faq standalone">
        <? foreach ($arResult["ITEMS"] as $arItem) { ?>
            <div id="file<?= $arItem['ID'] ?>">
                <a href="#" class="faq-q"><span><?= $arItem['NAME'] ?></span></a>
                <div class="faq-a">
                    <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                    <? if ($arItem['PROPERTIES']['file']) {
                        foreach ($arItem["PROPERTIES"]["file"]["VALUE"] as $key => &$file) { ?>
                            <p><a href="<?= $file['SRC'] ?>"
                                  class="doc-link"><?= $file['ORIGINAL_NAME'] ?></a></p>
                        <?
                        }
                    } ?>
                    <? if ($arItem['PROPERTIES']['youtube']['src']) { ?>
                        <div class="flex-row">
                            <div class="col-xs-12 col-sm-9 fitvid">
                                <iframe width="560" height="315" src="<?= $arItem['PROPERTIES']['youtube']['src'] ?>"
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        <? } ?>
    </div>
</div>
