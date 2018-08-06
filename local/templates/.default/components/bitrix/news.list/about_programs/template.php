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
use \Bitrix\Main\Localization\Loc;
?>

<div class="usercontent p-bottom">
    <div class="wrap">
        <h2 class="align-center p-bottom"><?= Loc::getMessage('about_program'); ?></h2>

        <div class="features-list flex-row is-hidden is-visible">
            <? foreach ($arResult["ITEMS"] as $arItem) { ?>
                <div class="col-xs-12 col-sm-4">
                    <div class="feature">
                        <div class="feature-img">
                            <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                 alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>">
                        </div>
                        <h4 class="feature-title"><?= html_entity_decode($arItem['NAME']) ?></h4>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
</div>