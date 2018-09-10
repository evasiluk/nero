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
<div class="usercontent bg--white wrap wrap-content">
    <?$APPLICATION->IncludeComponent("astronim:orders.admin.list", "", array(
            "ID" => $arParams['ID'],
            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
            "FILTER_NAME" => $arParams['FILTER_NAME'],
            "DISPLAY_BOTTOM_PAGER" => $arParams['DISPLAY_BOTTOM_PAGER'],
            "DISPLAY_TOP_PAGER" => $arParams['DISPLAY_TOP_PAGER'],
            "MESSAGE_404" => $arParams['MESSAGE_404'],
            "PAGER_BASE_LINK_ENABLE" => $arParams['PAGER_BASE_LINK_ENABLE'],
            "PAGER_DESC_NUMBERING" => $arParams['PAGER_DESC_NUMBERING'],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
            "PAGER_SHOW_ALL" => $arParams['PAGER_SHOW_ALL'],
            "PAGER_SHOW_ALWAYS" => $arParams['PAGER_SHOW_ALWAYS'],
            "PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE'],
            "PAGER_TITLE" => $arParams['PAGER_TITLE'],
        ),
        $component
    );?>
</div>
