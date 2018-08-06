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

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
?>


<? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>


<?
if(count($arResult['ITEMS']) > 0) {
    foreach ($arResult["ITEMS"] as $arItem) {
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $no_image = empty($arItem['PREVIEW_PICTURE']);
        ?>
        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="news-item">
            <div class="flex-row">
                <div class="col-xs-12 col-sm-6 n-image">
                    <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>">
                </div>
                <div class="col-xs-12 col-sm-6 n-abstract">
                    <div class="n-date"><?= $arItem["DISPLAY_ACTIVE_FROM"] ?></div>
                    <div class="n-title"><?= $arItem['NAME'] ?></div>
                    <p><?= $arItem['PREVIEW_TEXT'] ?></p>
                </div>
            </div>
        </a>
    <? }
} else {?>
    <a href="#" class="news-item">
        <div class="flex-row">
            <div class="col-xs-12 col-sm-6 n-abstract">
                <div class="n-title">К сожалению, в данном разделе новостей нет!</div>
                <p>Нам очень жаль =(</p>
            </div>
        </div>
    </a>
<?}?>

<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>
