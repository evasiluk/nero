<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<table class="quality-table">
    <?foreach($arResult["ITEMS"] as $arItem):?>
    <tr>
        <td>
            <div>
                <?if(SITE_ID == "s1"):?>
                    <span><?=$arItem["NAME"]?></span>
                <?else:?>
                    <span><?=$arItem["PROPERTIES"]["NAME_EN"]["VALUE"]?></span>
                <?endif?>
            </div>
        </td>
        <td>
            <?if(SITE_ID == "s1"):?>
                <?=$arItem["PREVIEW_TEXT"]?>
            <?else:?>
                <?=$arItem["DETAIL_TEXT"]?>
            <?endif?>
        </td>
    </tr>
    <?endforeach?>
</table>
