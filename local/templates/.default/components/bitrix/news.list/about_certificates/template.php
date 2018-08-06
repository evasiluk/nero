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

use \Bitrix\Main\Localization\Loc; ?>
<? foreach ($arResult['SECTIONS'] as $arSection) {
    if(empty($arSection["ITEMS"])) continue;?>
    <div class="wrap">

        <h2><?= $arSection['NAME'] ?></h2>
        <div class="cert-list flex-row">

            <? foreach ($arSection["ITEMS"] as $arItem) {
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="col-xxs-12 col-xs-6 col-sm-4 col-lg-3" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <a href="<?= $arItem["PROPERTIES"]["file"]['SRC'] ?>" class="cert" target="_blank">
                        <div class="cert-img">
                            <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                 alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>">
                        </div>
                        <div class="cert-descr">
                            <?= $arItem["NAME"] ?>
                        </div>
                    </a>
                </div>
            <? } ?>

        </div>

    </div>
<? } ?>