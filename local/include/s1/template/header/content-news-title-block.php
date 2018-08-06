<?
/** believe that this script includes from news.* template */
?>
<?$image = Astronim\Helper::getChainBg();?>
<div class="content-title-block news-title-block">
    <img src="<?=$image['SRC']?>" alt="<?=$image['ALT']?>">
    <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "", Array(
        "PATH" => "",
        "SITE_ID" => "s1",
        "START_FROM" => "0"
    ), false); ?>
    <h1><?=$arItem['NAME']?></h1>
    <div class="b-date">
        <svg viewBox="0 0 50 50">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-clock"></use>
        </svg>
        <span><?=$arItem['DISPLAY_ACTIVE_FROM']?></span>
    </div>
</div>