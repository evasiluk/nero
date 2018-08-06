<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

/** @var PageNavigationComponent $component */
$component = $this->getComponent();

$this->setFrameMode(true);
if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
?>
<div class="pagination">
    <div class="pagination-row">
        <div class="pagination-nav">
            <? if ($arResult["NavPageNomer"] > 1): ?>
                <a href="<?= $arResult['previous'] ?>" class="c-ico ico-50 ico--red">
                    <svg viewBox="0 0 50 50">
                        <use xlink:href="#ico-left"></use>
                    </svg>
                </a>
            <? else: ?>
                <a href="#" disabled="true" class="c-ico ico-50 ico--red">
                    <svg viewBox="0 0 50 50">
                        <use xlink:href="#ico-left"></use>
                    </svg>
                </a>
            <? endif ?>
        </div>

        <div class="pagination-list">
            <? while ($arResult["nStartPage"] <= $arResult["nEndPage"]):
                $is_current = $arResult['NavPageNomer'] == $arResult["nStartPage"]; ?>
                <? if ($is_current): ?>
                <a class="active" href="#"><?= $arResult["nStartPage"] ?></a>
            <? else: ?>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>

            <? endif ?>
                <? $arResult["nStartPage"]++ ?>
            <? endwhile ?>
        </div>

        <div class="pagination-nav">
            <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
                <a href="<?= $arResult['next'] ?>" class="c-ico ico-50 ico--red">
                    <svg viewBox="0 0 50 50">
                        <use xlink:href="#ico-right"></use>
                    </svg>
                </a>

            <? else: ?>
                <a href="#" disabled="true" class="c-ico ico-50 ico--red">
                    <svg viewBox="0 0 50 50">
                        <use xlink:href="#ico-right"></use>
                    </svg>
                </a>
            <? endif ?>
        </div>

    </div>
</div>
