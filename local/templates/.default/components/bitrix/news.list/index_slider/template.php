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

<div class="owl-carousel owl-carousel--video">
    <?foreach($arResult["ITEMS"] as $arItem){?>
        <div data-slide-bg="dark">
            <img data-src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" class="slide-bg">
            <div class="slide-in">
                <div class="slide-content">
                    <div class="slide-header--welcome color--white">
                        <div class="slide-title">
                            <?=html_entity_decode($arItem['NAME'])?>
                        </div>
                    </div>
                </div>
            </div>
            <video preload="none" muted="true">
                <source src="<?=$arItem['PROPERTIES']['video']['VALUE']['SRC']?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'/>
                Video tag not supported. Download the video
                <a href="<?=$arItem['PROPERTIES']['video']['VALUE']['SRC']?>">here</a>.
            </video>
            <div class="video-cover"></div>
        </div>
    <?}?>
</div>

<ul class="slide-nav tvideo-nav">
    <?foreach($arResult["ITEMS"] as $arItem){?>
        <li class="js-slide-tab">
            <div class="tv-link">
                <span><?=$arItem['PREVIEW_TEXT']?></span>
            </div>
        </li>
    <?}?>
</ul>

<div class="title-mob-slider js-title-mob-slider swiper-container">
    <div class="swiper-wrapper">
        <?foreach($arResult["ITEMS"] as $arItem){?>
            <div class="swiper-slide">
                <img data-src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" class="swiper-lazy">
                <div class="slide-title">
                    <?=html_entity_decode($arItem['NAME'])?>
                </div>
            </div>
        <?}?>
    </div>
</div>

