<?$image = Astronim\Helper::getChainBg();?>
<div class="content-title-block">
    <img src="<?=$image['SRC']?>" alt="<?=$image['ALT']?>">
    <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "", Array(
        "PATH" => "",
        "SITE_ID" => "s1",
        "START_FROM" => "0"
    ), false); ?>
    <h1><?$APPLICATION->ShowTitle()?></h1>
</div>