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


<?if($arResult["ITEMS"]):?>
    <div class="maxwrap">
        <div class="tab-heading heading-level-2 align-center"><?=GetMessage("FILES_TO_DOWNLOAD")?></div>
        <div class="sq-docs">
            <?foreach($arResult["ITEMS"] as $doc):?>
                <div class="col">
                    <a href="<?=$doc["LINK"]?>" class="doc-node"><?=$doc["NAME"]?></a>
                </div>
            <?endforeach?>
        </div>
    </div>
<?endif?>
