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
<div class="maxwrap">
    <div class="tab-heading heading-level-2 align-center"><?=GetMessage("FEATURES");?></div>
    <div class="device-details">
        <div class="flex-row">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="detail-box">
                        <div class="detail-box-img">
                            <img class="lozad" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                        </div>
                        <div class="detail-box-heading">
                            <?if(SITE_ID == "s1"):?>
                                <span><?=$arItem["NAME"]?></span>
                            <?else:?>
                                <span><?=$arItem["PROPERTIES"]["NAME_EN"]["VALUE"]?></span>
                            <?endif?>

                        </div>
                        <?if(SITE_ID == "s1"):?>
                            <p><?=$arItem["PREVIEW_TEXT"]?></p>
                        <?else:?>
                            <p><?=$arItem["DETAIL_TEXT"]?></p>
                        <?endif?>

                    </div>
                </div>
            <?endforeach?>
        </div>
    </div>
</div>
