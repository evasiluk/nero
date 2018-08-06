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

<h2 class="align-center"><?=$arResult['NAME']?></h2>

<div class="features-list flex-row">
    <?foreach($arResult["ITEMS"] as $arItem){?>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="feature">
                <div class="feature-img">
                    <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
                </div>
                <h4 class="feature-title"><?=$arItem['NAME']?></h4>
                <div class="feature-article"><?=$arItem['PREVIEW_TEXT']?></div>
            </div>
        </div>
    <?}?>
</div>


